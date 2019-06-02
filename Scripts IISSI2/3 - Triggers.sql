----------------------------------Triggers--------------------------------------

--Da el evento por finalizado al recibir de vuelta el envío
CREATE OR REPLACE TRIGGER envios1 
AFTER UPDATE ON envios 
FOR EACH ROW
DECLARE
aux integer;
BEGIN
  SELECT eid INTO aux FROM parteEquipo WHERE PEID=:NEW.PEID;
  IF(:NEW.ESTADOENVIO='recibido') then 
  update evento set estadoEvento='Realizado' where eid=aux;
  end if;
END;

--Pone el estado del ítem 'Disponible' cuendo finaliza el evento. 
CREATE OR REPLACE TRIGGER EVENTO_inventario
AFTER UPDATE OF ESTADOEVENTO ON EVENTO 
FOR EACH ROW
declare aux integer;
BEGIN
select peid into aux from parteequipo where eid=:old.eid; 
IF(:NEW.ESTADOEVENTO='Realizado') then
update inventario set estadoitem='Disponible' where peid=aux;
update inventario set PEID=null where peid=aux;
end if;
END;


--Deja disponible al personal tras finalizar un evento. 
CREATE OR REPLACE TRIGGER EVENTO_PERSONAL 
BEFORE UPDATE ON evento
FOR EACH ROW
BEGIN
  IF(:NEW.ESTADOEVENTO='Realizado') then 
  update personal set estado='Libre' where eid=:new.eid;
  end if;
END;

--Regla de negocio ARN01 -> Se cumple sin necesidad de trigger

--Regla de negocio ARN02
CREATE OR REPLACE TRIGGER ARN02
BEFORE INSERT OR UPDATE OF PID ON Mantenimiento FOR EACH ROW
BEGIN
IF :new.PID > 999999 then
 raise_application_error(-20619, 'ID de usuario incorrecto');
end if;
end;

--Regla de negocio ARN04. ESTA REGLA SE HA HECHO TAMBIÉN CON UN UNIQUE.
CREATE OR REPLACE TRIGGER ARN04
BEFORE INSERT ON PARTEEQUIPO 
FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM ENVIOS WHERE :NEW.PEID=PEID; 
  IF(AUX=1) THEN RAISE_APPLICATION_ERROR(-20611,'Un envio no puede tener más de un parte de equipo asignado');
  end if;
END;

--Trigger almacén IISSI2 1 Mira si el trabajador está libre
CREATE OR REPLACE TRIGGER ARN05
BEFORE INSERT OR UPDATE OF PID ON MANTENIMIENTO FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE ESTADO='Ocupado' AND :NEW.PID = PID;
 IF(AUX>0) THEN RAISE_APPLICATION_ERROR(-20630,'El trabajador ya está ocupado');
 end if;
 end;
 
 --Trigger almacén IISSI2 2
CREATE OR REPLACE TRIGGER ARN06
BEFORE UPDATE OF PID ON MANTENIMIENTO FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE DEPARTAMENTO='Almacen' AND :NEW.PID = PID;
 IF(AUX=0) THEN RAISE_APPLICATION_ERROR(-20631,'El trabajador no es departamento de almacén');
 end if;
 end;
 
 --Trigger almacén IISSI2 3 -> MIRA SI EL ÍTEM SELECCIONADO REQUIERE REPARACIÓN (ESTADO = PORREPARAR)
CREATE OR REPLACE TRIGGER ARN07
BEFORE UPDATE OF ESTADOITEM ON INVENTARIO FOR EACH ROW
BEGIN
  IF :NEW.ESTADOITEM='enMantenimiento' AND :OLD.ESTADOITEM!='porReparar' then
   RAISE_APPLICATION_ERROR(-20632, 'El ítem no necesita reparación');
end if;
END;
 
--Trigger almacén IISSI2 3 -> NO DEJA MANDAR A REPARACIONES PENDIENTES UN ÍTEM QUE YA SE ESTÁ REPARANDO
CREATE OR REPLACE TRIGGER ARN08
BEFORE UPDATE OF ESTADOITEM ON INVENTARIO FOR EACH ROW
BEGIN
  IF :NEW.ESTADOITEM='porReparar' AND :OLD.ESTADOITEM='enMantenimiento' then
   RAISE_APPLICATION_ERROR(-20633, 'El ítem está en reparación');
end if;
END;

