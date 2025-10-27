<?php

/**
 *
 * borrar.php | control/borrar.php
 * @package Leishmania
 * @subpackage Control
 * @param int clave del registro
 * @return bool resultado de la operación
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (31/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un
 *              registro y ejecuta la consulta de eliminación
 *              retorna el resultado de la operación
 *
 */

// incluimos e instanciamos
require_once "control.class.php";
$control = new Control();

// ejecutamos la consulta
$resultado = $control->borraControl((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
