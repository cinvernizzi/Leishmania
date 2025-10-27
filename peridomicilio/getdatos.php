<?php

/**
 *
 * getdatos.php | peridomicilio/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @param       int clave del registro
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y retorna el
 * array json con los datos del registro
 *
*/

// incluimos e instanciamos
require_once "peridomicilio.class.php";
$peridomicilio = new Peridomicilio();

// obtenemos el registro
$resultado = $peridomicilio->getDatosPeridomicilio((int) $_GET["id"]);

// si anduvo bien
if ($resultado){

    // retornamos el vector
    echo json_encode(array("Resultado" => true,
                           "Id" =>        $peridomicilio->getId(),
                           "Animal" =>    $peridomicilio->getAnimal(),
                           "Paciente" =>  $peridomicilio->getPaciente(),
                           "Distancia" => $peridomicilio->getDistancia(),
                           "Cantidad" =>  $peridomicilio->getCantidad(),
                           "Usuario" =>   $peridomicilio->getUsuario(),
                           "Alta" =>      $peridomicilio->getAlta()));

// si hubo un problema
} else {

    // retornamos el error
    echo json_encode(array("Resultado" => false));

}
