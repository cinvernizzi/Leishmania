<?php

/**
 *
 * Archivo: getdatos.php / evolucion/getdatos.php
 * @package Leishmania
 * @subpackage Evolucion
 * @param int clave del registro
 * @return array vector json con el registro
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un
 *              paciente ejecuta la consulta en la base
 *              de datos y retorna el array json con los
 *              valores del registro
 *
 */

// incluimos e instanciamos
require_once "evolucion.class.php";
$evolucion = new Evolucion();

// obtenemos el registro
$estado = $evolucion->getDatosEvolucion((int) $_GET["id"]);

// si no hubo errores
if ($estado){

    // retornamos el registro
    echo json_encode(array("Id" =>              $evolucion->getId(),
                           "Paciente" =>        $evolucion->getPaciente(),
                           "Hospitalizacion" => $evolucion->getHospitalizacion(),
                           "FechaAlta" =>       $evolucion->getFechaAlta(),
                           "Defuncion" =>       $evolucion->getDefuncion(),
                           "Condicion" =>       $evolucion->getCondicion(),
                           "Clasificacion" =>   $evolucion->getClasificacion(),
                           "Usuario" =>         $evolucion->getUsuario(),
                           "Alta" =>            $evolucion->getAlta()));

// si ocurrió un error
} else {

    // retornamos
    echo json_encode(array("Resultado" => false));

}
