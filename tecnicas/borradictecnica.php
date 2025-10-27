<?php

/**
 *
 * tecnicas/borradictecnica.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe como parámetro la clave de un registro del
 * diccionario de técnicas y ejecuta la consulta de eliminación,
 * retorna el resultado de la operación
 *
*/

// incluimos e instanciamos
require_once "dictecnicas.class.php";
$tecnicas = new DictTecnicas();

// borramos
$resultado = $tecnicas->borraTecnica((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