--Trigger almacén IISSI2 4 -> NO DEJA REPARAR UN ÍTEM QUE NO EXISTE O QUE NO LO NECESITA -> Mantenimiento
CREATE OR REPLACE TRIGGER ARN09
BEFORE INSERT ON MANTENIMIENTO FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM INVENTARIO WHERE REFERENCIA=:NEW.REFERENCIA AND ESTADOITEM='porReparar';
 IF(AUX=0) THEN RAISE_APPLICATION_ERROR(-20634,'No se puede reparar el ítem');
 end if;
 end;

--Trigger IISSI2 5 -> Mira si el ítem que se va a reparar lo necesita -> Inventario
 CREATE OR REPLACE TRIGGER ARN13
BEFORE UPDATE OF estadoItem ON INVENTARIO FOR EACH ROW
BEGIN
 IF :NEW.estadoItem='enMantenimiento' AND :OLD.estadoItem!='porReparar' THEN RAISE_APPLICATION_ERROR(-20637,'No se puede reparar el ítem');
 end if;
 end;
 
--Trigger IISSI2 6 -> Actualiza el estado del personal si se le asigna una reparación -> SOLUCIÓN ALTERNATIVA AL PROCEDURE PARA ASIGNAR LA REPARACIÓN
 CREATE OR REPLACE TRIGGER ARN14
AFTER UPDATE OF PID ON MANTENIMIENTO FOR EACH ROW
BEGIN
UPDATE personal set estado='Ocupado' where PID=:NEW.PID;
 end;
 
--Trigger almacén IISSI2 7 -> Mira si el trabajador está ocupado antes de asignarlo a un envío
CREATE OR REPLACE TRIGGER ARN10
BEFORE UPDATE OF PID ON ENVIOS FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE ESTADO='Ocupado' AND :NEW.PID = PID;
 IF(AUX>0) THEN RAISE_APPLICATION_ERROR(-20630,'El trabajador ya está ocupado');
 end if;
 end;
 
 --Trigger almacén IISSI2 8 -> Mira si el parte de equipo se esta enviando ya
 CREATE OR REPLACE TRIGGER ARN11
 BEFORE INSERT ON ENVIOS FOR EACH ROW
 DECLARE AUX INTEGER;
 BEGIN
 SELECT COUNT(*) INTO AUX FROM ENVIOS WHERE PEID=:NEW.PEID;
 IF(AUX>0) THEN RAISE_APPLICATION_ERROR(-20635,'Parte ya enviado');
 END IF;
 END;
 
 --Trigger almacén IISSI2 9 -> Prohibe editar un envío ya recibido
 CREATE OR REPLACE TRIGGER ARN12
 BEFORE UPDATE ON ENVIOS FOR EACH ROW
 BEGIN
 IF :OLD.ESTADOENVIO='recibido' then RAISE_APPLICATION_ERROR(-20636, 'No se puede editar');
end if;
end;

--Trigger almacén IISSI2 10 -> Mira si el empleado es de almacén antes de asignarlo a un envío
CREATE OR REPLACE TRIGGER ARN15
BEFORE INSERT ON ENVIOS FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE DEPARTAMENTO='Almacen' AND :NEW.PID = PID;
 IF(AUX=0) THEN RAISE_APPLICATION_ERROR(-20631,'El trabajador no es departamento de almacén');
 end if;
 end;

--Trigger almacén IISSI2 11 -> Cambia el estado del ítem alquilado tras devolverlo
CREATE OR REPLACE TRIGGER ARN16
AFTER UPDATE OF ESTADODEVOLUCION ON DEVOLUCIONES
FOR EACH ROW
declare aux integer;
BEGIN
select ia into aux from devoluciones where did=:old.did; 
IF(:NEW.ESTADODEVOLUCION='Devuelto') then
update itemAlquilado set estado='Devuelto' where ia=aux;
end if;
END;

--Trigger almacén IISSI2 12 -> Mira si el empleado está libre
CREATE OR REPLACE TRIGGER ARN17
BEFORE INSERT OR UPDATE OF PID ON DEVOLUCIONES FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE ESTADO='Ocupado' AND :NEW.PID = PID;
 IF(AUX>0) THEN RAISE_APPLICATION_ERROR(-20630,'El trabajador ya está ocupado');
 end if;
 end;
 
 --Trigger almacén IISSI2 13 -> Mira si el empleado es de almacén
