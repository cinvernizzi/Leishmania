<?php

/**
 *
 * material/validadicmaterial.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y la descripciòn
 * de un material recibido y verifica que no esté declarado en el
 * diccionario para evitar los registros duplicados, retorna verdadero
 * si puede editar / agregar
 *
*/

// incluimos e instanciamos las clases
require_once "dicmaterial.class.php";
$material = new DictMaterial();

// verificamos
$resultado = $material->validaMaterial((int) $_GET["id"], $_GET["material"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
