<?php

/**
 *
 * Class Notificados | reportes/notificados.class.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @param       int $anio - el año a reportar
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (28/08/2025)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que genera el documento pdf con los pacientes notificados
 * al sisa, recibe como parámetro el año a reportar
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

// incluimos las clases
require_once "../informes/paginas.class.php";
require_once "../pacientes/pacientes.class.php";
require_once "../mascotas/mascotas.class.php";

// leemos el archivo de configuración
$config = parse_ini_file("config.ini");
DEFINE ("TEMP", $config["Temp"]);
define('FPDF_FONTPATH', $config["Fuentes"]);

/**
 * Definición de la clase
 */
class Notificados{

    // definimos las variables de clase
    protected $Documento;        // documento pdf
    protected $Interlineado;     // distancia del interlineado
    protected $Fuente;           // tamaño de la fuente en puntos

    /**
     * Constructor de la clase, instanciamos los objetos y generamos
     * el documento
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - el año a reportar
     */
    public function __construct(int $anio){

        // instanciamos los objetos
        $this->Documento = new Paginas('P', 'mm');

        // agrega una fuente unicode
        $this->Documento->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->Documento->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);

        // fijamos las propiedades del documento
        $this->Documento->SetAuthor("Claudio Invernizzi");
        $this->Documento->SetCreator("Instituto Nacional de Parasitología");
        $this->Documento->SetDisplayMode("fullpage", "single");
        $this->Documento->SetSubject("Pacientes con determinaciones notificadas", true);
        $this->Documento->SetTitle("Trazabilidad de muestras de Leishmania", true);
        $this->Documento->SetAutoPageBreak(true);
        $this->Documento->AliasNbPages();        

        // inicializamos el interlineado y el tamaño de la fuente
        $this->Interlineado = 7;
        $this->Fuente = 12;

        // generamos el documento
        $this->generarReporte($anio);

        // guardamos el documento
        $this->Documento->Output("F", TEMP . "/notificados.pdf");

    }

    /**
     * Método llamado desde el constructor, que agrega al
     * documento los registros correspondientes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - el año a reportar
     */
    protected function generarReporte(int $anio){

        // agregamos los registros pendientes de pacientes
        $this->notificadosPacientes($anio);

        // agregamos los registros pendientes de mascotas
        $this->notificadosMascotas($anio);

    }

    /**
     * Método que agrega al documento los registros pendientes
     * de pacientes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - el año a reportar
     */
    protected function notificadosPacientes(int $anio){

        // instanciamos la clase y
        // obtenemos los registros pendientes
        $pacientes = new Pacientes(); 
        $registros = $pacientes->getNotificadosPacientes($anio);

        // si hay registros
        if (count($registros) > 0){

            // seteamos la fuente
            $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

            // presenta el título
            $texto = "Muestras de pacientes notificadas";
            $this->Documento->MultiCell(100, $this->Interlineado, $texto, 0);

            // definimos los encabezados de columna
            $this->Documento->Cell(10, $this->Interlineado, "Fecha", 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, "Paciente", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Documento", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Notificado", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Operador", 0, 1);

            // seteamos la fuente
            $this->Documento->SetFont('DejaVu', '', $this->Fuente);

            // recorremos el vector
            foreach($registros as $valor){

                // presentamos el registro
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $valor["paciente"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["documento"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["notificado"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["usuario"], 0, 1);
                
            }

        // si no hay registros pendientes
        } else {

            // presenta el mensaje
            $this->Documento->Cell(100, $this->Interlineado, "No hay muestras notificadas", 0, 1, "C");

        }

    }

    /**
     * Método que agrega al documento los registros
     * de mascotas notificadas al sisa
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - año a reportar
     */
    protected function notificadosMascotas(int $anio){

        // instanciamos la clase y 
        // obtenemos los registros pendientes
        $mascota = new Mascotas();
        $registros = $mascota->getNotificadosMascotas($anio);

        // si hay registros
        if (count($registros) > 0){

            // seteamos la fuente
            $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

            // presenta el título
            $texto = "Muestras de mascotas notificadas";
            $this->Documento->MultiCell(100, $this->Interlineado, $texto, 0);

            // definimos los encabezados de columna
            $this->Documento->Cell(10, $this->Interlineado, "Fecha", 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, "Paciente", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Documento", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Mascota", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Notificado", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Operador", 0, 1);

            // seteamos la fuente
            $this->Documento->SetFont('DejaVu', '', $this->Fuente);

            // recorremos el vector
            foreach($registros as $valor){

                // presentamos el registro
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $valor["paciente"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["documento"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["mascota"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["notificado"], 0, 0);                
                $this->Documento->Cell(10, $this->Interlineado, $valor["usuario"], 0, 1);                
            }

        // si no hay registros pendientes
        } else {

            // presenta el mensaje
            $this->Documento->Cell(100, $this->Interlineado, "No hay muestras notificadas", 0, 1, "C");

        }

    }

}
