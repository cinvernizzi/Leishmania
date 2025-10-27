 /**

    Script que genera las tablas con los datos de los
    del peridomicilio

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    animal entero clave del animal
    paciente entero clave del paciente
    distancia entero distancia de la casa
    cantidad entero número de animales
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
DROP TABLE IF EXISTS peridomicilio;

-- la recreamos
CREATE TABLE peridomicilio(
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    animal int(4) UNSIGNED NOT NULL,
    paciente int(4) UNSIGNED NOT NULL,
    distancia int(3) UNSIGNED DEFAULT NULL,
    cantidad int(3) UNSIGNED DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY animal(animal),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Datos del peridomicilio';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_peridomicilio;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_peridomicilio AS
       SELECT leishmania.peridomicilio.id AS id,
              leishmania.peridomicilio.animal AS idanimal,
              leishmania.dicanimales.animal AS animal,
              leishmania.peridomicilio.paciente AS idpaciente,
              leishmania.peridomicilio.distancia AS distancia,
              leishmania.peridomicilio.cantidad AS cantidad,
              leishmania.peridomicilio.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.peridomicilio.alta, '%d/%m/%Y') AS alta
       FROM leishmania.peridomicilio INNER JOIN cce.responsables ON leishmania.peridomicilio.usuario = cce.responsables.id
                                     INNER JOIN leishmania.dicanimales ON leishmania.peridomicilio.animal = leishmania.dicanimales.id;

