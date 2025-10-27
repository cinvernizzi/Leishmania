<?php

/**
 *
 * nomina.php | viajes/nomina.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @param       int clave del paciente
 * @return      array vector con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y retorna el
 * array json con todos los viajes de ese paciente
 *
*/

// incluimos e instanciamos
require_once "viajes.class.php";
$viajes = new Viajes();

// si recibió la clave
if (isset($_POST["idpaciente"])){

    // obtenemos la nómina
    $nomina = $viajes->nominaViajes((int) $_POST["idpaciente"]);

    // declaramos el array
    $resultado = array();

    // recorremos el vector
    foreach($nomina as $registro){

        // agregamos el registro
        $resultado[] = array("Id" =>       $registro["id"],
                             "Paciente" => $registro["paciente"],
                             "Lugar" =>    $registro["lugar"],
                             "Fecha" =>    $registro["fecha"],
                             "Usuario" =>  $registro["usuario"],
                             "Alta" =>     $registro["alta"],
                             "Editar" =>    "<img src='imagenes/save.png'>",
                             "Borrar" =>    "<img src='imagenes/borrar.png'>");

    }

    // retornamos
    echo json_encode($resultado);

}
