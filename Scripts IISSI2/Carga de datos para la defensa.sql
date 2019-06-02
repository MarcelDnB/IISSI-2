--Carga de datos - ZeUS
--Carga de personal
execute contratar_personal_almacen('Empleado10', 'Encargado', 50, '23456789A', 610000000, 'alm10@zeus.es', 'qwerty');
execute contratar_personal_almacen('Empleado11', 'Encargado', 50, '23456789B', 610000001, 'alm11@zeus.es', 'qwerty');
execute contratar_personal_almacen('Empleado12', 'Encargado', 50, '23456789C', 610000002, 'alm12@zeus.es', 'qwerty');
execute contratar_personal_almacen('Empleado13', 'Encargado', 50, '23456789D', 610000003, 'alm13@zeus.es', 'qwerty');
execute contratar_personal_almacen('Empleado14', 'Encargado', 50, '23456789E', 610000004, 'alm14@zeus.es', 'qwerty');
execute contratar_personal_produccion('Empleado20', 'Encargado', 50, '33456789A', 620000000, 'prod20@zeus.es', 'qwerty');
execute contratar_personal_produccion('Empleado21', 'Encargado', 50, '33456789B', 620000001, 'prod21@zeus.es', 'qwerty');
execute contratar_personal_produccion('Empleado22', 'Encargado', 50, '33456789C', 620000002, 'prod22@zeus.es', 'qwerty');
execute contratar_personal_produccion('Empleado23', 'Encargado', 50, '33456789D', 620000003, 'prod23@zeus.es', 'qwerty');
execute contratar_personal_tecnico('Empleado30', 'Encargado', 50, '43456789A', 630000000, 'tec30@zeus.es', 'qwerty');
execute contratar_personal_tecnico('Empleado31', 'Encargado', 50, '43456789B', 630000001, 'tec31@zeus.es', 'qwerty');
execute contratar_personal_tecnico('Empleado32', 'Encargado', 50, '43456789C', 630000002, 'tec32@zeus.es', 'qwerty');
execute contratar_personal_tecnico('Empleado33', 'Encargado', 50, '43456789D', 630000003, 'tec33@zeus.es', 'qwerty');
execute contratar_personal_tecnico('Empleado34', 'Encargado', 50, '43456789E', 630000004, 'tec34@zeus.es', 'qwerty');

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

