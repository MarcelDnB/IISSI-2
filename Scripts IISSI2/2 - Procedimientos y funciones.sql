--Proyecto ZeUS
------------------------------------Procedures----------------------------------

--PRN01.2 Solo el departamento de producción puede contratar personal externo
/*create or replace PROCEDURE contratar_personal_externo(w_nombre IN personal.nombre%TYPE,w_cargo IN personal.cargo%TYPE,w_sueldo IN personal.sueldo%TYPE,w_dni IN personal.dni%TYPE,w_telefono IN personal.telefono%TYPE, w_eid IN personal.eid%TYPE, w_peid IN personal.peid%TYPE, w_contrata IN personal.pid%TYPE) 
IS
BEGIN 
IF (w_contrata > 999999 and w_contrata < 2000000) then
INSERT INTO personal(pid,departamento,nombre,cargBo,sueldo,dni,telefono,estado,eid,peid)VALUES (sec_personal_externo.nextval, 'Externo', w_nombre, w_cargo,w_sueldo, w_dni, w_telefono,'Ocupado',w_eid, w_peid);
end if;
COMMIT WORK;
end contratar_personal_externo;
*/
create or replace PROCEDURE crear_usuario(w_departamento IN personal.departamento%TYPE,w_nombre IN personal.nombre%TYPE,w_cargo IN personal.cargo%TYPE,w_sueldo IN personal.sueldo%TYPE,
w_dni IN personal.dni%TYPE,w_telefono IN personal.telefono%TYPE,w_estado IN personal.estado%TYPE,w_eid IN personal.eid%TYPE,w_peid IN personal.peid%TYPE,w_email IN personal.email%TYPE,
w_pass IN personal.pass%TYPE) IS
BEGIN
INSERT INTO personal(pid,departamento,nombre,cargo,sueldo,dni,telefono,email,pass,estado,eid,peid)
VALUES (sec_personal.nextval, w_departamento, w_nombre, w_cargo,w_sueldo,w_dni,w_telefono,w_email,w_pass,w_estado,w_eid,w_peid);
COMMIT WORK;
end crear_usuario;

--Procedures para agregar ítems al inventario. ARF03
create or replace procedure agregar_altavoz(w_nombre IN inventario.nombre%type, w_precio IN inventario.precio%type, w_potencia IN altavoz.potencia%type, w_pulgadas IN altavoz.pulgadas%type)
IS
n_referencia number;
BEGIN
INSERT INTO inventario(referencia, nombre, estadoItem, precio, peid) values(sec_item.nextval, w_nombre, 'Disponible', w_precio,null) returning referencia into n_referencia;
INSERT INTO altavoz(referencia, nombre, precio, potencia, pulgadas) values(n_referencia, w_nombre, w_precio, w_potencia, w_pulgadas);
COMMIT WORK;
end agregar_altavoz;

create or replace procedure agregar_microfono(w_nombre IN inventario.nombre%type, w_precio IN inventario.precio%type, w_alimentacion IN microfono.alimentacion%type, w_tiposujeccion IN microfono.tipoSujeccion%type)
IS
n_referencia number;
BEGIN
INSERT INTO inventario(referencia, nombre, estadoItem, precio, peid) values(sec_item.nextval, w_nombre, 'Disponible', w_precio,null) returning referencia into n_referencia;
INSERT INTO microfono(referencia, nombre, precio, alimentacion, tiposujeccion) values(n_referencia, w_nombre, w_precio, w_alimentacion, w_tiposujeccion);
COMMIT WORK;
end agregar_microfono;


--IISSI2
create or replace procedure agregar_otrositems(w_nombre IN inventario.nombre%type, w_precio IN inventario.precio%type)
IS
n_referencia number;
BEGIN
INSERT INTO inventario(referencia, nombre, estadoItem, precio, peid) values(sec_item.nextval, w_nombre, 'Disponible', w_precio,null) returning referencia into n_referencia;
INSERT INTO otrosItems(referencia, nombre, precio) values(n_referencia, w_nombre, w_precio);
COMMIT WORK;
end agregar_otrositems;

