<?php

/**
 *
 * getcoordenadas | reportes/getcoordenadas.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @return      array con las coordenadas de los pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (24/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que retorna el array json con las coordenadas gps de los
 * pacientes ingresados
 *
 */

// incluimos e instanciamos
require_once "mapas.class.php";
$mapas = new Mapas();

// obtenemos el vector
$nomina = $mapas->getCoordenadasPacientes();

// retornamos
echo json_encode($nomina);