CREATE OR REPLACE TRIGGER ARN18
BEFORE INSERT OR UPDATE OF PID ON DEVOLUCIONES FOR EACH ROW
DECLARE AUX INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX FROM PERSONAL WHERE DEPARTAMENTO='Almacen' AND :NEW.PID = PID;
 IF(AUX=0) THEN RAISE_APPLICATION_ERROR(-20631,'El trabajador no es departamento de almacén');
 end if;
 end;
 
--Trigger almacén IISSI2 14  Mira si el ítem se ha devuelto ya
 CREATE OR REPLACE TRIGGER ARN19
 BEFORE INSERT ON DEVOLUCIONES FOR EACH ROW
 DECLARE AUX INTEGER;
 BEGIN
 SELECT COUNT(*) INTO AUX FROM ITEMALQUILADO WHERE ESTADO='Devuelto';
 IF(AUX>0) THEN RAISE_APPLICATION_ERROR(-20635,'Ítem ya devuelto');
 END IF;
 END;
 
 --Trigger almacén IISSI2 15 -> Prohibe editar una devolución ya realizada
 CREATE OR REPLACE TRIGGER ARN20
 BEFORE UPDATE ON DEVOLUCIONES FOR EACH ROW
 BEGIN
 IF :OLD.ESTADODEVOLUCION='Devuelto' then RAISE_APPLICATION_ERROR(-20636, 'No se puede editar');
end if;
end;

--Regla de negocio PRN01.1
create or replace TRIGGER PRN011
BEFORE INSERT OR UPDATE OF PID ON ItemAlquilado FOR EACH ROW
BEGIN
IF :new.PID <1000000 and :new.PID>1999999 then
 raise_application_error(-20612, 'ID de usuario incorrecto');
end if;
end;

--Regla de negocio PRN02
create or replace TRIGGER PRN02_2
BEFORE INSERT ON EVENTO
FOR EACH ROW
BEGIN
  IF(:new.estadoevento != 'porRealizar') then raise_application_error(-20613,'El evento se debe crear en estado "porRealizar"');
end if;
END;