--Procedures para modificar ítems
CREATE OR REPLACE PROCEDURE modificar_altavoz(w_REFERENCIA IN altavoz.referencia%TYPE, w_precio IN altavoz.precio%TYPE, w_potencia IN altavoz.potencia%TYPE,w_pulgadas IN altavoz.pulgadas%TYPE)
IS
BEGIN
UPDATE ALTAVOZ SET precio = w_precio, potencia=w_potencia ,pulgadas=w_pulgadas where REFERENCIA=w_REFERENCIA;
UPDATE INVENTARIO SET precio = w_precio where REFERENCIA=w_REFERENCIA;
commit work;
end MODIFICAR_ALTAVOZ;

CREATE OR REPLACE PROCEDURE modificar_microfono(w_REFERENCIA IN microfono.referencia%TYPE, w_precio IN microfono.precio%TYPE, w_alimentacion IN microfono.alimentacion%TYPE,w_sujeccion IN microfono.tiposujeccion%TYPE)
IS
BEGIN
UPDATE MICROFONO SET precio = w_precio, alimentacion=w_alimentacion ,tiposujeccion=w_sujeccion where REFERENCIA=w_REFERENCIA;
UPDATE INVENTARIO SET precio = w_precio where REFERENCIA=w_REFERENCIA;
commit work;
end MODIFICAR_MICROFONO;

CREATE OR REPLACE PROCEDURE modificar_otrositems(w_REFERENCIA IN microfono.referencia%TYPE, w_nombre IN otrositems.nombre%TYPE, w_precio IN microfono.precio%TYPE)
IS
BEGIN
UPDATE OTROSITEMS SET precio = w_precio, nombre=w_nombre where REFERENCIA=w_REFERENCIA;
UPDATE INVENTARIO SET precio = w_precio, nombre=w_nombre where REFERENCIA=w_REFERENCIA;
commit work;
end MODIFICAR_otrositems;

--Procedure para borrar ítems. Contiene una restricción para asegurar que el que borra el ítem pertenece al departamento de almacén. ARF03
CREATE OR REPLACE PROCEDURE borrar_item(w_referencia IN inventario.referencia%type) IS 
BEGIN
DELETE from inventario where referencia=w_referencia;
COMMIT WORK;
end borrar_item;


--Procedure para borrar ítems. Contiene una restricción para asegurar que el que borra el ítem pertenece al departamento de almacén. ARF03
CREATE OR REPLACE PROCEDURE borrar_item(w_referencia IN inventario.referencia%type) IS 
BEGIN
DELETE from inventario where referencia=w_referencia;
COMMIT WORK;
end borrar_item;

--Procedure para alquilar un ítem
create or replace PROCEDURE alquilar_item(w_tipo IN itemalquilado.tipo%TYPE, w_nombre IN itemalquilado.nombre%TYPE, w_empresa IN itemalquilado.empresa%TYPE, w_fechallegada IN itemalquilado.fechaLlegada%TYPE, w_fechadevolucion IN itemalquilado.fechadevolucion%TYPE, w_cantidad IN itemalquilado.cantidad%TYPE, w_precio IN itemalquilado.precio%TYPE, w_pid IN itemalquilado.pid%TYPE, w_peid IN itemalquilado.peid%TYPE,
w_mid IN itemalquilado.mid%TYPE)
IS
BEGIN 
INSERT INTO itemAlquilado(ia,tipo, nombre, empresa, fechaLlegada, fechaDevolucion, cantidad, precio, pid, peid,mid) values(SEC_ITEM.nextval,w_tipo, w_nombre, w_empresa, w_fechaLlegada, w_fechaDevolucion, w_cantidad, w_precio, w_pid, w_peid,w_mid);
COMMIT WORK;
end alquilar_item;
--Procedure para ver el personal de cada evento. COMPILAR ANTES LA FUNCIÓN
/*CREATE OR REPLACE PROCEDURE DIRECCION_PERSONAL_EVENTO(weid in evento.eid%type) AS 
BEGIN
  DBMS_OUTPUT.PUT_LINE(personal_evento(weid));
END DIRECCION_PERSONAL_EVENTO;
*/
--Procedure para dar el aviso de que un ítem necesita ser reparado.
CREATE OR REPLACE PROCEDURE necesita_reparacion(w_referencia IN inventario.referencia%TYPE)
IS
BEGIN 
UPDATE inventario set estadoItem='porReparar' where referencia=w_referencia;
insert into mantenimiento(fechaInicio, pid, referencia) values (null, null, w_referencia);
COMMIT WORK;
end necesita_reparacion;

