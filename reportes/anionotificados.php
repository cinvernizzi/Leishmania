<?php

/**
 *
 * anionotificados | reportes/anionotificados.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (25/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que obtiene la nómina de años con casos notificados al
 * sisa (no utilizamos una clase porque no vale la pena)
 *
 */

// incluimos e instanciamos la conexión
require_once "../clases/conexion.class.php";
$link = new Conexion();

// componemos la consulta
$consulta = "SELECT DISTINCT(YEAR(leishmania.pacientes.notificado)) AS anio
             FROM leishmania.pacientes
             WHERE NOT ISNULL(leishmania.pacientes.notificado)
             ORDER BY leishmania.pacientes.notificado DESC;";

// ejecutamos y obtenemos el vector
$resultado = $link->query($consulta);
$nomina = $resultado->fetchAll(PDO::FETCH_ASSOC);

// definimos el array
$anios = array();

// recorremos el vector
foreach($nomina as $registro){

    // lo agregamos al array
    $anios[] = array("Anio" => $registro["anio"]);

}

// retornamos
echo json_encode($anios);
