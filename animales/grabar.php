<?php

/**
 *
 * Archivo: grabar.php / animales/grabar.php
 * @package Leishmania
 * @subpackage DicAnimales
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version 1.0 (29/07/2025)
 * @copyright (c) 2025, Claudio Invernizzi
 *
 * Comentarios: Método que recibe por post los datos de un registro
 *              y ejecuta la consulta en el servidor, retorna la
 *              clave del registro afectado o cero en caso de error
 *
 */

// incluimos e instanciamos
require_once "dicanimales.class.php";
$diccionario = new DicAnimales();

// asignamos en la clase
$diccionario->setId((int) $_POST["Id"]);
$diccionario->setAnimal($_POST["Animal"]);
$diccionario->setIdUsuario((int) $_POST["IdUsuario"]);

// obtenemos el registro
$resultado = $diccionario->grabaAnimal();

// retornamos
echo json_encode(array("Resultado" => $resultado));