--Procedure para que un trabajador se asigne la reparación. ARF04
CREATE OR REPLACE PROCEDURE asignar_reparacion(w_pid IN mantenimiento.pid%TYPE, w_referencia IN inventario.referencia%TYPE)
IS
BEGIN 
UPDATE mantenimiento set pid=w_pid where referencia=w_referencia;
UPDATE mantenimiento set fechaInicio=sysdate where referencia=w_referencia;
UPDATE inventario set estadoItem='enMantenimiento' where referencia=w_referencia;
COMMIT WORK;
end asignar_reparacion;

--Procedure para dar por finalizada una reparación
CREATE OR REPLACE PROCEDURE fin_reparacion(w_pid IN mantenimiento.pid%TYPE, w_referencia IN mantenimiento.referencia%TYPE) 
IS
BEGIN
delete from mantenimiento where referencia=w_referencia;
update inventario set estadoItem = 'Disponible' where referencia=w_referencia;
update personal set estado='Libre' where pid=w_pid;
commit work;
end fin_reparacion;

--Procedure para crear un envío
CREATE OR REPLACE PROCEDURE crear_envio(w_direccion IN envios.direccion%TYPE, w_fechaEntrada IN envios.fechaEntrada%TYPE, w_fechaSalida IN envios.fechaSalida%TYPE, w_pid IN envios.pid%TYPE, w_peid IN envios.peid%TYPE)
IS
BEGIN
insert into ENVIOS(enid, direccion, fechaentrada, fechasalida, pid, peid, estadoEnvio) values (sec_envio.nextval, w_direccion, w_fechaentrada, w_fechasalida, w_pid, w_peid, 'porRealizar');
update personal set estado='Ocupado' where pid=w_pid;
COMMIT WORK;
END CREAR_ENVIO;

--Procedure para modificar un envío
CREATE OR REPLACE PROCEDURE modificar_envio(w_enid IN envios.enid%TYPE, w_direccion IN envios.direccion%type, w_estadoEnvio IN envios.estadoEnvio%TYPE)
IS
BEGIN
update envios set estadoEnvio = w_estadoEnvio where enid=w_enid;
update envios set direccion = w_direccion where enid=w_enid;
COMMIT WORK;
END modificar_envio;

--Procedure para finalizar un envío
CREATE OR REPLACE PROCEDURE fin_envio(w_pid IN envios.pid%type, w_enid IN envios.enid%TYPE)
IS
BEGIN
update envios set estadoEnvio = 'recibido' where enid=w_enid;
update personal set estado='Libre' where pid=w_pid;
COMMIT WORK; 
END FIN_ENVIO;

--Procedure para crear una devolución
CREATE OR REPLACE PROCEDURE crear_devolucion(w_direccion IN devoluciones.direccion%TYPE, w_empresa IN devoluciones.empresa%TYPE, w_PID IN devoluciones.PID%TYPE, w_ia IN devoluciones.ia%TYPE)
IS
BEGIN
insert into DEVOLUCIONES(did, direccion, empresa, pid, ia, estadodevolucion) values (sec_devoluciones.nextval, w_direccion, w_empresa, w_pid, w_ia, 'porDevolver');
update personal set estado='Ocupado' where pid=w_pid;
COMMIT WORK;
END CREAR_DEVOLUCION;

