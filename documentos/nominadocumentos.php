<?php

/**
 *
 * nominadocumentos | documentos/nominadocumentos.php
 *
 * @package     Leishmania
 * @subpackage  Documentos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (13/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que retorna el array json con la nómina de tipos
 * de documentos
 * Utilizado tanto para cargar los combos de tipo de documento
 * como la grilla del abm
 *
*/

// incluimos e instanciamos la clase
require_once "documentos.class.php";
$documentos = new Documentos();

// obtenemos el vector
$nomina = $documentos->listaDocumentos();

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("iddocumento" =>   $registro["id_documento"],
                         "tipodocumento" => $registro["tipo_documento"],
                         "descripcion" =>   $registro["descripcion"],
                         "usuario" =>       $registro["usuario"],
                         "fecha" =>         $registro["fecha_alta"],
                         "editar" =>        "<img src='imagenes/meditar.png'>",
                         "borrar" =>        "<img src='imagenes/borrar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
