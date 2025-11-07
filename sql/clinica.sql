/**

    Script que genera las tablas con los datos de sospecha
    clínica y descripción de un paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 16/05/2025

    Licencia: GPL

    Estructura:
    id entero clave del registro
    paciente entero clave del paciente
    cutaneaunica varchar(5) si presenta lesión cutánea única
    cutaneamultiple varchar(5) si presenta lesión múltiple
    mucosanasal varchar(5) si presenta lesión mucosa nasal
    bucofaringea varchar(5) si presenta lesión bucofaringea
    laringea varchar(5) si presenta lesión laringea
    visceral varchar(5) si presenta lesión visceral
    fiebre varchar(5) si presenta fiebre
    inicio date fecha de inicio de la fiebre
    caracteristicas varchar(20) características de la fiebre (diurna, nocturna)
    fatiga varchar(5) si presenta fatiga
    debilitad varchar(5) si presenta debilidad
    vomitos varchar(5) si presenta vómitos
    diarrea varchar(5) si presenta diarrea
    tosseca varchar(5) si presenta tos
    pielgris varchar(5) si presenta piel grisásea
    edema varchar(5) si presenta edemas
    escamosa varchar(5) si presenta piel escamosa
    petequias varchar(5) si presenta petequias
    cabello varchar(5) si presenta adelgazamiento del cabello
    adenomegalia varchar(5) si presenta adenomegalia
    hepatoesplenomegalia varchar(5) si presenta
    linfadenopatia varchar(5) si presenta
    perdidapeso varchar(5) si presenta,
    nodulo varchar(5) si presenta
    ulcera varchar(5) si presenta
    cicatriz varchar(5) si presenta
    antecedentes text antecedentes epidemiológicos
    lesionmucosa varchar(5) si presenta
    alta date fecha de alta del registro
    modificado fecha de modificación del registro
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
DROP TABLE IF EXISTS clinica;

-- la recreamos
CREATE TABLE clinica (
    id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    paciente int(5) UNSIGNED NOT NULL,
    cutaneaunica varchar(5) DEFAULT NULL,
    cutaneamultiple varchar(5) DEFAULT NULL,
    mucosanasal varchar(5) DEFAULT NULL,
    bucofaringea varchar(5) DEFAULT NULL,
    laringea varchar(5) DEFAULT NULL,
    visceral varchar(5) DEFAULT NULL,
    fiebre varchar(5) DEFAULT NULL,
    inicio date DEFAULT NULL,
    caracteristicas varchar(20) DEFAULT NULL,
    fatiga varchar(5) DEFAULT NULL,
    debilidad varchar(5) DEFAULT NULL,
    vomitos varchar(5) DEFAULT NULL,
    diarrea varchar(5) DEFAULT NULL,
    tosseca varchar(5) DEFAULT NULL,
    pielgris varchar(5) DEFAULT NULL,
    edema varchar(5) DEFAULT NULL,
    escamosa varchar(5) DEFAULT NULL,
    petequias varchar(5) DEFAULT NULL,
    cabello varchar(5) DEFAULT NULL,
    adenomegalia varchar(5) DEFAULT NULL,
    hepatoesplenomegalia varchar(5) DEFAULT NULL,
    linfadenopatia varchar(5) DEFAULT NULL,
    perdidapeso varchar(5) DEFAULT NULL,
    nodulo varchar(5) DEFAULT NULL,
    ulcera varchar(5) DEFAULT NULL,
    cicatriz varchar(5) DEFAULT NULL,
    antecedentes text DEFAULT NULL, 
    lesionmucosa varchar(5) DEFAULT NULL,
    alta date DEFAULT CURDATE(),
    modificado timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario int(4) UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Descripción clínica y sospecha';

-- eliminamos la vista si existe
DROP VIEW IF EXISTS v_clinica;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_clinica AS
       SELECT leishmania.clinica.id AS id,
              leishmania.clinica.paciente AS idpaciente,
              leishmania.pacientes.nombre AS paciente,
              leishmania.clinica.cutaneaunica AS cutaneaunica,
              leishmania.clinica.cutaneamultiple AS cutaneamultiple,
              leishmania.clinica.mucosanasal AS mucosanasal,
              leishmania.clinica.bucofaringea AS bucofaringea,
              leishmania.clinica.laringea AS laringea,
              leishmania.clinica.visceral AS visceral,
              leishmania.clinica.fiebre AS fiebre,
              DATE_FORMAT(leishmania.clinica.inicio, '%d/%m/%y') AS inicio,
              leishmania.clinica.caracteristicas AS caracteristicas,
              leishmania.clinica.fatiga AS fatiga,
              leishmania.clinica.debilidad AS debilidad,
              leishmania.clinica.vomitos AS vomitos,
              leishmania.clinica.diarrea AS diarrea,
              leishmania.clinica.tosseca AS tosseca,
              leishmania.clinica.pielgris AS pielgris,
              leishmania.clinica.edema AS edema,
              leishmania.clinica.escamosa AS escamosa,
              leishmania.clinica.petequias AS petequias,
              leishmania.clinica.cabello AS cabello,
              leishmania.clinica.adenomegalia AS adenomegalia,
              leishmania.clinica.hepatoesplenomegalia AS hepatoesplenomegalia,
              leishmania.clinica.linfadenopatia AS linfadenopatia,
              leishmania.clinica.perdidapeso AS perdidapeso,
              leishmania.clinica.nodulo AS nodulo,
              leishmania.clinica.ulcera AS ulcera,
              leishmania.clinica.cicatriz AS cicatriz,
              leishmania.clinica.antecedentes AS antecedentes, 
              leishmania.clinica.lesionmucosa AS lesionmucosa,
              DATE_FORMAT(leishmania.clinica.alta, '%d/%m/%Y') As alta,
              DATE_FORMAT(leishmania.clinica.modificado, '%d/%m/%Y') AS modificado,
              leishmania.clinica.usuario AS idusuario,
              cce.responsables.usuario AS usuario
       FROM leishmania.clinica INNER JOIN cce.responsables ON leishmania.clinica.usuario = cce.responsables.id
                               INNER JOIN leishmania.pacientes ON leishmania.clinica.paciente = leishmania.pacientes.id;
