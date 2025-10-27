<?php

/**
 *
 * material/puedeborrardic.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y verifica
 * que este no esté asociado a ningún paciente, llamado antes
 * de eliminar
 *
*/

// incluimos e instanciamos las clases
require_once "dicmaterial.class.php";
$material = new DictMaterial();

// verificamos
$resultado = $material->puedeBorrar((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
