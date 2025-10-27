 /**

    Script que genera las tablas con los datos de los
    animales y ambiente del peridomicilio

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    animal varchar nombre del animal
    usuario entero clave del usuario
    alta date fecha de alta

    No utilizamos registros de auditoría

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS dicanimales;

-- la recreamos
CREATE TABLE dicanimales(
    id int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    animal varchar(100) NOT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Diccionario de animales del peridomicilio';

-- eliminamos la vista
DROP VIEW IF EXISTS v_dicanimales;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_dicanimales AS
       SELECT leishmania.dicanimales.id AS id,
              leishmania.dicanimales.animal AS animal,
              leishmania.dicanimales.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.dicanimales.alta, '%d/%m/%Y') AS alta
       FROM leishmania.dicanimales INNER JOIN cce.responsables ON leishmania.dicanimales.usuario = cce.responsables.id
       ORDER BY leishmania.dicanimales.animal;

