<?php

/**
 *
 * documentos/puedeborrar.php
 *
 * @package     Leishmania
 * @subpackage  Documentos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (13/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un tipo de documento
 * y verifica que no esté asignado a ningún paciente, retorna
 * la cantidad de registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "documentos.class.php";
$documentos = new Documentos();

// verificamos si tiene registros
$registros = $documentos->puedeBorrar((int) $_GET["id"]);

// retornamos el número de registros
echo json_encode(array("Registros" => $registros));
