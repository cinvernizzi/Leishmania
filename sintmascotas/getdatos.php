<?php

/**
 *
 * getdatos.php | sintmascotas/getdatos.php
 *
 * @package     Leishmania
 * @subpackage  Sintmascotas
 * @param       int clave de la mascota
 * @return      array vector con el registro
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (04/08/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de una mascota y retorna el
 * vector con los datos de los sintomas de esa mascota (asumimos
 * que existe una relación uno a uno entre los síntomas y las
 * mascotas)
 *
*/

// incluimos e instanciamos
require_once "sintmascotas.class.php";
$sintomas = new SintMascotas();

// obtenemos el registro
$resultado = $sintomas->getDatosSintomas((int) $_GET["idmascota"]);

// si salió bien
if ($resultado){

    // retornamos
    echo json_encode(array("Resultado" => true,
                           "Id" => $sintomas->getId(),
                           "Mascota" => $sintomas->getMascota(),
                           "Paciente" => $sintomas->getPaciente(),
                           "Pelo" => $sintomas->getPelo(),
                           "Adelgazamiento" => $sintomas->getAdelgazamiento(),
                           "Ulceras" => $sintomas->getUlceras(),
                           "PocoActivo" => $sintomas->getPocoActivo(),
                           "Usuario" => $sintomas->getUsuario(),
                           "Alta" => $sintomas->getAlta()));

// si ocurrió un error
} else {

    // retornamos el error
    echo json_encode(array("Resultado" => false));

}
