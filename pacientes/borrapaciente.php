<?php

/**
 *
 * pacientes/borrapaciente.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y ejecuta la
 * consulta de eliminación, retorna el resultado de la operación
 *
*/

// incluimos e instanciamos las clases
require_once "pacientes.class.php";
$paciente = new Pacientes();

// eliminamos el registro
$resultado = $paciente->borraPaciente((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
