<?php

/**
 *
 * notificados | reportes/notificados.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @param       anio entero con el año a reportar
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (24/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe como parámetro el año a reportar y genera el
 * documento pdf con la nómina de los pacientes que han sido
 * notificados al sisa en ese período
 *
 */

// leemos el archivo de configuración
$config = parse_ini_file("config.ini");
DEFINE ("TEMP", $config["Temp"]);

// incluimos la clase y generamos el certificado
require_once "notificados.class.php";
$reporte = new Notificados((int) $_GET["anio"]);

// usamos el frame que nos permite incrustarlo desde php
echo "<iframe src= TEMP . '/notificados.pdf'
       height='100%'
       width='100%'>
      </iframe>";
