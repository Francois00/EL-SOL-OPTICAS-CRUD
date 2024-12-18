CREATE DATABASE ElSol;
USE ElSol;

CREATE TABLE Empleado (
    codigo_empleado CHAR(10) NOT NULL,
    nombre_empleado VARCHAR(45) NOT NULL,
    turno CHAR(5) NOT NULL,
    estado CHAR(8) NOT NULL,
    PRIMARY KEY (codigo_empleado)
) ENGINE = InnoDB;

CREATE TABLE Catalogo (
    codigo_catalogo CHAR(3) NOT NULL,
    version INT NOT NULL,
    tipo_de_productos VARCHAR(25) NOT NULL,
    fecha_ultima_modificacion DATE NOT NULL,
    stock INT NOT NULL,
    codigo_empleado CHAR(10) NOT NULL,
    PRIMARY KEY (codigo_catalogo),
    INDEX codigo_empleado_idx (codigo_empleado),
    CONSTRAINT fk_codigo_empleado FOREIGN KEY (codigo_empleado) REFERENCES Empleado (codigo_empleado)
) ENGINE = InnoDB;

CREATE TABLE Producto (
    codigo_producto CHAR(5) NOT NULL,
    nombre VARCHAR(25) NOT NULL,
    marca VARCHAR(25) NOT NULL,
    descripcion VARCHAR(45) NULL,
    precio DECIMAL(10,2) NOT NULL,
    tipo_de_producto VARCHAR(45) NOT NULL,
    codigo_catalogo CHAR(3) NOT NULL,
    PRIMARY KEY (codigo_producto),
    INDEX codigo_catalogo_idx (codigo_catalogo),
    CONSTRAINT fk_codigo_catalogo FOREIGN KEY (codigo_catalogo) REFERENCES Catalogo (codigo_catalogo)
) ENGINE = InnoDB;

CREATE TABLE Proveedor (
    codigo_proveedor CHAR(10) NOT NULL,
    nombre_proveedor VARCHAR(45) NOT NULL,
    PRIMARY KEY (codigo_proveedor)
) ENGINE = InnoDB;

CREATE TABLE Pedido (
    numero_pedido CHAR(5) NOT NULL,
    codigo_empleado CHAR(10) NOT NULL,
    codigo_proveedor CHAR(10) NOT NULL,
    PRIMARY KEY (numero_pedido),
    INDEX codigo_empleado_idx (codigo_empleado),
    INDEX codigo_proveedor_idx (codigo_proveedor),
    CONSTRAINT fk_codigo_empleado_pedido FOREIGN KEY (codigo_empleado) REFERENCES Empleado (codigo_empleado),
    CONSTRAINT fk_codigo_proveedor_pedido FOREIGN KEY (codigo_proveedor) REFERENCES Proveedor (codigo_proveedor)
) ENGINE = InnoDB;

CREATE TABLE Distribuir_Productos (
    codigo_producto CHAR(5) NOT NULL,
    codigo_proveedor CHAR(10) NOT NULL,
    fecha_de_ingreso DATE NOT NULL,
    PRIMARY KEY (codigo_producto, codigo_proveedor),
    INDEX codigo_proveedor_idx (codigo_proveedor),
    CONSTRAINT fk_codigo_producto FOREIGN KEY (codigo_producto) REFERENCES Producto (codigo_producto),
    CONSTRAINT fk_codigo_proveedor FOREIGN KEY (codigo_proveedor) REFERENCES Proveedor (codigo_proveedor)
) ENGINE = InnoDB;

CREATE TABLE Incluir_Producto (
    codigo_producto CHAR(5) NOT NULL,
    numero_pedido CHAR(5) NOT NULL,
    cantidad INT NOT NULL,
    PRIMARY KEY (codigo_producto, numero_pedido),
    INDEX numero_pedido_idx (numero_pedido),
    CONSTRAINT fk_codigo_producto_incluir FOREIGN KEY (codigo_producto) REFERENCES Producto (codigo_producto),
    CONSTRAINT fk_numero_pedido FOREIGN KEY (numero_pedido) REFERENCES Pedido (numero_pedido)
) ENGINE = InnoDB;

CREATE TABLE Proveedor_Telefonos (
    codigo_proveedor CHAR(10) NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    PRIMARY KEY (codigo_proveedor, telefono),
    CONSTRAINT fk_codigo_proveedor_telefonos FOREIGN KEY (codigo_proveedor) REFERENCES Proveedor (codigo_proveedor)
) ENGINE = InnoDB;

CREATE TABLE Proveedor_Correos (
    codigo_proveedor CHAR(10) NOT NULL,
    correo VARCHAR(60) NOT NULL,
    PRIMARY KEY (codigo_proveedor, correo),
    CONSTRAINT fk_codigo_proveedor_correos FOREIGN KEY (codigo_proveedor) REFERENCES Proveedor (codigo_proveedor)
) ENGINE = InnoDB;

CREATE TABLE Empleado_Telefonos (
    codigo_empleado CHAR(10) NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    PRIMARY KEY (codigo_empleado, telefono),
    CONSTRAINT fk_codigo_empleado_telefonos FOREIGN KEY (codigo_empleado) REFERENCES Empleado (codigo_empleado)
) ENGINE = InnoDB;

