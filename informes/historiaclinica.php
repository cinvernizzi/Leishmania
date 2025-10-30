<?php

/**
 *
 * informes/historiaclinica.php
 *
 * @package     Leishmania
 * @subpackage  Informes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (30/10/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y genera la 
 * historia clínica completa (incluída las mascotas) del mismo
 *
*/

// incluimos e instanciamos la clase
require_once "historia.class.php";
$historia = new Historia((int) $_GET["id"]);

// enviamos los encabezados
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, false");
header("Pragma: no-cache");

// usamos el frame que nos permite incrustarlo desde php
echo "<iframe src='temp/historia.pdf' 
       height='100%' 
       width='100%'>
      </iframe>";
