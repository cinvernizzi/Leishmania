<?php

/**
 *
 * dependencias/grabadependencia.php
 *
 * @package     Leishmania
 * @subpackage  Dependencias
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (13/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de un tipo de
 * dependencia y ejecuta la consulta de grabación
 *
*/

// incluimos e instanciamos la clase
require_once "dependencias.class.php";
$dependencia = new Dependencias();

// asignamos las propiedades
$dependencia->setIdDependencia((int) $_POST["Id"]);
$dependencia->setDependencia($_POST["Dependencia"]);
$dependencia->setDescripcion(($_POST["Descripcion"]));
$dependencia->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $dependencia->grabaDependencia();

// retornamos
echo json_encode(array("Id" => $resultado));
