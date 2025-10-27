<?php

/**
 *
 * sindeterminacion | reportes/sindeterminacion.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (24/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que genera el documento pdf con la nómina de los pacientes
 * que tienen resultados pendientesd
 *
 */

// leemos el archivo de configuración
$config = parse_ini_file("config.ini");
DEFINE ("TEMPORAL", $config["TEMPORAL"]);

// incluimos la clase y generamos el documento
require_once "sindeterminacion.class.php";
$reporte = new SinDeterminacion();

// usamos el frame que nos permite incrustarlo desde php
echo "<iframe src= TEMPORAL . '/sindeterminacion.pdf'
       height='100%'
       width='100%'>
      </iframe>";
