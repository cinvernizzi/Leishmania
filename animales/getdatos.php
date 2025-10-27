<?php

/**
 *
 * Archivo: getdatos.php / animales/getdatos.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un registro
 *              del diccionario de animales del peridomicilio y
 *              retorna el vector json con los datos del registro
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// obtenemos el registro
$resultado = $diccionario->getDatosAnimal((int) $_GET["idanimal"]);

// si salió bien
if ($resultado){
    
    // retornamos el registro
    echo json_encode(array("Resultado" => true,
                           "Id" =>        $diccionario->getId(),
                           "Animal" =>    $diccionario->getAnimal(),
                           "Usuario" =>   $diccionario->getUsuario(),
                           "Alta" =>      $diccionario->getAlta()));
    
    
// si ocurrió un error
} else {
    
    // retorna el estado
    echo json_encode(array("Resultado" => false));
    
}
