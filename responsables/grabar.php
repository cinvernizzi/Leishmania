<?php

/**
 *
 * grabar | responsables/grabar.php
 *
 * @package     CCE
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de un registro y ejecuta
 * la consulta en la base de datos, retorna el resultado de la
 * operación
 *
 */

// incluimos e instanciamos las clases
require_once "responsables.class.php";
$responsable = new Responsables();

// asignamos en la clase
$responsable->setIdResponsable((int) $_POST["Id"]);
$responsable->setNombre($_POST["Nombre"]);
$responsable->setUsuario($_POST["Usuario"]);
$responsable->setInstitucion($_POST["Institucion"]);
$responsable->setCargo($_POST["Cargo"]);
$responsable->setMail($_POST["Mail"]);
$responsable->setTelefono($_POST["Telefono"]);
$responsable->setIdPais((int) $_POST["IdPais"]);
$responsable->setIdLocalidad($_POST["CodLoc"]);
$responsable->setDireccion($_POST["Direccion"]);
$responsable->setCodigoPostal($_POST["CodigoPostal"]);
$responsable->setResponsableChagas($_POST["RespChagas"]);
$responsable->setResponsableLeish($_POST["RespLeish"]);
$responsable->setIdLaboratorio((int) $_POST["IdLaboratorio"]);
$responsable->setActivo($_POST["Activo"]);
$responsable->setNivelCentral($_POST["NivelCentral"]);
$responsable->setIdAutorizo((int) $_POST["Autorizo"]);
$responsable->setObservaciones($_POST["Observaciones"]);

// grabamos el registro
$resultado = $responsable->grabaResponsable();

// retornamos
echo json_encode(array("Id" =>       $resultado["Id"],
                       "Password" => $resultado["Password"]));
