<?php

/**
 *
 * validar.php | peridomicilio/validar.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @param       int clave animal
 * @param       int clave del paciente
 * @return      array vector con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un animal y la clave del
 * paciente y verifica que no se encuentre declarado, retorna
 * verdadero si puede insertar
 *
*/

// incluimos e instanciamos
require_once "peridomicilio.class.php";
$peridomicilio = new Peridomicilio();

// verificamos
$resultado = $peridomicilio->validaPeridomicilio((int) $_GET["idanimal"], (int) $_GET["idpaciente"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
