<?php

/**
 *
 * pacientes/getpaciente.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (17/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un registro y obtiene
 * los datos del mismo, los que retorna en un array json
 *
*/

// incluimos e instanciamos las clases
require_once "pacientes.class.php";
$paciente = new Pacientes();

// obtenemos el registro
$registro = $paciente->getDatosPaciente((int) $_GET["id"]);

// retornamos
echo json_encode(array("Id" =>                 $paciente->getId(),
                       "Fecha" =>              $paciente->getFecha(),
                       "Nombre" =>             $paciente->getNombre(),
                       "Documento" =>          $paciente->getDocumento(),
                       "IdTipoDoc" =>          $paciente->getIdTipoDoc(),
                       "IdSexo" =>             $paciente->getIdSexo(),
                       "Edad" =>               $paciente->getEdad(),
                       "LocNacimiento" =>      $paciente->getLocNacimiento(),
                       "Nacimiento" =>         $paciente->getNacimiento(),
                       "Provincia" =>          $paciente->getProvincia(),
                       "IdProvincia" =>        $paciente->getIdProvincia(),
                       "Nacionalidad" =>       $paciente->getNacionalidad(),
                       "IdNacionalidad" =>     $paciente->getIdNacionalidad(),
                       "Coordenadas" =>        $paciente->getCoordenadas(),
                       "Domicilio" =>          $paciente->getDomicilio(),
                       "Urbano" =>             $paciente->getUrbano(),
                       "TelPaciente" =>        $paciente->getTelPaciente(),
                       "IdOcupacion" =>        $paciente->getIdOcupacion(),
                       "IdInstitucion" =>      $paciente->getIdInstitucion(),
                       "Institucion" =>        $paciente->getInstitucion(),
                       "CodLocInstitucion" =>  $paciente->getCodLocInstitucion(),
                       "NomLocInstitucion" =>  $paciente->getLocInstitucion(),
                       "CodProvInstitucion" => $paciente->getCodProvInstitucion(),
                       "ProvInstitucion" =>    $paciente->getProvInstitucion(),
                       "Enviado" =>            $paciente->getEnviado(),
                       "Mail" =>               $paciente->getMail(),
                       "Telefono" =>           $paciente->getTelefono(),
                       "Antecedentes" =>       $paciente->getAntecedentes(),
                       "Notificado" =>         $paciente->getNotificado(),
                       "Sisa" =>               $paciente->getSisa(),
                       "Usuario" =>            $paciente->getUsuario(),
                       "Alta" =>               $paciente->getAlta(),
                       "Modificado" =>         $paciente->getModificado()));
