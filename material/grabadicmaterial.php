<?php

/**
 *
 * material/grabadicmaterial.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro del diccionario
 * de materiales recibidos y ejecuta la consulta de grabación,
 * retorna la clave del registro o 0 en caso de error
 *
*/

// incluimos e instanciamos las clases
require_once "dicmaterial.class.php";
$material = new DictMaterial();

// asignamos en la clase
$material->setId((int) $_POST["Id"]);
$material->setMaterial($_POST["Material"]);
$material->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $material->grabaMaterial();

// retornamos
echo json_encode(array("Resultado" => $resultado));
