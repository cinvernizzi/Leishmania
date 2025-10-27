<?php

/**
 *
 * nomina.php | laboratorios/nomina.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (01/10/2024)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por post parte del nombre de un laboratorio
 * y si debe listar laboratorios de leishmaniasis, serología y
 * pcr, retorna el array json con los laboratorios coincidentes
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// obtenemos los valores recibidos
$leishmania = isset($_POST['Leishmania']) ? $_POST['Leishmania'] : "Si";
$serologia = isset($_POST['Serologia']) ? $_POST['Serologia'] : "Si";
$pcr = isset($_POST['Pcr']) ? $_POST['Pcr'] : "Si";
$laboratorio = isset($_POST['Laboratorio']) ? $_POST['Laboratorio'] : "";
$pagina = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;

// definimos los array
$resultado = array();
$items = array();

// calculamos el offset
$offset = ($pagina - 1) * $rows;

// obtenemos el número total de registros
$registros = $laboratorios->numeroLaboratorios($laboratorio, $leishmania, $serologia, $pcr);

// obtenemos el vector
$nomina = $laboratorios->laboratoriosPaginados($laboratorio, $leishmania, $serologia, $pcr, $offset, $registros);

// agregamos el total de registros
$resultado["total"] = $registros;

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $items[] = array("idlaboratorio" =>  $registro["id"],
                     "laboratorio" =>    $registro["laboratorio"],
                     "responsable" =>    $registro["responsable"],
                     "provincia" =>      $registro["provincia"],
                     "localidad" =>      $registro["localidad"],
                     "activo" =>         $registro["activo"],
                     "editar" =>         "<img src='imagenes/meditar.png'>");

}


// agregamos el vector
$resultado["rows"] = $items;

// retornamos el vector
echo json_encode($resultado);
