<?php

/**
 *
 * buscar.php | laboratorios/buscar.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (28/03/2023)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get parte del nombre de un laboratorio
 * y retorna el array json con los registros coincidentes
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// obtenemos la nómina
$nomina = $laboratorios->buscaLaboratorio($_GET["laboratorio"]);

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("idlaboratorio" => $registro["idlaboratorio"],
                         "laboratorio" =>   $registro["laboratorio"],
                         "responsable" =>   $registro["responsable"],
                         "provincia" =>     $registro["provincia"],
                         "localidad" =>     $registro["localidad"],
                         "editar" =>        "<img src='imagenes/meditar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
