<?php

/**
 *
 * laboratorios/xlslaboratorios.php
 *
 * @package     Leishmania
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (12/06/2025)
 * @copyright   Copyright [(c) 2025, DsGestion
 *
 * Comentarios: Método que genera la tabla xls con el listado
 *              completo de laboratorios
 *
*/

// incluimos e instanciamos la clase
require_once "laboratorios.class.php";
$laboratorios = new Laboratorios();

// incluimos la clase xls
require_once "../clases/xlsxwriter.class.php";

// obtenemos la nómina de laboratorios que
// participan de leishmania
$nomina = $laboratorios->nominaLeishmania();

// instanciamos la clase
$writer = new XLSXWriter();

// agrega los encabezados del archivo
$writer->setAuthor("Lic. Claudio Invernizzi");
$writer->setTitle('Laboratorios participantes CCE Leishmania');
$writer->setSubject('Control de Calidad Externo');
$writer->setCompany('Instituto Nacional de Parasitología');
$writer->setDescription('Laboratorios de Leishmania');

// definimos el estilo de los encabezados y tìtulo
$titulo = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center');

// definimos el estilo de las celdas a la izquierda
$izquierda = array('font'=>'Arial','font-size'=>10,'halign'=>'left');

// presenta el título
$titulos = array("", "", "Instituto Nacional de Parasitología");

// agrega el tìtulo
$writer->writeSheetRow('Leishmania', $titulos, $titulo);

// presenta el título
$titulos = array("", "", "Control de Calidad Externo en Leishmaniasis");

// agrega el tìtulo
$writer->writeSheetRow('Leishmania', $titulos, $titulo);

// presenta la descripción
$titulos = array("", "", "Laboratorios Registrados");

// agrega el tìtulo
$writer->writeSheetRow('Leishmania', $titulos, $titulo);

// presenta el título
$titulos = array("", "", "Fecha de Impresión " . date('d/m/Y'));

// agrega el tìtulo
$writer->writeSheetRow('Leishmania', $titulos, $titulo);

// define los encabezados de columna
$encabezados = array("Id",
                     "Provincia",
                     "Localidad",
                     "Laboratorio",
                     "Responsable",
                     "Dirección",
                     "Cod.Postal",
                     "Activo",
                     "Participación");

// agrega los encabezados de columna
$writer->writeSheetRow('Leishmania', $encabezados, $titulo);

// recorremos el vector
foreach ($nomina as $registro){

    // verificamos el tipo de participación
    $participacion = $registro["muestras"] == 10 ? "Evaluacion" : "Entrenamiento";

    // definimos el vector
    $datos = array($registro["id"],
                   $registro["provincia"],
                   $registro["localidad"],
                   $registro["laboratorio"],
                   $registro["responsable"],
                   $registro["direccion"],
                   $registro["codigo_postal"],
                   $registro["activo"],
                   $participacion);
                   
    // agregamos el registro
    $writer->writeSheetRow('Leishmania', $datos, $izquierda);

}

// generamos los encabezados
$filename = "laboratorios.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// enviamos a la salida estandar
$writer->writeToStdOut();
