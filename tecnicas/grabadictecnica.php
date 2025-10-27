<?php

/**
 *
 * tecnicas/grabatecnicas.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos de un registro y ejecuta
 * la coinsulta de grabación, retorna el resultado de la operación
 *
*/

// incluimos e instanciamos
require_once "dictecnicas.class.php";
$tecnicas = new DictTecnicas();

// asignamos en la clase
$tecnicas->setId((int) $_POST["Id"]);
$tecnicas->setTecnica($_POST["Tecnica"]);
$tecnicas->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $tecnicas->grabaTecnica();

// retornamos
echo json_encode(array("Resultado" => $resultado));
