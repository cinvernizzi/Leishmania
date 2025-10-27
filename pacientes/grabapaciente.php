<?php

/**
 *
 * pacientes/grabapaciente.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos de un registro y
 * ejecuta la consulta de grabación, retorna el resultado
 * de la operación
 *
*/

// incluimos e instanciamos las clases
require_once "pacientes.class.php";
$paciente = new Pacientes();

// asignamos en la clase
$paciente->setId((int) $_POST["Id"]);
$paciente->setFecha($_POST["Fecha"]);
$paciente->setNombre($_POST["Nombre"]);
$paciente->setDocumento($_POST["Documento"]);
$paciente->setIdTipoDoc((int) $_POST["IdTipoDoc"]);
$paciente->setIdSexo((int) $_POST["IdSexo"]);
$paciente->setNacimiento($_POST["Nacimiento"]);
$paciente->setEdad((int) $_POST["Edad"]);
$paciente->setLocNacimiento($_POST["LocNacimiento"]);
$paciente->setCoordenadas($_POST["Coordenadas"]);
$paciente->setDomicilio($_POST["Domicilio"]);
$paciente->setUrbano($_POST["Urbano"]);
$paciente->setTelPaciente($_POST["TelPaciente"]);
$paciente->setIdOcupacion((int) $_POST["IdOcupacion"]);
$paciente->setIdInstitucion((int) $_POST["IdInstitucion"]);
$paciente->setEnviado($_POST["Enviado"]);
$paciente->setMail($_POST["Mail"]);
$paciente->setTelefono($_POST["Telefono"]);
$paciente->setAntecedentes($_POST["Antecedentes"]);
$paciente->setNotificado($_POST["Notificado"]);
$paciente->setSisa($_POST["Sisa"]);
$paciente->setIdUsuario((int) $_POST["IdUsuario"]);

// ejecutamos
$resultado = $paciente->grabaPaciente();

// retornamos
echo json_encode(array("Resultado" => $resultado));
