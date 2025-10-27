<?php

/**
 *
 * Archivo: grabar.php / actividades/grabar.php
 * @package Leishmania
 * @subpackage Actividades
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por post los datos de un
 *              registro y ejecuta la consulta de grabación
 *              en la base de datos, retorna la clave del
 *              registro afectado o cero en caso de error
 *
 */

// incluimos e instanciamos
require_once "actividades.class.php";
$actividad = new Actividades();

// asignamos en la clase
$actividad->setId((int) $_POST["Id"]);
$actividad->setIdPaciente((int) $_POST["Paciente"]);
$actividad->setLugar($_POST["Lugar"]);
$actividad->setActividad($_POST["Actividad"]);
$actividad->setFecha($_POST["Fecha"]);
$actividad->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $actividad->grabaActividad();

// retornamos
echo json_encode(array("Resultado" => $resultado));
