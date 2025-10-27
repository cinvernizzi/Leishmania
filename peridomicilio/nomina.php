<?php

/**
 *
 * nomina.php | peridomicilio/nomina.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @param       int clave del paciente
 * @return      array vector con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y retorna el
 * vector con todos los animales y objetos declarados en el
 * peridomicilio
 *
*/

// incluimos e instanciamos
require_once "peridomicilio.class.php";
$peridomicilio = new Peridomicilio();

// si recibió la clave del paciente
if (isset($_POST["idpaciente"])){
    
    // obtenemos los registros
    $nomina = $peridomicilio->nominaPeridomicilio((int) $_POST["idpaciente"]);

    // declaramos la matriz
    $resultado = array();

    // recorremos el vector
    foreach ($nomina as $registro){

        // agregamos el registro
        $resultado[] = array("Id" =>        $registro["id"],
                             "Animal" =>    $registro["animal"],
                             "Distancia" => $registro["distancia"],
                             "Cantidad" =>  $registro["cantidad"],
                             "Usuario" =>   $registro["usuario"],
                             "Alta" =>      $registro["alta"],
                             "Editar" =>    "<img src='imagenes/save.png'>",
                             "Borrar" =>    "<img src='imagenes/borrar.png'>");

    }

    // retornamos
    echo json_encode($resultado);

}
