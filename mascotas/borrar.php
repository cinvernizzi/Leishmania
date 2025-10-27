<?php

/**
 *
 * borrar.php | mascotas/borrar.php
 *
 * @package     Leishmania
 * @subpackage  Mascotas
 * @param       int idmascota - clave del registro
 * @return      bool resultado de la operación
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro de las mascotas
 * de un paciente y ejecuta la consulta de eliminación, retorna el
 * resultado de la operación
 *
*/

// incluimos e instanciamos
require_once "mascotas.class.php";
$mascota = new Mascotas();

// eliminamos el registro
$resultado = $mascota->borraMascota((int) $_GET["idmascota"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
