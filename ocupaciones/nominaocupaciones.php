<?php

/**
 *
 * ocupaciones/nominaocupaciones.php
 *
 * @package     Leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que retorna el vector con la nómina de ocupaciones
 *
*/

// incluimos e instanciamos la clase
require_once "ocupaciones.class.php";
$ocupaciones = new Ocupaciones();

// obtenemos el vector
$nomina = $ocupaciones->nominaOcupaciones();

// definimos el vector
$resultado = array();

// recorremos la nómina
foreach($nomina as $registro){

    $resultado[] = array("id" =>        $registro["id"],
                         "ocupacion" => $registro["ocupacion"],
                         "alta" =>      $registro["alta"],
                         "usuario" =>   $registro["usuario"],
                         "editar" =>    "<img src='imagenes/meditar.png'>",
                         "borrar" =>    "<img src='imagenes/borrar.png'>");

}

// retornamos
echo json_encode($resultado);
