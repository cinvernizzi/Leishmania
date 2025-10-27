 /**

    Script que genera las tablas con los datos de las
    mascotas del paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    nombre varchar nombre del perro
    edad entero edad en años
    origen varchar origen del perro
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
DROP TABLE IF EXISTS mascotas;

-- la recreamos
CREATE TABLE mascotas(
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    nombre varchar(100) DEFAULT NULL,
    edad int(2) UNSIGNED DEFAULT NULL,
    origen varchar(100) DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Mascotas de los pacientes';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_mascotas;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_mascotas AS
       SELECT leishmania.mascotas.id AS id,
              leishmania.mascotas.paciente AS idpaciente,
              leishmania.mascotas.nombre AS nombre,
              leishmania.mascotas.edad AS edad,
              leishmania.mascotas.origen AS origen,
              leishmania.mascotas.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.mascotas.alta, '%d/%m/%Y') AS alta
       FROM leishmania.mascotas INNER JOIN cce.responsables ON leishmania.mascotas.usuario = cce.responsables.id
       ORDER BY leishmania.mascotas.nombre;