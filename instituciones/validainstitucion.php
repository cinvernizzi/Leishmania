<?php

/**
 *
 * instituciones/validainstitucion.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (18/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get el nombre de una institución
 * y la clave indec de una provincia y verifica que no esté
 * repetida, retorna el número de registros encontrados
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// verificamos si está declarado
$registros = $institucion->validaInstitucion($_GET["institucion"], $_GET["codloc"]);

// retornamos
echo json_encode(array("Registros" => $registros));
