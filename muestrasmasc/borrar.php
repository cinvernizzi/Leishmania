<?php

/**
 *
 * muestrasmasc/borrar.php
 *
 * @package     Leishmania
 * @subpackage  MuestrasMasc
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param       int clave del registro
 * @return      bool resultado de la operación
 * @version     1.0 (14/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe la clave de un registro y ejecuta la
 * consulta de eliminación
 *
*/

// incluimos e instanciamos
require_once "muestrasmasc.class.php";
$muestras = new MuestrasMasc();

// eliminamos el registro
$resultado = $muestras->borraMuestra((int) $_GET["idmuestra"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
