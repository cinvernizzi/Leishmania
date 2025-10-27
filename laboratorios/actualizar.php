<?php

/**
 *
 * actualizar.php | laboratorios/actualizar.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (01/08/2023)
 * @copyright   Copyright (c) 2021, INP
 *
 * Método que recibe por post la clave de un laboratorio y
 * su estado (activo o no) y actualiza el registro
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// ejecutamos la consulta
$id = $laboratorios->actualizaEstado((int) $_POST["Id"],
                                     $_POST["Activo"],
                                     $_POST["Chagas"],
                                     $_POST["Pcr"],
                                     $_POST["Leishmania"],
                                     (int) $_POST["Usuario"]);

// retornamos
echo json_encode(array("Id" => $id));