--Procedure para modificar una devolución
CREATE OR REPLACE PROCEDURE modificar_devolucion(w_did IN devoluciones.did%TYPE, w_direccion IN devoluciones.direccion%type, w_empresa IN devoluciones.empresa%TYPE)
IS
BEGIN
update devoluciones set empresa = w_empresa where did=w_did;
update devoluciones set direccion = w_direccion where did=w_did;
COMMIT WORK;
END modificar_devolucion;

--Procedure para finalizar una devolución
CREATE OR REPLACE PROCEDURE fin_devolucion(w_did IN devoluciones.did%type, w_pid IN devoluciones.pid%TYPE)
IS
BEGIN
update devoluciones set estadoDevolucion = 'Devuelto' where did=w_did;
update personal set estado='Libre' where pid=w_pid;
COMMIT WORK; 
END FIN_DEVOLUCION;

--Procedure para crear un envío
CREATE OR REPLACE PROCEDURE crear_envio(w_direccion IN envios.direccion%TYPE, w_fechaEntrada IN envios.fechaEntrada%TYPE, w_fechaSalida IN envios.fechaSalida%TYPE, w_pid IN envios.pid%TYPE, w_peid IN envios.peid%TYPE)
IS
BEGIN
insert into ENVIOS(enid, direccion, fechaentrada, fechasalida, pid, peid, estadoEnvio) values (sec_envio.nextval, w_direccion, w_fechaentrada, w_fechasalida, w_pid, w_peid, 'porRealizar');
COMMIT WORK;
END CREAR_ENVIO;

--Procedure para cambiar el estado de un envío
CREATE OR REPLACE PROCEDURE actualiza_estado_envio(w_enid IN envios.enid%TYPE, w_estadoEnvio IN envios.estadoEnvio%TYPE)
IS
BEGIN
update envios set estadoEnvio = w_estadoEnvio where enid=w_enid;
COMMIT WORK;
END actualiza_estado_envio;

--Procedures para crear un evento y para avisar de que se empieza a preparar. El evento finalizará cuando llegue el envío de material de vuelta al almacén

create or replace PROCEDURE crear_evento(w_precioTotal IN evento.precioTotal%TYPE,w_lugar IN evento.lugar%TYPE,w_fechaInicio IN evento.fechaInicio%TYPE,w_fechaFin IN evento.fechaFin%TYPE,w_descripcionCliente IN evento.descripcionCliente%TYPE) IS
BEGIN
INSERT INTO evento(eid,precioTotal, lugar,fechainicio,fechafin,descripcioncliente,estadoevento)
VALUES (sec_evento.nextval, w_precioTotal, w_lugar, w_fechaInicio,w_fechaFin, w_descripcionCliente, 'porRealizar');
COMMIT WORK;
end crear_evento;

/*create or replace PROCEDURE comenzar_evento(w_eid IN evento.eid%TYPE) IS
BEGIN
UPDATE evento set estadoevento = 'enPreparacion' where eid=w_eid;
COMMIT WORK;
end comenzar_evento;
*/

--Procedure para asignar un empleado a un evento

/*CREATE OR REPLACE PROCEDURE asignar_personal_evento(w_pid IN mantenimiento.pid%TYPE, w_eid IN Personal.eid%TYPE)
IS
BEGIN 
UPDATE personal set estado='Ocupado' where pid=w_pid;
UPDATE personal set eid=w_eid where pid=w_pid;
COMMIT WORK;
end asignar_personal_evento;
*/
--Procedure para liberar personal

CREATE OR REPLACE PROCEDURE liberar_personal_evento(w_eid IN Personal.eid%TYPE)
IS
BEGIN
UPDATE personal set estado='Libre' where eid=w_eid;
UPDATE personal set eid=null where estado='Libre';
COMMIT WORK;
end liberar_personal_evento;

--Procedure para liberar material
CREATE OR REPLACE PROCEDURE liberar_material_evento(w_peid IN Inventario.peid%TYPE)
IS 
BEGIN
UPDATE inventario set estadoItem='Disponible' where peid=w_peid;
COMMIT WORK;
end liberar_material_evento;

