<?php

/**
 *
 * material/nominadicmaterial.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que retorna el array json con la nómina completa del
 * diccionario de materiales recibidos
 *
*/

// incluimos e instanciamos las clases
require_once "dicmaterial.class.php";
$material = new DictMaterial();

// obtenemos el vector
$nomina = $material->nominaMateriales();

// definimos el vector
$resultado = array();

// recorremos el vactor
foreach($nomina as $registro){

    // agregamos el registro
    $resultado[] = array("Id" =>         $registro["id"],
                         "Material" =>   $registro["material"],
                         "Alta" =>       $registro["alta"],
                         "Modificado" => $registro["modificado"],
                         "Usuario" =>    $registro["usuario"],
                         "Editar" =>     "<img src='imagenes/save.png'>",
                         "Borrar" =>     "<img src='imagenes/borrar.png'>");

}

// retornamos
echo json_encode($resultado);
