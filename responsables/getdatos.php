<?php

/**
 *
 * getdatos | responsables/getdatos.php
 *
 * @package     CCE
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de un registro y retorna
 * el array json con los datos del mismo
 *
 */

// incluimos e instanciamos las clases
require_once "responsables.class.php";
$responsable = new Responsables();

// obtenemos el registro
$responsable->getResponsable((int) $_GET["id"]);

// retornamos
echo json_encode(array("Id" =>                $responsable->getIdResponsable(),
                       "Nombre" =>            $responsable->getNombre(),
                       "Institucion" =>       $responsable->getInstitucion(),
                       "Cargo" =>             $responsable->getCargo(),
                       "Mail" =>              $responsable->getMail(),
                       "Telefono" =>          $responsable->getTelefono(),
                       "Pais" =>              $responsable->getPais(),
                       "IdPais" =>            $responsable->getIdPais(),
                       "CodProv" =>           $responsable->getIdProvincia(),
                       "Localidad" =>         $responsable->getLocalidad(),
                       "IdLocalidad" =>       $responsable->getIdLocalidad(),
                       "Provincia" =>         $responsable->getProvincia(),
                       "Direccion" =>         $responsable->getDireccion(),
                       "CodigoPostal" =>      $responsable->getCodigoPostal(),
                       "Coordenadas" =>       $responsable->getCoordenadas(),
                       "ResponsableChagas" => $responsable->getResponsableChagas(),
                       "ResponsableLeish" =>  $responsable->getResponsableLeish(),
                       "Laboratorio" =>       $responsable->getLaboratorio(),
                       "IdLaboratorio" =>     $responsable->getIdLaboratorio(),
                       "Activo" =>            $responsable->getActivo(),
                       "Observaciones" =>     $responsable->getObservaciones(),
                       "Usuario" =>           $responsable->getUsuario(),
                       "Autorizo" =>          $responsable->getAutorizo(),
                       "NivelCentral" =>      $responsable->getNivelCentral(),
                       "FechaAlta" =>         $responsable->getFechaAlta()));
