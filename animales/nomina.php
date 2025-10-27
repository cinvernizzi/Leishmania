<?php

/**
 *
 * Archivo: nomina.php / animales/nomina.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que retorna el array json con la nómina
 *              completa del diccionario de animales del
 *              peridomicilio
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// obtenemos el registro
$nomina = $diccionario->nominaAnimales();

// declaramos el array
$resultado = array();

// recorremos el vector
foreach($nomina as $registro){
 
    // lo agregamos
    $resultado[] = array("Id" =>      $registro["id"],
                         "Animal" =>  $registro["animal"],
                         "Usuario" => $registro["usuario"],
                         "Alta" =>    $registro["alta"],
                         "Editar" =>  "<img src='imagenes/save.png'>",
                         "Borrar" =>  "<img src='imagenes/borrar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
