<?php

/**
 *
 * grabar.php | sintmascotas/grabar.php
 *
 * @package     Leishmania
 * @subpackage  SintMascotas
 * @param       array datos del registro
 * @return      int clave del registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (04/08/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro y ejecuta la
 * consulta de grabación, retorna la clave del registro o cero
 * en caso de error
 *
*/

// incluimos e instanciamos
require_once "sintmascotas.class.php";
$sintomas = new SintMascotas();

// asignamos los valores
$sintomas->setId((int) $_POST["Id"]);
$sintomas->setMascota((int) $_POST["Mascota"]);
$sintomas->setPaciente((int) $_POST["Paciente"]);
$sintomas->setAnorexia($_POST["Anorexia"]);
$sintomas->setAdinamia($_POST["Adinamia"]);
$sintomas->setEmaciacion($_POST["Emaciacion"]);
$sintomas->setPolidipsia($_POST["Polidipsia"]);
$sintomas->setAtrofia($_POST["Atrofia"]);
$sintomas->setParesia($_POST["Paresia"]);
$sintomas->setConvulsiones($_POST["Convulsiones"]);
$sintomas->setAdenomegalia($_POST["Adenomegalia"]);
$sintomas->setBlefaritis($_POST["Blefaritis"]);
$sintomas->setQueratitis($_POST["Queratitis"]);
$sintomas->setUveitis($_POST["Uveitis"]);
$sintomas->setPalidez($_POST["Palidez"]);
$sintomas->setEpistaxis($_POST["Epistaxis"]);
$sintomas->setUlceras($_POST["Ulceras"]);
$sintomas->setDiarrea($_POST["Diarrea"]);
$sintomas->setNodulos($_POST["Nodulos"]);
$sintomas->setVomitos($_POST["Vomitos"]);
$sintomas->setArtritis($_POST["Artritis"]);
$sintomas->setEritema($_POST["Eritema"]);
$sintomas->setPrurito($_POST["Prurito"]);
$sintomas->setUlceraCutanea($_POST["UlceraCutanea"]);
$sintomas->setNodulosCutaneos($_POST["NodulosCutaneos"]);
$sintomas->setAlopeciaLocalizada($_POST["AlopeciaLocalidada"]);
$sintomas->setAlopeciaGeneralizada($_POST["AlopeciaGeneralidada"]);
$sintomas->setHiperqueratosisN($_POST["HiperqueratosisN"]);
$sintomas->setHiperqueratosisP($_POST["HiperqueratosisP"]);
$sintomas->setSeborreaGrasa($_POST["SeborreaGrasa"]);
$sintomas->setSeborreaEscamosa($_POST["SeborreaEstamosa"]);
$sintomas->setOnicogrifosis($_POST["Onicogrifosis"]);
$sintomas->setCasoHumano($_POST["CasoHumano"]);
$sintomas->setFlebotomos($_POST["Flebotomos"]);
$sintomas->setCastaTrampeada($_POST["CasaTrampeada"]);
$sintomas->setFumigacion($_POST["Fumigacion"]);
$sintomas->setMateriaOrganica($_POST["MateriaOrganica"]);
$sintomas->setRepelentes($_POST["Repelentes"]);
$sintomas->setPeriodicidad($_POST["Periodicidad"]);
$sintomas->setDuerme($_POST["Duerme"]);
$sintomas->setQuedaLibre($_POST["QuedaLibre"]);
$sintomas->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $sintomas->grabaSintoma();

// retornamos
echo json_encode(array("Resultado" => $resultado));