INSERT INTO Empleado VALUES 
('2014010012', 'Aurelio Valderrama Dueñas', 'Dia', 'Inactivo'),
('2014010078', 'Jose Manuel Muñoz', 'Dia', 'Inactivo'),
('2015020056', 'Guadalupe Oliva Blazquez', 'Tarde', 'Activo'),
('2015010018', 'Catalina Guzmán', 'Dia', 'Inactivo'),
('2015025040', 'Aurelio Peralta Borja', 'Tarde', 'Activo'),
('2015026039', 'María Cristina Polo', 'Tarde', 'Activo'),
('2016017039', 'Luís Pereira Talavera', 'Dia', 'Inactivo'),
('2016018038', 'Noelia Torres Muñoz', 'Dia', 'Activo'),
('2017119038', 'Pilar Leiva Martinez', 'Dia', 'Activo'),
('2017020038', 'Leonel Cortes Carrión', 'Tarde', 'Activo'),
('2017021037', 'Sonia Loida Girón Amaya', 'Tarde', 'Inactivo'),
('2018022037', 'Juan José Pinedo', 'Tarde', 'Inactivo'),
('2020023036', 'Andrés Felipe Gonzalez Cuesta', 'Tarde', 'Activo');

INSERT INTO Empleado_Telefonos VALUES 
('2014010012', '979008272'),
('2014010078', '993765927'),
('2015020056', '997588710'),
('2015010018', '979461944'),
('2015025040', '971677336'),
('2015026039', '969445859'),
('2016017039', '980988338'),
('2016018038', '988439954'),
('2017119038', '986262582'),
('2017020038', '967148428'),
('2017021037', '975114806'),
('2018022037', '999143043'),
('2020023036', '981164905');

INSERT INTO Proveedor VALUES 
('5420101010', 'Francisco Carlos Molina'),
('5420111015', 'Sonia Aguilar Caceres'),
('5420142020', 'Camila Zúñiga'),
('5420132025', 'Julio Oviedo Muñoz'),
('5420193035', 'Jorge Enrique Gutierrez'),
('5420103040', 'Graciela Gladys Grau'),
('5420113045', 'Isaac Saul Barrios'),
('5120181025', 'Sergio Tomas Garate'),
('5120181035', 'Rosa Beatriz Ballesteros'),
('5220001015', 'Grupo Solar'),
('5220001020', 'Benigna Marta Cespedes'),
('5220102025', 'Esther Rocio Villalba'),
('5220102035', 'Raquel Luisa Olmedo'),
('5320161055', 'Rosa Maria Chavez'),
('5320161045', 'Asunción Gomez'),
('1120011015', 'Grupo Zambrano'),
('1120011025', 'Grupo Diaz'),
('1120021035', 'Grupo San Agustin'),
('1120031045', 'Teresa Izaguirre de Ocampo'),
('1120061050', 'Maria Villanueva Benavides'),
('1120092060', 'Adelia Mercy Guzman Borja'),
('1120122065', 'Consuelo Candia Cervantes'),
('1120152070', 'Carmen Rosas Paredes'),
('1120192075', 'Maria Fernando Perez Morales'),
('1120192080', 'Anastasia Graciela Ugarte'),
('1120192090', 'Reynaldo Paul Valdes');

INSERT INTO Proveedor_Telefonos VALUES 
('5420101010', '954497769'),
('5420111015', '960744067'),
('5420142020', '979902373'),
('5420132025', '979673744'),
('5420193035', '985378919'),
('5420103040', '975194475'),
('5420113045', '950364965'),
('5120181025', '937556880'),
('5120181035', '951719788'),
('5220001015', '998388445'),
('5220001020', '936817036'),
('5220102025', '986776259'),
('5220102035', '975853581'),
('5320161055', '937482000'),
('5320161045', '996019020'),
('1120011015', '981265011'),
('1120011025', '955409093'),
('1120021035', '975910151'),
('1120031045', '960339837'),
('1120061050', '962101058'),
('1120092060', '970128509'),
('1120122065', '960518375'),
('1120152070', '970814970'),
('1120192075', '981718864'),
('1120192080', '970275827'),
('1120192090', '975297687');

INSERT INTO Proveedor_Correos VALUES 
('5420101010', 'Francisco_13@gmail.com'),
('5420111015', 'Sonia_22@gmail.com'),
('5420142020', 'camila.31@gmail.com'),
('5420132025', 'Julio_2000@gmail.com'),
('5420193035', 'Jorge_Gut@gmail.com'),
('5420103040', 'Graciela_Grau@yahoo.com'),
('5420113045', 'Isaac_Barrios@yahoo.com'),
('5120181025', 'Sergio_1999@yahoo.com'),
('5120181035', 'Rosa_Ballesteros@yahoo.com'),
('5220001015', 'GSolar_city@tutanota.com'),
('5220001020', 'Benigna_Cespedes@tutanota.com'),
('5220102025', 'Esther_villalba@yahoo.com'),
('5220102035', 'Raquel_Olmedo23@yahoo.com'),
('5320161055', 'Rosa_Ballestero45@gmail.com'),
('5320161045', 'Asunción_31@gmail.com'),
('1120011015', 'GZambrano_@gmail.com'),
('1120011025', 'GDiaz_Lima@gmail.com'),
('1120021035', 'GSan_Agustin_Lima@yahoo.com'),
('1120031045', 'Teresa_Ocampo45@yahoo.com'),
('1120061050', 'Maria_Benavides33@yahoo.com'),
('1120092060', 'Adelia_20_Guzman@tutanota.com'),
('1120122065', 'ConsueloCandia_1980@gmail.com'),
('1120152070', 'Carmen_30@gmail.com'),
('1120192075', 'Maria_Perez2000@gmail.com'),
('1120192080', 'Anastasia_45@yahoo.com'),
('1120192090', 'Reynaldo_Valdez200@yahoo.com');

