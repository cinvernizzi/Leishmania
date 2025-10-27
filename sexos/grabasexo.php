<?php

/**
 *
 * sexos/grabasexo.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de un
 * sexo y ejecuta la consulta de grabación
 *
*/

// incluimos e instanciamos la clase
require_once "sexos.class.php";
$sexos = new Sexos();

// asignamos las propiedades
$sexos->setIdSexo((int) $_POST["Id"]);
$sexos->setSexo($_POST["Sexo"]);
$sexos->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $sexos->grabaSexo();

// retornamos
echo json_encode(array("Id" => $resultado));
