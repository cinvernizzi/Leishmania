<?php

/**
 *
 * tecnicas/nominadictecnicas.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que retorna el vector json con la nómina completa de
 * técnicas registradas
 *
*/

// incluimos e instanciamos
require_once "dictecnicas.class.php";
$tecnicas = new DictTecnicas();

// otenemos el vector
$nomina = $tecnicas->nominaTecnicas();

// declaramos el array
$resultado = array();

// recorremos el vector
foreach($nomina as $registro){

    // lo agregamos a la matriz
    $resultado[] = array("Id" =>         $registro["id"],
                         "Tecnica" =>    $registro["tecnica"],
                         "Alta" =>       $registro["alta"],
                         "Modificado" => $registro["modificado"],
                         "Usuario" =>    $registro["usuario"],
                         "Editar" =>    "<img src='imagenes/save.png'>",
                         "Borrar" =>    "<img src='imagenes/borrar.png'>");


}

// retornamos
echo json_encode($resultado);
