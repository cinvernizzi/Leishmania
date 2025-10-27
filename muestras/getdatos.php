<?php

/**
 *
 * getdatos.php | muestras/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Muestras
 * @param       int clave del registro
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y retorna el
 * array json con los datos de se registro
 *
*/

// incluimos e instanciamos
require_once "muestras.class.php";
$muestras = new Muestras();

// obtenemos el registro
$resultado = $muestras->getDatosMuestra((int) $_GET["idmuestra"]);

// si no hubo errores
if ($resultado){

    // retornamos el vector
    echo json_encode(array("Resultado" => true,
                           "Id" => $muestras->getId(),
                           "Paciente" => $muestras->getPaciente(),
                           "Material" => $muestras->getMaterial(),
                           "Tecnica" => $muestras->getTecnica(),
                           "Fecha" => $muestras->getFecha(),
                           "Resultado" => $muestras->getResultado(),
                           "Determinacion" => $muestras->getDeterminacion(),
                           "Usuario" => $muestras->getUsuario(),
                           "Alta" => $muestras->getAlta()));
                           
// si hubo un error
} else {


    // retornamos el estado
    echo json_encode(array("Resultado" => false));

}
