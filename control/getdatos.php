<?php

/**
 *
 * getdatos.php | control/getdatos.php
 * @package Leishmania
 * @subpackage Control
 * @param int clave del registro
 * @return array datos del registro
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (31/07/2025)
 * @copyright (c) 2025, DsGestion
 *
 * Método que recibe como parámetro la clave de un paciente
 * y retorna el array json con los datos del mismo
 *
 */

// incluimos e instanciamos
require_once "control.class.php";
$control = new Control();

// obtenemos el registro
$resultado = $control->getDatosControl((int) $_GET["id"]);

// si anduvo bien
if ($resultado){

    // retornamos
    echo json_encode(array("Resultado" =>     true,
                           "Id" =>            $control->getId(),
                           "Paciente" =>      $control->getPaciente(),
                           "Tratamiento" =>   $control->getTratamiento(),
                           "Droga" =>         $control->getDroga(),
                           "Dosis" =>         $control->getDosis(),
                           "Contactos" =>     $control->getContactos(),
                           "NroContactos" =>  $control->getNroContactos(),
                           "ContactosPos" =>  $control->getContactosPos(),
                           "Bloqueo" =>       $control->getBloqueo(),
                           "NroViviendas" =>  $control->getNroViviendas(),
                           "SitiosRiesgo" =>  $control->getSitiosRiesgo(),
                           "Insecticida" =>   $control->getInsecticida(),
                           "CantidadInsec" => $control->getCantidadInsec(),
                           "Fecha" =>         $control->getFecha(),
                           "Usuario" =>       $control->getUsuario(),
                           "Alta" =>          $control->getAlta()));

// si ocurrió un error
} else {

    // retornamos el error
    echo json_encode(array("Resultado" => false));

}
