<?php

/**
 *
 * Archivo: grabar.php / evolucion/grabar.php
 * @package Leishmania
 * @subpackage Evolucion
 * @param array vector con el registro
 * @return int clave del registro
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por post los datos del
 *              registro y ejecuta la consulta de grabación
 *              retorna la clave del registro afectado o
 *              cero en caso de error
 *
 */

// incluimos e instanciamos
require_once "evolucion.class.php";
$evolucion = new Evolucion();

// asignamos los parámetros
$evolucion->setId((int) $_POST["Id"]);
$evolucion->setPaciente((int) $_POST["Paciente"]);
$evolucion->setHospitalizacion($_POST["Hospitalizacion"]);
$evolucion->setFechaAlta($_POST["FechaAlta"]);
$evolucion->setDefuncion($_POST["Defuncion"]);
$evolucion->setCondicion($_POST["Condicion"]);
$evolucion->setClasificacion($_POST["Clasificacion"]);
$evolucion->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $evolucion->grabaEvolucion();

// retornamos
echo json_encode(array("Resultado" => $resultado));