--Procedure para crear un parte de equipo
CREATE OR REPLACE PROCEDURE CREAR_PARTEEQUIPO(w_eid IN parteEquipo.eid%TYPE) IS
BEGIN
INSERT INTO parteEquipo(peid, eid)
VALUES(sec_parteequipo.nextval, w_eid);
COMMIT WORK;
END CREAR_PARTEEQUIPO;

--Procedure para agregar un ítem al parte de equipo
create or replace procedure agregar_item_parte(w_referencia inventario.referencia%TYPE, w_peid inventario.peid%TYPE) IS
BEGIN
UPDATE inventario set peid=w_peid where referencia=w_referencia;
UPDATE inventario set estadoitem = 'enEvento' where referencia=w_referencia;
COMMIT WORK;
end agregar_item_parte;

--Procedura para agregar un ítem alquilado al parte de equipo
create or replace procedure agregar_itemalquilado_parte(w_nombre itemalquilado.nombre%TYPE, w_peid itemalquilado.peid%TYPE) IS
BEGIN
UPDATE itemalquilado set peid=w_peid where nombre=w_nombre;
COMMIT WORK;
end agregar_itemalquilado_parte;

--Procedure para ver el inventario. ARF01.
create or replace PROCEDURE ver_inventario IS
CURSOR c IS
SELECT referencia, nombre, estadoItem, precio, peid, pid FROM inventario;
BEGIN
DBMS_OUTPUT.PUT_LINE('INVENTARIO: REFERENCIA, NOMBRE, ESTADOITEM, PEID, PID');
FOR fila IN c LOOP
EXIT WHEN C%NOTFOUND;
DBMS_OUTPUT.PUT_LINE(fila.referencia || '   ' ||fila.nombre||'   '|| fila.estadoItem ||'   ' || fila.precio ||'   '|| fila.peid ||'   '|| fila.pid);
END LOOP;
COMMIT WORK;
end ver_inventario;

--Procedure para ver los partes de equipo.
create or replace PROCEDURE ver_ParteEquipo IS
CURSOR c1 IS
SELECT peid, eid FROM parteEquipo;
BEGIN
DBMS_OUTPUT.PUT_LINE('PARTE DE EQUIPO: PEID, EID');
FOR fila IN c1 LOOP
EXIT WHEN C1%NOTFOUND;
DBMS_OUTPUT.PUT_LINE(fila.peid || '   '|| fila.eid ||'   ');
END LOOP;
COMMIT WORK;
end ver_ParteEquipo;

--Procedure para ver información de los envíos. ARF04 y ARF05
create or replace PROCEDURE ver_envios IS
CURSOR c2 IS
SELECT enid, direccion, fechaEntrada, fechaSalida, pid, peid, estadoEnvio FROM envios;
BEGIN
DBMS_OUTPUT.PUT_LINE('ENVIOS: ENID, DIRECCION, FECHAENTREGA, FECHASALIDA, PID, PEID, ESTADOENVIO');
FOR fila IN c2 LOOP
EXIT WHEN C2%NOTFOUND;
DBMS_OUTPUT.PUT_LINE(fila.enid || '   ' ||fila.direccion||'   '|| fila.fechaEntrada ||'   ' || fila.fechaSalida||'   '|| fila.pid ||'   '|| fila.peid ||'   '||fila.estadoEnvio);
END LOOP;
COMMIT WORK;
end ver_envios;

--Procedure para ver los ítems que necesitan reparación. ARF06
create or replace PROCEDURE ver_item_por_reparar IS
CURSOR c3 IS
SELECT referencia, nombre FROM inventario where estadoItem = 'porReparar';
BEGIN
DBMS_OUTPUT.PUT_LINE('Items por reparar:');
FOR fila IN c3 LOOP
EXIT WHEN C3%NOTFOUND;
DBMS_OUTPUT.PUT_LINE(fila.referencia || '   ' ||fila.nombre);
END LOOP;
COMMIT WORK;
end ver_item_por_reparar;

