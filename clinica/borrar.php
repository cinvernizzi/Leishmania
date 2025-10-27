<?php

/**
 *
 * clinica/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Clinica
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (21/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y ejecuta
 * la consulta de eliminación, retorna el resultado de la
 * operación
 *
*/

// incluimos e instanciamos
require_once "clinica.class.php";
$clinica = new Clinica();

// ejecutamos
$resultado = $clinica->borraClinica((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
