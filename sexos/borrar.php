<?php

/**
 *
 * sexos/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un sexo
 * y ejecuta la consulta de eliminación
 *
*/

// incluimos e instanciamos la clase
require_once "sexos.class.php";
$sexos = new Sexos();
$resultado = $sexos->borraSexo((int) $_GET["id"]);

// retornamos la operación
echo json_encode(array("Resultado" => $resultado));
