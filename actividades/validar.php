<?php

/**
 *
 * Archivo: validar.php / actividades/validar.php
 * @package Leishmania
 * @subpackage Actividades
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe como parámetros la descripción de
 *              la actividad, el lugar de la misma y la fecha,
 *              verifica entonces que no esté declarada, si puede
 *              insertar retorna verdadero
 *
 */

// incluimos e instanciamos
require_once "actividades.class.php";
$actividad = new Actividades();

// verificamos
$resultado = $actividad->validaActividad($_GET["actividad"],
                                         $_GET["lugar"],
                                         $_GET["fecha"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
