<?php

/**
 *
 * validarmail | responsables/validarmail.php
 *
 * @package     CCE
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (28/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get una dirección de correo y verifica
 * que no se encuentre registrado, retorna el número de registros
 * encontrados
 *
 */

// incluimos e instanciamos las clases
require_once "responsables.class.php";
$responsable = new Responsables();

// verificamos si existe
$registros = $responsable->verificaMail($_GET["mail"]);

// retornamos
echo json_encode(array("Registros" => $registros));
