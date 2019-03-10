------------------------------------DROP_TABLES------------------------------------   TECNICO tienes q añadir en tecnico: cargo y tienes q quitar la asociacion compra/pide


            DROP TABLE altavoces;
            DROP TABLE inventario; 
            DROP TABLE EVENTO;
            DROP TABLE PERSONAL;
            DROP TABLE PERSONALEXTERNO;
            DROP TABLE ALOJAMIENTO;
            DROP TABLE TRANSPORTE;
            DROP TABLE parteequipo;
            DROP TABLE itemalquilado;


------------------------------------TABLAS_IMPORTANTES------------------------------------


            create table EVENTO (
            eid number(5),
            precioTotal number(10),
            lugar varchar2(40),
            fechaInicio date,
            fechaFin date,
            descripcionCliente varchar2(140),
            estadoEvento varchar2(15) check (estadoEvento in ('realizado','porRealizar')),
            dni varchar2(9),
            primary key(eid)
            );

            CREATE TABLE PERSONALTECNICO(
            cargo varchar2(20),
            nombre varchar2(20),
            sueldo number(10),
            dni varchar2(9),
            telefono number(9),
            eid number(5),
            direccion varchar2(50),
            estado varchar2(10),
            pid number(4),
            primary key(dni),
            foreign key(eid) references evento,
            foreign key(direccion) references alojamiento,
            foreign key(pid) references parteEquipo
            );

            CREATE TABLE PERSONALTECNICOEXTERNO(
            cargo varchar2(20),
            nombre varchar2(20),
            sueldo number(10),
            eid number(5),
            dni varchar2(9),
            direccion varchar2(50),
            telefono number(12),
            fechaInicio date, 
            fechaFin date,
            primary key(dni),
            foreign key(eid) references evento,
            foreign key(direccion) references alojamiento
            );

            create table ALOJAMIENTO(
            ciudad varchar2(20),
            direccion varchar2(50),
            fechaInicio date,
            fechaFin date,
            hotel varchar2(40),
            dni varchar2(9),
            numPersonas number(4),
            primary key(direccion)
            );

            create table TRANSPORTE(
            medioUtilizado varchar2(10),
            numPersonas number(4),
            direccion varchar2(50),
            foreign key(direccion) references alojamiento
            );

            create table inventario( -- por hacer el inventario relacionado con el personal de almacen
            referencia number(10) primary key,
            nombre varchar(30),
            estadoItem varchar(20) check (estadoItem in ('disponible','enEvento','enMantenimiento','por reparar')),
            precio number(20),
            pid number(4),
            foreign key(pid) references parteEquipo
            );

            create table itemAlquilado(
            tipo varchar2(10),
            nombre varchar2(10),
            Empresa varchar2(10),
            Fechallegada date,
            Fechadevolucion date,
            cantidad number(5),
            precio number(5),
            pid number(4),
            envid number(14),
            foreign key(pid) references parteEquipo,
            foreign key(envid) references envios
            );
          
            create table parteEquipo(
            pid number(4) primary key,
            referencia number(10),
            eid number(5),
            foreign key(eid) references evento
            );
            
            create table personalAlmacen( -- esto contiene el personal de transporte
            cargo varchar2(20),
            nombre varchar2(20),
            sueldo number(10),
            dni varchar2(9),
            telefono number(9),
            direccion varchar2(50),
            estado varchar2(10),
            primary key(dni)
            );
            
            create table envios(
            envid number(14) primary key,
            direccion varchar2(30),
            fechaEntrada date,
            fechaSalida date, 
            dni varchar2(9),
            estadoEnvio varchar2(11) check (estadoEnvio in ('porRealizar','enEvento','recibido')),
            foreign key(dni) references personalAlmacen
            );
            
            create table mantenimiento(
            fechaInicio date,
            fechaFin date,
            dni varchar2(9),
            foreign key(dni) references personalAlmacen
            );







------------------------------------TABLAS_MENOS_IMPORTANTES------------------------------------


            create table altavoces(
            potencia number(4),
            referencia number(10),
            pulgadas number(2),
            aid number(3),
            foreign key(referencia) references inventario
            );
            
            create table microfono(
            alimentacion varchar2(7),
            tipoSujeccion varchar2(10),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table pantalla(
            tamaño number(3),
            resolucion number(4),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table mesaMezcla(
            canales number(2),
            tipo varchar2(10),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table foco(
            tipoLuz varchar2(20),
            tipoMovimimiento varchar2(7),
            potencia number(5),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table proyector(
            resolucion number(4),
            lumenes number(5),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table cable(
            conexion varchar2(6),
            metros number(4),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table ordenador(
            procesador varchar2(15),
            gbram number(3),
            referencia number(10),
            foreign key(referencia) references inventario
            );