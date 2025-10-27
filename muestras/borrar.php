<?php

/**
 *
 * borrar.php | muestras/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Muestras
 * @param       int clave del registro
 * @return      bool resultado de la operación
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y ejecuta la
 * consulta de eliminación, retorna el resultado de la operación
 *
*/

// incluimos e instanciamos
require_once "muestras.class.php";
$muestras = new Muestras();

// eliminamos el registro
$resultado = $muestras->borraMuestra((int) $_GET["idmuestra"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
