<?php

/**
 *
 * nomina.php | mascotas/nomina.php
 *
 * @package     Leishmania
 * @subpackage  Mascotas
 * @param       int clave del paciente
 * @return      array vector con los registros
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (29/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get la clave de un paciente y retorna el
 * vector con la nómina de mascotas de ese paciente
 *
*/

// incluimos e instanciamos
require_once "mascotas.class.php";
$mascota = new Mascotas();

// si recibió la clave
if (isset($_POST["idpaciente"])){
    
    // obtenemos el vector
    $nomina = $mascota->nominaMascotas((int) $_POST["idpaciente"]);

    // definimos el array
    $resultado = array();

    // recorremos el vector
    foreach($nomina as $registro){
        
        // agregamos el registro
        $resultado[] = array("Id" =>       $registro["id"],
                             "Paciente" => $registro["paciente"],
                             "Nombre" =>   $registro["nombre"],
                             "Edad" =>     $registro["edad"],
                             "Origen" =>   $registro["origen"],
                             "Usuario" =>  $registro["usuario"],
                             "Alta" =>     $registro["alta"],
                             "Editar" =>   "<img src='imagenes/save.png'>",
                             "Borrar" =>   "<img src='imagenes/borrar.png'>",
                             "Muestras" => "<img src='imagenes/mquimica.png'>");
        
    }

    // retornamos
    echo json_encode($resultado);
}
