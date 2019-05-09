--Pruebas de la tabla Personal
insert into Personal(pid, departamento, nombre, cargo, sueldo, dni, telefono, estado, eid, peid) values(500, 'Almacen', 'V�ctor Jim�nez', 'Encargado', 32, '32165498M', 954000000, 'Libre', null, null);
update Personal set sueldo=35 where pid=500;
delete from Personal where pid=500;
select * from Personal;

--CASO DE PRUEBA 1. El cliente quiere realizar un evento. Todos los �tems y empelados est�n disponibles. Sueldo y precio de alquiler por d�a
--Carga de empleados
execute contratar_personal_almacen('Miguel L�pez','Mozo', 32, '28888888N', 954322222);
execute contratar_personal_almacen('�lvaro Jim�nez','Encargado', 31, '28888881N', 954322221);
execute contratar_personal_tecnico('Manuel L�pez','TecnicoSonido', 45, '27888888N', 954322722);
execute contratar_personal_tecnico('Alicia D�az','TecnicoLuces', 40, '27888868F', 954311722);
execute contratar_personal_produccion('Miguel P�rez','JefeProduccion', 50, '26888888A', 975322822);
execute contratar_personal_comercial('Mart�n L�pez','Telefonista', 31, '25888888B', 954322922);
select*from personal;

--Carga de �tems. Nombre,`precio, PID, caracter�stica1, caracter�stica2
execute agregar_altavoz('Electrovoice', 5, 35, 50, 12);
execute agregar_microfono('Blue Mic', 3, 35, 'Phantom', 'Atril');
execute agregar_pantalla('LG 2095', 4, 35, 32, 1080);
--execute borrar_item(26, 3);
select * from Inventario;
select * from Altavoces;

--Creaci�n del evento. Precio, lugar, fechaInicio, fechaFin y descripci�n
execute crear_evento(6000, 'Hospital Macarena', TO_DATE('2019/05/03 19:00:00','yyyy/mm/dd hh24:mi:ss'),TO_DATE('2019/05/04 00:00:00','yyyy/mm/dd hh24:mi:ss'), 'Retransmisi�n de cirug�a');
select * from evento;

--Asignar personal al evento. PID y EID
execute asignar_personal_evento(2000034, 43);
execute asignar_personal_evento(2000035, 43);
select * from personal;

--Dar comienzo a la preparaci�n del evento. EID
execute comenzar_evento(43);

--Creaci�n del parte de equipo. EID
execute crear_parteequipo(43);
select * from parteEquipo;

--Agregar �tems al parte. Referencia y parte
execute agregar_item_parte(63, 38);
execute agregar_item_parte(64, 38);
execute agregar_item_parte(65, 38);

--Crear el env�o de los �tems al evento. Direcci�n, fechaEntrada, fechaSalida, PID, PEID
execute crear_envio('Hospital Macarena', TO_DATE('2019/05/07 19:00:00','yyyy/mm/dd hh24:mi:ss'),TO_DATE('2019/05/01 00:00:00','yyyy/mm/dd hh24:mi:ss'), 35, 38);
select * from envios;

--Informa de que el env�o ha salido del almac�n. ENID y estado 
execute actualiza_estado_envio(42, 'enEvento');
execute actualiza_estado_envio(42, 'recibido');
select* from envios;
select* from evento;

--Liberar personal del evento. EID
execute liberar_personal_evento(43);
select *from personal;

--Liberar material del evento para que pueda ser usado en otro. PEID
execute liberar_material_evento(38);
select * from inventario;


--CASO DE PRUEBA 2. PROCESO DE REPARACI�N
select * from inventario;
select * from mantenimiento;

--Da el aviso de que se necesita reparaci�n. Referencia
EXECUTE necesita_reparacion(63);

--Asigna la reparaci�n a un empleado. PID y referencia
EXECUTE asignar_reparacion(35, 63);

--Da por finalizada una reparaci�n. PID y referencia
EXECUTE fin_reparacion(35, 63);