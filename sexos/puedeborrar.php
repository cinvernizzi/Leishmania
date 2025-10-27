<?php

/**
 *
 * sexos/puedeborrar.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un sexo
 * y verifica que no esté asignado a ningún paciente
 * retorna la cantidad de registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "sexos.class.php";
$sexos = new Sexos();

// verificamos si tiene registros
$registros = $sexos->puedeBorrar((int) $_GET["id"]);

// retornamos el número de registros
echo json_encode(array("Registros" => $registros));
