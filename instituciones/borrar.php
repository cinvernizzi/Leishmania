<?php

/**
 *
 * instituciones/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (18/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de una institución
 * y ejecuta la consulta de eliminación
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();
$resultado = $institucion->borraInstitucion((int) $_GET["id"]);

// retornamos la operación
echo json_encode(array("Error" => $resultado));
