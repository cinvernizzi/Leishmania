<?php

/**
 *
 * Class SinDeterminacion | reportes/SinDeterminacion.class.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (28/08/2025)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que genera el documento pdf con los pacientes registrados
 * que tienen una determinación pendiente
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
require_once "../clases.conexion.class.php";
require_once "leishpdf.class.php";

// leemos el archivo de configuración
$config = parse_ini_file("config.ini");
DEFINE ("TEMPORAL", $config["TEMPORAL"]);

/**
 * Definición de la clase
 */
class SinDeterminacion{

    // definimos las variables de clase
    protected $Link;             // puntero a la base de datos
    protected $Documento;        // documento pdf
    protected $Interlineado;     // distancia del interlineado
    protected $Fuente;           // tamaño de la fuente en puntos

    /**
     * Constructor de la clase, instanciamos los objetos y generamos
     * el documento
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // instanciamos los objetos
        $this->Link = new Conexion();
        $this->Documento = new LeishPdf();

        // fijamos las propiedades del documento
        $this->Documento->SetAuthor("Claudio Invernizzi");
        $this->Documento->SetCreator("Instituto Nacional de Parasitología");
        $this->Documento->SetDisplayMode("fullpage", "single");
        $this->Documento->SetSubject("Pacientes con determinaciones pendientes", true);
        $this->Documento->SetTitle("Trazabilidad de muestras de Leishmania", true);
        $this->Documento->SetAutoPageBreak(true);

        // inicializamos el interlineado y el tamaño de la fuente
        $this->Interlineado = 7;
        $this->Fuente = 12;

        // agrega una fuente unicode
        $this->Documento->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->Documento->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);

        // generamos el documento
        $this->generarReporte();

        // guardamos el documento
        $this->Documento->Output("F", TEMPORAL . "/sindeterminacion.pdf");

    }

    /**
     * Método llamado desde el constructor, que agrega al
     * documento los registros correspondientes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function generarReporte(){

        // agregamos los registros pendientes de pacientes
        $this->pendientesPacientes();

        // agregamos los registros pendientes de mascotas
        $this->pendientesMascotas();

    }

    /**
     * Método que agrega al documento los registros pendientes
     * de pacientes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function pendientesPacientes(){

        // obtenemos los registros pendientes
        $registros = $this->getPendientesPacientes();

        // si hay registros
        if (count($registros) > 0){

            // presenta el título
            $texto = "Muestras de pacientes aún no procesadas";
            $this->Documento->MultiCell(100, $this->Interlineado, $texto, 0);

            // definimos los encabezados de columna
            $this->Documento->Cell(10, $this->Interlineado, "Fecha", 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, "Paciente", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Documento", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Material", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Técnica", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Muestra", 0, 1);

            // recorremos el vector
            foreach($registros as $valor){

                // presentamos el registro
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $valor["paciente"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["documento"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["material"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["tecnica"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha_muestra"], 0, 1);
                
            }

        // si no hay registros pendientes
        } else {

            // presenta el mensaje
            $this->Documento->Cell(100, $this->Interlineado, "No hay muestras pendientes", 0, 1, "C");

        }

    }

    /**
     * Método que obtiene los registros pendientes de
     * muestras sin resultados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    protected function getPendientesPacientes() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.material AS material,
                            leishmania.v_pacientes.tecnica AS tecnica,
                            leishmania.v_pacientes.fecha_muestra AS fecha_muestra
                     FROM leishmania.v_pacientes
                     WHERE ISNULL(leishmania.v_pacientes.resultado) AND
                           NOT ISNULL(leishmania.v_pacientes.material)
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y),
                              leishmania.v_pacientes.nombre; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que agrega al documento los registros
     * pendientes de mascotas
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function pendientesMascotas(){

        // obtenemos los registros pendientes
        $registros = $this->getPendientesMascotas();

        // si hay registros
        if (count($registros) > 0){

            // presenta el título
            $texto = "Muestras de mascotas aún no procesadas";
            $this->Documento->MultiCell(100, $this->Interlineado, $texto, 0);

            // definimos los encabezados de columna
            $this->Documento->Cell(10, $this->Interlineado, "Fecha", 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, "Paciente", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Documento", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Mascota", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Material", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Técnica", 0, 0);
            $this->Documento->Cell(10, $this->Interlineado, "Muestra", 0, 1);

            // recorremos el vector
            foreach($registros as $valor){

                // presentamos el registro
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $valor["paciente"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["documento"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["mascota"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["material"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["tecnica"], 0, 0);
                $this->Documento->Cell(10, $this->Interlineado, $valor["fecha_muestra"], 0, 1);
                
            }

        // si no hay registros pendientes
        } else {

            // presenta el mensaje
            $this->Documento->Cell(100, $this->Interlineado, "No hay muestras pendientes", 0, 1, "C");

        }

    }

    /**
     * Método que obtiene los registros de las muestras
     * de mascotas sin determinación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    protected function getPendientesMascotas() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.mascota AS mascota,
                            leishmania.v_pacientes.materialmasc AS material,
                            leishmania.v_pacientes.tecnicamasc AS tecnica,
                            leishmania.v_pacientes.fechamuestramasc AS fecha_muestra
                     FROM leishmania.v_pacientes
                     WHERE ISNULL(leishmania.v_pacientes.resultadomasc) AND
                           NOT ISNULL(leishmania.v_pacientes.materialmasc)
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y),
                              leishmania.v_pacientes.nombre; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

}
