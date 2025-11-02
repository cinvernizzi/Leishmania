<?php

/**
 *
 * informes/protocolo.php
 *
 * @package     Leishmania
 * @subpackage  Informes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (02/11/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y la fecha 
 * de la muestra para generar el protocolo con las determinaciones
 * de esa misma fecha
 *
*/

// incluimos e instanciamos la clase
require_once "protocolo.class.php";
$protocolo = new Protocolo((int) $_GET["id"], $_GET["fecha"]);

// enviamos los encabezados
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, false");
header("Pragma: no-cache");

// usamos el frame que nos permite incrustarlo desde php
echo "<iframe src='temp/protocolo.pdf' 
       height='100%' 
       width='100%'>
      </iframe>";
