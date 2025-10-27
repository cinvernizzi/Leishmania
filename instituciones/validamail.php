<?php

/**
 *
 * instituciones/validamail.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (18/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get el mail de una institución
 * y verifica que no esté declarado, retorna el número de
 * registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$instituciones = new Instituciones();

// verificamos si está declarado
$registros = $instituciones->validaMail($_GET["email"]);

// retornamos
echo json_encode(array("Registros" => $registros));
