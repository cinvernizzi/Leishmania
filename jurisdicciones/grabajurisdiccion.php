<?php

/**
 *
 * jurisdicciones/grabajurisdiccion.php
 *
 * @package     Leishmania
 * @subpackage  Jurisdicciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (14/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por post los datos de una
 * provincia y el tipo de evento y ejecuta la consulta de grabación
 *
*/

// incluimos e instanciamos la clase
require_once "jurisdicciones.class.php";
$jurisdicciones = new Jurisdicciones();

// asignamos las propiedades
$jurisdicciones->setIdPais((int) $_POST["IdPais"]);
$jurisdicciones->setNombreProvincia($_POST["Provincia"]);
$jurisdicciones->setIdProvincia($_POST["CodProv"]);
$jurisdicciones->setPoblacion((int) $_POST["Poblacion"]);
$jurisdicciones->setIdUsuario((int) $_POST["IdUsuario"]);

// según la clave recibida
$evento = $_POST["Id"] == 0 ? "insertar" : "editar";

// grabamos
$resultado = $jurisdicciones->grabaProvincia($evento);

// retornamos
echo json_encode(array("Resultado" => $resultado));
