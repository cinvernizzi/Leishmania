<?php

/**
 *
 * tecnicas/validadictecnicas.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe como parámetro el nombre de una técnica y la
 * clave del registro (0 en caso de alta) y verifica que la misma
 * no se encuentre repetido, retorna verdadero si puede insertar
 *
*/

// incluimos e instanciamos
require_once "dictecnicas.class.php";
$tecnicas = new DictTecnicas();

// verificamos
$resultado = $tecnicas->validaTecnica((int) $_GET["id"], $_GET["tecnica"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
