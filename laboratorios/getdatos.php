<?php

/**
 *
 * getdatos | laboratorios/getdatos.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un registro y retorna
 * el array json con los datos del mismo
 *
 */

// incluímos e instanciamos las clases
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// obtenemos el registro
$laboratorios->getDatosLaboratorio((int) $_GET["id"]);

// retornamos
echo json_encode(array("Id" =>            $laboratorios->getIdLaboratorio(),
                       "Laboratorio" =>   $laboratorios->getNombre(),
                       "Responsable" =>   $laboratorios->getResponsable(),
                       "Pais" =>          $laboratorios->getPais(),
                       "IdPais" =>        $laboratorios->getIdPais(),
                       "Localidad" =>     $laboratorios->getLocalidad(),
                       "CodLoc" =>        $laboratorios->getIdLocalidad(),
                       "Provincia" =>     $laboratorios->getProvincia(),
                       "CodProv" =>       $laboratorios->getIdProvincia(),
                       "Direccion" =>     $laboratorios->getDireccion(),
                       "CodigoPostal" =>  $laboratorios->getCodigoPostal(),
                       "IdDependencia" => $laboratorios->getIdDependencia(),
                       "Mail" =>          $laboratorios->getEmail(),
                       "FechaAlta" =>     $laboratorios->getFechaAlta(),
                       "Activo" =>        $laboratorios->getActivo(),
                       "RecibeChagas" =>  $laboratorios->getRecibeMuestrasChagas(),
                       "RecibePcr" =>     $laboratorios->getRecibeMuestrasPcr(),
                       "RecibeLeish" =>   $laboratorios->getRecibeMuestrasLeish(),
                       "Muestras" =>      $laboratorios->getMuestras(),
                       "IdRecibe" =>      $laboratorios->getIdRecibe(),
                       "Observaciones" => $laboratorios->getObservaciones(),
                       "Usuario" =>       $laboratorios->getUsuario()));
