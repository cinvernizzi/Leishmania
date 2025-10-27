<?php

/**
 *
 * grabar.php | laboratorios/grabar.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/03/2023)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por post los datos de un registro y
 * ejecuta la consulta de actualización, retorna el
 * resultado de la operación
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// asignamos en la clase
$laboratorios->setIdLaboratorio((int) $_POST["Id"]);
$laboratorios->setNombre($_POST["Laboratorio"]);
$laboratorios->setResponsable($_POST["Responsable"]);
$laboratorios->setIdPais((int) $_POST["IdPais"]);
$laboratorios->setIdLocalidad($_POST["CodLoc"]);
$laboratorios->setDireccion($_POST["Direccion"]);
$laboratorios->setCodigoPostal($_POST["CodigoPostal"]);
$laboratorios->setIdDependencia((int) $_POST["IdDependencia"]);
$laboratorios->setEMail($_POST["Mail"]);
$laboratorios->setActivo($_POST["Activo"]);
$laboratorios->setRecibeMuestrasChagas($_POST["RecibeChagas"]);
$laboratorios->setRecibeMuestrasPcr($_POST["RecibePcr"]);
$laboratorios->setRecibeMuestrasLeish($_POST["RecibeLeish"]);
$laboratorios->setMuestras((int) $_POST["Muestras"]);
$laboratorios->setObservaciones($_POST["Observaciones"]);
$laboratorios->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos el registro
$id = $laboratorios->grabarLaboratorio();

// retornamos
echo json_encode(array("Id" => $id));
