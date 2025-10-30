<?php

/**
 *
 * informes/historia.class.php
 *
 * @package     Leishmania
 * @subpackage  Informes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.5.0 (30/10/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
*/

// declaramos el tipeado estricto
declare(strict_types=1);

// incluimos los archivos
require_once "paginas.class.php";
require_once "../pacientes/pacientes.class.php";
require_once "../muestras/muestras.class.php";
require_once "../clinica/clinica.class.php";

// leemos el archivo de configuración
$config = parse_ini_file("../clases/config.ini");

// define la ruta a las fuentes pdf
define('FPDF_FONTPATH', $config["Fuentes"]);
define('TEMP', $config["Temp"]);

// convención para la nomenclatura de las propiedades, comienzan con una
// letra mayúscula, de tener mas de una palabra no se utilizan separadores
// y la inicial de cada palabra va en mayúscula
// para las variables recibidas como parámetro el criterio es todas en
// minúscula

// convención para la nomenclatura de los metodos, comienzan con set o get
// según asignen un valor o lo lean y luego el nombre del valor a obtener

/**
 * Clase que genera el documento pdf con la historia clínica
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Historia{

    // definimos las variables 
    protected $Documento;             // el documento pdf
    protected $Interlineado;          // el interlineado 
    protected $Fuente;                // el tamaño de la fuente

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $id - clave del paciente 
     * Constructor de la clase, recibe como parámetro la clave 
     * del paciente, instancia los objetos y genera el 
     * documento pdf con toda la historia clínica del paciente
     */
    public function __construct(int $id){
    
        // inicializamos el interlineado y el tamaño de la fuente
        $this->Interlineado = 7;
        $this->Fuente = 12;

        // instanciamos el documento
        $this->Documento = new Paginas('P', 'mm');

        // agrega una fuente unicode
        $this->Documento->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->Documento->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);

        // fijamos las propiedades
        $this->Documento->SetAuthor("Claudio Invernizzi");
        $this->Documento->SetCreator("Instituto Nacional de Parasitología");
        $this->Documento->SetDisplayMode("fullpage", "single");
        $this->Documento->SetSubject("Departamento de Diagnóstico", true);
        $this->Documento->SetTitle("Historias Clínicas de Leishmaniasis", true);
        $this->Documento->SetAutoPageBreak(true);
        $this->Documento->AliasNbPages();

        // presentamos los datos de filiación 
        $this->getDatosFiliacion((int) $id);

        // verificamos si tiene muestras 
        $this->verificaMuestras((int) $id);

        // verificamos si tiene datos clínicos
        $this->verificaClinica((int) $id);

        // verificamos si tiene actividades
        
        // verificamos si tiene viajes realizados 

        // si hay datos de la evolución 

        // si hay datos de control y seguimiento

        // si tiene mascotas (si tiene verifica la historia 
        // clínica de la mascota)

        // objetos y animales del peridomicilio 

        // guardamos el documento
        $this->Documento->Output("F", TEMP . "/historia.pdf");

    }
    
    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $id - clave del paciente 
     * Método que recibe como parámetro la clave del paciente y 
     * obtiene y presenta los datos de filiación del mismo 
     * (puede ser el paciente o el tutor en caso de recibir 
     * la muestra de un animal)
     */
    protected function getDatosFiliacion(int $id) : void {

        // instanciamos la clase y obtenemos el registro
        $pacientes = new Pacientes();
        $pacientes->getDatosPaciente((int) $id);

        // agregamos la página
        $this->Documento->AddPage('P');

        // definimos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título
        $this->Documento->MultiCell(0, $this->Interlineado, "Datos de Filiación");

        // setea la fuente
        $this->Documento->setFont('Dejavu', '', $this->Fuente);

        // presentamos el registro 
        $this->Documento->Cell(20, $this->Interlineado, "Id: " . $pacientes->getId(), 0, 0);

        // obtenemos la longitud
        $longitud = $this->Documento->GetStringWidth("Nombre: " . $pacientes->getNombre());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Nombre: " . $pacientes->getNombre(), 0, 0);
        
        // si tiene tipo y número de documento
        if (!empty($pacientes->getDocumento())){

            // obtenemos la longitud
            $longitud = $this->Documento->GetStringWidth($pacientes->getTipoDoc() . " " . $pacientes->getDocumento());
        
            // lo presenta
            $this->Documento->Cell($longitud + 5, $this->Interlineado, $pacientes->getTipoDoc() . " " . $pacientes->getDocumento(), 0, 0);

        }

        // agregamos el sexo
        $this->Documento->Cell(0, $this->Interlineado, "Sexo: " . $pacientes->getSexo(), 0, 1);

        // si tiene fecha de nacimiento
        if (!$pacientes->getNacimiento() != '00/00/0000'){

            // la presenta 
            $this->Documento->Cell(30, $this->Interlineado, "Nacimiento: " . $pacientes->getNacimiento(), 0, 1);

        }

        // si existe la nacionalidad
        if (!empty($pacientes->getNacionalidad())){

            // lo presenta
            $this->Documento->Cell(50, $this->Interlineado, "Nacionalidad: " . $pacientes->getNacionalidad(), 0, 1);

        }

        // si existe la provincia
        if (!empty($pacientes->getProvincia())){

            // lo presenta 
            $this->Documento->Cell(50, $this->Interlineado, "Provincia: " . $pacientes->getProvincia(), 0, 1);
            
        }

        // si existe la localidad
        if (!empty($pacientes->getLocalidad())){

            // lo presenta 
            $this->Documento->Cell(50, $this->Interlineado, "Localidad: " . $pacientes->getLocalidad(), 0, 1);

        }

        // si declaró la dirección 
        if (!empty($pacientes->getDomicilio())){

            // obtenemos la longitud
            $longitud = $this->Documento->GetStringWidth("Domicilio: " . $pacientes->getDomicilio());

            // lo presenta 
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Domicilio: " . $pacientes->getDomicilio(), 0, 0);

        }

        // agregamos el tipo de domicilio
        $this->Documento->Cell(20, $this->Interlineado, "Tipo: " . $pacientes->getUrbano(), 0, 1);

        // si tenemos el teléfono 
        if (!empty($pacientes->getTelefono())){

            // lo presenta
            $this->Documento->Cell(20, $this->Interlineado, "Teléfono: " . $pacientes->getTelefono(), 0, 0);

        }

        // presenta la ocupación 
        $this->Documento->Cell(0, $this->Interlineado, "Ocupación: " . $pacientes->getOcupacion(), 0, 1);

        // si existen antecedentes
        if (!empty(strip_tags($pacientes->getAntecedentes()))){

            // presenta los antecedentes
            $this->Documento->MultiCell(0, $this->Interlineado, strip_tags($pacientes->getAntecedentes()));

        }

        // ahora insertamos un separador
        $this->Documento->Ln($this->Interlineado);

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Datos de la Institución Denunciante");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // presenta el nombre de la institución 
        $this->Documento->MultiCell(0, $this->Interlineado, "Institución: " . $pacientes->getInstitucion());

        // presenta la provincia y la localidad
        $longitud = $this->Documento->GetStringWidth("Provincia: " . $pacientes->getProvInstitucion());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Provincia: " . $pacientes->getProvInstitucion(), 0, 0);
        $this->Documento->Cell(0, $this->Interlineado, "Localidad: " . $pacientes->getLocInstitucion(), 0, 1);

        // presenta el profesional
        $longitud = $this->Documento->GetStringWidth("Profesional: " . $pacientes->getEnviado());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Profesional: " . $pacientes->getEnviado(), 0, 0);

        // si declaró teléfono 
        if (!empty($pacientes->getTelefono())){

            // obtenemos la longitud y presentamos
            $longitud = $this->Documento->GetStringWidth("Telefono: " .  $pacientes->getTelefono());
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Teléfono: " . $pacientes->getTelefono(), 0, 0);

        }

        // si declaró el mail 
        if (!empty($pacientes->getMail())){

            // lo presenta
            $this->Documento->Cell(0, $this->Interlineado, "Mail: " . $pacientes->getMail(), 0, 1);

        }

        // si existe la denuncia
        if (!empty($pacientes->getSisa())){

            // presenta la fecha de denuncia y la clave
            $longitud = $this->Documento->GetStringWidth("Fecha Denuncia: " . $pacientes->getNotificado());
            $this->Documento->Cell($longitud, $this->Interlineado, "Fecha Denuncia: " . $pacientes->getNotificado(), 0, 0);
            $this->Documento->Cell(0, $this->Interlineado, "Clave Sisa: " . $pacientes->getSisa(), 0, 1);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $id - clave del paciente
     * Método que recibe la clave del paciente y presenta las 
     * muestras tomadas al mismo
     */
    protected function verificaMuestras(int $id) : void {

        // instanciamos la clase
        $muestras = new Muestras();
        $nomina = $muestras->nominaMuestras((int) $id);

        // si no hay registros 
        if (count($nomina) == 0){
            return;
        }

        // insertamos un separador
        $this->Documento->Ln($this->Interlineado);

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // definimos el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Muestras Recibidas del Paciente");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // definimos los encabezados 
        $this->encabezadosMuestra();

        // recorremos el vector 
        foreach($nomina as $registro){

            // verificamos si hay espacio
            if (!$this->hayLugar($this->Interlineado)){

                // agregamos una página y definimos los encabezados 
                $this->Documento->AddPage();
                $this->encabezadosMuestra();

            }

            // presentamos la determinación 
            $this->Documento->Cell(10, $this->Interlineado, $registro["id"], 0, 0);
            $this->Documento->Cell(35, $this->Interlineado, $registro["tecnica"], 0, 0);
            $this->Documento->Cell(35, $this->Interlineado, $registro["material"], 0, 0);

            // si hay un resultado
            if (!empty($registro["resultado"])){
                $this->Documento->Cell(30, $this->Interlineado, $registro["determinacion"], 0, 0);
                $this->Documento->Cell(35, $this->Interlineado, $registro["resultado"], 0, 0);
                $this->Documento->Cell(35, $this->Interlineado, $registro["usuario"], 0, 1);
            } else {
                $this->Documento->Cell(90, $this->Interlineado, "Determinación Pendiente", 0, 1);
            }

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que genera los encabezados de la tabla de 
     * muestras recibidas del paciente
     */
    protected function encabezadosMuestra() : void {

        // definimos los encabezados 
        $this->Documento->Cell(10, $this->Interlineado, "ID", 0, 0);
        $this->Documento->Cell(35, $this->Interlineado, "Técnica", 0, 0);
        $this->Documento->Cell(35, $this->Interlineado, "Material", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Fecha", 0, 0);
        $this->Documento->Cell(35, $this->Interlineado, "Resultado", 0, 0);
        $this->Documento->Cell(35, $this->Interlineado, "Operador", 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $id - clave del paciente
     * Método que recibe como parámetro la clave de un paciente
     * y presenta (en caso de tener) los datos clínicos
     */
    protected function verificaClinica(int $id) : void {

        // instanciamos la clase y obtenemos el registro
        $clinica = new Clinica();
        $clinica->getDatosClinica((int) $id);

        // verificamos si hay un registro
        if ($clinica->getId() == 0){
            return;
        }

        // inserta un salto de página
        $this->Documento->AddPage();

        // fijamos la fuente
        $this->Documento->setFont('DejaVu', 'B', $this->Fuente);

        // presenta el título
        $this->Documento->MultiCell(0, $this->Interlineado, "Datos Clínicos del Paciente");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // presenta la leishmaniasis tegumentaria
        $this->Documento->MultiCell(0, $this->Interlineado, "Leishmaniasis Tegumentaria");

        // presentamos en tres columnas
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Cutánea Unica: " . $clinica->getCutaneaUnica(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Cutánea Múltiple: " . $clinica->getCutaneaMultiple(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Mucosa Nasal: " . $clinica->getMucosaNasal(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Bucofaringea: " . $clinica->getBucofaringea(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Laringea: " . $clinica->getLaringea(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Ulceras: " . $clinica->getUlcera(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Cicatrices: " . $clinica->getCicatriz(), 0, 1);

        // insertamos un separador
        $this->Documento->Ln($this->Interlineado);

        // presenta la leishmaniasis visceral
        $this->Documento->Multicell(0, $this->Interlineado, "Leishmaniasis Visceral");

        // presentamos también en tres columnas
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Visceral: " . $clinica->getVisceral(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Fiebre: " . $clinica->getFiebre(), 0, 0);

        // si presenta fiebre
        if ($clinica->getFiebre() == "Si"){

            // presenta la fecha y el tipo
            $this->Documento->Cell(35, $this->Interlineado, "Inicio: " . $clinica->getInicio(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Tipo: " . $clinica->getCaracteristicas(), 0, 1);

        // si no hay fiebre avanzamos a la siguiente línea
        } else {
            $this->Documento->Ln($this->Interlineado);
        }

        // sigue presentando
        $this->Documento->Cell(60, $this->Interlineado, "Edema: " . $clinica->getEdema(), 0, 0);        
        $this->Documento->Cell(60, $this->Interlineado, "Vómitos: " . $clinica->getVomitos(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Diarrea: " . $clinica->getDiarrea(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Pérdida de Peso: " . $clinica->getPerdidaPeso(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Fatiga: " . $clinica->getFatiga(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Debilidad: " . $clinica->getDebilidad(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Hepatoesplenomegalia: " . $clinica->getHepatoEspleno(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Linfadenopatía: " . $clinica->getLinfadenopaTia(), 0, 1);

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

        // presenta los síntomas comunes
        $this->Documento->MultiCell(0, $this->Interlineado, "Síntomas Comunes");

        // seguimos con tres columnas
        $this->Documento->Cell(60, $this->Interlineado, "Nódulos: " . $clinica->getNodulo(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Piel Gris: " . $clinica->getPielGris(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Piel Escamosa: " . $clinica->getEscamosa(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Petequias: " . $clinica->getPetequias(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Adenomegalia: " . $clinica->getAdenomegalia(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Lesión Mucosa: " . $clinica->getLesionMucosa(), 0, 1);
        $this->Documento->Cell(60, $this->Interlineado, "Tos Seca: " . $clinica->getTosSeca(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Périda de Cabello: " . $clinica->getCabello(), 0, 0);
        $this->Documento->Cell(60, $this->Interlineado, "Operador: " . $clinica->getUsuario(), 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int espacio que ocupa el texto a imprimir
     * @return boolean verdadero si hay lugar 
     * Método que recibe como parámetro el alto del texto a 
     * imprimir y retorna verdadero si hay espacio en la 
     * página para el mismo
     */
    protected function hayLugar(int $tamanio) : bool {

        // obtenemos el tamaño de la página y le 
        // descontamos el pié de página 
        $pagina = (int) $this->Documento->GetPageHeight() - 15;

        // obtenemos la posición actual del cabezal
        $posicion = (int) $this->Documento->GetY();

        // verifica si hay espacio
        if ($posicion + $tamanio < $pagina){
            return true;
        } else {
            return false;
        }

    }

}
