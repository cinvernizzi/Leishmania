 /**

    Script que genera las tablas con los datos de las
    muestras recibidas de una mascota y las técnicas y
    resultados utilizados

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 13/08/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    mascota entero clave de la mascota
    paciente entero clave del paciente o dueño
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
DROP TABLE IF EXISTS muestrasmasc;

-- la recreamos
CREATE TABLE muestrasmasc (
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    mascota int(4) UNSIGNED NOT NULL, 
    paciente int(5) UNSIGNED NOT NULL,
    material int(2) UNSIGNED NOT NULL,
    tecnica int(2) UNSIGNED NOT NULL,
    fecha date NOT NULL,
    resultado varchar(50) DEFAULT NULL,
    determinacion date DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY mascota(mascota),
    KEY paciente(paciente),
    KEY material(material),
    KEY tecnica(tecnica),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Muestras recibidas de las mascotas';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_muestrasmasc;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_muestrasmasc AS
       SELECT leishmania.muestrasmasc.id AS id,
              leishmania.muestrasmasc.mascota AS idmascota,
              leishmania.mascotas.nombre AS mascota, 
              leishmania.muestrasmasc.paciente AS idpaciente,
              leishmania.muestrasmasc.material AS idmaterial,
              leishmania.dicmaterial.material AS material,
              leishmania.muestrasmasc.tecnica AS idtecnica,
              leishmania.dictecnicas.tecnica AS tecnica,
              DATE_FORMAT(leishmania.muestrasmasc.fecha, '%d/%m/%Y') AS fecha,
              leishmania.muestrasmasc.resultado AS resultado,
              DATE_FORMAT(leishmania.muestrasmasc.determinacion, '%d/%m/%Y') AS determinacion,
              leishmania.muestrasmasc.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.muestrasmasc.alta, '%d/%m/%Y') AS alta
       FROM leishmania.muestrasmasc INNER JOIN leishmania.dicmaterial ON leishmania.muestrasmasc.material = leishmania.dicmaterial.id
                                    INNER JOIN leishmania.dictecnicas ON leishmania.muestrasmasc.tecnica = leishmania.dictecnicas.id
                                    INNER JOIN leishmania.mascotas ON leishmania.muestrasmasc.mascota = leishmania.mascotas.id
                                    INNER JOIN cce.responsables ON leishmania.muestrasmasc.usuario = cce.responsables.id;

