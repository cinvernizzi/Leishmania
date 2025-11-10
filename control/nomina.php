<?php

/**
 *
 * nomina.php | control/nomina.php
 * @package Leishmania
 * @subpackage Control
 * @param int clave del paciente
 * @return array vector con los registros
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (31/07/2025)
 * @copyright (c) 2025, DsGestion
 *
 * Método que recibe como parámetro la clave de un paciente
 * y retorna el vector con todas las visitas de control de
 * ese paciente
 *
 */

// incluimos e instanciamos
require_once "control.class.php";
$control = new Control();

// obtenemos el vector
$nomina = $control->nominaControl((int) $_GET["idpaciente"]);

// definimos el array
$resultado = array();

// recorremos el vector
foreach($nomina as $registro){

    // lo agregamos
    $resultado[] = array("Id" =>          $registro["id"],
                         "Tratamiento" => $registro["tratamiento"],
                         "Droga" =>       $registro["droga"],
                         "Contactos" =>   $registro["contactos"],
                         "Bloqueo" =>     $registro["bloqueo"],
                         "Insecticida" => $registro["insectidida"],
                         "Fecha" =>       $registro["fecha"],
                         "Usuario" =>     $registro["usuario"],
                         "Editar" =>      "<img src='imagenes/save.png'>",
                         "Borrar" =>      "<img src='imagenes/borrar.png'>");


}

// retornamos
echo json_encode($resultado);
