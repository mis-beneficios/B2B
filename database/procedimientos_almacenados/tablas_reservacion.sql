DROP TABLE IF EXISTS c_estatus_reservacion;
CREATE TABLE IF NOT EXISTS c_estatus_reservacion(
    id_estatus_reservacion INT AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    clave VARCHAR (2),
    activo TINYINT(1) DEFAULT 1,
    PRIMARY KEY(id_estatus_reservacion)
);

INSERT INTO c_estatus_reservacion (descripcion,clave)
VALUES ('Nuevo','NC'), ('Ingresada','NR'),('En proceso','EP'),
('Cupón enviado','CE'),('Cancelada','CA'),('Penalizada','PN'),
('Revisión','RE'),('Autorizada','OK'),('Seguimiento','SG');

-- SELECT * FROM c_estatus_reservacion;

DROP TABLE IF EXISTS c_tipo_reservacion;
CREATE TABLE IF NOT EXISTS c_tipo_reservacion(
    id_tipo_reservacion INT AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    clave VARCHAR (25),
    activo TINYINT(1) DEFAULT 1,
    PRIMARY KEY(id_tipo_reservacion)
);

INSERT INTO c_tipo_reservacion (descripcion,clave)
VALUES ('Venta','venta'), ('Cortesía referidos','referido'),
('Cortesía campaña','camapana'),('Cortesía reconocimiento','reconocimiento'),
('Vuelo','vuelo'),('Traslado','traslado'),
('Tour','tour'),('Autibús','autobus');


