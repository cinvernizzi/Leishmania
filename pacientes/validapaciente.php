<?php

/**
 *
 * pacientes/validapaciente.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get el número de documento de un paciente
 * y verifica si ya está declarado
 *
*/

// incluimos e instanciamos las clases
require_once "pacientes.class.php";
$paciente = new Pacientes();

// verificamos
$resultado = $paciente->validaPaciente($_GET["documento"], (int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
