<?php

/**
 *
 * material/borradicmaterial.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro del diccionario
 * de materiales recibidos y ejecuta la consulta de eliminación,
 * retorna el resultado de la operación
 *
*/

// incluimos e instanciamos las clases
require_once "dicmaterial.class.php";
$material = new DictMaterial();

// eliminamos
$resultado = $material->borraMaterial((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
