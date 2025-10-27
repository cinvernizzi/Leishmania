<?php

/**
 *
 * borrar.php | viajes/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @param       int clave del registro
 * @return      bool resultado de la operación
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y ejecuta la
 * consulta de eliminación, retorna el resultado de la operación
 *
*/

// incluimos e instanciamos
require_once "viajes.class.php";
$viajes = new Viajes();

// eliminamos
$resultado = $viajes->borraViaje((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
