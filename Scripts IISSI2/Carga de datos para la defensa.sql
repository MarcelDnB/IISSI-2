--Carga de datos - ZeUS
--Carga de personal
execute crear_usuario('Almacen','Empleado10', 'Encargado', 50, '23456789A', 610000000,'Libre',null,null, 'alm10@zeus.es', 'qwerty');
execute crear_usuario('Almacen','Empleado11', 'Encargado', 50, '23456789B', 610000001, 'Libre',null,null,'alm11@zeus.es', 'qwerty');
execute crear_usuario('Almacen','Empleado12', 'Encargado', 50, '23456789C', 610000002, 'Libre',null,null,'alm12@zeus.es', 'qwerty');
execute crear_usuario('Almacen','Empleado13', 'Encargado', 50, '23456789D', 610000003, 'Libre',null,null,'alm13@zeus.es', 'qwerty');
execute crear_usuario('Almacen','Empleado14', 'Encargado', 50, '23456789E', 610000004, 'Libre',null,null,'alm14@zeus.es', 'qwerty');
execute crear_usuario('Produccion','Empleado20', 'Encargado', 50, '33456789A', 620000000, 'Libre',null,null,'prod20@zeus.es', 'qwerty');
execute crear_usuario('Produccion','Empleado21', 'Encargado', 50, '33456789B', 620000001, 'Libre',null,null,'prod21@zeus.es', 'qwerty');
execute crear_usuario('Produccion','Empleado22', 'Encargado', 50, '33456789C', 620000002, 'Libre',null,null,'prod22@zeus.es', 'qwerty');
execute crear_usuario('Produccion','Empleado23', 'Encargado', 50, '33456789D', 620000003, 'Libre',null,null,'prod23@zeus.es', 'qwerty');
execute crear_usuario('Tecnico','Empleado30', 'Encargado', 50, '43456789A', 630000000, 'Libre',null,null,'tec30@zeus.es', 'qwerty');
execute crear_usuario('Tecnico','Empleado31', 'Encargado', 50, '43456789B', 630000001, 'Libre',null,null,'tec31@zeus.es', 'qwerty');
execute crear_usuario('Tecnico','Empleado32', 'Encargado', 50, '43456789C', 630000002, 'Libre',null,null,'tec32@zeus.es', 'qwerty');
execute crear_usuario('Tecnico','Empleado33', 'Encargado', 50, '43456789D', 630000003, 'Libre',null,null,'tec33@zeus.es', 'qwerty');
execute crear_usuario('Tecnico','Empleado34', 'Encargado', 50, '43456789E', 630000004, 'Libre',null,null,'tec34@zeus.es', 'qwerty');

--Carga de ítems
execute agregar_altavoz('ALESIS Elevate 5',20,30,5);
execute agregar_altavoz('Mackien Thump 15A',30,1200,15);
execute agregar_altavoz('JBL EON 615',35,1000,12);
execute agregar_altavoz('JBL EON 615',35,1000,12);
execute agregar_altavoz('ALTO PROFESIONAL TS',25,215,15);
execute agregar_altavoz('ELECTRO VOICE ZLX-12',21,700,12);
execute agregar_microfono('Blue Snowball',30,'USB','Mesa');
execute agregar_microfono('Shure SM57',20,'48V','Instr.');
execute agregar_microfono('Sennheiser E835S',25,'Dinámico','Mano');
execute agregar_otrositems('Oculus Rift VR',50);
execute agregar_otrositems('Atril micro',7);
execute agregar_otrositems('Cable HDMI 1m',3);

--Carga de eventos
execute crear_evento(6000, 'Hospital Macarena', TO_DATE('2019/07/08 19:00:00','yyyy/mm/dd hh24:mi:ss'),TO_DATE('2019/07/10 00:00:00','yyyy/mm/dd hh24:mi:ss'), 'Retransmisión de cirugía');

