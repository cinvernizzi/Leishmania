<?php

/**
 *
 * Archivo: validar.php / animales/validar.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get el nombre de un animal
 *              del peridomicilio y la clave del mismo (o cero
 *              en caso de alta) y retorna verdadero si no está
 *              repetido y puede dar el alta
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// velidamos
$resultado = $diccionario->validaAnimal($_GET["animal"], (int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
