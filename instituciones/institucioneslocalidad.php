<?php

/**
 *
 * institucioneslocalidad.php | instituciones/institucioneslocalidad.php
 *
 * @package     Leishmania
 * @subpackage  Localidades
 * @param       string clave indec de la localidad
 * @return      array vector json con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (06/08/2025)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por get la clave indec de una localidad y retorna
 * el array json con la nómina de instituciones de esa localidad,
 * utilizado en la selección de la institución en el abm de pacientes
 *
*/

// incluimos e instanciamos
require_once "instituciones.class.php";
$instituciones = new Instituciones();

// obtenemos el vector
$nomina = $instituciones->localidadInstitucion($_GET["codloc"]);

// definimos el vector
$resultado = array();

// recorremos el vector
foreach ($nomina as $registro){

    // lo agregamos
    $resultado[] = array("Id" => $registro["id"],
                         "Institucion" => $registro["institucion"]);

}

// retornamos
echo json_encode($resultado);
