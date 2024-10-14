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
    descripcion VARCHAR(1000),
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
	motivo VARCHAR(200) NOT NULL,
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
drop table notificaciones;
CREATE TABLE notificaciones( -- notificaciones para el usuario
	id INT NOT NULL auto_increment,
	id_usuario INT NOT NULL, -- usuario al que se le va mostrar las notificaciones
    name_usuario VARCHAR(100), -- usuario que esta interactuando
    descripcion VARCHAR(200) NOT NULL, -- descripcion de la notificacion,
    PRIMARY KEY(id),
    CONSTRAINT fk_usuario_notificacion_usuario FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE USER 'user_proyect_final'@'localhost' IDENTIFIED BY 'proyectofinal';
GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_eventos.* TO 'user_proyect_final'@'localhost';

-- crear funciones en la base de datos
-- insertando un usuario admin
INSERT INTO usuarios (nombres, apellidos, telefono, rol, password, edad, permiso_publicar)
VALUES ('Juan', 'Pérez', 1234567890, 1, 'password123', 30, 1);

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
    IN imagen_e VARCHAR(200),
    IN descripcion_e VARCHAR(1000)
)
BEGIN
    DECLARE automaticpublicacion BOOLEAN DEFAULT FALSE; -- Cambiado a BOOLEAN
    DECLARE cantidadPublicaciones INT DEFAULT 0; -- Tipo INT y inicializado
    DECLARE permisoPublicar BOOLEAN DEFAULT FALSE;

    -- Contar las publicaciones aprobadas del usuario
    SELECT COUNT(*) INTO cantidadPublicaciones 
    FROM eventos 
    WHERE id_usuario = id_user AND aprobacion = TRUE;

	SELECT permiso_publicar INTO permisoPublicar FROM usuarios  
    WHERE ID = id_user;
    -- Verificar si el usuario tiene dos o más publicaciones aprobadas
    IF (cantidadPublicaciones >= 2 and permisoPublicar = TRUE) THEN
        SET automaticpublicacion = TRUE; -- Establecer a TRUE si cumple la condición
    END IF;

	IF(permisoPublicar = TRUE or cantidadPublicaciones >= 2 ) THEN
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
        imagen,
        descripcion
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
        imagen_e,
        descripcion_e
    );
    END IF;
   
    

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
    VALUES (p_nombres, p_apellidos, p_telefono, p_rol, p_edad, p_password,true);
    
    -- Devolver el usuario recién insertado
    SELECT * FROM usuarios WHERE id = LAST_INSERT_ID();
END //

DELIMITER ;


 -- funcion para actualizar evento
DELIMITER //
CREATE PROCEDURE actualizar_evento(
    IN p_id INT,
    IN p_id_usuario INT,
    IN p_lugar VARCHAR(70),
    IN p_fecha DATE,
    IN p_hora TIME,
    IN p_cupo_limitado INT,
    IN p_url VARCHAR(750),
    IN p_tipo_publico VARCHAR(2),
    IN p_imagen VARCHAR(200),
    IN p_descripcion VARCHAR(1000)
)
BEGIN
    IF p_imagen = 'null' THEN
        -- Si la imagen es 'null', no se actualiza el campo 'imagen'
        UPDATE eventos
        SET 
            id_usuario = p_id_usuario,
            lugar = p_lugar,
            fecha = p_fecha,
            hora = p_hora,
            cupo_limitado = p_cupo_limitado,
            cupo_restante = cupo_restante + (p_cupo_limitado-cupo_restante),
            url = p_url,
            tipo_publico = p_tipo_publico,
            descripcion = p_descripcion
        WHERE id = p_id;
    ELSE
        -- Si la imagen tiene un valor diferente de 'null', se actualiza el campo 'imagen'
        UPDATE eventos
        SET 
            id_usuario = p_id_usuario,
            lugar = p_lugar,
            fecha = p_fecha,
            hora = p_hora,
            cupo_limitado = p_cupo_limitado,
            cupo_restante = cupo_restante + (p_cupo_limitado-cupo_restante),
            url = p_url,
            tipo_publico = p_tipo_publico,
            imagen = p_imagen,
            descripcion = p_descripcion
        WHERE id = p_id;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE obtener_eventos_publicados(IN idP INT, IN idU INT)