INSERT INTO Catalogo VALUES 
('100', 1, 'MONTURA SOLAR', '2014-05-15', 158, '2014010012'),
('101', 2, 'MONTURA PARA NIÑOS', '2014-05-16', 150, '2014010078'),
('102', 3, 'MONTURA OFTALMOLÓGICA', '2014-05-30', 230, '2015020056'),
('103', 4, 'ACCESORIO', '2015-05-15', 301, '2015010018'),
('104', 5, 'MONTURA SOLAR', '2015-02-14', 288, '2015025040'),
('105', 6, 'MONTURA PARA NIÑOS', '2015-05-01', 284, '2015026039'),
('106', 7, 'MONTURA OFTALMOLÓGICA', '2016-03-10', 324, '2016017039'),
('107', 8, 'ACCESORIO', '2016-08-24', 285, '2016018038'),
('108', 9, 'MONTURA SOLAR', '2017-01-20', 270, '2017119038'),
('109', 10, 'MONTURA PARA NIÑOS', '2017-08-14', 224, '2017020038'),
('110', 11, 'MONTURA OFTALMOLÓGICA', '2017-11-25', 295, '2017021037'),
('111', 12, 'ACCESORIO', '2018-02-06', 270, '2018022037'),
('112', 13, 'MONTURA SOLAR', '2020-09-27', 216, '2020023036'),
('113', 14, 'MONTURA PARA NIÑOS', '2020-12-08', 192, '2020023036');

