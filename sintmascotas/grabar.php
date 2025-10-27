<?php

/**
 *
 * grabar.php | sintmascotas/grabar.php
 *
 * @package     Leishmania
 * @subpackage  SintMascotas
 * @param       array datos del registro
 * @return      int clave del registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (04/08/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro y ejecuta la
 * consulta de grabación, retorna la clave del registro o cero
 * en caso de error
 *
*/

// incluimos e instanciamos
require_once "sintmascotas.class.php";
$sintomas = new SintMascotas();

// asignamos los valores
$sintomas->setId((int) $_POST["Id"]);
$sintomas->setMascota((int) $_POST["Mascota"]);
$sintomas->setPaciente((int) $_POST["Paciente"]);
$sintomas->setPelo($_POST["Pelo"]);
$sintomas->setAdelgazamiento($_POST["Adelgazamiento"]);
$sintomas->setUlceras($_POST["Ulceras"]);
$sintomas->setPocoActivo($_POST["PocoActivo"]);
$sintomas->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $sintomas->grabaSintoma();

// retornamos
echo json_encode(array("Resultado" => $resultado));