--Procedure para ver quién repara un ítem. ARF07
create or replace PROCEDURE ver_reparador(w_referencia IN mantenimiento.referencia%TYPE) IS
CURSOR c4 IS
SELECT referencia, pid FROM mantenimiento where referencia=w_referencia;
BEGIN
FOR fila IN c4 LOOP
EXIT WHEN C4%FOUND;
DBMS_OUTPUT.PUT_LINE('Ítem: '|| fila.referencia || '  Empleado:   ' ||fila.pid);
END LOOP;
COMMIT WORK;
end ver_reparador;

--Procedure para ver la empresa a la que pertenece un ítem alquilado. ARF08
create or replace PROCEDURE ver_empresa(w_nombre IN itemalquilado.nombre%TYPE) IS
CURSOR c5 IS
SELECT empresa, nombre FROM itemalquilado where nombre=w_nombre;
BEGIN
FOR fila IN c5 LOOP
EXIT WHEN C5%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Ítem: '|| fila.nombre || '  Empresa:   ' ||fila.empresa);
END LOOP;
COMMIT WORK;
end ver_empresa;

--Procedure para ver los datos del personal
/*create or replace PROCEDURE ver_personal IS
CURSOR c6 IS
SELECT cargo,nombre,dni,telefono FROM personal;
BEGIN
FOR fila IN c6 LOOP
EXIT WHEN C6%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Nombre: ' ||fila.nombre ||  '  Cargo:   ' ||fila.cargo || ' DNI:   '  ||fila.dni ||'  Teléfono:   ' || fila.telefono );
END LOOP;
COMMIT WORK;
end ver_personal;
*/

--Procedure para ver el personal técnico. TRN04
create or replace PROCEDURE ver_tecnicos(w_eid IN personal.eid%TYPE) IS
CURSOR c7 IS
SELECT Nombre, dni, telefono FROM personal where (eid=w_eid and departamento='Tecnico');
BEGIN
FOR fila IN c7 LOOP
EXIT WHEN C7%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Nombre: ' ||fila.nombre  || '  DNI:   '  ||fila.dni|| '  Teléfono:   ' || fila.telefono );
END LOOP;
COMMIT WORK;
end ver_tecnicos;

--Procedure para ver ítems alquilados
/*
create or replace PROCEDURE ver_itemsalquilados IS
CURSOR c8 IS
SELECT tipo, nombre,empresa FROM itemalquilado;
BEGIN
FOR fila IN c8 LOOP
EXIT WHEN C8%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Tipo: ' ||fila.tipo ||  '  Nombre:   ' || fila.nombre|| '  Empresa:   ' || fila.empresa);
END LOOP;
COMMIT WORK;
end ver_itemsalquilados;
*/

--Requisito funcional TRF02
CREATE OR REPLACE PROCEDURE TRF02 IS CURSOR c9 IS 
SELECT nombre,cargo FROM personal WHERE (departamento='Tecnico' AND estado='Libre');
BEGIN
FOR fila IN c9 LOOP
EXIT WHEN C9%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Nombre: '||fila.nombre||'Cargo: '||fila.cargo);
END LOOP;
COMMIT WORK;
END TRF02;

--Muestra los items asociados a un evento
create or replace PROCEDURE ver_inventario_evento(w_eid IN evento.eid%TYPE) IS 
CURSOR c10 IS
SELECT nombre,referencia,precio FROM inventario where peid=funcion_ver_inventario(w_eid); 
BEGIN
FOR fila IN c10 LOOP
EXIT WHEN C10%NOTFOUND;
DBMS_OUTPUT.PUT_LINE('Nombre: ' || fila.nombre ||  '  Referencia:   ' ||fila.referencia||'  Precio:   ' ||fila.precio);
END LOOP;
COMMIT WORK;
end ver_inventario_evento;

