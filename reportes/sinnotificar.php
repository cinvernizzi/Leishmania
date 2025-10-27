<?php

/**
 *
 * sinnotificar | reportes/sinnotificar.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (24/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que genera el documento pdf con la nómina de los pacientes
 * que tienen resultados cargados y que aún no han sido notificados
 * al sisa
 *
 */

// leemos el archivo de configuración
$config = parse_ini_file("config.ini");
DEFINE ("TEMPORAL", $config["TEMPORAL"]);

// incluimos la clase y generamos el certificado
require_once "sinnotificar.class.php";
$reporte = new SinNotificar();
 

// usamos el frame que nos permite incrustarlo desde php
echo "<iframe src= TEMPORAL . '/sinnotificar.pdf'
       height='100%'
       width='100%'>
      </iframe>";
