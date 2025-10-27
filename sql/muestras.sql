 /**

    Script que genera las tablas con los datos de las
    muestras recibidas del paciente y las técnicas y
    resultados utilizados

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    material entero clave del material recibido
    tecnica entero clave de la técnica aplicada
    fecha date fecha de recepción del material
    resultado varchar(50) resultado obtenido
    determinacion date fecha de la determinación
    usuario entero clave del usuario
    alta date fecha de alta del registro

    No usamos registros de auditoría

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS muestras;

-- la recreamos
CREATE TABLE muestras (
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    material int(2) UNSIGNED NOT NULL,
    tecnica int(2) UNSIGNED NOT NULL,
    fecha date NOT NULL,
    resultado varchar(50) DEFAULT NULL,
    determinacion date DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY material(material),
    KEY tecnica(tecnica),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Muestras recibidas de los pacientes';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_muestras;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_muestras AS
       SELECT leishmania.muestras.id AS id,
              leishmania.muestras.paciente AS idpaciente,
              leishmania.muestras.material AS idmaterial,
              leishmania.dicmaterial.material AS material,
              leishmania.muestras.tecnica AS idtecnica,
              leishmania.dictecnicas.tecnica AS tecnica,
              DATE_FORMAT(leishmania.muestras.fecha, '%d/%m/%Y') AS fecha,
              leishmania.muestras.resultado AS resultado,
              DATE_FORMAT(leishmania.muestras.determinacion, '%d/%m/%Y') AS determinacion,
              leishmania.muestras.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.muestras.alta, '%d/%m/%Y') AS alta
       FROM leishmania.muestras INNER JOIN leishmania.dicmaterial ON leishmania.muestras.material = leishmania.dicmaterial.id
                                INNER JOIN leishmania.dictecnicas ON leishmania.muestras.tecnica = leishmania.dictecnicas.id
                                INNER JOIN cce.responsables ON leishmania.muestras.usuario = cce.responsables.id;

