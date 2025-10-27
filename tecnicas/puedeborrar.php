<?php

/**
 *
 * tecnicas/puedeborrar.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe como parámetro la clave de una técnica y verifica
 * que no tenga hijos, retorna verdadero si puede eliminar
 *
*/

// incluimos e instanciamos
require_once "dictecnicas.class.php";
$tecnicas = new DictTecnicas();

// verificamos
$resultado = $tecnicas->puedeBorrar((int) $_GET["id"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
