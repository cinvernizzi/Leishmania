<?php

/**
 *
 * muestrasmasc/nomina.php
 *
 * @package     Leishmania
 * @subpackage  MuestrasMasc
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param       int clave del animal
 * @return      array vector con los registros
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un animal y retorna el
 * array json con las muestras de esa mascota
 *
*/

// incluimos e instanciamos
require_once "muestrasmasc.class.php";
$muestras = new MuestrasMasc();

// si recibió la clave
if (!empty($_GET["idmascota"])){

    // obtenemos el vector
    $nomina = $muestras->nominaMuestras((int) $_GET["idmascota"]);

    // declaramos el array
    $resultado = array();

    // recorremos los registros
    foreach ($nomina as $registro){

        // lo agregamos
        $resultado[] = array("Id" =>            $registro["id"],
                             "Material" =>      $registro["idmaterial"],
                             "Tecnica" =>       $registro["idtecnica"],
                             "Fecha" =>         $registro["fecha"],
                             "Resultado" =>     $registro["resultado"],
                             "Determinacion" => $registro["determinacion"],
                             "Usuario" =>       $registro["usuario"],
                             "Alta" =>          $registro["alta"],
                             "Editar" =>        "<img src='imagenes/save.png'>",
                             "Borrar" =>        "<img src='imagenes/borrar.png'>",
                             "Imprimir" =>      "<img src='imagenes/print.png'>");

    }

    // retornamos
    echo json_encode($resultado);

}
