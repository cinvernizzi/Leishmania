<?php

/**
 *
 * borrar.php | peridomicilio/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @param       int clave del registro
 * @return      bool resultado de la operación
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/07/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y retorna el
 * vector con la nómina de muestras de ese paciente
 *
*/

// incluimos e instanciamos
require_once "peridomicilio.class.php";
$peridomicilio = new Peridomicilio();

// borramos el registro
$resultado = $peridomicilio->borraPeridomicilio((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
