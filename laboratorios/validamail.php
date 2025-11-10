<?php

/**
 *
 * validamail.php | laboratorios/validamail.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/03/2023)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get el una dirección de mail y
 * y verifica que no exista ningún laboratorio declarado
 * con esa dirección
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// verificamos si existe
$registros = $laboratorios->verificaMail($_GET["mail"]);

// retornamos
echo json_encode(array("Registros" => $registros));
