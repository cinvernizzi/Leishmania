<?php

/**
 *
 * Archivo: borrar.php / animales/borrar.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la claeve de un registro
 *              y ejecuta la consulta de aliminación
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// ejecutamos
$resultado = $diccionario->borraAnimal((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
