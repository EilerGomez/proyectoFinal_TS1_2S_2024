DROP DATABASE IF EXISTS sistema_eventos;
CREATE DATABASE sistema_eventos;
use sistema_eventos;

CREATE TABLE usuarios(
	id INT NOT NULL AUTO_INCREMENT,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono INT(10) NOT NULL,
    rol INT NOT NULL,
    password VARCHAR(50) NOT NULL,
    edad INT NOT NULL,
    permiso_publicar BOOLEAN NOT NULL, /*en caso de que sea un usuario publicador*/
    PRIMARY KEY(id)
);

CREATE TABLE eventos(
	id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,/*USUARIO QUE CREO EL EVENTO*/
    lugar VARCHAR(70) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    cupo_limitado INT NOT NULL,
    cupo_restante INT NOT NULL,
    url VARCHAR(750) NOT NULL,
    tipo_publico VARCHAR(2) NOT NULL, /*T=todos, ME = menores de edad, MA=mayores de edad*/
    publicacion_automatica BOOLEAN NOT NULL,
    aprobacion BOOLEAN NOT NULL,
    estado VARCHAR(15) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT id_usuario_usuario_evento_fk FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE usuario_evento (
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    PRIMARY KEY(id_evento, id_usuario),
    CONSTRAINT fk_usuario_evento_usuario FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_usuario_evento_evento FOREIGN KEY(id_evento)
        REFERENCES eventos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE reporte_eventos(
	id_evento INT NOT NULL,
    id_usuario_reportador INT NOT NULL,
	motivo VARCHAR(50) NOT NULL,
    estado VARCHAR(15) NOT NULL,
    PRIMARY KEY(id_evento, id_usuario_reportador),
	CONSTRAINT id_usuario_reportador_reporte_evento_fk FOREIGN     KEY(id_usuario_reportador)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT id_evento_report_reporte_evento_fk FOREIGN KEY(id_evento)
        REFERENCES eventos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

/*CREATE USER 'user_practica1_TS1'@'localhost' IDENTIFIED BY 'practica1';
GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_jugadores.* TO 'user_practica1_TS1'@'localhost';*/