INSERT INTO Producto VALUES 
('43101', 'SOLAR CAT', 'OMG', 'MONTURA SOLAR CAT', 399.00, 'MONTURA SOLAR', '112'),
('43102', 'SOLAR OAKLEY', 'OAKLEY', 'MONTURA SOLAR OAKLEY', 799.00, 'MONTURA SOLAR', '112'),
('43103', 'SOLAR ONEILL', 'ONEILL', 'MONTURA SOLAR ONEILL', 449.00, 'MONTURA SOLAR', '112'),
('43104', 'SOLAR RAYBAN', 'RAYBAN', 'MONTURA SOLAR RAYBAN', 699.00, 'MONTURA SOLAR', '112'),
('43105', 'SOLAR GUESS', 'GUESS', 'MONTURA SOLAR GUESS', 499.00, 'MONTURA SOLAR', '112'),
('43106', 'SOLAR RALPH DAMA', 'RALPH', 'MONTURA SOLAR RALPH DAMA', 589.00, 'MONTURA SOLAR', '112'),
('43107', 'SOLAR FILA VARON', 'FILA', 'MONTURA SOLAR FILA VARON', 599.00, 'MONTURA SOLAR', '112'),
('43108', 'SEGURIDAD MIRAFLEX', 'MIRAFLEX', 'MONTURA DE SEGURIDAD MIRAFLEX', 379.00, 'MONTURA SOLAR', '112'),
('43109', 'SOLAR ANTONELLA', 'ANTONELLA', 'MONTURA SOLAR ANTONELLA', 189.00, 'MONTURA SOLAR', '112'),
('43110', 'SOLAR HENKO', 'HENKO', 'MONTURA SOLAR HENKO', 289.00, 'MONTURA SOLAR', '112'),
('43111', 'SOLAR VALENTINA F.', 'VALENTINA F.', 'MONTURA SOLAR VALENTINA F.', 300.00, 'MONTURA SOLAR', '112'),
('43112', 'SOLAR FERRETI', 'FERRETI', 'MONTURA SOLAR FERRETI', 159.00, 'MONTURA SOLAR', '112'),
('43113', 'SOLAR EZIO', 'EZIO', 'MONTURA SOLAR EZIO', 319.00, 'MONTURA SOLAR', '112'),
('43114', 'SOLAR BEIKUBEI', 'BEIKUBEI', 'MONTURA SOLAR BEIKUBEI', 129.00, 'MONTURA SOLAR', '112'),
('43115', 'SOLAR BOWEN', 'BOWEN', 'MONTURA SOLAR BOWEN', 200.00, 'MONTURA SOLAR', '112'),
('43116', 'SM REDONDA', 'SM', 'MONTURA REDONDA SM', 179.00, 'MONTURA SOLAR', '112'),
('43117', 'SOLAR MIRAFLEX', 'MIRAFLEX', 'MONTURA SOLAR MIRAFLEX', 319.00, 'MONTURA SOLAR', '112'),
('43118', 'MONTURA RAZZA', 'RAZZA', 'MONTURA RAZZA', 149.00, 'MONTURA SOLAR', '112'),
('43119', 'SOLAR DAMA MODA', 'MODA', 'MONTURA SOLAR DAMA MODA', 69.00, 'MONTURA SOLAR', '112'),
('43120', 'MONTURA COLOR WISSE', 'WISSE', 'MONTURA COLOR WISSE', 79.00, 'MONTURA SOLAR', '112'),
('43121', 'SOLAR MYTHO', 'MYTHO', 'MONTURA SOLAR MYTHO', 259.00, 'MONTURA SOLAR', '112'),
('43122', 'SOLAR SOBRELENTE', 'ALPI', 'MONTURA SOLAR SOBRELENTE ALPI', 239.00, 'MONTURA SOLAR', '112'),
('43123', 'MONTURA GRACO', 'GRACO', 'MONTURA GRACO', 229.00, 'MONTURA SOLAR', '112'),
('43124', 'SOLAR MVK', 'MVK', 'MONTURA SOLAR MVK', 120.00, 'MONTURA SOLAR', '112'),
('43125', 'MONTURA METALICA CAREY', 'OMG', 'MONTURA METALICA y CAREY UV400', 120.00, 'MONTURA PARA NIÑOS', '113'),
('43126', 'SOLAR HELLO KITTY', 'HELLO KITTY', 'MONTURA SOLAR HELLO KITTY', 149.00, 'MONTURA PARA NIÑOS', '113'),
('43127', 'SOLAR NIÑO STYLE', 'CENTRO STYLE', 'MONTURA SOLAR NIÑO CENTRO STYLE', 159.00, 'MONTURA PARA NIÑOS', '113'),
('43128', 'SOLAR NIÑO SM POLARIZADO', 'SM', 'MONTURA SOLAR NIÑO SM POLARIZADO', 129.00, 'MONTURA PARA NIÑOS', '113'),
('43129', 'SOLAR NIÑA-NIÑO', 'OMG', 'MONTURAS SOLAR NIÑANIÑO', 49.00, 'MONTURA PARA NIÑOS', '113'),
('43130', 'NIÑO ANGELINA B', 'ANGELINA B', 'MONTURA OFTÁLMICA NIÑO ANGELINA B', 139.00, 'MONTURA PARA NIÑOS', '113'),
('43131', 'SBBAOTH SOBRELENTE NIÑOS', 'SBBAOTH', 'MONTURA SBBAOTH SOBRELENTE NIÑOS', 130.00, 'MONTURA PARA NIÑOS', '113'),
('43132', 'MONTURA ALLPA', 'ALLPA', 'MONTURA OFTALMICA ALLPA', 189.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43133', 'MONTURA ANTONELLA', 'ANTONELLA', 'MONTURA OFTALMICA ANTONELLA', 179.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43134', 'MONTURA BACK/BACK', 'BACK/BACK', 'MONTURA OFTALMICA BACK/BACK', 225.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43135', 'MONTURA DIXON', 'DIXON', 'MONTURA OFTALMICA DIXON', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43136', 'MONTURA EUROPTICS', 'EUROPTICS', 'MONTURA OFTALMICA EUROPTICS', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43137', 'MONTURA EXPRESS', 'EXPRESS', 'MONTURA OFTALMICA EXPRESS', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43138', 'MONTURA FIORELLA C.', 'FIORELLA C.', 'MONTURA OFTALMICA FIORELLA C.', 179.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43139', 'MONTURA FRENCHIES', 'FRENCHIES', 'MONTURA OFTALMICA FRENCHIES', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43140', 'MONTURA HELLO KITTY', 'HELLO KITTY', 'MONTURA OFTALMICA HELLO KITTY', 259.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43141', 'MONTURA GAET', 'GAET', 'MONTURA OFTALMICA GAET', 179.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43142', 'MONTURA MAZZIMO', 'MAZZIMO', 'MONTURA OFTALMICA MAZZIMO', 225.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43143', 'MONTURA MOPS', 'MOPS', 'MONTURA OFTALMICA MOPS', 225.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43144', 'MONTURA NEWYORK', 'NEWYORK', 'MONTURA OFTALMICA NEWYORK', 200.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43145', 'MONTURA VIRIATTO', 'VIRIATTO', 'MONTURA OFTALMICA VIRIATTO', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43146', 'MONTURA NATIVA', 'NATIVA', 'MONTURA OFTALMICA NATIVA', 159.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43147', 'MONTURA ALPI', 'ALPI', 'MONTURA OFTÁLMICA ALPI', 219.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43148', 'MONTURA DAMA MODA', 'MODA', 'MONTURA OFTLALMICA DAMA MODA', 69.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43149', 'MONTURA REEBOK', 'REEBOK', 'MONTURA REEBOK', 259.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43150', 'MONTURA ANGELINA B', 'ANGELINA B', 'MONTURA OFTALMICA ANGELINA B', 199.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43151', 'SOLAR POLA', 'POLA', 'MONTURA SOLAR POLA', 200.00, 'MONTURA OFTALMOLÓGICA', '110'),
('43201', 'PERNOS', 'RAYBAN', 'NULL', 2.00, 'ACCESORIO', '111'),
('43202', 'PLAQUETAS DE SILICONA', 'RAYBAN', 'PLAQUETAS DE SILICONA (PAR)', 8.00, 'ACCESORIO', '111'),
('43203', 'PLAQUETAS RAYBAN', 'RAYBAN', 'PLAQUETAS RAYBAN', 25.00, 'ACCESORIO', '111'),
('43204', 'SUJETADOR CADENA DAMA', 'RAYBAN', 'SUJETADOR CADENA DAMA', 20.00, 'ACCESORIO', '111'),
('43205', 'SUJETADORES DE GOMA', 'RAYBAN', 'NULL', 15.00, 'ACCESORIO', '111'),
('43206', 'SUJETADORES SPORT', 'RAYBAN', 'NULL', 10.00, 'ACCESORIO', '111'),
('43207', 'LIQUIDO REFLEX CLEAN', 'RAYBAN', 'NULL', 20.00, 'ACCESORIO', '111'),
('43208', 'ENCANTOS DE GOMA', 'RAYBAN', 'NULL', 19.00, 'ACCESORIO', '111');


INSERT INTO Distribuir_Productos VALUES 
('43101', '5120181035', '2021-07-17'),
('43102', '5220001015', '2022-07-18'),
('43103', '5220001020', '2022-07-19'),
('43104', '5220102025', '2022-08-01'),
('43105', '5220102035', '2022-08-02'),
('43106', '5320161055', '2022-08-03'),
('43107', '5320161045', '2022-09-17'),
('43108', '1120011015', '2022-09-19'),
('43109', '1120011025', '2022-09-27'),
('43110', '1120021035', '2022-12-07'),
('43111', '1120031045', '2022-12-08'),
('43112', '1120192075', '2022-12-09'),
('43113', '1120192080', '2022-12-10'),
('43114', '1120192090', '2022-12-11');

INSERT INTO Pedido VALUES 
('29101', '2016018038', '5420101010'),
('29102', '2016018038', '5420111015'),
('29103', '2015020056', '5420142020'),
('29104', '2015026039', '5420132025'),
('29105', '2015025040', '5420193035'),
('29106', '2015026039', '5420103040'),
('29107', '2020023036', '5420113045'),
('29108', '2016018038', '5120181025'),
('29109', '2017119038', '5120181035'),
('29110', '2017020038', '5220001015'),
('29111', '2020023036', '5220001020'),
('29112', '2016018038', '1120011015'),
('29113', '2015026039', '1120011025'),
('29114', '2015026039', '1120021035'),
('29115', '2017119038', '1120031045'),
('29201', '2017119038', '5220001015'),
('29202', '2016018038', '5220001020'),
('29203', '2016018038', '1120192090'),
('29204', '2015026039', '5420111015'),
('29205', '2016018038', '5420142020'),
('29215', '2016018038', '5420132025'),
('29116', '2016018038', '1120122065'),
('29117', '2015025040', '1120152070'),
('29118', '2015026039', '1120192075'),
('29119', '2015026039', '5220102025'),
('29120', '2017119038', '5220102035'),
('29121', '2016018038', '5320161055'),
('29122', '2016018038', '5320161045'),
('29123', '2015025040', '1120061050'),
('29124', '2015026039', '1120092060'),
('29125', '2020023036', '1120192080');

INSERT INTO Incluir_Producto VALUES 
('43149', '29101', 1),
('43133', '29102', 1),
('43106', '29103', 1),
('43131', '29104', 1),
('43141', '29105', 2),
('43109', '29106', 1),
('43139', '29107', 1),
('43120', '29108', 1),
('43128', '29109', 1),
('43109', '29110', 1),
('43111', '29111', 1),
('43129', '29112', 1),
('43127', '29113', 1),
('43128', '29114', 1),
('43144', '29115', 2),
('43114', '29201', 1),
('43208', '29202', 2),
('43203', '29203', 1),
('43202', '29204', 1),
('43208', '29205', 2),
('43206', '29115', 1),
('43148', '29116', 1),
('43150', '29117', 1),
('43136', '29118', 1),
('43137', '29119', 1),
('43123', '29120', 1),
('43109', '29121', 1),
('43118', '29122', 1),
('43138', '29123', 1),
('43128', '29124', 1),
('43119', '29125', 1);


CREATE PROCEDURE insertarEmpleado(
    IN p_codigo_empleado CHAR(10),
    IN p_nombre_empleado VARCHAR(45),
    IN p_turno CHAR(5),
    IN p_estado CHAR(8)
)
BEGIN
    INSERT INTO Empleado (codigo_empleado, nombre_empleado, turno, estado)
    VALUES (p_codigo_empleado, p_nombre_empleado, p_turno, p_estado);
END;

CREATE PROCEDURE modificarEmpleado(
    IN p_codigo_empleado CHAR(10),
    IN p_nombre_empleado VARCHAR(45),
    IN p_turno CHAR(5),
    IN p_estado CHAR(8)
)
BEGIN
    UPDATE Empleado
    SET nombre_empleado = p_nombre_empleado, turno = p_turno, estado = p_estado
    WHERE codigo_empleado = p_codigo_empleado;
END;

CREATE PROCEDURE borrarEmpleado(
    IN p_codigo_empleado CHAR(10)
)
BEGIN
    DELETE FROM Empleado
    WHERE codigo_empleado = p_codigo_empleado;
END;

CREATE PROCEDURE leerEmpleado()
BEGIN
    SELECT * FROM Empleado;
END;

CREATE PROCEDURE leerEmpleadoPorCodigo(
    IN p_codigo_empleado CHAR(10)
)
BEGIN
    SELECT * FROM Empleado
    WHERE codigo_empleado = p_codigo_empleado;
END;


CREATE TRIGGER before_insert_empleado
BEFORE INSERT ON Empleado
FOR EACH ROW
BEGIN
    SET NEW.codigo_empleado = UPPER(NEW.codigo_empleado);
END;

CREATE TRIGGER before_update_empleado
BEFORE UPDATE ON Empleado
FOR EACH ROW
BEGIN
    SET NEW.codigo_empleado = UPPER(NEW.codigo_empleado);
END;

CREATE TRIGGER before_delete_empleado
BEFORE DELETE ON Empleado
FOR EACH ROW
BEGIN
END;

CREATE PROCEDURE insertarCatalogo(
    IN p_codigo_catalogo CHAR(3),
    IN p_version INT,
    IN p_tipo_de_productos VARCHAR(25),
    IN p_fecha_ultima_modificacion DATE,
    IN p_stock INT,
    IN p_codigo_empleado CHAR(10)
)
BEGIN
    INSERT INTO Catalogo (codigo_catalogo, version, tipo_de_productos, fecha_ultima_modificacion, stock, codigo_empleado)
    VALUES (p_codigo_catalogo, p_version, p_tipo_de_productos, p_fecha_ultima_modificacion, p_stock, p_codigo_empleado);
END;

CREATE PROCEDURE modificarCatalogo(
    IN p_codigo_catalogo CHAR(3),
    IN p_version INT,
    IN p_tipo_de_productos VARCHAR(25),
    IN p_fecha_ultima_modificacion DATE,
    IN p_stock INT,
    IN p_codigo_empleado CHAR(10)
)
BEGIN
    UPDATE Catalogo
    SET version = p_version, tipo_de_productos = p_tipo_de_productos, fecha_ultima_modificacion = p_fecha_ultima_modificacion, stock = p_stock, codigo_empleado = p_codigo_empleado
    WHERE codigo_catalogo = p_codigo_catalogo;
END;

CREATE PROCEDURE borrarCatalogo(
    IN p_codigo_catalogo CHAR(3)
)
BEGIN
    DELETE FROM Catalogo
    WHERE codigo_catalogo = p_codigo_catalogo;
END;

CREATE PROCEDURE leerCatalogo()
BEGIN
    SELECT * FROM Catalogo;
END;

CREATE TRIGGER before_insert_catalogo
BEFORE INSERT ON Catalogo
FOR EACH ROW
BEGIN
    SET NEW.codigo_catalogo = UPPER(NEW.codigo_catalogo);
END;

CREATE TRIGGER before_update_catalogo
BEFORE UPDATE ON Catalogo
FOR EACH ROW
BEGIN
    SET NEW.codigo_catalogo = UPPER(NEW.codigo_catalogo);
END;

CREATE TRIGGER before_delete_catalogo
BEFORE DELETE ON Catalogo
FOR EACH ROW
BEGIN
END;

CREATE PROCEDURE insertarProducto(
    IN p_codigo_producto CHAR(5),
    IN p_nombre VARCHAR(25),
    IN p_marca VARCHAR(25),
    IN p_descripcion VARCHAR(45),
    IN p_precio DECIMAL(10,2),
    IN p_tipo_de_producto VARCHAR(45),
    IN p_codigo_catalogo CHAR(3)
)
BEGIN
    INSERT INTO Producto (codigo_producto, nombre, marca, descripcion, precio, tipo_de_producto, codigo_catalogo)
    VALUES (p_codigo_producto, p_nombre, p_marca, p_descripcion, p_precio, p_tipo_de_producto, p_codigo_catalogo);
END;

CREATE PROCEDURE modificarProducto(
    IN p_codigo_producto CHAR(5),
    IN p_nombre VARCHAR(25),
    IN p_marca VARCHAR(25),
    IN p_descripcion VARCHAR(45),
    IN p_precio DECIMAL(10,2),
    IN p_tipo_de_producto VARCHAR(45),
    IN p_codigo_catalogo CHAR(3)
)
BEGIN
    UPDATE Producto
    SET nombre = p_nombre, marca = p_marca, descripcion = p_descripcion, precio = p_precio, tipo_de_producto = p_tipo_de_producto, codigo_catalogo = p_codigo_catalogo
    WHERE codigo_producto = p_codigo_producto;
END;

CREATE PROCEDURE borrarProducto(
    IN p_codigo_producto CHAR(5)
)
BEGIN
    DELETE FROM Producto
    WHERE codigo_producto = p_codigo_producto;
END;

CREATE PROCEDURE leerProducto()
BEGIN
    SELECT * FROM Producto;
END;

CREATE PROCEDURE leerProductoPorCodigo(
    IN p_codigo_producto CHAR(5)
)
BEGIN
    SELECT * FROM Producto
    WHERE codigo_producto LIKE p_codigo_producto;
END;


CREATE TRIGGER before_insert_producto
BEFORE INSERT ON Producto
FOR EACH ROW
BEGIN
    SET NEW.codigo_producto = UPPER(NEW.codigo_producto);
END;

CREATE TRIGGER before_update_producto
BEFORE UPDATE ON Producto
FOR EACH ROW
BEGIN
    SET NEW.codigo_producto = UPPER(NEW.codigo_producto);
END;

CREATE TRIGGER before_delete_producto
BEFORE DELETE ON Producto
FOR EACH ROW
BEGIN
END;

CREATE PROCEDURE insertarProveedor(
    IN p_codigo_proveedor CHAR(10),
    IN p_nombre_proveedor VARCHAR(45)
)
BEGIN
    INSERT INTO Proveedor (codigo_proveedor, nombre_proveedor)
    VALUES (p_codigo_proveedor, p_nombre_proveedor);
END;

CREATE PROCEDURE modificarProveedor(
    IN p_codigo_proveedor CHAR(10),
    IN p_nombre_proveedor VARCHAR(45)
)
BEGIN
    UPDATE Proveedor
    SET nombre_proveedor = p_nombre_proveedor
    WHERE codigo_proveedor = p_codigo_proveedor;
END;

CREATE PROCEDURE borrarProveedor(
    IN p_codigo_proveedor CHAR(10)
)
BEGIN
    DELETE FROM Proveedor
    WHERE codigo_proveedor = p_codigo_proveedor;
END;

CREATE PROCEDURE leerProveedor()
BEGIN
    SELECT * FROM Proveedor;
END;

CREATE PROCEDURE leerProveedorPorCodigo(
    IN p_codigo_proveedor CHAR(10)
)
BEGIN
    SELECT * FROM Proveedor
    WHERE codigo_proveedor = p_codigo_proveedor;
END;


CREATE TRIGGER before_insert_proveedor
BEFORE INSERT ON Proveedor
FOR EACH ROW
BEGIN
    SET NEW.codigo_proveedor = UPPER(NEW.codigo_proveedor);
END;

CREATE TRIGGER before_update_proveedor
BEFORE UPDATE ON Proveedor
FOR EACH ROW
BEGIN
    SET NEW.codigo_proveedor = UPPER(NEW.codigo_proveedor);
END;

CREATE TRIGGER before_delete_proveedor
BEFORE DELETE ON Proveedor
FOR EACH ROW
BEGIN
END;


CREATE PROCEDURE obtenerCantidadPedidosPorEmpleado()
BEGIN
    SELECT COUNT(P.codigo_empleado) AS Cantidad_Pedidos, 
           E.nombre_empleado, 
           E.estado, 
           P.numero_pedido, 
           ET.telefono
    FROM Empleado AS E
    INNER JOIN Pedido AS P ON E.codigo_empleado = P.codigo_empleado
    INNER JOIN Empleado_Telefonos AS ET ON E.codigo_empleado = ET.codigo_empleado
    WHERE E.estado LIKE 'A%'
    GROUP BY E.nombre_empleado, E.estado, P.numero_pedido, ET.telefono
    ORDER BY Cantidad_Pedidos DESC;
END;

CREATE PROCEDURE obtenerProductoConMayorStock()
BEGIN
    SELECT MAX(catalogo.stock) AS Mayor_Producto, 
           producto.nombre, 
           producto.tipo_de_producto, 
           proveedor.nombre_proveedor
    FROM producto
    INNER JOIN distribuir_productos
    ON producto.codigo_producto = distribuir_productos.codigo_producto
    INNER JOIN proveedor
    ON proveedor.codigo_proveedor = distribuir_productos.codigo_proveedor
    INNER JOIN catalogo
    ON catalogo.codigo_catalogo = producto.codigo_catalogo -- corregido
    GROUP BY producto.nombre, producto.tipo_de_producto, proveedor.nombre_proveedor;
END;

CREATE PROCEDURE obtenerCostoPromedioPorTipoDeProducto(IN tipo_de_producto VARCHAR(255))
BEGIN
    SELECT TRUNCATE(AVG(producto.precio), 2) as Costo_Promedio, catalogo.tipo_de_productos
    FROM producto
    INNER JOIN catalogo
    ON producto.codigo_catalogo = catalogo.codigo_catalogo
    WHERE catalogo.tipo_de_productos = tipo_de_producto
    GROUP BY catalogo.tipo_de_productos;
END;

CREATE PROCEDURE obtenerProveedoresConCorreosYahoo()
BEGIN
    SELECT proveedor.nombre_proveedor, proveedor_correos.correo, producto.nombre as Nombre_Producto
    FROM proveedor
    INNER JOIN proveedor_correos
    ON proveedor.codigo_proveedor = proveedor_correos.codigo_proveedor
    INNER JOIN distribuir_productos
    ON distribuir_productos.codigo_proveedor = proveedor_correos.codigo_proveedor
    INNER JOIN producto
    ON producto.codigo_producto = distribuir_productos.codigo_producto
    WHERE proveedor_correos.correo LIKE '%yahoo%'
    ORDER BY proveedor.nombre_proveedor;
END;

CREATE PROCEDURE obtenerCatalogosModificadosEntreFechas(IN inicio DATE, IN fin DATE)
BEGIN
    SELECT catalogo.version, catalogo.fecha_ultima_modificacion, empleado.nombre_empleado,
                  empleado.turno
           FROM catalogo
           INNER JOIN empleado
           ON empleado.codigo_empleado = catalogo.codigo_empleado
           WHERE catalogo.fecha_ultima_modificacion BETWEEN inicio AND fin;
END;


CREATE PROCEDURE obtenerProveedoresConTelefonosYCorreos(codigo_proveedor_pattern VARCHAR(255))
BEGIN
    SELECT Proveedor.nombre_proveedor AS "Proveedor",Proveedor_Telefonos.telefono AS "Telefono",Proveedor_Correos.correo AS "Correo"
    FROM Proveedor
    INNER JOIN Proveedor_Telefonos ON Proveedor_Telefonos.codigo_proveedor = Proveedor.codigo_proveedor
    INNER JOIN Proveedor_Correos ON Proveedor_Correos.codigo_proveedor = Proveedor.codigo_proveedor
    WHERE Proveedor.codigo_proveedor LIKE codigo_proveedor_pattern;
END;

CREATE PROCEDURE obtenerProductosInvolucradosEnPedidosPorEmpleado()
BEGIN
    SELECT incluir_producto.numero_pedido, incluir_producto.cantidad,
    empleado.nombre_empleado,
    proveedor.codigo_proveedor
    FROM incluir_producto
    INNER JOIN pedido
    ON pedido.numero_pedido = incluir_producto.numero_pedido
    INNER JOIN proveedor
    ON proveedor.codigo_proveedor = pedido.codigo_proveedor
    INNER JOIN empleado
    ON empleado.codigo_empleado = pedido.codigo_empleado
    WHERE empleado.turno LIKE 'T%'
    ORDER BY incluir_producto.cantidad DESC;
END;

CREATE PROCEDURE obtenerProductosSolarParaNinosPorPedido()
BEGIN
    SELECT P.numero_pedido, PR.codigo_producto, PR.nombre, PR.precio 
    FROM Producto as PR
    INNER JOIN Incluir_Producto as P
    ON P.codigo_producto = PR.codigo_producto
    WHERE PR.nombre LIKE "SOLAR%" AND PR.nombre LIKE "%NIÑO%"
    ORDER BY numero_pedido ASC;
END;

CREATE PROCEDURE obtenerNumeroDePedidosPorEmpleado()
BEGIN
    SELECT empleado.codigo_empleado, Empleado.nombre_empleado, empleado.turno,
    count(pedido.numero_pedido) as numero_pedidos
    FROM Empleado
    INNER JOIN pedido
    ON empleado.codigo_empleado = pedido.codigo_empleado
    GROUP BY empleado.codigo_empleado
    ORDER BY numero_pedidos DESC
    LIMIT 2;
END;

CREATE PROCEDURE obtenerInformacionDeCatalogos()
BEGIN
    SELECT C.codigo_catalogo, 
           C.tipo_de_productos, 
           MAX(C.fecha_ultima_modificacion) AS UltimaModificacion, 
           C.Stock, 
           E.nombre_empleado
    FROM Catalogo AS C
    INNER JOIN Empleado AS E ON E.codigo_empleado = C.codigo_empleado
    GROUP BY C.codigo_catalogo, C.tipo_de_productos, C.Stock, E.nombre_empleado;
END;


CREATE PROCEDURE obtenerMesesEnCatalogoPorProducto()
BEGIN
    SELECT producto.nombre, 
           TIMESTAMPDIFF(YEAR, distribuir_productos.fecha_de_ingreso, catalogo.fecha_ultima_modificacion) AS Meses_en_Catalogo,
           producto.tipo_de_producto, 
           distribuir_productos.codigo_producto
    FROM catalogo
    INNER JOIN producto
    ON catalogo.codigo_catalogo = producto.codigo_catalogo  
    INNER JOIN distribuir_productos
    ON distribuir_productos.codigo_producto = producto.codigo_producto;
END;

CREATE PROCEDURE obtenerProductosDistribuidosDespuesDe20170101()
BEGIN
    SELECT IP.numero_pedido, IP.codigo_producto, P.nombre, DP.fecha_de_ingreso
    FROM Incluir_Producto AS IP
    INNER JOIN Producto AS P
    ON IP.codigo_producto = P.codigo_producto
    INNER JOIN Distribuir_Productos AS DP
    ON IP.codigo_producto = DP.codigo_producto
    WHERE DP.fecha_de_ingreso >'2017-01-01';
END;

CREATE PROCEDURE obtenerProductosParaNinosConPrecioMenorA150()
BEGIN
    SELECT Producto.tipo_de_producto AS "Tipo de producto",
    Producto.descripcion AS "Descripcion", 
    Producto.precio AS "Precio"
    FROM Producto
    WHERE Producto.tipo_de_producto = "MONTURA PARA NIÑOS"
    AND Producto.nombre LIKE '%SOLAR%'
    AND Producto.precio < 150;
END;
