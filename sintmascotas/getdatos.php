<?php

/**
 *
 * getdatos.php | sintmascotas/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Sintmascotas
 * @param       int clave de la mascota
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (04/08/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de una mascota y retorna el
 * vector con los datos de los sintomas de esa mascota (asumimos
 * que existe una relación uno a uno entre los síntomas y las
 * mascotas)
 *
*/

// incluimos e instanciamos
require_once "sintmascotas.class.php";
$sintomas = new SintMascotas();

// obtenemos el registro
$resultado = $sintomas->getDatosSintomas((int) $_GET["idmascota"]);

// si salió bien
if ($resultado){

    // retornamos
    echo json_encode(array("Resultado" =>            true,
                           "Id" =>                   $sintomas->getId(),
                           "Mascota" =>              $sintomas->getMascota(),
                           "Paciente" =>             $sintomas->getPaciente(),
                           "Anorexia" =>             $sintomas->getAnorexia(),
                           "Adinamia" =>             $sintomas->getAdinamia(),
                           "Emaciacion" =>           $sintomas->getEmaciacion(),
                           "Polidipsia" =>           $sintomas->getPolidipsia(),
                           "Atrofia" =>              $sintomas->getAtrofia(),
                           "Paresia" =>              $sintomas->getParesia(),
                           "Convulsiones" =>         $sintomas->getConvulsiones(),
                           "Adenomegalia" =>         $sintomas->getAdenomegalia(),
                           "Blefaritis" =>           $sintomas->getBlefaritis(),
                           "Conjuntivitis" =>        $sintomas->getConjuntivitis(),
                           "Queratitis" =>           $sintomas->getQueratitis(),
                           "Uveitis" =>              $sintomas->getUveitis(),
                           "Palidez" =>              $sintomas->getPalidez(),
                           "Epistaxis" =>            $sintomas->getEpistaxis(),
                           "Ulceras" =>              $sintomas->getUlceras(),
                           "Diarrea" =>              $sintomas->getDiarrea(),
                           "Nodulos" =>              $sintomas->getNodulos(),
                           "Vomitos" =>              $sintomas->getVomitos(),
                           "Artritis" =>             $sintomas->getArtritis(),
                           "Eritema" =>              $sintomas->getEritema(),
                           "Prurito" =>              $sintomas->getPrurito(),
                           "UlceraCutanea" =>        $sintomas->getUlceraCutanea(),
                           "NodulosCutaneos" =>      $sintomas->getNodulosCutaneos(),
                           "AlopeciaLocalizada" =>   $sintomas->getAlopeciaLocalizada(),
                           "AlopeciaGeneralizada" => $sintomas->getAlopeciaGeneralizada(),
                           "HiperqueratosisN" =>     $sintomas->getHiperqueratosisN(),
                           "HiperqueratosisP" =>     $sintomas->getHiperqueratosisP(),
                           "SeborreaGrasa" =>        $sintomas->getSeborreaGrasa(),
                           "SeborreaEscamosa" =>     $sintomas->getSeborreaEscamosa(),
                           "Onicogrifosis" =>        $sintomas->getOnicogrifosis(),
                           "CasoHumano" =>           $sintomas->getCasoHumano(),
                           "Flebotomos" =>           $sintomas->getFlebotomos(),
                           "CasaTrampeada" =>        $sintomas->getCasaTrampeada(),
                           "Fumigacion" =>           $sintomas->getFumigacion(),
                           "MateriaOrganica" =>      $sintomas->getMateriaOrganica(),
                           "Repelentes" =>           $sintomas->getRepelentes(),
                           "Periodicidad" =>         $sintomas->getPeriodicidad(),
                           "Duerme" =>               $sintomas->getDuerme(),
                           "QuedaLibre" =>           $sintomas->getQuedaLibre(),
                           "Antecedentes" =>         $sintomas->getAntecedentes(),
                           "Usuario" =>              $sintomas->getUsuario(),
                           "Alta" =>                 $sintomas->getAlta()));

// si ocurrió un error
} else {

    // retornamos el error
    echo json_encode(array("Resultado" => false));

}
