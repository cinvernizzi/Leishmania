<?php

/**
 *
 * grabar.php | control/grabar.php
 * @package Leishmania
 * @subpackage Control
 * @param array vector con el registro
 * @return int clave del registro
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (31/07/2025)
 * @copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro y ejecuta
 * la consulta en el servidor, retorna la clave del registro
 * o cero en caso de error
 *
 */

// incluimos e instanciamos
require_once "control.class.php";
$control = new Control();

// asignamos los valores
$control->setId((int) $_POST["Id"]);
$control->setPaciente((int) $_POST["Paciente"]);
$control->setTratamiento($_POST["Tratamiento"]);
$control->setDroga($_POST["Droga"]);
$control->setDosis((int) $_POST["Dosis"]);
$control->setContactos($_POST["Contactos"]);
$control->setNroContactos((int) $_POST["NroContactos"]);
$control->setContactosPos((int) $_POST["ContactosPos"]);
$control->setBloqueo($_POST["Bloqueo"]);
$control->setNroViviendas((int) $_POST["NroViviendas"]);
$control->setSitiosRiesgo($_POST["SitiosRiesgo"]);
$control->setInsecticida($_POST["Insecticida"]);
$control->setCantidadInsec((int) $_POST["CantidadInsec"]);
$control->setFecha($_POST["Fecha"]);
$control->setIdUsuario((int) $_POST["IdUsuario"]);

// ejecutamos la consulta
$resultado = $control->grabaControl();

// retornamos
echo json_encode(array("Resultado" => $resultado));
