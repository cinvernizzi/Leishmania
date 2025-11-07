/**

    Script que genera las tablas con los datos de las
    acciones de control y prevención

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 16/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    paciente entero clave del paciente
    tratamiento varchar tratamiento indicado
    droga varchar droga utilizada
    dosis entero dosis de la droga en miligramos
    contactos varchar si identificaron contactos expuestos
    nrocontactos entero número de contactos identificados
    contactospos entero número de contactos positivos
    bloqueo varchar si se utilizaron insecticidas
    nroviviendas entero número de viviendas controladas
    sitiosriesgo varchar sitios de riesgo controlados (descripción)
    insecticida varchar descripción del insecticida utilizado
    cantidadinsec entero cantidad de insecticida aplicado (ver unidad)
    fecha date fecha del control
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

-- eliminamos la tabla
DROP TABLE IF EXISTS control;

-- la recreamos
CREATE TABLE control(
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    tratamiento varchar(250) DEFAULT NULL,
    droga varchar(100) DEFAULT NULL,
    dosis int(4) UNSIGNED DEFAULT NULL,
    contactos varchar(5) DEFAULT NULL,
    nrocontactos int(2) UNSIGNED DEFAULT NULL,
    contactospos int(2) UNSIGNED DEFAULT NULL,
    bloqueo varchar(200) DEFAULT NULL,
    nroviviendas int(2) UNSIGNED DEFAULT NULL,
    sitiosriesgo varchar(200) DEFAULT NULL,
    insecticida varchar(100) DEFAULT NULL,
    cantidadinsec int(3) DEFAULT NULL,
    fecha date DEFAULT NULL, 
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Actividades de control realizadas';

-- eliminamos la vista
DROP VIEW IF EXISTS v_control;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_control AS
       SELECT leishmania.control.id AS id,
              leishmania.control.paciente AS idpaciente,
              leishmania.control.tratamiento AS tratamiento,
              leishmania.control.droga AS droga,
              leishmania.control.dosis AS dosis,
              leishmania.control.contactos AS contactos,
              leishmania.control.nrocontactos AS nrocontactos,
              leishmania.control.contactospos AS contactospos,
              leishmania.control.bloqueo AS bloqueo,
              leishmania.control.nroviviendas AS nroviviendas,
              leishmania.control.sitiosriesgo AS sitiosriesgo,
              leishmania.control.insecticida AS insecticida,
              leishmania.control.cantidadinsec AS cantidadinsec,
              DATE_FORMAT(leishmania.control.fecha, '%d/%m/%Y') AS fecha,
              leishmania.control.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.control.alta, '%d/%m/%Y') AS alta
       FROM leishmania.control INNER JOIN cce.responsables ON leishmania.control.usuario = cce.responsables.id;
