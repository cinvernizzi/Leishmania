/**

    Script que genera las tablas con los datos de las
    actividades del paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    lugar varchar lugar de la actividad
    actividad varchar descripción de la actividad
    fecha date fecha de la actividad
    usuario entero clave del usuario
    alta date fecha de alta del registro

    No utilizamos registros de auditoría

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS actividades;

-- la recreamos
CREATE TABLE actividades (
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    lugar varchar(100) NOT NULL,
    actividad varchar(100) NOT NULL,
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
COMMENT='Actividades del paciente';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_actividades;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_actividades AS
       SELECT leishmania.actividades.id AS id,
              leishmania.actividades.paciente AS idpaciente,
              leishmania.actividades.lugar AS lugar,
              leishmania.actividades.actividad AS actividad,
              DATE_FORMAT(leishmania.actividades.fecha, '%d/%m/%Y') AS fecha,
              leishmania.actividades.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.actividades.alta, '%d/%m/%Y') AS alta
       FROM leishmania.actividades INNER JOIN cce.responsables ON leishmania.actividades.usuario = cce.responsables.id;

