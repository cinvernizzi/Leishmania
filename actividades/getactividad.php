<?php

/**
 *
 * actividades/getactividad.php
 *
 * @package     Leishmania
 * @subpackage  Actividades
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/07/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un registro y retorna
 * el array json con los datos del mismo
 *
*/

// incluimos e instanciamos
require_once "actividades.class.php";
$actividad = new Actividades();

// obtenemos el registro
$resultado = $actividad->getDatosActividad((int) $_GET["id"]);

// si no hubo errores
if ($resultado){

    // retornamos el vector
    echo json_encode(array("Resultado" =>  true,
                           "Id" =>         $actividad->getId(),
                           "IdPaciente" => $actividad->getIdPaciente(),
                           "Lugar" =>      $actividad->getLugar(),
                           "Actividad" =>  $actividad->getActividad(),
                           "Fecha" =>      $actividad->getFecha(),
                           "Usuario" =>    $actividad->getUsuario(),
                           "Alta" =>       $actividad->getAlta()));

// si ocurrió un error
} else {

    // retornamos
    echo json_encode(array("Resultado" =>  false));
    
}
