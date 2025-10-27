<?php

/**
 *
 * Class PdfLeish | reportes/PdfLeish.class.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (28/08/2025)
 * @copyright   Copyright (c) 2018, INP
 *
 * Esta clase extiende la clase pdf para definir el encabezado y pié 
 * de página del programa
 * 
 * Sin embargo, la clase para ahorrar espacio regenera las fuentes que
 * son utilizadas en el documento, si migramos el sistema y cambia el
 * path de la aplicación arroja un error señalando que no encuentra las
 * fuentes.

 * Para obligar a que regenere las fuentes basta con eliminar todos los
 * archivos dat y aquellos php que tengan nombres de fuentes del directorio
 * /font/unifont/ dejando solamente los archivos ttf y el archivo ttfonts.php
 * que es el que se encarga de generar las fuentes

 * Si se desean incluir otras fuentes en el documento, bastaría con
 * copiar los archivos ttf en este directorio y luego al incluirlos en
 * el documento el sistema se encarga automáticamente de generar los dat
 * 
*/

// declaramos el tipeado estricto
declare(strict_types=1);

// leemos el archivo de configuración
$config = parse_ini_file("../clases/config.ini");

// define la ruta a las fuentes pdf
define('FPDF_FONTPATH', $config["Fuentes"]);

// incluimos la clase tpdf
require_once "../clases/fpdf/tfpdf.php";

// convención para la nomenclatura de las propiedades, comienzan con una
// letra mayúscula, de tener mas de una palabra no se utilizan separadores
// y la inicial de cada palabra va en mayúscula
// para las variables recibidas como parámetro el criterio es todas en
// minúscula

// convención para la nomenclatura de los metodos, comienzan con set o get
// según asignen un valor o lo lean y luego el nombre del valor a obtener

/**
 * Definición de la clase
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class LeishPdf extends tFPDF {

	/**
	 * Constructor de la clase, definimos las fuentes 
	 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
	 */
	public function __construct(){

        // agrega una fuente unicode
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);

	}

	/**
	 * Método que sobrecarga la cabecera de la página
	 */
	protected function Header() {

	    // presenta el logo
	    $this->Image('../imagenes/logoleish.png',10, 10, 50, 30);

	    // fijamos la fuente
	    $this->Documento->SetFont('DejaVu', '', 12);

	    // fijamos la posición 
	    $this->Cell(80);
	    
	    // presenta el título 
	    $this->Cell(30,10,'Trazabilidad de Muestras de Leishmania',1,0,'C');

	    // un salto de línea
	    $this->Ln(20);

	}

	/**
	 * Método que sobrecarga el pié de página 
	 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
	 */
	protected function Footer() {

    	// fijamos la posición de impresión
    	$this->SetY(-15);

    	// establecemos la fuente
    	$this->SetFont('DejaVu', '', 10);
    	
    	// presentamos el número de página
    	$this->Cell(0, 10,'Página: ' . $this->PageNo() ." de " . '/{nb}', 0, 0, 'C');

	}

}
