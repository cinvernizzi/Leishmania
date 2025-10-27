<?php

/**
 *
 * pacientes/buscapaciente.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (20/05/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Método que recibe por get un texto, el desplazamiento a partir
 * del primer registro y el número de registros a retornar, busca
 * la ocurrencia del texto en el nombre y documento del paciente
 * y retorna el vector con los registros encontrados
 *
*/

// incluimos e instanciamos las clases
require_once "pacientes.class.php";
$paciente = new Pacientes();

// obtenemos los valores recibidos
$texto = isset($_GET['texto']) ? $_GET['texto'] : $_POST['texto'];

// obtenemos el número de página y de registros
$pagina = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;

// definimos los array
$resultado = array();
$items = array();

// calculamos el offset
$offset = ($pagina - 1) * $rows;

// obtenemos el número total de registros
$registros = $paciente->numeroPacientes($texto);

// obtenemos el vector
$nomina = $paciente->buscaPaciente($texto, $offset, $rows);

// agregamos el total de registros
$resultado["total"] = $registros;

// vamos a recorrer el vector para agregar la imagen
foreach($nomina as $registro){

    // agregamos la fila al vector
    $items[] = array("Id" =>          $registro["id"],
                     "Nombre" =>      $registro["nombre"],
                     "Documento" =>   $registro["documento"],
                     "Institucion" => $registro["institucion"],
                     "Enviado" =>     $registro["enviado"],
                     "Editar" =>      "<img src='imagenes/meditar.png'>");

}


// agregamos el vector
$resultado["rows"] = $items;

// retornamos el vector
echo json_encode($resultado);
