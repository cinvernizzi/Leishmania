/**

    Script que genera las tablas con el diccionario del 
    tipo de material remitido

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 16/05/2025

    Licencia: GPL

    Estructura: 
    id entero clave del registro
    material varchar descripción del material 
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
DROP TABLE IF EXISTS dicmaterial; 

-- la recreamos 
CREATE TABLE dicmaterial(
    id int(2) UNSIGNED NOT NULL AUTO_INCREMENT, 
    material varchar(200) NOT NULL, 
    alta date DEFAULT CURDATE(),
    modificado timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario int(4) UNSIGNED NOT NULL, 
    PRIMARY KEY(id),
    KEY material(material), 
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Diccionario de material remitido';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_dicmaterial; 

-- la recreamos 
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_dicmaterial AS
       SELECT leishmania.dicmaterial.id AS id, 
              leishmania.dicmaterial.material AS material, 
              DATE_FORMAT(leishmania.dicmaterial.alta, '%d/%m/%Y') AS alta, 
              DATE_FORMAT(leishmania.dicmaterial.modificado, '%d/%m/%Y') AS modificado, 
              leishmania.dicmaterial.usuario AS idusuario, 
              cce.responsables.usuario AS usuario
       FROM leishmania.dicmaterial INNER JOIN cce.responsables ON leishmania.dicmaterial.usuario = cce.responsables.id
       ORDER BY leishmania.dicmaterial.material;