--CREA ALOJAMIENTO
create or replace PROCEDURE crear_alojamiento(w_EID IN alojamiento.eid%TYPE,w_ciudad IN alojamiento.ciudad%TYPE,w_direccion IN alojamiento.direccion%TYPE,w_fechaInicio IN alojamiento.fechaInicio%TYPE,w_fechaFin IN alojamiento.fechafin%TYPE
,w_hotel IN alojamiento.hotel%TYPE,w_numPersonas IN alojamiento.numpersonas%TYPE) IS
BEGIN
INSERT INTO alojamiento(ciudad,direccion, fechainicio,fechafin,hotel,numpersonas,eid)
VALUES (w_ciudad, w_direccion, w_fechaInicio, w_fechaFin,w_hotel, w_numPersonas, w_EID);
COMMIT WORK;
end crear_alojamiento;

--PARA CREAR TRANSPORTE
create or replace PROCEDURE crear_transporte(w_medioutilizado IN transporte.medioutilizado%TYPE,w_numpersonas in transporte.numpersonas%type,w_eid IN transporte.eid%TYPE) IS
BEGIN
INSERT INTO transporte(tid,medioutilizado, numpersonas,eid)
VALUES (SEC_TRANSPORTE.nextval, w_medioutilizado, w_numpersonas, w_eid);
COMMIT WORK;
end crear_transporte;

--PARA MODIFICAR ALOJAMIENTO
create or replace PROCEDURE MODIFICAR_ALOJAMIENTO(w_CIUDAD IN ALOJAMIENTO.CIUDAD%TYPE,w_DIRECCION IN alojamiento.direccion%TYPE,w_FECHAI IN alojamiento.fechainicio%TYPE,w_FECHAF IN alojamiento.fechafin%TYPE,
w_HOTEL IN alojamiento.hotel%TYPE,w_NUMPERSONAS IN alojamiento.numpersonas%TYPE, w_EID IN alojamiento.eid%TYPE) is
begin
UPDATE ALOJAMIENTO SET CIUDAD = w_CIUDAD,direccion=w_direccion, fechainicio=w_fechai,fechafin=w_fechaf,HOTEL=w_HOTEL,numpersonas=w_numpersonas where EID=w_EID;
commit work;
end MODIFICAR_ALOJAMIENTO;

--PARA MODIFICAR EVENTO
create or replace PROCEDURE MODIFICAR_EVENTO(w_EID IN evento.eid%TYPE,w_PRECIOTOTAL IN EVENTO.PRECIOTOTAL%TYPE,w_LUGAR IN EVENTO.LUGAR%TYPE,w_FECHAI IN EVENTO.FECHAINICIO%TYPE,
w_FECHAF IN evento.fechafin%TYPE,w_DESCRIPCION IN evento.descripcioncliente%TYPE, w_ESTADO IN evento.estadoevento%TYPE) is
begin
UPDATE EVENTO SET PRECIOTOTAL = w_PRECIOTOTAL,LUGAR=w_LUGAR, fechainicio=w_fechai,fechafin=w_fechaf,descripcioncliente=w_descripcion,estadoevento=w_estado where EID=w_EID;
commit work;
end MODIFICAR_EVENTO;

--PARA MODIFICAR ITEM ALQUILADO
create or replace PROCEDURE modificar_itema(w_IA IN itemalquilado.IA%TYPE,w_tipo IN itemalquilado.tipo%TYPE, w_nombre IN itemalquilado.nombre%TYPE, w_empresa IN itemalquilado.empresa%TYPE, w_fechallegada IN itemalquilado.fechaLlegada%TYPE, w_fechadevolucion IN itemalquilado.fechadevolucion%TYPE, w_cantidad IN itemalquilado.cantidad%TYPE, w_precio IN itemalquilado.precio%TYPE, w_pid IN itemalquilado.pid%TYPE, w_peid IN itemalquilado.peid%TYPE)
IS
BEGIN 
update itemalquilado set tipo=w_tipo, nombre=w_nombre, empresa=w_empresa, fechaLlegada=w_fechallegada, fechaDevolucion=w_fechadevolucion, cantidad=w_cantidad, precio=w_precio, pid=w_pid, peid=w_peid where
IA=W_IA;
COMMIT WORK;
end modificar_itema;

