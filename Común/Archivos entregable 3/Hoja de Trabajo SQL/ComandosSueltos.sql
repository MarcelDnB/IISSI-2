insert into evento values(2,4500,'Huelva-prado-plaza',null,null,'blablablabla','porRealizar',123456789);
insert into evento values(3,4500,'Huelva-plaza',null,null,'blablablabla','preparacion',123436789);
UPDATE EVENTO SET ESTADO='PORREALIZAR' WHERE EID=2; 
insert into personaltecnico values('encargadoAudio','juan',);

ALTER TRIGGER PRN02 ENABLE;



CREATE OR REPLACE TRIGGER PRN02 
BEFORE INSERT ON EVENTO
FOR EACH ROW
BEGIN
  IF(:new.estadoevento != 'preparacion') then raise_application_error(-20600,'el evento se debe crear en estado "preparacion"');
end if;
END;



CREATE OR REPLACE TRIGGER PRN02_1 
BEFORE UPDATE ON EVENTO 
FOR EACH ROW
declare aux evento.eid%type;
BEGIN
    select eid into aux from personal where eid=:new.eid;
  IF((:NEW.ESTADOEVENTO='porRealizar' and :old.estadoevento='preparacion') and aux=0) then raise_application_error(-20600,'el evento no puede pasar a porRealizar debido a que no hay ningun 
  técnico asociado al evento');
  end if;
END;