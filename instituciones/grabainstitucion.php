<?php

/**
 *
 * instituciones/grabainstitucion.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (18/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de una institución
 * ejecuta la consulta de grabación
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// asignamos las propiedades
$institucion->setInstitucion($_POST["Institucion"]);
$institucion->setSiisa($_POST["Siisa"]);
$institucion->setCodLoc($_POST["CodLoc"]);
$institucion->setDireccion($_POST["Direccion"]);
$institucion->setCodigoPostal($_POST["CodigoPostal"]);
$institucion->setTelefono($_POST["Telefono"]);
$institucion->setMail($_POST["Mail"]);
$institucion->setResponsable($_POST["Responsable"]);
$institucion->setIdUsuario((int) $_POST["IdUsuario"]);
$institucion->setIdDependencia((int) $_POST["IdDependencia"]);
$institucion->setComentarios($_POST["Comentarios"]);
$institucion->setCoordenadas($_POST["Coordenadas"]);
$institucion->setIdInstitucion((int) $_POST["IdInstitucion"]);

// grabamos
$resultado = $institucion->grabaInstitucion();

// retornamos
echo json_encode(array("Id" => $resultado));