create or replace TRIGGER PRN02_1 
BEFORE UPDATE ON EVENTO 
FOR EACH ROW
declare aux integer;
BEGIN
    select count(eid) into aux from personal where eid=:new.eid;
  IF((:NEW.ESTADOEVENTO='enPreparacion' and :old.estadoevento='porRealizar') and aux=0) then raise_application_error(-20614,'El evento no puede pasar a preparación debido a que no hay ningún 
  técnico asociado al evento');
  end if;
END;

--Regla de negocio PRN03
CREATE OR REPLACE TRIGGER PRN03 
BEFORE INSERT ON PERSONAL 
FOR EACH ROW
declare aux integer;
BEGIN
    select max(sueldo) into aux from personal where departamento!='Externo';
  IF((:NEW.DEPARTAMENTO='Externo') AND :NEW.sueldo>2*aux) then raise_application_error(-20615,'El personal externo no puede tener más del doble del salario máximo del personal interno');
end if;
END;

--Regla de negocio PRN04
CREATE OR REPLACE TRIGGER PRN04 
BEFORE INSERT ON ALOJAMIENTO 
for each row
declare 
eventofi evento.fechainicio%type; 
eventoff evento.fechafin%type;
BEGIN
    select fechainicio into eventofi from evento where eid=:new.eid;
  if(:new.fechainicio>=eventofi and :new.fechainicio<=eventoff) then raise_application_error(-20616,'Debe haber un margen de al menos 1 día en los extremos de la duración del evento para contratar un alojamiento');
  end if;
END;

--Regla de negocio TRN03
create or replace TRIGGER TRN03 BEFORE INSERT OR UPDATE OF eid ON parteequipo
FOR EACH ROW
BEGIN
IF inserting THEN
IF(:new.eid<:new.peid)THEN
  raise_application_error(-20617,'Maximo un Parte de Equipo por Evento ');
END IF;
END IF;
IF updating then
  IF(:new.eid<:old.eid AND :old.peid<>:new.eid)THEN
raise_application_error(-20617,'Maximo un Parte de Equipo por Evento');
END IF;
END IF;
END;

--Requisito funcional PRF01
create or replace TRIGGER PRF01
AFTER UPDATE ON PERSONAL
declare
auxP integer;
auxA integer;
auxT integer;
auxC integer;
BEGIN
select count(*) into auxP from personal where (estado='Libre' and departamento='Produccion');
select count(*) into auxA from personal where (estado='Libre' and departamento='Almacen');
select count(*) into auxT from personal where (estado='Libre' and departamento='Tecnico');
select count(*) into auxC from personal where (estado='Libre' and departamento='Comercial');
  IF(auxP<=2 or auxA<=2 or auxT<=2 or auxC<=2) then DBMS_OUTPUT.PUT_LINE('¡ATENCION! Hay dos o menos trabajadores disponibles en alguno de los departamentos');
  end if;
END;

--Requisito funcional PRF03
create or replace TRIGGER PRF03 
BEFORE INSERT ON ITEMALQUILADO 
FOR EACH ROW
declare 
aux date;
aux1 integer;
BEGIN
    select eid into aux1 from parteequipo where peid=:new.peid;
    select fechainicio into aux from evento where eid=aux1;
  IF(:NEW.FECHALLEGADA>aux) then raise_application_error(-20618,'La fecha de llegada del ítem alquilado no puede ser posterior al inicio del evento');
  end if;
END;

--Requisito funcional PRF04
CREATE OR REPLACE TRIGGER PRF04 
AFTER UPDATE ON PERSONAL
declare aux integer; aux1 integer;
BEGIN
  select count(*) into aux from personal where (estado='Ocupado' and departamento='Externo');
  select count(*) into aux1 from personal where (estado='Ocupado' and (departamento='Almacen' or departamento='Produccion' or departamento='Comercial' or departamento='Tecnico'));
  if(aux>aux1) then DBMS_OUTPUT.PUT_LINE('ATENCION! Hay más trabajadores externos asociados a eventos, que trabajadores internos');
  end if;
END;

--Requisito funcional PRF07
/*CREATE OR REPLACE TRIGGER PRF07 
after INSERT OR UPDATE ON ALOJAMIENTO
DECLARE 
AUX1 INTEGER;
AUX2 INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX1 FROM PERSONAL WHERE EID=EID;
SELECT numPersonas INTO AUX2 FROM ALOJAMIENTO WHERE EID=EID;
  IF NOT(AUX2<=AUX1) then raise_application_error(-20620,'El alojamiento tiene que ser para todas las personas asignadas al evento');
  end if;
END;
*/
--Requisito funcional PRF08
create or replace TRIGGER PRF08
after UPDATE of estado ON PERSONAL
DECLARE
AUX1 INTEGER;
BEGIN
SELECT COUNT(*) INTO AUX1 FROM PERSONAL WHERE estado='Libre';
  IF(aux1>30) THEN RAISE_APPLICATION_ERROR(-20622,'Hay mas de 30 empleados contratados sin estar en ningun evento');
  end if;
END;

--Requisito funcional TRF04
CREATE OR REPLACE TRIGGER TRF04
BEFORE UPDATE OF PEID ON INVENTARIO
FOR EACH ROW
BEGIN
IF(:old.estadoItem<>'Disponible')THEN
RAISE_APPLICATION_ERROR(-20621,'No es posible enviar el Item al Evento');
END IF;
END;

--Requisito funcional TRF05
CREATE OR REPLACE TRIGGER TRF05
BEFORE UPDATE ON PERSONAL
FOR EACH ROW
BEGIN
IF(:new.estado='Libre' AND :new.eid<>0) THEN
RAISE_APPLICATION_ERROR(-20623,'No es posible que un empleado esté libre con un Evento asignado');
END IF;
END;

--Requisito funcional TRF07
CREATE OR REPLACE TRIGGER TRF07
BEFORE UPDATE ON PERSONAL
FOR EACH ROW
BEGIN
IF(:new.estado='Ocupado' AND :new.eid=0) THEN
RAISE_APPLICATION_ERROR(-20624,'No es posible que un empleado esté ocupado sin ningún Evento asignado');
END IF;
END;


--ELIMINAR ALOJAMIENTO AL REALIZAR EVENTO
create or replace TRIGGER EVENTO_ALOJAMIENTO
BEFORE UPDATE ON evento
FOR EACH ROW
BEGIN
  IF(:NEW.ESTADOEVENTO='Realizado') then 
  delete alojamiento where eid=:new.eid;
  end if;
END;


-ELIMINAR TRANSPORTE AL REALIZAR EVENTO
create or replace TRIGGER EVENTO_TRANSPORTE
BEFORE UPDATE ON evento
FOR EACH ROW
BEGIN
  IF(:NEW.ESTADOEVENTO='Realizado') then 
  delete transporte where eid=:new.eid;
  end if;
END;
