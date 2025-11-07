<?php

/**
 *
 * documentos/grabadocumento.php
 *
 * @package     Leishmania
 * @subpackage  Documentos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (13/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de un tipo de
 * documento y ejecuta la consulta de grabación
 *
*/

// incluimos e instanciamos la clase
require_once "documentos.class.php";
$documentos = new Documentos();

// asignamos las propiedades
$documentos->setIdDocumento((int) $_POST["Id"]);
$documentos->setTipoDocumento($_POST["TipoDocumento"]);
$documentos->setDescripcion($_POST["Descripcion"]);
$documentos->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $documentos->grabaDocumento();

// retornamos
echo json_encode(array("Id" => $resultado));
