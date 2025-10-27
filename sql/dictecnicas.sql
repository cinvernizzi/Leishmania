/**

    Script que genera las tablas con el diccionario del 
    técnicas realizadas sobre una muestra

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 16/05/2025

    Licencia: GPL

    Estructura: 
    id entero clave del registro
    tecnica varchar descripción de la técnica
    alta date fecha de alta del registro
    modificado date fecha de modificación del registro
    usuario entero clave del registro 

    No utiliza registros de auditoría

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS dictecnicas;

-- la recreamos
CREATE TABLE dictecnicas (
    id int(2) UNSIGNED NOT NULL AUTO_INCREMENT, 
    tecnica varchar(200) NOT NULL, 
    alta date DEFAULT CURDATE(),
    modificado timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    usuario int(4) UNSIGNED NOT NULL, 
    PRIMARY KEY(id),
    KEY tecnica(tecnica),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Diccionario de técnicas utilizadas';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_dictecnicas;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_dictecnicas AS
       SELECT leishmania.dictecnicas.id AS id, 
              leishmania.dictecnicas.tecnica AS tecnica,
              DATE_FORMAT(leishmania.dictecnicas.alta, '%d/%m/%Y') AS alta, 
              DATE_FORMAT(leishmania.dictecnicas.modificado, '%d/%m/%Y') AS modificado, 
              leishmania.dictecnicas.usuario AS idusuario, 
              cce.responsables.usuario AS usuario
       FROM leishmania.dictecnicas INNER JOIN cce.responsables ON leishmania.dictecnicas.usuario = cce.responsables.id
       ORDER BY leishmania.dictecnicas.tecnica;
