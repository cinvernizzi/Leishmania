<?php

/**
 *
 * recuperamail | seguridad/recuperamail.php
 *
 * @package     Leishmania
 * @subpackage  Seguridad
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la dirección de correo de un
 * usuario y verifica que corresponda a un usuario
 * registrado, en cuyo caso reinicia la contraseña de
 * ingreso y retorna el array con el nombre de usuario
 * y la nueva contraseña
 *
*/

// incluimos e instanciamos las clases
require_once ("seguridad.class.php");
$seguridad = new Seguridad();

// obtenemos los registros
$resultado = $seguridad->recuperaMail($_GET["mail"]);

// retornamos
echo json_encode(["Resultado" => $resultado["Resultado"],
                  "Usuario" =>   $resultado["Usuario"],
                  "Password" =>  $resultado["Password"]]);