BEGIN
    IF idP = 0 THEN -- Es el usuario registrado
        SELECT 
            e.id, 
            SUM(CASE WHEN re.estado = 'REPORTADA' THEN 1 ELSE 0 END) AS reportes, -- Contar el número de reportes con estado 'REPORTADA'
            CONCAT(u.nombres, ' ', u.apellidos) AS usuarioPublicador, 
            u.id AS usuarioNotificacion, -- Al que se le va mostrar la notificación si se inscribió a la publicación
            e.lugar, 
            e.fecha, 
            e.hora, 
            e.cupo_limitado, 
            e.cupo_restante, 
            e.url, 
            e.tipo_publico, 
            e.estado, 
            e.imagen, 
            e.descripcion,
            CASE WHEN ue.id_evento IS NOT NULL THEN true ELSE false END AS asistiendo -- Determinar si el usuario está asistiendo
        FROM 
            eventos e
        LEFT JOIN 
            usuario_evento ue ON e.id = ue.id_evento AND ue.id_usuario = idU -- Verificar si el usuario está inscrito al evento
        LEFT JOIN 
            reporte_eventos re ON re.id_evento = e.id -- Unión con la tabla de reportes
        JOIN 
            usuarios u ON e.id_usuario = u.id
        WHERE 
            e.aprobacion = true 
        GROUP BY 
            e.id, u.id -- Agrupar por el id del evento y usuario
        HAVING 
            SUM(CASE WHEN re.estado = 'REPORTADA' THEN 1 ELSE 0 END) < 3 -- Filtrar para eventos con menos de 3 reportes 'REPORTADA'
        ORDER BY 
            e.id DESC;
    ELSE 
        SELECT 
            e.id, 
            CONCAT(u.nombres, ' ', u.apellidos) AS usuarioPublicador, 
            e.lugar, 
            e.fecha, 
            e.hora, 
            e.cupo_limitado, 
            e.cupo_restante, 
            e.url, 
            e.tipo_publico, 
            e.estado, 
            e.imagen, 
            e.descripcion 
        FROM 
            eventos e
        JOIN 
            usuarios u ON e.id_usuario = u.id
        WHERE 
			e.id = idP 
        ORDER BY 
            e.id DESC;
    END IF;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE obtener_usuario_evento(IN idU INT)
BEGIN
    SELECT 
            e.id, 
            SUM(CASE WHEN re.estado = 'REPORTADA' THEN 1 ELSE 0 END) AS reportes, -- Contar el número de reportes con estado 'REPORTADA'
            CONCAT(u.nombres, ' ', u.apellidos) AS usuarioPublicador, 
            u.id AS usuarioNotificacion, -- Al que se le va mostrar la notificación si se inscribió a la publicación
            e.lugar, 
            e.fecha, 
            e.hora, 
            e.cupo_limitado, 
            e.cupo_restante, 
            e.url, 
            e.tipo_publico, 
            e.estado, 
            e.imagen, 
            e.descripcion,
            CASE WHEN ue.id_evento IS NOT NULL THEN true ELSE false END AS asistiendo -- Determinar si el usuario está asistiendo
        FROM 
            eventos e
        INNER JOIN 
            usuario_evento ue ON e.id = ue.id_evento AND ue.id_usuario = idU -- Verificar si el usuario está inscrito al evento
        LEFT JOIN 
            reporte_eventos re ON re.id_evento = e.id -- Unión con la tabla de reportes
        JOIN 
            usuarios u ON e.id_usuario = u.id
        WHERE 
            e.aprobacion = true
        GROUP BY 
            e.id, u.id -- Agrupar por el id del evento y usuario
        HAVING 
            SUM(CASE WHEN re.estado = 'REPORTADA' THEN 1 ELSE 0 END) < 3 -- Filtrar para eventos con menos de 3 reportes 'REPORTADA'
        ORDER BY 
            e.id DESC;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE obtener_reportes_eventos()
BEGIN
    SELECT re.id_evento,CONCAT(u.nombres, ' ', u.apellidos) as usuario_reportador,
    re.id_usuario_reportador,
    re.motivo, re.estado 
    FROM reporte_eventos re
    JOIN usuarios u ON re.id_usuario_reportador = u.id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE aceptar_reporte_evento(IN idP INT, IN idUR INT)
BEGIN
	DECLARE idPublicador INT DEFAULT 0;
    SELECT id_usuario INTO  idPublicador from eventos WHERE id=idP;
    UPDATE usuarios SET permiso_publicar = false WHERE id = idPublicador;
    UPDATE reporte_eventos SET estado = 'REPORTADA' where id_evento = idP 
		AND id_usuario_reportador = idUR;
    
END //
DELIMITER ;



GRANT EXECUTE ON PROCEDURE sistema_eventos.guardar_usuario TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.obtener_usuario TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.guardar_evento TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.actualizar_evento TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.obtener_eventos_publicados TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.obtener_usuario_evento TO 'user_proyect_final'@'localhost';
GRANT EXECUTE ON PROCEDURE sistema_eventos.obtener_reportes_eventos TO 'user_proyect_final'@'localhost';

select * from eventos;

describe eventos;
call obtener_usuario(1,'password123',1);
CALL guardar_usuario('Juan', 'Perez', 123456789, 1, 30, 'mi_contraseña_segura');
CALL guardar_evento('Juan', 'Perez', 123456789, 1, 30, 'mi_contraseña_segura');
delete from eventos where id_usuario=3;




SHOW PROCEDURE STATUS WHERE Db = 'sistema_eventos';
select * from notificaciones;
insert into notificaciones(id_usuario, name_usuario, descripcion) values (3,'Jorge Morales','Se ha unido a tu publicacion San Jose xd');
update eventos set aprobacion = true where id=29;



insert into usuario_evento(id_evento, id_usuario) values (25,4);
delete from usuario_evento where id_evento = 25 and id_usuario=4;
select * from usuario_evento;
select * from notificaciones;
truncate notificaciones;
select * from usuarios;
update usuarios set permiso_publicar=true where id > 0;

insert into reporte_eventos(id_evento,id_usuario_reportador,motivo,estado) values ();
select * from reporte_eventos;
update reporte_eventos set estado = 'PENDIENTE' where id_evento = 27;

select * from reporte_eventos;