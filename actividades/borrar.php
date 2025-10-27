<?php

/**
 *
 * Archivo: borrar.php / actividades/borrar.php
 * @package Leishmania
 * @subpackage Actividades
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un
 *              registro y ejecuta la consulta de eliminación
 *              retorna el resultado de la operación
 *
 */

// incluimos los archivos
require_once "actividades.class.php";
$actividad = new Actividades();

// eliminamos el registro
$resultado = $actividad->borraActividad((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
