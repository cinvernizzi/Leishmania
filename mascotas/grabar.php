<?php

/**
 *
 * grabar.php | mascotas/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Mascotas
 * @param       array vector con el registro
 * @return      int clave del registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro y ejecuta la
 * consulta en la base de datos, retorna la clave del registro
 * afectado o cero en caso de error
 *
*/

// incluimos e instanciamos
require_once "mascotas.class.php";
$mascota = new Mascotas();

// asignamos en la clase
$mascota->setId((int) $_POST["Id"]);
$mascota->setPaciente((int) $_POST["Paciente"]);
$mascota->setNombre($_POST["Nombre"]);
$mascota->setEdad((int) $_POST["Edad"]);
$mascota->setOrigen($_POST["Origen"]);
$mascota->setIdUsuario((int) $_POST["IdUsuario"]);

// ejecutamos la consulta
$resultado = $mascota->grabaMascota();

// retornamos
echo json_encode(array("Resultado" => $resultado));
