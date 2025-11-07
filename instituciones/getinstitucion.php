<?php

/**
 *
 * getinstitucion | instituciones/getinstitucion.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (19/10/2021)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la clave de una institución y
 * retorna el array json con los datos del registro
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
$institucion = new Instituciones();

// obtenemos el registro
$institucion->getDatosInstitucion((int) $_GET["idinstitucion"]);

// retornamos
echo json_encode(array("Id" =>            $institucion->getIdInstitucion(),
                       "Institucion" =>   $institucion->getInstitucion(),
                       "Siisa" =>         $institucion->getSiisa(),
                       "CodLoc" =>        $institucion->getCodLoc(),
                       "Localidad" =>     $institucion->getLocalidad(),
                       "CodProv" =>       $institucion->getCodProv(),
                       "Provincia" =>     $institucion->getProvincia(),
                       "IdPais" =>        $institucion->getIdPais(),
                       "Pais" =>          $institucion->getPais(),
                       "Direccion" =>     $institucion->getDireccion(),
                       "CodPost" =>       $institucion->getCodigoPostal(),
                       "Telefono" =>      $institucion->getTelefono(),
                       "Mail" =>          $institucion->getMail(),
                       "Responsable" =>   $institucion->getResponsable(),
                       "Usuario" =>       $institucion->getUsuario(),
                       "IdDependencia" => $institucion->getIdDependencia(),
                       "Fecha" =>         $institucion->getFechaAlta(),
                       "Comentarios" =>   $institucion->getComentarios(),
                       "Coordenadas" =>   $institucion->getCoordenadas()));
