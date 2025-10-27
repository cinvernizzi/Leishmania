<?php

/**
 *
 * instituciones/buscainstitucion.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (28/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get parte del nombre de una institución
 * y retorna el array json con las instituciones coincidentes
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// obtenemos el vector
$nomina = $institucion->buscaInstitucion($_GET["institucion"]);

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("id" =>          $registro["id"],
                         "institucion" => $registro["institucion"],
                         "localidad" =>   $registro["localidad"],
                         "provincia" =>   $registro["provincia"],
                         "usuario" =>     $registro["usuario"],
                         "fecha" =>       $registro["fecha"],
                         "editar" =>      "<img src='imagenes/meditar.png'>",
                         "borrar" =>      "<img src='imagenes/borrar.png'>");
                         
}

// retornamos el vector
echo json_encode($resultado);
