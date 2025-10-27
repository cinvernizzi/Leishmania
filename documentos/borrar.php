<?php

/**
 *
 * documentos/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Documentos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (13/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un tipo de documento
 * y ejecuta la consulta de eliminación
 *
*/

// incluimos e instanciamos la clase
require_once "documentos.class.php";
$documentos = new Documentos();
$resultado = $documentos->borraDocumento((int) $_GET["id"]);

// retornamos la operación
echo json_encode(array("Resultado" => $resultado));
