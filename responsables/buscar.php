<?php

/**
 *
 * buscar | responsables/buscar.php
 *
 * @package     CCE
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get una cadena de texto y busca la ocurrencia
 * en la base de datos de responsables, retorna el vector json con los
 * datos de los registros encontrados
 *
 */

// incluimos e instanciamos las clases
require_once "responsables.class.php";
$responsable = new Responsables();

// buscamos
$nomina = $responsable->buscaResponsable($_GET["texto"]);

// definimos el vector
$resultado = array();

// ahora recorremos el vector
// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("Id" =>          $registro["idresponsable"],
                         "Nombre" =>      $registro["nombre"],
                         "Institucion" => $registro["institucion"],
                         "Cargo" =>       $registro["cargo"],
                         "Provincia" =>   $registro["provincia"],
                         "Localidad" =>   $registro["localidad"],
                         "editar" =>      "<img src='imagenes/meditar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
