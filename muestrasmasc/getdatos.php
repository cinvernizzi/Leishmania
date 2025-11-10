<?php

/**
 *
 * muestrasmasc/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  MuestrasMasc
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param       int clave del registro
 * @return      array vector con los datos del registro
 * @version     1.0 (14/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave del registro y retorna
 * el array json con los datos del mismo
 *
*/

// incluimos e instanciamos
require_once "muestrasmasc.class.php";
$muestras = new MuestrasMasc();

// obtenemos el registro
$resultado = $muestras->getDatosMuestra((int) $_GET["id"]);

// retornamos
echo json_encode(array("Id" =>            $muestras->getId(),
                       "Mascota" =>       $muestras->getMascota(),
                       "Paciente" =>      $muestras->getPaciente(),
                       "Material" =>      $muestras->getMaterial(),
                       "Tecnica" =>       $muestras->getTecnica(),
                       "Fecha" =>         $muestras->getFecha(),
                       "Resultado" =>     $muestras->getResultado(),
                       "Determinacion" => $muestras->getDeterminacion(),
                       "Usuario" =>       $muestras->getUsuario(),
                       "Alta" =>          $muestras->getAlta()));
