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
    url VARCHAR(750),
    tipo_publico VARCHAR(2) NOT NULL, /*T=todos, ME = menores de edad, MA=mayores de edad*/
    publicacion_automatica BOOLEAN NOT NULL,
    aprobacion BOOLEAN NOT NULL,
    estado VARCHAR(15) NOT NULL,
    imagen VARCHAR(200),
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

CREATE USER 'user_proyect_final'@'localhost' IDENTIFIED BY 'proyectofinal';
GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_eventos.* TO 'user_proyect_final'@'localhost';

-- crear funciones en la base de datos
-- insertando un usuario admin
INSERT INTO usuarios (nombres, apellidos, telefono, rol, password, edad, permiso_publicar)
VALUES ('Juan', 'Pérez', 1234567890, 1, 'password123', 30, TRUE);

DELIMITER //

CREATE PROCEDURE obtener_usuario(IN id_usuario INT, IN pass VARCHAR(50), IN rol_param INT)
BEGIN
    SELECT * 
    FROM usuarios
    WHERE id = id_usuario 
      AND password = pass 
      AND rol = rol_param;
END //

DELIMITER ;




-- INSERTAR UNA NUEVA PUBLICACION
DELIMITER //
CREATE PROCEDURE guardar_evento(
    IN id_user INT,
    IN lugar_e VARCHAR(70),
    IN fecha_e DATE,
    IN hora_e TIME,
    IN cupo_e INT,
    IN url_e VARCHAR(200),
    IN publico_e VARCHAR(2),
    IN imagen_e VARCHAR(200)
)
BEGIN
    DECLARE automaticpublicacion BOOLEAN DEFAULT FALSE; -- Cambiado a BOOLEAN
    DECLARE cantidadPublicaciones INT DEFAULT 0; -- Tipo INT y inicializado

    -- Contar las publicaciones aprobadas del usuario
    SELECT COUNT(*) INTO cantidadPublicaciones 
    FROM eventos 
    WHERE id_usuario = id_user AND aprobacion = TRUE;

    -- Verificar si el usuario tiene dos o más publicaciones aprobadas
    IF (cantidadPublicaciones >= 2) THEN
        SET automaticpublicacion = TRUE; -- Establecer a TRUE si cumple la condición
    END IF;

    -- Insertar el nuevo evento
    INSERT INTO eventos (
        id_usuario, 
        lugar, 
        fecha, 
        hora, 
        cupo_limitado, 
        cupo_restante, 
        url, 
        tipo_publico,
        publicacion_automatica, 
        aprobacion, 
        estado,
        imagen
    )
    VALUES (
        id_user, 
        lugar_e, 
        fecha_e, 
        hora_e, 
        cupo_e, 
        cupo_e, 
        url_e, 
        publico_e,
        automaticpublicacion, -- Aquí se usa el valor calculado
        automaticpublicacion, -- También puedes usar la misma variable aquí
        'PENDIENTE', -- Estado por defecto,
        imagen_e
    );

    -- Devolver el evento recién insertado
   --  SELECT * FROM eventos WHERE id_evento = LAST_INSERT_ID(); -- Asegúrate de usar el ID correcto
END //
DELIMITER ;





-- INSERTAR UN NUEVO USUARIO
DELIMITER //
CREATE PROCEDURE guardar_usuario(
    IN p_nombres VARCHAR(100),
    IN p_apellidos VARCHAR(100),
    IN p_telefono BIGINT,
    IN p_rol INT,
    IN p_edad INT,
    IN p_password VARCHAR(255)
)
BEGIN
    -- Insertar el nuevo usuario
    INSERT INTO usuarios (nombres, apellidos, telefono, rol, edad, password,permiso_publicar)
    VALUES (p_nombres, p_apellidos, p_telefono, p_rol, p_edad, p_password,false);
    
    -- Devolver el usuario recién insertado
    SELECT * FROM usuarios WHERE id = LAST_INSERT_ID();
END //

DELIMITER ;
GRANT EXECUTE ON PROCEDURE sistema_eventos.guardar_usuario TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.obtener_usuario TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.guardar_evento TO 'user_proyect_final'@'localhost';

select * from eventos;
describe eventos;
call obtener_usuario(1,'password123',1);
CALL guardar_usuario('Juan', 'Perez', 123456789, 1, 30, 'mi_contraseña_segura');
CALL guardar_evento('Juan', 'Perez', 123456789, 1, 30, 'mi_contraseña_segura');
CALL guardar_evento(
    1,                     -- id_user: ID del usuario, debe ser un número entero (ejemplo: 1)
    'Centro de Eventos',  -- lugar_e: Nombre del lugar, debe ser una cadena de texto
    '2024-10-10',         -- fecha_e: Fecha del evento en formato YYYY-MM-DD
    '14:00:00',          -- hora_e: Hora del evento en formato HH:MM:SS
    30,                   -- cupo_e: Número máximo de asistentes (ejemplo: 30)
    'http://example.com', -- url_e: URL relacionado con el evento
    'P'                   -- publico_e: Tipo de público (ejemplo: 'P' para público)
);

SHOW PROCEDURE STATUS WHERE Db = 'sistema_eventos';

