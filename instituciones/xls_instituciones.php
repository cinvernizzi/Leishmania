<?php

/**
 *
 * instituciones/xls_instituciones.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (02/02/2022)
 * @copyright   Copyright (c) 2017, INP/
 *
 * Método que genera el excel con la nómina completa
 * de las instituciones declaradas
 *
*/

// incluimos e instanciamos la clase
require_once "instituciones.class.php";
require_once "../clases/xlsxwriter.class.php";
$instituciones = new Instituciones();

// obtenemos los datos de la heladera
$nomina = $instituciones->listadoInstituciones();

// instanciamos la hoja de cálculo
$hoja = new XLSXWriter();

// fijamos las propiedades del documento
$hoja->setAuthor('Claudio Invernizzi');
$hoja->setTitle('Instituciones Registradas');
$hoja->setSubject('Plataforma de Leishmaniasis');
$hoja->setCompany('Instituto Nacional de Parasitología');
$hoja->setDescription('Listado de Instituciones Asistenciales');

// define el estilo de los títulos
$titulo = array('font' => 'Arial',
                'font-size' => 12,
                'font-style' => 'bold',
                'halign' => 'center');

// define el estilo de las celdas comunes (centradas)
$normal = array('halign'=>'center');

// definimos el array de la línea en blanco
$vacio = array('', '');

// presenta el encabezado
$datos = array('',
               '',
               'Instituto Nacional de Parasitología');
$hoja->writeSheetRow('Instituciones', $datos, $titulo);

// presenta el programa
$datos = array('',
               '',
               'Plataforma de Trazabilidad de Leishmania');
$hoja->writeSheetRow('Instituciones', $datos, $titulo);

// presenta la fecha de impresión
$datos = array('',
               '',
               'Fecha de Impresión: ' . date('d/m/Y'));
$hoja->writeSheetRow('Instituciones', $datos, $titulo);

// presenta una fila en blanco
$hoja->writeSheetRow('Instituciones', $vacio, $titulo);

// presenta el título
$datos = array('',
               '',
               'Instituciones Asistenciales Identificadas');
$hoja->writeSheetRow('Instituciones', $datos, $titulo);

// presenta una línea en blanco
$hoja->writeSheetRow('Instituciones', $vacio, $titulo);

// definimos los encabezados
$datos = array (
    'Id',
    'Institución',
    'Sisa',
    'País',
    'Provincia',
    'Localidad',
    'Dirección',
    'Cod.Post.',
    'Teléfono',
    'Mail',
    'Dependencia',
    'Responsable',
    'Fecha',
    'Usuario'
);

// agregamos la fila
$hoja->writeSheetRow('Instituciones', $datos, $normal);

// ahora recorremos el vector
foreach($nomina as $registro){

    // componemos el array ordenado
    $datos = array(
            $registro["id"],
            $registro["institucion"],
            $registro["siisa"],
            $registro["pais"],
            $registro["provincia"],
            $registro["localidad"],
            $registro["direccion"],
            $registro["codigo_postal"],
            $registro["telefono"],
            $registro["mail"],
            $registro["dependencia"],
            $registro["responsable"],
            $registro["fecha"],
            $registro["usuario"]
    );

    // agregamos la fila sin formato
    $hoja->writeSheetRow('Instituciones', $datos, $normal);

}

// definimos el archivo
$filename = "instituciones.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// envía la hoja a la salida estandar
$hoja->writeToStdOut();
