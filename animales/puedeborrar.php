<?php

/**
 *
 * Archivo: puedeborrar.php / animales/puedeborrar.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un registro
 *              y verifica que no tenga registros hijos antes de
 *              eliminarlo
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// verificamos
$resultado = $diccionario->puedeBorrar((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
