<?php

/**
 *
 * validar.php | viajes/validar.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @param       string destino del viaje
 * @param       string fecha del viaje
 * @return      bool verdadero si puede insertar
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get el destino y la fecha de un viaje y
 * verifica que este no se encuentre declarado, retorna verdadero
 * si puede insertar
 *
*/

// incluimos e instanciamos
require_once "viajes.class.php";
$viajes = new Viajes();

// consultamos
$resultado = $viajes->validaViaje($_GET["destino"], $_GET["fecha"]);

// retornamos
echo json_encode(array("Resultado" => $resultado));