--PARA MODIFICAR PERSONAL
create or replace PROCEDURE MODIFICAR_PERSONAL(w_PID IN PERSONAL.PID%TYPE, w_DEPARTAMENTO IN personal.departamento%TYPE,w_NOMBRE IN PERSONAL.NOMBRE%TYPE,w_CARGO IN PERSONAL.CARGO%TYPE,
w_SUELDO IN PERSONAL.SUELDO%TYPE,w_DNI IN PERSONAL.DNI%TYPE,w_TELEFONO IN PERSONAL.TELEFONO%TYPE,w_ESTADO IN PERSONAL.ESTADO%TYPE,w_EID IN PERSONAL.EID%TYPE,
w_PEID IN PERSONAL.PEID%TYPE) is
begin
UPDATE personal SET PID=w_PID, DEPARTAMENTO=w_DEPARTAMENTO, NOMBRE=w_NOMBRE,CARGO=w_CARGO,SUELDO=w_SUELDO,DNI=w_DNI, TELEFONO=w_TELEFONO,ESTADO=w_ESTADO,EID=w_EID,PEID=w_PEID where PID=w_PID;
commit work;
end MODIFICAR_PERSONAL;


--PARA MODIFICAR TRANSPORTE
create or replace PROCEDURE MODIFICAR_TRANSPORTE(w_TID IN TRANSPORTE.TID%TYPE,w_MU IN transporte.medioutilizado%TYPE,w_NP IN transporte.numpersonas%TYPE,w_EID IN transporte.eid%TYPE) is
begin
UPDATE transporte SET MEDIOUTILIZADO = w_MU,NUMPERSONAS=w_NP, EID=w_EID where TID=w_TID;
commit work;
end MODIFICAR_TRANSPORTE;


--PARA QUITAR ALOJAMIENTO
create or replace PROCEDURE quitar_alojamiento(w_EID IN evento.EID%TYPE,w_HOTEL IN ALOJAMIENTO.HOTEL%TYPE) is
begin
delete alojamiento where EID=w_eid AND HOTEL=w_hotel;
commit work;
end quitar_alojamiento;


-PARA QUITAR EVENTO
create or replace PROCEDURE quitar_evento(w_EID IN evento.EID%TYPE) is
begin
delete evento cascade where eid=w_EID;
commit work;
end quitar_evento;


--PARA QUITAR ITEMALQUILADO
create or replace PROCEDURE quitar_itema(w_IA IN itemalquilado.ia%TYPE) is
begin
delete itemalquilado where IA=w_IA;
commit work;
end quitar_itema;


-PARA QUITAR MATERIALNECESARIO
create or replace PROCEDURE quitar_materialnecesario(w_MID IN materialnecesario.MID%TYPE) is
begin
delete materialnecesario where mid=w_MID;
commit work;
end quitar_materialnecesario;



-PARA QUITAR PERSONAL
create or replace PROCEDURE quitar_personal(w_pid in personal.pid%type) is
begin
delete personal where pid=w_pid;
commit work;
end quitar_personal;



-PARA QUITAR TRANSPORTE
create or replace PROCEDURE QUITAR_TRANSPORTE(w_TID IN TRANSPORTE.TID%TYPE) is
begin
delete TRANSPORTE cascade where TID=w_TID;
commit work;
end QUITAR_TRANSPORTE;


------------------------------------Funciones-----------------------------------
--Requisito PRF05
/*CREATE OR REPLACE FUNCTION  PERSONAL_EVENTO(weid in evento.eid%type) RETURN VARCHAR2 AS wdireccion alojamiento.direccion%type;
BEGIN
select direccion into wdireccion from alojamiento where eid=weid;
  RETURN wdireccion;
END PERSONAL_EVENTO;

--Devuelve el número de ítems asociados a un evento dado. Parte de equipo de ese evento.
create or replace FUNCTION FUNCION_VER_INVENTARIO(weid in evento.eid%type) RETURN number AS wpeid parteequipo.peid%type;
BEGIN
select peid into wpeid from parteequipo where eid=weid;
  RETURN wpeid;
END FUNCION_VER_INVENTARIO;
*/

--
