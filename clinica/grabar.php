<?php

/**
 *
 * clinica/grabar.php
 *
 * @package     Leishmania
 * @subpackage  Clinica
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (21/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por post los datos del registro y ejecuta la
 * consulta de grabación, retorna la clave del registro afectado
 * o cero en caso de error
 *
*/

// incluimos e instanciamos
require_once "clinica.class.php";
$clinica = new Clinica();

// asignamos los valores
$clinica->setId((int) $_POST["Id"]);
$clinica->setPaciente((int)$_POST["IdPaciente"]);
$clinica->setCutaneaUnica($_POST["CutaneaUnica"]);
$clinica->setCutaneaMultiple($_POST["CutaneaMultiple"]);
$clinica->setMucosaNasal($_POST["MucosaNasal"]);
$clinica->setBucoFaringea($_POST["BucoFaringea"]);
$clinica->setLaringea($_POST["Laringea"]);
$clinica->setVisceral($_POST["Visceral"]);
$clinica->setFiebre($_POST["Fiebre"]);
$clinica->setInicio($_POST["Inicio"]);
$clinica->setCaracteristicas($_POST["Caracteristicas"]);
$clinica->setFatiga($_POST["Fatiga"]);
$clinica->setDebilidad($_POST["Debilidad"]);
$clinica->setVomitos($_POST["Vomitos"]);
$clinica->setDiarrea($_POST["Diarrea"]);
$clinica->setTosSeca($_POST["TosSeca"]);
$clinica->setPielGris($_POST["PielGris"]);
$clinica->setEdema($_POST["Edema"]);
$clinica->setEscamosa($_POST["Escamosa"]);
$clinica->setPetequias($_POST["Petequias"]);
$clinica->setCabello($_POST["Cabello"]);
$clinica->setAdenomegalia($_POST["Adenomegalia"]);
$clinica->setHepatoEspleno($_POST["HepatoEspleno"]);
$clinica->setLinfadenopatia($_POST["Linfadenopatia"]);
$clinica->setPerdidaPeso($_POST["PerdidaPeso"]);
$clinica->setNodulo($_POST["Nodulo"]);
$clinica->setUlcera($_POST["Ulcera"]);
$clinica->setCicatriz($_POST["Cicatriz"]);
$clinica->setLesionMucosa($_POST["LesionMucosa"]);
$clinica->setIdUsuario((int) $_POST["IdUsuario"]);

// grabamos
$resultado = $clinica->grabaClinica();

// retornamos
echo json_encode(array("Resultado" => $resultado));
