<?php

/**
 *
 * Archivo: borrar.php / evolucion/borrar.php
 * @package Leishmania
 * @subpackage Evolucion
 * @param int clave del registro
 * @return bool resultado de la operación
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por get la clave de un
 *              registro y ejecuta la consulta de eliminación
 *              retorna el resultado de la operación
 *
 */

// incluimos e instanciamos
require_once "evolucion.class.php";
$evolucion = new Evolucion();

// ejecutamos la consulta
$resultado = $evolucion->borraEvolucion((int) $_GET["idevolucion"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
