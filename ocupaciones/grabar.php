<?php

/**
 *
 * ocupaciones/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos del registro y
 * ejecuta la consulta de grabación, retorna la clave
 * del registro afectado
 *
*/

// incluimos e instanciamos la clase
require_once "ocupaciones.class.php";
$ocupaciones = new Ocupaciones();

// asignamos en la clase
$ocupaciones->setId((int) $_POST["Id"]);
$ocupaciones->setOcupacion($_POST["Ocupacion"]);
$ocupaciones->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos el registro
$id = $ocupaciones->grabaOcupacion();

// retornamos
echo json_encode(array("Id" => $id));
