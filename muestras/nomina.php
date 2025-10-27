<?php

/**
 *
 * nomina.php | muestras/nomina.php
 *
 * @package     Leishmania
 * @subpackage  Muestras
 * @param       int clave del paciente
 * @return      array vector con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post la clave de un paciente y retorna el
 * vector con la nómina de muestras de ese paciente
 *
*/

// incluimos e instanciamos
require_once "muestras.class.php";
$muestras = new Muestras();

// si recibió al paciente
if (isset($_POST["idpaciente"])){

    // obtenemos la nómina
    $nomina = $muestras->nominaMuestras((int) $_POST["idpaciente"]);

    // definimos el array
    $resultado = array();

    // recorremos el vector
    foreach($nomina as $registro){

        // lo agregamos
        $resultado[] = array("Id" =>           $registro["id"],
                            "Paciente" =>      $registro["paciente"],
                            "Material" =>      $registro["material"],
                            "Tecnica" =>       $registro["tecnica"],
                            "Fecha" =>         $registro["fecha"],
                            "Resultado" =>     $registro["resultado"],
                            "Determinacion" => $registro["determinacion"],
                            "Usuario" =>       $registro["usuario"],
                            "Alta" =>          $registro["alta"],
                            "Editar" =>        "<img src='imagenes/save.png'>",
                            "Borrar" =>        "<img src='imagenes/borrar.png'>");

        }

    // retornamos
    echo json_encode($resultado);

}
