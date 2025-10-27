<?php

/**
 *
 * nominasexos.php | sexos/nominasexos.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (02/08/2021)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que retorna el array json con la nómina completa de
 * sexos, utilizado tanto en los combos como en la grilla
 * del abm
 *
*/

// incluimos e instanciamos la clase
require_once "sexos.class.php";
$sexo = new Sexos();

// obtenemos la nómina
$nomina = $sexo->nominaSexos();

// definimos el vector
$resultado = array();

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $resultado[] = array("idsexo" =>  $registro["id_sexo"],
                         "sexo" =>    $registro["sexo"],
                         "usuario" => $registro["usuario"],
                         "fecha" =>   $registro["fecha_alta"],
                         "editar" =>  "<img src='imagenes/meditar.png'>",
                         "borrar" =>  "<img src='imagenes/borrar.png'>");

}

// retornamos el vector
echo json_encode($resultado);
