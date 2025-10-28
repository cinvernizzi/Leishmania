 /**

    Script que genera las tablas con los datos de los
    sintomas de las mascotas del paciente

    Author: Claudio Invernizzi <cinvernizzi@dsgestion.site>

    Fecha: 15/07/2025

    Licencia: GPL

    Estructura:

    id entero clave del registro
    mascota entero clave de la mascota
    paciente entero clave del paciente
    anorexia enum si presenta anorexia
    adinamia enum si presenta adinamia
    emaciacion si presenta emaciacion
    polidipsia si presenta polidipcia
    atrofia si presenta atrofia muscular
    paresia si presenta parecia
    convulsiones si presenta convulsiones
    adenomegalia si presenta adenomegalia
    blefaritis si presenta blefaritis
    conjuntivitis si presenta conjuntivitis
    queratitis si presenta queratitis
    uveitis si presenta uveitis
    palidez si presenta palidez en las mucosas
    epistaxis si presenta epistaxis
    ulceras si presenta úlceras en las mucosas
    nodulos si presenta nódulos en las mucosas
    vomitos si presenta vómitos
    diarrea si presenta diarrea
    artritis si presenta artritis
    eritema si presenta eritema
    prurito si presenta prurito
    ulceracutanea si presenta úlcera cutánea
    noduloscutaneos si presenta nódulos cutáneos 
    alopecialocalizada si presenta péridida de cabello 
    alopeciageneralizada si presenta pérdida de cabello
    hipequeratosisn si presenta hiperqueratosis nasal
    hiperquetatosis si presenta hiperqueratosis plantar
    seborreagrasa si presenta seborrea
    seborreaescamosa si presenta seborrea
    onicogrifosis si presenta engrosamiento de las uñas
    casohumano enum si hay presencia de caso humano
    flebotomos enum si hay flebótomos
    casatrampeada enum si la casa está trampeada
    fumigacion enum si hay fumigación 
    materiaorganica enum si hay acúmulo de materia orgánica
    repelentes enum si usan repelentes en la mascota
    periodicidad semanal / mensual / semestral frecuencia del repelente
    duerme interior / exterior 
    quedalibre si queda libre en la calle
    usuario entero clave del usuario
    alta date fecha de alta del registro

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos la tabla si existe
DROP TABLE IF EXISTS sintmascotas;

-- la recreamos
CREATE TABLE sintmascotas(
    id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    mascota int(4) UNSIGNED NOT NULL,
    paciente int(4) UNSIGNED NOT NULL,
    anorexia varchar(10) DEFAULT 'No',
    adinamia varchar(10) DEFAULT 'No',
    emaciacion varchar(10) DEFAULT 'No',
    polidipsia varchar(10) DEFAULT 'No',
    atrofia varchar(10) DEFAULT 'No',
    paresia varchar(10) DEFAULT 'No',
    convulsiones varchar(10) DEFAULT 'No',
    adenomegalia varchar(10) DEFAULT 'No',
    blefaritis varchar(10) DEFAULT 'No',
    conjuntivitis varchar(10) DEFAULT 'No',
    queratitis varchar(10) DEFAULT 'No',
    uveitis varchar(10) DEFAULT 'No',
    palidez varchar(10) DEFAULT 'No',
    epistaxis varchar(10) DEFAULT 'No',
    ulceras varchar(10) DEFAULT 'No',
    nodulos varchar(10) DEFAULT 'No',
    vomitos varchar(10) DEFAULT 'No',
    diarrea varchar(10) DEFAULT 'No',
    artritis varchar(10) DEFAULT 'No',
    eritema varchar(10) DEFAULT 'No',
    prurito varchar(10) DEFAULT 'No',
    ulceracutanea varchar(10) DEFAULT 'No',
    noduloscutaneos varchar(10) DEFAULT 'No',
    alopecialocalizada varchar(10) DEFAULT 'No',
    alopeciageneralizada varchar(10) DEFAULT 'No',
    hiperqueratosisn varchar(10) DEFAULT 'No',
    hiperqueratosisp varchar(10) DEFAULT 'No',
    seborreagrasa varchar(10) DEFAULT 'No',
    seborreaescamosa varchar(10) DEFAULT 'No',
    onicogrifosis varchar(10) DEFAULT 'No',
    casohumano varchar(10) DEFAULT 'No',
    flebotomos varchar(10) DEFAULT 'No',
    casatrampeada varchar(10) DEFAULT 'No',
    fumigacion varchar(10) DEFAULT 'No',
    materiaorganica varchar(10) DEFAULT 'No',
    repelentes varchar(10) DEFAULT 'No',
    periodicidad varchar(20) DEFAULT NULL,
    duerme varchar(20) DEFAULT NULL,
    quedalibre varchar(10) DEFAULT 'No',
    usuario int(4) UNSIGNED NOT NULL,
    alta timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    KEY mascota(mascota),
    KEY paciente(paciente),
    KEY usuario(usuario)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_spanish_ci
COMMENT='Síntomas de las mascotas';

-- eliminamos la vista
DROP VIEW IF EXISTS v_sintmascotas;

-- la recreamos
CREATE ALGORITHM = UNDEFINED
       DEFINER = CURRENT_USER
       SQL SECURITY INVOKER
       VIEW v_sintmascotas AS
       SELECT leishmania.sintmascotas.id AS id,
              leishmania.sintmascotas.mascota AS idmascota,
              leishmania.sintmascotas.paciente AS idpaciente,
              leishmania.sintmascotas.anorexia AS anorexia,
              leishmania.sintmascotas.adinamia AS adinamia,
              leishmania.sintmascotas.emaciacion AS emaciacion,
              leishmania.sintmascotas.polidipsia AS polidipsia,
              leishmania.sintmascotas.atrofia AS atrofia,
              leishmania.sintmascotas.paresia AS paresia, 
              leishmania.sintmascotas.convulsiones AS convulsiones,
              leishmania.sintmascotas.adenomegalia As adenomegalia,
              leishmania.sintmascotas.blefaritis AS blefaritis,
              leishmania.sintmascotas.conjuntivitis AS conjuntivitis,
              leishmania.sintmascotas.queratitis AS queratitis,
              leishmania.sintmascotas.uveitis AS uveitis,
              leishmania.sintmascotas.palidez AS palidez,
              leishmania.sintmascotas.epistaxis AS epistaxis,
              leishmania.sintmascotas.ulceras AS ulceras,
              leishmania.sintmascotas.nodulos AS nodulos,
              leishmania.sintmascotas.vomitos AS vomitos,
              leishmania.sintmascotas.diarrea AS diarrea,
              leishmania.sintmascotas.artritis AS artritis,
              leishmania.sintmascotas.eritema AS eritema,
              leishmania.sintmascotas.prurito AS prurito,
              leishmania.sintmascotas.ulceracutanea AS ulceracutanea,
              leishmania.sintmascotas.noduloscutaneos AS noduloscutaneos,
              leishmania.sintmascotas.alopecialocalizada AS alopecialocalizada,
              leishmania.sintmascotas.alopeciageneralizada AS alopeciageneralizada,
              leishmania.sintmascotas.hiperqueratosisn AS hiperqueratosisn,
              leishmania.sintmascotas.hiperqueratosisp AS hiperqueratosisp,
              leishmania.sintmascotas.seborreagrasa AS seborreagrasa,
              leishmania.sintmascotas.seborreaescamosa AS seborreaescamosa,
              leishmania.sintmascotas.onicogrifosis AS onicogrifosis,
              leishmania.sintmascotas.casohumano AS casohumano,
              leishmania.sintmascotas.flebotomos AS flebotomos,
              leishmania.sintmascotas.casatrampeada AS casatrampeada,
              leishmania.sintmascotas.fumigacion AS fumigacion,
              leishmania.sintmascotas.materiaorganica AS materiaorganica,
              leishmania.sintmascotas.repelentes AS repelentes,
              leishmania.sintmascotas.periodicidad AS periodicidad,
              leishmania.sintmascotas.duerme AS duerme,
              leishmania.sintmascotas.quedalibre AS quedalibre,
              leishmania.sintmascotas.usuario AS idusuario,
              cce.responsables.usuario AS usuario,
              DATE_FORMAT(leishmania.sintmascotas.alta, '%d/%m/%Y') AS alta
       FROM leishmania.sintmascotas INNER JOIN cce.responsables ON leishmania.sintmascotas.usuario = cce.responsables.id;
