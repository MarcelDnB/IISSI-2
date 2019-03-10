------------------------------------DROP_TABLES------------------------------------   TECNICO tienes q añadir en tecnico: cargo Y   tienes q quitar la asociacion compra/pide
 
            DROP TABLE Evento;
            DROP TABLE PersonalTecnico;
            DROP TABLE PersonalTecnicoExterno;
            DROP TABLE Alojamiento;
            DROP TABLE Transporte;
            DROP TABLE parteEquipo;
            DROP TABLE itemAlquilado;
            DROP TABLE Inventario;
            DROP TABLE personalAlmacen;
            DROP TABLE Envios;
            DROP TABLE Mantenimiento;
            DROP TABLE Altavoces;
            DROP TABLE Microfono;
            DROP TABLE Pantalla;
            DROP TABLE mesaMezcla;
            DROP TABLE Foco;
            DROP TABLE Proyector;
            DROP TABLE Cable;
            DROP TABLE Ordenador;

------------------------------------TABLAS_IMPORTANTES------------------------------------


            create table Evento (
            eid number(5) primary key,
            precioTotal number(10),
            lugar varchar2(40),
            fechaInicio date,
            fechaFin date,
            constraint fechas check(fechaInicio < fechaFin),
            descripcionCliente varchar2(140),
            estadoEvento varchar2(15) check (estadoEvento in ('realizado','porRealizar')),
            );

            CREATE TABLE personalTecnico(
            ptid number(5) primary key,
            nombre varchar2(20),
            cargo varchar2(20),
            sueldo number(10) check (sueldo>20),  --Sueldo por día
            dni varchar2(9) unique,
            telefono number(9),
            direccion varchar2(50),
            estado varchar2(10) not null,
            eid number(5),
            pid number(4),
            foreign key(eid) references evento,
            foreign key(direccion) references alojamiento,
            foreign key(peid) references parteEquipo
            );

            CREATE TABLE personalTecnicoExterno(
            pteid number(5) primary key,
            cargo varchar2(20),
            nombre varchar2(20),
            sueldo number(10) check(sueldo>20),
            eid number(5),
            dni varchar2(9) unique,
            direccion varchar2(50),
            telefono number(12),
            fechaInicio date default SYSDATE, 
            fechaFin date,
            constraint fechas check(fechaInicio < fechaFin),
            foreign key(eid) references evento,
            foreign key(direccion) references alojamiento
            );

            create table Alojamiento(
            ciudad varchar2(20),
            direccion varchar2(50) primary key,
            fechaInicio date default SYSDATE,
            fechaFin date,
            constraint fechas check(fechaInicio < fechaFin),
            hotel varchar2(40),
            numPersonas number(4)
            );

            create table Transporte(
            tid number(5) primary key,
            medioUtilizado varchar2(10),
            numPersonas number(4),
            direccion varchar2(50),
            foreign key(direccion) references alojamiento
            );

            create table Inventario(
            referencia number(10) primary key,
            nombre varchar2(30),
            estadoItem varchar2(20) check (estadoItem in ('disponible','enEvento','enMantenimiento','por reparar')),
            precio number(20) check (precio>=0),
            pid number(4),
            foreign key(peid) references parteEquipo,
            foreign key(paid) references personalAlmacen
            );

            create table itemAlquilado(
            tipo varchar2(10),
            nombre varchar2(10),
            Empresa varchar2(10) not null,
            fechaLlegada date default sysdate,
            fechaDevolucion date not null,
            constraint fechas check(fechaLlegada <= fechaDevolucion),
            cantidad number(5),
            precio number(5) check (precio >=0),
            pid number(4),
            envid number(14),
            foreign key(peid) references parteEquipo,
            foreign key(enid) references envios
            );
          
            create table parteEquipo(
            peid number(4) primary key,
            referencia number(10),
            eid number(5),
            foreign key(eid) references evento
            );
            
            create table personalAlmacen( 
            paid number(5) primary key,
            nombre varchar2(20),
            dni varchar2(9) unique,
            cargo varchar2(20),
            sueldo number(6) check (sueldo>20),
            telefono number(9),
            direccion varchar2(50),
            estadoEmpleado varchar(7) check (estadoEmpleado in ('Libre','Ocupado'))
            );
            
            create table Envios(
            enid number(14) primary key,
            direccion varchar2(30),
            fechaEntrada date,
            fechaSalida date, 
            constraint fechas check(fechaEntrada < fechaSalida),
            estadoEnvio varchar2(11) check (estadoEnvio in ('porRealizar','enEvento','recibido')),
            foreign key(paid) references personalAlmacen
            );
            
            create table Mantenimiento(
            fechaInicio date,
            fechaFin date,
            constraint fechas check(fechaInicio < fechaFin),
            foreign key(paid) references personalAlmacen
            );







------------------------------------TABLAS_MENOS_IMPORTANTES------------------------------------


            create table Altavoces(
            potencia number(4),
            referencia number(10),
            pulgadas number(2),
            foreign key(referencia) references inventario
            );
            
            create table Microfono(
            alimentacion varchar2(7),
            tipoSujeccion varchar2(10),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table Pantalla(
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
            
            create table Foco(
            tipoLuz varchar2(20),
            tipoMovimimiento varchar2(7),
            potencia number(5),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table Proyector(
            resolucion number(4),
            lumenes number(5),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table Cable(
            conexion varchar2(6),
            metros number(4),
            referencia number(10),
            foreign key(referencia) references inventario
            );
            
            create table Ordenador(
            procesador varchar2(15),
            gbram number(3),
            referencia number(10),
            foreign key(referencia) references inventario
            );