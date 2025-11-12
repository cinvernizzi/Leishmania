<?php

/**
 *
 * nominansinnotificar | reportes/nominasinnotificar.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @param       page entero con el número de página
 * @param       rows entero con el número de filas a retornar
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (07/11/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe el desplazamiento del primer registro y el número
 * de registros a retornar y devuelve el vector con los pacientes 
 * que tienen determinaciones y que aún no han sido notificados 
 * al sisa
 *
 */

// incluimos e instanciamos la clase
require_once "../muestras/muestras.class.php";
$muestras = new Muestras();

// obtenemos los valores recibidos por post
$pagina = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

// calculamos el offset
$offset = ($pagina - 1) * $rows;     

// obtenemos el total de registros 
$registros = $muestras->numeroSinNotificar();
$resultado["total"] = $registros;

// obtenemos el vector con los registros
$nomina = $muestras->sinNotificarPaginados($offset, $rows);

// definimos el vector 
$items = array();

// recorremos el vector
foreach ($nomina as $registro){

    // lo agregamos al array
    $items[] = array("Id" =>           $registro["id"],
                     "Fecha" =>        $registro["fecha"],
                     "Nombre" =>       $registro["nombre"],
                     "Documento" =>    $registro["documento"],
                     "FechaMuestra" => $registro["fecha_muestra"],
                     "Usuario" =>      $registro["usuario"],
                     "Editar" =>       "<img src='imagenes/meditar.png'>");

}

// agregamos al resultado
$resultado["rows"] = $items;

// retornamos 
echo json_encode($resultado);
