<?php

/**
 *
 * grabapassword | seguridad/grabapassword.php
 *
 * @package     Leishmania
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/08/2025)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get la clave del usuario y el nuevo
 * password y ejecuta la consulta de actualización
 *
*/

// incluimos e instanciamos la clase
require_once "responsables.class.php";
$responsable = new Responsables();

// asignamos en la clase
$responsable->setIdResponsable((int) $_GET["idusuario"]);
$responsable->setPassword($_GET["password"]);

// actualizamos
$resultado = $responsable->nuevoPassword();

// retornamos
echo json_encode(array("Resultado" => $resultado));
