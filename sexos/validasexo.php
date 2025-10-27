<?php

/**
 *
 * sexos/validasexo.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get nombre de un sexo
 * y verifica que no esté repetido, retorna el número de
 * registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "sexos.class.php";
$sexos = new Sexos();

// verificamos si está declarado
$registros = $sexos->validaSexo($_GET["sexo"]);

// retornamos
echo json_encode(array("Registros" => $registros));
