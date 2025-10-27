<?php

/**
 *
 * clinica/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Clinica
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (21/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y retorna
 * el vector con los datos del mismo
 *
*/

// incluimos e instanciamos
require_once "clinica.class.php";
$clinica = new Clinica();

// obtenemos el registro
$clinica->getDatosClinica((int) $_GET["id"]);

// retornamos el vector
echo json_encode(array("Id" =>              $clinica->getId(),
                       "CutaneaUnica" =>    $clinica->getCutaneaUnica(),
                       "CutaneaMultiple" => $clinica->getCutaneaMultiple(),
                       "MucosaNasal" =>     $clinica->getMucosaNasal(),
                       "BucoFaringea" =>    $clinica->getBucofaringea(),
                       "Laringea" =>        $clinica->getLaringea(),
                       "Visceral" =>        $clinica->getVisceral(),
                       "Fiebre" =>          $clinica->getFiebre(),
                       "Inicio" =>          $clinica->getInicio(),
                       "Caracteristicas" => $clinica->getCaracteristicas(),
                       "Fatiga" =>          $clinica->getFatiga(),
                       "Debilidad" =>       $clinica->getDebilidad(),
                       "Vomitos" =>         $clinica->getVomitos(),
                       "Diarrea" =>         $clinica->getDiarrea(),
                       "TosSeca" =>         $clinica->getTosSeca(),
                       "PielGris" =>        $clinica->getPielGris(),
                       "Edema" =>           $clinica->getEdema(),
                       "Escamosa" =>        $clinica->getEscamosa(),
                       "Petequias" =>       $clinica->getPetequias(),
                       "Cabello" =>         $clinica->getCabello(),
                       "Adenomegalia" =>    $clinica->getAdenomegalia(),
                       "HpatoEspleno" =>    $clinica->getHepatoEspleno(),
                       "Linfadenopatia" =>  $clinica->getLinfadenopaTia(),
                       "PerdidaPeso" =>     $clinica->getPerdidaPeso(),
                       "Nodulo" =>          $clinica->getNodulo(),
                       "Ulcera" =>          $clinica->getUlcera(),
                       "Cicatriz" =>        $clinica->getCicatriz(),
                       "LesionMucosa" =>    $clinica->getLesionMucosa(),
                       "Alta" =>            $clinica->getAlta(),
                       "Modificado" =>      $clinica->getModificado(),
                       "Usuario" =>         $clinica->getUsuario()));
