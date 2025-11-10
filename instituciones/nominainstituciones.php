<?php

/**
 *
 * nominainstituciones | instituciones/nominainstituciones.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (18/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave indec de una provincia y
 * retorna la nómina de instituciones
 * Utilizado tanto para cargar los combos de tipo de dependencias
 * como la grilla del abm
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// obtenemos el vector
$nomina = $institucion->nominaInstituciones($_GET["codprov"]);

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("id" =>          $registro["id"],
                         "institucion" => $registro["institucion"],
                         "localidad" =>   $registro["localidad"],
                         "dependencia" => $registro["dependencia"],
                         "usuario" =>     $registro["usuario"],
                         "fecha" =>       $registro["fecha"],
                         "editar" =>      "<img src='imagenes/meditar.png'>",
                         "borrar" =>      "<img src='imagenes/borrar.png'>");
                         
}

// retornamos el vector
echo json_encode($resultado);
