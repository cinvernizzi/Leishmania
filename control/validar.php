<?php

/**
 *
 * validar.php | control/validar.php
 * @package Leishmania
 * @subpackage Control
 * @param int clave del paciente
 * @param string fecha del control
 * @return bool verdadero si puede insertar
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y la fecha
 * del control y verifica que no se encuentre ya declarada,
 * retorna verdadero si puede insertar
 *
 */

// incluimos e instanciamos
require_once "control.class.php";
$control = new Control();

// verificamos
$resultado = $control->validaControl((int) $_GET["idpaciente"], $_GET["fecha"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
