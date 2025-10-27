<?php

/**
 *
 * ocupaciones/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe la clave de un registro y ejecuta la
 * consulta de eliminación
 *
*/

// incluimos e instanciamos la clase
require_once "ocupaciones.class.php";
$ocupaciones = new Ocupaciones();

// eliminamos
$resultado = $ocupaciones->borraOcupacion((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
