<?php

/**
 *
 * informes/paginas.class.php
 *
 * @package     Leishmania
 * @subpackage  Informes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (30/10/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Clase que extiene la clase pdf y sobrecarga el header y footer
 * del documento
*/

// declaramos el tipeado estricto
declare(strict_types=1);

// inclusión de archivos 
require_once "../clases/fpdf/tfpdf.php";

/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * Definición de la clase
 */
class Paginas extends tFPDF {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que sobrecarga el pié de página 
     */
    public function Footer(){
    
        // nos desplazamos a 1,5 cm del borde inferior
        $this->SetY(-15);

        // seleccionamos la fuente
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);                
        $this->SetFont('DejaVu', '', 8);

        // presenta la fecha de impresión 
        $this->Cell(100, 10, "Fecha Impresión: " . date('d/m/y'), 0, 0, 'L');

        // imprimimos el número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . ' de ' . '{nb}' , 0, 0, 'R');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que sobrecarga el encabezado de página 
     */
    public function Header(){
        
        // agrega los logos
        $this->Image('../imagenes/logoleish.png', 10, 10, 40, 30);
        $this->Image('../imagenes/logo.png', 80, 10, 35, 27);    
        $this->Image('../imagenes/LogoAnlis.png', 135, 10, 70, 30);            

        // fija la posición 
        $this->setY(40);

        // seleccionamos la fuente
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);         
        $this->SetFont('DejaVu', '', 12);

        // presenta el título 
        $this->Cell(0, 7, "Departamento de Diagnóstico", 0, 1, 'C');
        $this->Cell(0, 7, "Historias Clínicas de Leishmaniasis", 0, 1, 'C');

        // presenta un separador
        $this->Image('../imagenes/separador.png', 10, 55, 200, 3);

        // fijamos la posición del cabezal
        $this->SetY(60);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int espacio que ocupa el texto a imprimir
     * @return boolean verdadero si hay lugar 
     * Método que recibe como parámetro el alto del texto a 
     * imprimir y retorna verdadero si hay espacio en la 
     * página para el mismo
     */
    public function hayLugar(int $tamanio) : bool {

        // obtenemos el tamaño de la página y le 
        // descontamos el pié de página mas un pequeño margen
        $pagina = (int) $this->GetPageHeight() - 20;

        // obtenemos la posición actual del cabezal
        $posicion = (int) $this->GetY();

        // verifica si hay espacio
        if ($posicion + $tamanio >= $pagina){
            return false;
        } else {
            return true;
        }

    }

}
