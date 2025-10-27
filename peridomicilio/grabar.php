<?php

/**
 *
 * grabar.php | peridomicilio/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @param       array vector con el registro
 * @return      bool resultado de la operación
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos de un registro y ejecuta la
 * consulta de grabación, retorna la clave del registro afectado
 * o cero en caso de error
 *
*/

// incluimos e instanciamos
require_once "peridomicilio.class.php";
$peridomicilio = new Peridomicilio();

// asignamos los parámetros
$peridomicilio->setId((int) $_POST["Id"]);
$peridomicilio->setAnimal((int) $_POST["Animal"]);
$peridomicilio->setPaciente((int) $_POST["Paciente"]);
$peridomicilio->setDistancia((int) $_POST["Distancia"]);
$peridomicilio->setCantidad((int) $_POST["Cantidad"]);
$peridomicilio->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $peridomicilio->grabaPeridomicilio();

// retornamos
echo json_encode(array("Resultado" => $resultado));
