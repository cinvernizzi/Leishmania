<?php

/**
 *
 * nominanotificados | reportes/nominanotificados.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @param       anio entero con el año a reportar
 * @param       page entero con el número de página
 * @param       rows entero con el número de filas a retornar
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (06/11/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe como parámetro el año a reportar y obtiene el 
 * vector con la nómina de pacientes notificados al sisa
 *
 */

// incluimos e instanciamos la clase
require_once "../pacientes/pacientes.class.php";
$pacientes = new Pacientes();

// obtenemos los valores recibidos por post
$pagina = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

// calculamos el offset
$offset = ($pagina - 1) * $rows;     

// si recibió el año (porque puede ser llamado al cargar
// la grilla)
if (isset($_GET["anio"])){

    // obtenemos el total de registros 
    $registros = $pacientes->numeroNotificados((int) $_GET["anio"]);
    $resultado["total"] = $registros;

    // obtenemos el vector con los registros
    $nomina = $pacientes->getNotificadosPaginados((int) $anio, $offset, $rows);

    // definimos el vector 
    $items = array();

    // recorremos el vector
    foreach ($nomina as $registro){

        // lo agregamos al array
        $items[] = array("Id" =>           $registro["id"],
                         "Fecha" =>        $registro["fecha"],
                         "Nombre" =>       $registro["nombre"],
                         "Documento" =>    $registro["documento"],
                         "Material" =>     $registro["material"],
                         "Tecnica" =>      $registro["tecnica"],
                         "FechaMuestra" => $registro["fecha_muestra"],
                         "Notificado" =>   $registro["notificado"],
                         "Editar" =>       "<img src='imagenes/meditar.png'>");

    }

    // agregamos al resultado
    $resultado["rows"] = $items;

    // retornamos 
    echo json_encode($resultado);

}
