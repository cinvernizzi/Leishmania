<?php

/**
 *
 * getdatos.php | mascotas/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Mascotas
 * @param       int clave del registro
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y retorna el
 * array json con los datos del registro
 *
*/

// incluimos e instanciamos
require_once "mascotas.class.php";
$mascota = new Mascotas();

// obtenemos el registro
$resultado = $mascota->getDatosMascota((int) $_GET["id"]);

// si no hubo errores
if ($resultado){
    
    // retornamos el registro
    echo json_encode(array("Resultado" => true,
                           "Id" =>        $mascota->getId(),
                           "Paciente" =>  $mascota->getPaciente(),
                           "Nombre" =>    $mascota->getNombre(),
                           "Edad" =>      $mascota->getEdad(),
                           "Origen" =>    $mascota->getOrigen(),
                           "Usuario" =>   $mascota->getUsuario(),
                           "Alta" =>      $mascota->getAlta()));
                           
// hubo un error
} else {
    
    // retornamos
    echo json_encode(array("Resultado" => $resultado));
    
}
