<?php

/**
 *
 * seguridad/salir.php
 *
 * @package     CCE
 * @subpackage  Seguridad
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (15/12/2016)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que elimina las variables de sesión del usuario actual,
 * recibe como parámetro la clave de la sesión
 *
 */

// incluimos la clase del log de usuarios
require_once "seguridad.class.php";

// instanciamos la clase
$log = new Seguridad();

// grabamos la salida
$log->egresaUsuario((int) $_GET["Sesion"]);

// retorna siempre verdadero
echo json_encode(array("Error" => true));
