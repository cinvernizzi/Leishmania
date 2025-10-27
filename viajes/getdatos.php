<?php

/**
 *
 * getdatos.php | viajes/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @param       int clave del registro
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y retorna
 * el array json con los valores del mismo
 *
*/

// incluimos e instanciamos
require_once "viajes.class.php";
$viajes = new Viajes();

// obtenemos el registro
$resultado = $viajes->getDatosViaje((int) $_GET["id"]);

// si salió bien
if ($resultado){

    // retornamos
    echo json_encode(array("Resultado" => true,
                           "Id" =>        $viajes->getId(),
                           "Paciente" =>  $viajes->getPaciente(),
                           "Lugar" =>     $viajes->getLugar(),
                           "Fecha" =>     $viajes->getFecha(),
                           "Usuario" =>   $viajes->getUsuario(),
                           "Alta" =>      $viajes->getAlta()));

// si hubo algún error
} else {

    // retorna el error
    echo json_encode(array("Resultado" => false));

}
