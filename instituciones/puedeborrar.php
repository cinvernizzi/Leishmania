<?php

/**
 *
 * derivacion/puedeborrar.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (02/02/2022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de una institución
 * y verifica que no esté asignado a ningún paciente
 * retorna la cantidad de registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// verificamos si tiene registros
$registros = $institucion->puedeBorrar((int) $_GET["id"]);

// retornamos el número de registros
echo json_encode(array("Registros" => $registros));
