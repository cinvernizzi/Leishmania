<?php

/**
 *
 * validar.php | laboratorios/validar.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/03/2023)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get el nombre de un laboratorio y la clave
 * indec de la localidad y verifica que no exista ningún laboratorio
 * declarado en esa localidad
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// verificamos si existe
$registros = $laboratorios->verificaLaboratorio($_GET["laboratorio"], $_GET["codloc"]);

// retornamos
echo json_encode(array("Registros" => $registros));
