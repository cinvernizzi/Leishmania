<?php

/**
 *
 * Archivo: nomina.php / actividades/nomina.php
 * @package Leishmania
 * @subpackage Actividades
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe como parámetro la clave de
 *              un paciente y retorna el vector con todas
 *              las actividades realizadas por ese paciente
 *
 */

// incluimos e instanciamos
require_once "actividades.class.php";
$actividad = new Actividades();

// si recibió la clave
if (isset($_POST["idpaciente"])){

    // obtenemos el vector
    $nomina = $actividad->nominaActividades((int) $_POST["idpaciente"]);

    // definimos el array
    $resultado = array();

    // recorremos el vector
    foreach($nomina as $registro){

        // lo agregamos al vector
        $resultado[] = array("Id" =>        $registro["id"],
                             "Lugar" =>     $registro["lugar"],
                             "Actividad" => $registro["actividad"],
                             "Fecha" =>     $registro["fecha"],
                             "Usuario" =>   $registro["usuario"],
                             "Alta" =>      $registro["alta"],
                             "Editar" =>    "<img src='imagenes/save.png'>",
                             "Borrar" =>    "<img src='imagenes/borrar.png'>");

    }

    // retornamos
    echo json_encode($resultado);

}
