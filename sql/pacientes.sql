/**

    Script que genera las tablas de los pacientes con probable diagnóstico
    de leishmania

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 16/05/2025

    Licencia: GPL

    Estructura de la tabla

    id entero clave del registro
    fecha date fecha de denuncia
    nombre varchar nombre y apellido del paciente
    documento varchar número de documento del paciente
    tipodoc int clave del tipo de documento
    sexo int clave del sexo
    edad entero edad en años
    nacimiento date fecha de nacimiento
    locnac varchar clave indec de la localidad de nacimiento
    coordenadas varchar coordenadas gps de la localidad
    domicilio varchar dirección postal
    urbano varchar indica si el domicilio es urbano o rural
    telpaciente varchar teléfono del paciente
    ocupacion entero clave de la ocupación
    institucion entero clave de la institución que envía la muestra
    profesional varchar nombre del profesional que envió la muestra
    mail varchar mail del profesional
    telefono varchar número de teléfono del profesional
    antecedentes texto epidemiología y antededentes
    notificado date fecha de notificación al sisa
    sisa varchar clave de la notificación al sisa
    usuario entero clave del usuario
    alta date fecha de alta del registro
    modificado date fecha de modificación del registro

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS pacientes;

-- la recreamos
CREATE TABLE pacientes (
    id int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    fecha date NOT NULL,
    nombre varchar(200) NOT NULL,
    documento varchar(15) DEFAULT NULL,
    tipodoc int(1) UNSIGNED NOT NULL,
    sexo int(1) UNSIGNED NOT NULL,
    edad int(2) UNSIGNED DEFAULT NULL,
    nacimiento date DEFAULT NULL,
    locnac varchar(30) DEFAULT NULL,
    coordenadas varchar(50) DEFAULT NULL,
    domicilio varchar(200) DEFAULT NULL,
    urbano varchar(20) DEFAULT NULL,
    telpaciente varchar(50) DEFAULT NULL,
    ocupacion int(1) UNSIGNED DEFAULT NULL,
    institucion int(6) UNSIGNED NOT NULL,
    profesional varchar(200) NOT NULL,
    mail varchar(200) NOT NULL,
    telefono varchar(50) DEFAULT NULL,
    antecedentes TEXT DEFAULT NULL,
    notificado date DEFAULT NULL,
    sisa varchar(50) DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta date DEFAULT CURDATE(),
    modificado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY documento(documento),
    KEY tipodoc(tipodoc),
    KEY sexo(sexo),
    KEY nacimiento(nacimiento),
    KEY ocupacion(ocupacion),
    KEY institucion(institucion),
    KEY sisa(sisa),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Nómina de muestras de pacientes';

-- eliminamos la tabla de auditoría
DROP TABLE IF EXISTS auditoria_pacientes;

-- creamos la tabla de auditoría
CREATE TABLE auditoria_pacientes (
    id int(5) UNSIGNED NOT NULL,
    fecha date NOT NULL,
    nombre varchar(200) NOT NULL,
    documento varchar(15) DEFAULT NULL,
    tipodoc int(1) UNSIGNED NOT NULL,
    sexo int(1) UNSIGNED NOT NULL,
    edad int(2) UNSIGNED DEFAULT NULL,
    nacimiento date DEFAULT NULL,
    locnac varchar(30) DEFAULT NULL,
    coordenadas varchar(50) DEFAULT NULL,
    domicilio varchar(200) DEFAULT NULL,
    urbano varchar(20) DEFAULT NULL,
    telpaciente varchar(50) DEFAULT NULL,
    ocupacion int(1) UNSIGNED DEFAULT NULL,
    institucion int(6) UNSIGNED NOT NULL,
    profesional varchar(200) NOT NULL,
    mail varchar(200) NOT NULL,
    telefono varchar(50) DEFAULT NULL,
    antecedentes TEXT DEFAULT NULL,
    notificado date DEFAULT NULL,
    sisa varchar(50) DEFAULT NULL,
    usuario int(4) UNSIGNED NOT NULL,
    alta date NOT NULL,
    modificado date NOT NULL,
    fecha_evento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    evento varchar(15),
    KEY id(id),
    KEY documento(documento),
    KEY tipodoc(tipodoc),
    KEY nacimiento(nacimiento),
    KEY ocupacion(ocupacion),
    KEY institucion(institucion),
    KEY sisa(sisa),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Auditoría de muestras de pacientes';

-- eliminamos el trigger de edición
DROP TRIGGER IF EXISTS edicion_pacientes;

-- lo recreamos
CREATE TRIGGER edicion_pacientes
AFTER UPDATE ON pacientes
FOR EACH ROW
INSERT INTO auditoria_pacientes(
    id,
    fecha,
    nombre,
    documento,
    tipodoc,
    sexo,
    edad,
    nacimiento,
    locnac,
    coordenadas,
    domicilio,
    urbano,
    telpaciente,
    ocupacion,
    institucion,
    profesional,
    mail,
    telefono,
    antecedentes,
    notificado,
    sisa,
    usuario,
    alta,
    modificado,
    evento)
   VALUES
   (OLD.id,
    OLD.fecha,
    OLD.nombre,
    OLD.documento,
    OLD.tipodoc,
    OLD.sexo,
    OLD.edad,
    OLD.nacimiento,
    OLD.locnac,
    OLD.coordenadas,
    OLD.domicilio,
    OLD.urbano,
    OLD.telpaciente,
    OLD.ocupacion,
    OLD.institucion,
    OLD.profesional,
    OLD.mail,
    OLD.telefono,
    OLD.antecedentes,
    OLD.notificado,
    OLD.sisa,
    OLD.usuario,
    OLD.alta,
    OLD.modificado,
    "Edición");

-- eliminamos el trigger de eliminación
DROP TRIGGER IF EXISTS eliminacion_pacientes;

-- lo recreamos
CREATE TRIGGER eliminacion_pacientes
AFTER DELETE ON pacientes
FOR EACH ROW
INSERT INTO auditoria_pacientes(
    id,
    fecha,
    nombre,
    documento,
    tipodoc,
    sexo,
    edad,
    nacimiento,
    locnac,
    coordenadas,
    domicilio,
    urbano,
    telpaciente,
    ocupacion,
    institucion,
    profesional,
    mail,
    telefono,
    antecedentes,
    notificado,
    sisa,
    usuario,
    alta,
    modificado,
    evento)
   VALUES
   (OLD.id,
    OLD.fecha,
    OLD.nombre,
    OLD.documento,
    OLD.tipodoc,
    OLD.sexo,
    OLD.edad,
    OLD.nacimiento,
    OLD.locnac,
    OLD.coordenadas,
    OLD.domicilio,
    OLD.urbano,
    OLD.telpaciente,
    OLD.ocupacion,
    OLD.institucion,
    OLD.profesional,
    OLD.mail,
    OLD.telefono,
    OLD.antecedentes,
    OLD.notificado,
    OLD.sisa,
    OLD.usuario,
    OLD.alta,
    OLD.modificado,
    "Eliminación");

-- eliminamos la vista
DROP VIEW IF EXISTS v_pacientes;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_pacientes AS
       SELECT leishmania.pacientes.id AS id,
              DATE_FORMAT(leishmania.pacientes.fecha, '%d/%m/%Y') AS fecha,
              UCASE(leishmania.pacientes.nombre) AS nombre,
              leishmania.pacientes.documento AS documento,
              leishmania.pacientes.tipodoc AS iddocumento,
              diccionarios.tipo_documento.des_abreviada AS tipodoc,
              leishmania.pacientes.sexo AS idsexo,
              diccionarios.sexos.sexo AS sexo,
              leishmania.pacientes.edad AS edad,
              DATE_FORMAT(leishmania.pacientes.nacimiento, '%d/%m/%Y') AS nacimiento,
              leishmania.pacientes.locnac AS locnacimiento,
              diccionarios.localidades.nomloc AS localidad,
              diccionarios.provincias.nom_prov AS provincia,
              diccionarios.provincias.cod_prov AS codprov,
              diccionarios.paises.nombre AS nacionalidad,
              diccionarios.paises.id AS idnacionalidad,
              leishmania.pacientes.domicilio AS domicilio,
              leishmania.pacientes.coordenadas AS coordenadas,
              leishmania.pacientes.urbano AS urbano,
              leishmania.pacientes.telpaciente AS telpaciente,
              leishmania.pacientes.ocupacion AS idocupacion,
              leishmania.ocupaciones.ocupacion AS ocupacion,
              leishmania.pacientes.institucion AS idinstitucion,
              diagnostico.centros_asistenciales.nombre AS institucion,
              locinstitucion.nomloc AS nomlocinstitucion,
              locinstitucion.codloc AS codlocinstitucion,
              provinstitucion.nom_prov AS provinstitucion,
              provinstitucion.cod_prov AS codprovinstitucion,
              UCASE(leishmania.pacientes.profesional) AS profesional,
              LCASE(leishmania.pacientes.mail) AS mail,
              leishmania.pacientes.telefono AS telefono,
              leishmania.pacientes.antecedentes AS antecedentes,
              DATE_FORMAT(leishmania.pacientes.notificado, '%d/%m/%Y') AS notificado,
              leishmania.pacientes.sisa AS sisa,
              leishmania.pacientes.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              leishmania.mascotas.nombre AS mascota,
              DATE_FORMAT(leishmania.pacientes.alta, '%d/%m/%Y') AS alta,
              DATE_FORMAT(leishmania.pacientes.modificado, '%D/%m/%Y') AS modificado
       FROM leishmania.pacientes LEFT JOIN diccionarios.tipo_documento ON leishmania.pacientes.tipodoc = diccionarios.tipo_documento.id_documento
                                 LEFT JOIN diccionarios.localidades ON leishmania.pacientes.locnac = diccionarios.localidades.codloc
                                 LEFT JOIN diccionarios.provincias ON diccionarios.localidades.codpcia = diccionarios.provincias.cod_prov
                                 LEFT JOIN diccionarios.paises ON diccionarios.provincias.pais = diccionarios.paises.id
                                 LEFT JOIN leishmania.ocupaciones ON leishmania.pacientes.ocupacion = leishmania.ocupaciones.id
                                 LEFT JOIN diagnostico.centros_asistenciales ON leishmania.pacientes.institucion = diagnostico.centros_asistenciales.id
                                 LEFT JOIN diccionarios.localidades AS locinstitucion ON diagnostico.centros_asistenciales.localidad = locinstitucion.codloc
                                 LEFT JOIN diccionarios.provincias AS provinstitucion ON locinstitucion.codpcia = provinstitucion.cod_prov
                                 LEFT JOIN diccionarios.sexos ON leishmania.pacientes.sexo = diccionarios.sexos.id
                                 LEFT JOIN leishmania.mascotas ON leishmania.pacientes.id = leishmania.mascotas.paciente
                                 INNER JOIN cce.responsables ON leishmania.pacientes.usuario = cce.responsables.id;
