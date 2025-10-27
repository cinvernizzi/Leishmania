<?php

/**
 *
 * ocupaciones/getdatosocupacion.php
 *
 * @package     Leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/062022)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe como parámetro la clave de un registro
 * y retorna el array json con los datos del mismo
 *
*/

// incluimos e instanciamos la clase
require_once "ocupaciones.class.php";
$ocupaciones = new Ocupaciones();

// obtenemos el registro
$ocupaciones->getDatosOcupacion((int) $_GET["id"]);

// retornamos
echo json_encode(array("Id" =>        $ocupaciones->getId(),
                       "Ocupacion" => $ocupaciones->getOcupacion(),
                       "Alta" =>      $ocupaciones->getAlta(),
                       "Usuario" =>   $ocupaciones->getUsuario()));
