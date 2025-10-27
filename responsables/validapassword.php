<?php

/**
 *
 * validapassword | seguridad/validapassword.php
 *
 * @package     Leishmania
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/08/2025)
 * @copyright   Copyright (c) 2021, Msal
 *
 * Método que recibe por get el password actual y la clave del
 * usuario y verifica que coincida con la declarada en la base
 *
*/

// incluimos e instanciamos la clase
require_once "responsables.class.php";
$responsable = new Responsables();

// verificamos las credenciales
$resultado = $responsable->validaPassword((int) $_GET["idusuario"], $_GET["password"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
