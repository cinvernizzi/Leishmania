<?php

/**
 *
 * muestrasmasc/grabar.php
 *
 * @package     Leishmania
 * @subpackage  MuestrasMasc
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param       array vector con el registro
 * @return      int clave del registro
 * @version     1.0 (14/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de una determinación y los
 * graba en la base de datos
 *
*/

// incluimos e instanciamos
require_once "muestrasmasc.class.php";
$muestras = new MuestrasMasc();

// asignamos en la clase
$muestras->setId((int) $_POST["Id"]);
$muestras->setMascota((int) $_POST["Mascota"]);
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
