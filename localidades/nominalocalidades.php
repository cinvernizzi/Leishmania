<?php

/**
 *
 * nominalocalidades.php | localidades/nominalocalidades.php
 *
 * @package     CCE
 * @subpackage  Localidades
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (02/08/2021)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get la clave de una provincia
 * y retorna el array json con la nómina completa de
 * localidades
 *
*/

// incluimos e instanciamos la clase
require_once "localidades.class.php";
$localidades = new Localidades();

// como podemos llamarlo por get o post
$codprov = isset($_POST["codprov"]) ? $_POST["codprov"] : $_GET["codprov"];

// obtenemos la nómina
$nomina = $localidades->listaLocalidades($codprov);

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("id" =>          $registro["id"],
                         "idlocalidad" => $registro["idlocalidad"],
                         "localidad" =>   $registro["localidad"],
                         "provincia" =>   $registro["provincia"],
                         "codpcia" =>     $registro["codpcia"],
                         "poblacion" =>   $registro["poblacion"],
                         "fecha" =>       $registro["fecha_alta"],
                         "usuario" =>     $registro["usuario"],
                         "editar" =>      "<img src='imagenes/meditar.png'>",
                         "borrar" =>      "<img src='imagenes/borrar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
