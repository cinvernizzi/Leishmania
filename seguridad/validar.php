<?php

/**
 *
 * seguridad/validar.php
 *
 * @package     Leishmania
 * @subpackage  Seguridad
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/02/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get el nombre de usuario y la contraseña
 * verifica las credenciales de acceso y retorna el array json
 * con los permisos
 *
*/

// incluimos e instanciamos las clases
require_once "seguridad.class.php";
$seguridad = new Seguridad();

// verificamos
$estado = $seguridad->validaIngreso($_GET["usuario"], $_GET["password"]);

// si retornó correcto
if ($estado["Resultado"]){

    // agregamos los elementos
    $resultado = array("Resultado" => true,
                       "IdUsuario" =>     $estado["IdUsuario"],
                       "Usuario" =>       $estado["Usuario"],
                       "Area" =>          $estado["Area"],
                       "Administrador" => $estado["Administrador"],
                       "Activo" =>        $estado["Activo"],
                       "Sesion" =>        $estado["Sesion"]);

// si no autenticó
} else {

    // definimos el switch
    $resultado = array("Resultado" => false);

}

// retornamos
echo json_encode($estado);
