<?php

/**
 *
 * ocupaciones/validar.php
 *
 * @package     Leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe como parámetro el nombre de una ocupación
 * y verifica que no esté declarada, retorna el número de
 * registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "ocupaciones.class.php";
$ocupaciones = new Ocupaciones();

// verificamos
$registros = $ocupaciones->validaOcupacion($_GET["ocupacion"]);

// retornamos
echo json_encode(array("Registros" => $registros));
