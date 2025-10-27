/**

    Script que genera las tablas con los datos del
    diccionario de ocupaciones

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 17/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    ocupacion varchar descripción de la ocupación
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
DROP TABLE IF EXISTS ocupaciones;

-- la recreamos
CREATE TABLE ocupaciones(
    id int(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    ocupacion varchar(100) NOT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Diccionario de ocupaciones';

-- eliminamos la vista
DROP VIEW IF EXISTS v_ocupaciones;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_ocupaciones AS
       SELECT leishmania.ocupaciones.id AS id,
              leishmania.ocupaciones.ocupacion AS ocupacion,
              leishmania.ocupaciones.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.ocupaciones.alta, '%d/%m/%Y') AS alta
       FROM leishmania.ocupaciones INNER JOIN cce.responsables ON leishmania.ocupaciones.usuario = cce.responsables.id
       ORDER BY leishmania.ocupaciones.ocupacion;
       

