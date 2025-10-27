 /**

    Script que genera las tablas con los datos de la
    evolución clínica del paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    hospitalizacion date fecha en que fue hospitalizado
    fechaalta date fecha en que fue dado de alta
    defuncion date fecha de defunción
    condicion varchar descripción de la condición de alta
    clasificacion varchar clasificación final (ver con diccionarios)
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
DROP TABLE IF EXISTS evolucion;

-- la recreamos
CREATE TABLE evolucion(
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    hospitalizacion date DEFAULT NULL,
    fechaalta date DEFAULT NULL,
    defuncion date DEFAULT NULL,
    condicion varchar(250) DEFAULT NULL,
    clasificacion varchar(100) DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Evolución del paciente';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_evolucion;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_evolucion AS
       SELECT leishmania.evolucion.id AS id,
              leishmania.evolucion.paciente AS idpaciente,
              DATE_FORMAT(leishmania.evolucion.hospitalizacion, '%d/%m/%Y') AS hospitalizacion,
              DATE_FORMAT(leishmania.evolucion.fechaalta, '%d/%m/%Y') AS fechaalta,
              DATE_FORMAT(leishmania.evolucion.defuncion, '%d/%m/%Y') AS defuncion,
              leishmania.evolucion.condicion AS condicion,
              leishmania.evolucion.clasificacion AS clasificacion,
              leishmania.evolucion.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.evolucion.alta, '%d/%m/%Y') AS alta
       FROM leishmania.evolucion INNER JOIN cce.responsables ON leishmania.evolucion.usuario = cce.responsables.id;
