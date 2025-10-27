<?php

/**
 *
 * grabar.php | viajes/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @param       array vector con el registro
 * @return      int clave del registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos de un viaje y ejecuta la
 * consulta de grabación, retorna la clave del registro o cero
 * en caso de error
 *
*/

// incluimos e instanciamos
require_once "viajes.class.php";
$viajes = new Viajes();

// asignamos los valores
$viajes->setId((int) $_POST["Id"]);
$viajes->setPaciente((int) $_POST["Paciente"]);
$viajes->setLugar($_POST["Lugar"]);
$viajes->setFecha($_POST["Fecha"]);
$viajes->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos el registro
$resultado = $viajes->grabaViaje();

// retornamos
echo json_encode(array("Resultado" => $resultado));
