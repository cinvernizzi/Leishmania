/**

    Script que genera las tablas con los datos de los viajes
    del paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    lugar varchar destino del viaje
    fecha date fecha del viaje
    usuario entero clave del usuario
    alta fecha de alta del registro

    No usamos registros de auditoría

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS viajes;

-- la recreamos
CREATE TABLE viajes (
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    lugar varchar(100) NOT NULL,
    fecha date NOT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Viajes del paciente';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_viajes;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_viajes AS
       SELECT leishmania.viajes.id AS id,
              leishmania.viajes.paciente AS idpaciente,
              leishmania.viajes.lugar AS lugar,
              DATE_FORMAT(leishmania.viajes.fecha, '%d/%m/%Y') AS fecha,
              leishmania.viajes.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.viajes.alta, '%d/%m/%Y') AS alta
       FROM leishmania.viajes INNER JOIN cce.responsables ON leishmania.viajes.usuario = cce.responsables.id
       ORDER BY leishmania.viajes.fecha DESC;


