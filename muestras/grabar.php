<?php

/**
 *
 * grabar.php | muestras/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Muestras
 * @param       array datos del registro
 * @return      int clave del registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos de un registro y ejecuta
 * la consulta de grabación, retorna la clave del registro
 * afectado o cero en caso de error
 *
*/

// incluimos e instanciamos
require_once "muestras.class.php";
$muestras = new Muestras();

// asignamos en la clase
$muestras->setId((int) $_POST["Id"]);
$muestras->setPaciente((int) $_POST["Paciente"]);
$muestras->setMaterial((int) $_POST["Material"]);
$muestras->setTecnica((int) $_POST["Tecnica"]);
$muestras->setFecha($_POST["Fecha"]);
$muestras->setResultado($_POST["Resultado"]);
$muestras->setDeterminacion($_POST["Determinacion"]);
$muestras->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $muestras->grabaMuestra();

// retornamos
echo json_encode(array("Resultado" => $resultado));
