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
require_once "../actividades/actividades.class.php";
require_once "../viajes/viajes.class.php";
require_once "../evolucion/evolucion.class.php";
require_once "../control/control.class.php";
require_once "../peridomicilio/peridomicilio.class.php";
require_once "../mascotas/mascotas.class.php";
require_once "../muestrasmasc/muestrasmasc.class.php";
require_once "../sintmascotas/sintmascotas.class.php";

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
        $this->verificaActividades((int) $id);
        
        // verificamos si tiene viajes realizados 
        $this->verificaViajes((int) $id);

        // si hay datos de la evolución 
        $this->verificaEvolucion((int) $id);

        // si hay datos de control y seguimiento
        $this->verificaControl((int) $id);

        // si tiene mascotas (si tiene verifica la historia 
        // clínica de la mascota)
        $this->verificaMascotas((int) $id);

        // objetos y animales del peridomicilio 
        $this->verificaPeridomicilio((int) $id);

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
        if ($pacientes->getNacimiento() != '00/00/0000'){

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
        if (!empty(trim($pacientes->getAntecedentes()))){

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

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);
        
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
            if (!$this->Documento->hayLugar($this->Interlineado)){

                // agregamos una página y definimos los encabezados 
                $this->Documento->AddPage();
                $this->encabezadosMuestra();

            }

            // presentamos la determinación 
            $this->Documento->Cell(10, $this->Interlineado, $registro["id"], 0, 0);
            $this->Documento->Cell(35, $this->Interlineado, $registro["tecnica"], 0, 0);
            $this->Documento->Cell(35, $this->Interlineado, $registro["material"], 0, 0);
            $this->Documento->Cell(35, $this->Interlineado, $registro["fecha"], 0, 0);

            // si hay un resultado
            if (!empty($registro["resultado"])){
                $this->Documento->Cell(30, $this->Interlineado, $registro["determinacion"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $registro["resultado"], 0, 0);
                $this->Documento->Cell(35, $this->Interlineado, $registro["usuario"], 0, 1);
            } else {
                $this->Documento->Cell(95, $this->Interlineado, "Determinación Pendiente", 0, 1);
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
        $this->Documento->Cell(35, $this->Interlineado, "Ingreso", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Fecha", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Resultado", 0, 0);
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

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente
     * Método que recibe como parámetro la clave del paciente 
     * y verifica que el mismo tenga alguna actividad 
     * declarada, en cuyo caso la presenta
     */
    protected function verificaActividades(int $id) : void {

        // instanciamos la clase y obtenemos la nómina
        $actividades = new Actividades();
        $nomina = $actividades->nominaActividades((int) $id);

        // si no hay registros 
        if (count($nomina) == 0){
            return;
        }

        // de otra forma definimos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título
        $this->Documento->MultiCell(0, $this->Interlineado, "Actividades Realizadas por el Paciente"); 

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // presenta los encabezados
        $this->encabezadosActividad();

        // ahora recorremos los registros
        foreach($nomina as $registro){

            // verificamos si hay espacio
            if (!$this->Documento->hayLugar($this->Interlineado)){

                // agrega la página e imprime los encabezados
                $this->Documento->AddPage();
                $this->encabezadosActividad();

            }

            // presenta el registro
            $this->Documento->Cell(70, $this->Interlineado, $registro["lugar"], 0, 0);
            $this->Documento->Cell(70, $this->Interlineado, $registro["actividad"], 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, $registro["fecha"], 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, $registro["usuario"], 0, 1);

        }

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que agrega los encabezados de columna de las 
     * actividades del paciente
     */
    protected function encabezadosActividad() : void {

        // define los encabezados
        $this->Documento->Cell(70, $this->Interlineado, "Lugar", 0, 0);
        $this->Documento->Cell(70, $this->Interlineado, "Actividad", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Fecha", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Operador", 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente
     * Método que verifica si el paciente tiene viajes declarados
     * y en todo caso los presenta
     */
    protected function verificaViajes(int $id) : void {

        // instanciamos la clase y obtenemos la nómina
        $viajes = new Viajes();
        $nomina = $viajes->nominaViajes((int) $id);

        // si no hay registros 
        if (count($nomina) == 0){
            return;
        }

        // fijamos la fuente
        $this->Documento->setFont('DejaVu', 'B', $this->Fuente);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Viajes Realizados por el Paciente");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // presenta los encabezados 
        $this->encabezadosViajes();

        // recorremos el vector
        foreach($nomina as $registro){

            // verificamos si hay espacio 
            if (!$this->Documento->hayLugar($this->Interlineado)){

                // agregamos una página y presenta los encabezados
                $this->Documento->AddPage();
                $this->encabezadosViajes();

            }

            // presenta el registro
            $this->Documento->Cell(100, $this->Interlineado, $registro["lugar"], 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, $registro["fecha"], 0, 0);
            $this->Documento->Cell(30, $this->Interlineado, $registro["usuario"], 0, 1);

        }

        // insertamos un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que define los encabezados de columna de los viajes
     */
    protected function encabezadosViajes() : void {

        // define los encabezados 
        $this->Documento->Cell(100, $this->Interlineado, "Lugar", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Fecha", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Operador", 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente
     * Método que recibe como parámetro la clave de un paciente
     * y verifica si hay cargados datos de la evolución en cuyo 
     * caso los presenta
     */
    protected function verificaEvolucion(int $id){

        // instanciamos la clase y obtenemos el registro
        $evolucion = new Evolucion();
        $evolucion->getDatosEvolucion((int) $id);

        // si no hay registros 
        if ($evolucion->getId() == 0){
            return;
        }

        // seteamos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Evolución del Paciente");

        // setea la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // presenta la hospitalización 
        $this->Documento->Cell(0, $this->Interlineado, "Hospitalización: " . $evolucion->getHospitalizacion(), 0, 1);

        // si existe la fecha de alta
        if (!empty($evolucion->getFechaAlta())){
            $this->Documento->Cell(100, $this->Interlineado, "Fecha de Alta:" . $evolucion->getFechaAlta(), 0, 0);
        }

        // si existe la fecha de defunción 
        if (!empty($evolucion->getDefuncion())){
            $this->Documento->Cell(100, $this->Interlineado, "Fecha de Defunción:" . $evolucion->getDefuncion(), 0, 0);
        }

        // si presentó alguno de los dos anteriores
        if (!empty($evolucion->getFechaAlta()) || !empty($evolucion->getDefuncion())){

            // avanzamos una línea
            $this->Documento->Ln($this->Interlineado);

        }

        // si existe la condición final
        if (!empty($evolucion->getCondicion())){
            
            // obtenemos la longitud
            $longitud = $this->Documento->GetStringWidth("Condición Final: " . $evolucion->getCondicion());
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Condición Final: " . $evolucion->getCondicion(), 0, 0);

        }

        // si existe la clasificación 
        if (!empty($evolucion->getClasificacion())){
            $this->Documento->Cell(0, $this->Interlineado, "Clasificación: " . $evolucion->getClasificacion(), 0, 0);
        }

        // si presentó alguno de los dos anteriores
        if (!empty($evolucion->getCondicion()) || !empty($evolucion->getClasificacion())){

            // avanzamos una línea
            $this->Documento->Ln($this->Interlineado);

        }

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente 
     * Método que recibe la clave del paciente y verifica si 
     * este tiene datos de control, en cuyo caso los presenta
     */
    protected function verificaControl(int $id) : void {

        // instanciamos la clase y obtenemos el registro
        $control = new Control();
        $control->getDatosControl((int) $id);

        // si no hay registros 
        if ($control->getId() == 0) {
            return;
        }

        // verificamos si hay espacio
        if (!$this->Documento->hayLugar($this->Interlineado * 2)){
            $this->Documento->AddPage();
        }

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título
        $this->Documento->MultiCell(0, $this->Interlineado, "Datos de Control del Paciente");

        // setea la fuente
        $this->Documento->setfont('DejaVu', '', $this->Fuente);

        // presenta la fecha del control
        $this->Documento->Cell(0, $this->Interlineado, "Fecha del Control: " . $control->getFecha(), 0, 1);

        // presenta el tratamiento
        $longitud = $this->Documento->GetStringWidth("Tratamiento: " . $control->getTratamiento());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Tratamiento: " . $control->getTratamiento(), 0, 0);

        // la droga 
        $longitud = $this->Documento->GetStringWidth(("Droga: " . $control->getDroga()));
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Droga: " . $control->getDroga(), 0, 0);

        // la dosis 
        $this->Documento->Cell(0, $this->Interlineado, "Dosis: " . $control->getDosis() . " mg.", 0, 1);

        // si se exploraron contactos 
        $longitud = $this->Documento->GetStringWidth("Se exploraron contactos: " . $control->getContactos());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Se exploraron contactos: " . $control->getContactos(), 0, 0);

        // si se exploraron contactos
        if ($control->getContactos() == "Si"){

            // presenta el número de contactos 
            $longitud = $this->Documento->GetStringWidth("Nro. de Contactos: " . $control->getNroContactos());
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Nro. de Contactos: " . $control->getNroContactos(), 0, 0);

            // presenta los contactos positivos 
            $this->Documento->Cell(0, $this->Interlineado, "Contactos Positivos: " . $control->getContactosPos(), 0, 0);

        }

        // avanza de línea
        $this->Documento->Ln($this->Interlineado);

        // si se bloquearon viviendas
        $longitud = $this->Documento->GetStringWidth("Se bloquearon viviendas: " . $control->getBloqueo());
        $this->Documento->Cell($longitud + 5, $this->Interlineado, "Se bloquearon Viviendas: " . $control->getBloqueo(), 0, 0);

        // si se bloquearon, cuantas
        if ($control->getBloqueo() == "Si"){

            // presenta el número de viviendas
            $longitud = $this->Documento->GetStringWidth("Nro. Viviendas: " . $control->getNroViviendas(), 0, 0);
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Nro. Viviendas: " . $control->getNroViviendas(), 0, 0);
        }

        // si se exploraron sitios de riesgo
        $this->Documento->Cell(0, $this->Interlineado, "Sitios de Riesgo: " . $control->getSitiosRiesgo(), 0, 1);

        // si se utilizó insecticida
        if (!empty($control->getInsecticida())){

            // presenta el insecticida
            $longitud = $this->Documento->GetStringWidth("Insecticida Utilizado: " . $control->getInsecticida());
            $this->Documento->Cell($longitud + 5, $this->Interlineado, "Insecticida Utilizado: " . $control->getInsecticida(), 0, 0);

            // si se indica que cantidad
            $this->Documento->Cell(0, $this->Interlineado, "Cantidad: " . $control->getCantidadInsec(), 0, 1);

        // si no se utilizó 
        } else {

            // presenta el mensaje
            $this->Documento->Cell(0, $this->Interlineado, "No se utilizó insecticida", 0, 1);

        }

        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente
     * Método que recibe la clave del paciente y verifica si 
     * existen datos del peridomicilio en cuyo caso los 
     * presenta
     */
    protected function verificaPeridomicilio(int $id) : void {

        // instanciamos la clase y obtenemos los registros 
        $domicilio = new Peridomicilio();
        $nomina = $domicilio->nominaPeridomicilio((int) $id);

        // setea la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título
        $this->Documento->MultiCell(0, $this->Interlineado, "Datos del Peridomicilio");

        // seta la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // si no hay registros 
        if (count($nomina) == 0){
            $this->Documento->MultiCell(0, $this->Interlineado, "No se registran datos del peridomicilio");
        } else {

            // presenta los encabezados 
            $this->encabezadosPeridomicilio();

            // recorremos el vector
            foreach($nomina as $registro){

                // verificamos si hay lugar
                if (!$this->Documento->hayLugar($this->Interlineado)){

                    // inserta un salto de página 
                    $this->Documento->AddPage();

                    // los encabezados de columna 
                    $this->encabezadosPeridomicilio();

                }

                // presenta el registro 
                $this->Documento->Cell(70, $this->Interlineado, $registro["animal"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $registro["distancia"], 0, 0);
                $this->Documento->Cell(20, $this->Interlineado, $registro["cantidad"], 0, 0);
                $this->Documento->Cell(20, $this->Interlineado, $registro["usuario"], 0, 1);

            }

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta los encabezados de columna del
     * peridomicilio 
     */
    protected function encabezadosPeridomicilio() : void {

        // definimos las columnas
        $this->Documento->Cell(70, $this->Interlineado, "Animal u Objeto", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Distancia", 0, 0);
        $this->Documento->Cell(20, $this->Interlineado, "Cantidad", 0, 0);
        $this->Documento->Cell(20, $this->Interlineado, "Operador", 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del paciente
     * Método que recibe como parámetro la clave de un paciente
     * y verifica que el mismo tenga mascotas en cuyo caso 
     * las presenta
     */
    protected function verificaMascotas(int $id) : void {

        // instanciamos la clase y obtenemos la nómina
        $mascotas = new Mascotas();
        $nomina = $mascotas->nominaMascotas((int) $id);

        // fijamos la fuente
        $this->Documento->setFont('DejaVu', 'B', $this->Fuente);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Mascotas Declaradas");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // si no hay registros 
        if (count($nomina) == 0){

            // presenta el mensaje
            $this->Documento->MultiCell(0, $this->Interlineado, "El paciente no declara mascotas");

        // si hay mascotas
        } else {

            // presenta los encabezados 
            $this->encabezadosMascotas();

            // recorremos el vector 
            foreach($nomina as $registro){

                // verificamos si hay lugar
                if (!$this->Documento->hayLugar($this->Interlineado)){

                    // inserta una página 
                    $this->Documento->AddPage();

                    // presenta los encabezados 
                    $this->encabezadosMascotas();

                }

                // presenta el registro
                $this->Documento->Cell(70, $this->Interlineado, $registro["nombre"], 0, 0);
                $this->Documento->Cell(20, $this->Interlineado, $registro["edad"], 0, 0);
                $this->Documento->Cell(30, $this->Interlineado, $registro["origen"], 0, 0);
                $this->Documento->Cell(20, $this->Interlineado, $registro["usuario"], 0, 1);

            }

            // ahora llamamos los datos de las muestras de las mascotas
            // pasándole el array 
            $this->verMuestrasMascotas($nomina);

        }
     
        // inserta un separador
        $this->Documento->Ln($this->Interlineado);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta los encabezados de las mascotas
     */
    protected function encabezadosMascotas() : void {

        // definimos los encabezados 
        $this->Documento->Cell(70, $this->Interlineado, "Nombre", 0, 0);
        $this->Documento->Cell(20, $this->Interlineado, "Edad", 0, 0);
        $this->Documento->Cell(30, $this->Interlineado, "Origen", 0, 0);
        $this->Documento->Cell(20, $this->Interlineado, "Operador", 0, 1);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param array vector con las mascotas del paciente
     * Método que recibe como parámetro el vector con las 
     * mascotas del paciente y verifica que las mismas 
     * tengan muestras en cuyo caso las presenta
     */
    protected function verMuestrasMascotas(array $nomina){

        // instanciamos la clase
        $muestras = new MuestrasMasc();

        // insertamos un separador 
        $this->Documento->Ln($this->Interlineado);

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', 'B', $this->Fuente);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Muestras obtenidas de las mascotas");

        // fijamos la fuente
        $this->Documento->SetFont('DejaVu', '', $this->Fuente);

        // recorremos el vector 
        foreach($nomina as $registro){

            // verificamos si tiene muestras
            $listado = $muestras->nominaMuestras((int) $registro["id"]);

            // si no tiene muestras
            if (count($listado) == 0){

                // presenta el mensaje
                $this->Documento->MultiCell(0, $this->Interlineado, $registro["nombre"] . " No tiene muestras");

            // si hay resultados 
            } else {

                // inserta un separador
                $this->Documento->Ln($this->Interlineado);
                
                // presenta el título 
                $this->Documento->MultiCell(0, $this->Interlineado, "Muestras Obtenidas de " . $registro["nombre"]);

                // presenta los encabezados (que son los mismos que para 
                // las muestras de humanos)
                $this->encabezadosMuestra(); 

                // recorremos el vector 
                foreach($listado as $ejemplar){

                    // verificamos si hay espacio
                    if (!$this->Documento->hayLugar($this->Interlineado)){

                        // agrega una página y los encabezados
                        $this->Documento->AddPage();
                        $this->encabezadosMuestra();

                    }

                    // presenta el registro
                    $this->Documento->Cell(10, $this->Interlineado, $ejemplar["id"], 0, 0);
                    $this->Documento->Cell(35, $this->Interlineado, $ejemplar["tecnica"], 0, 0);
                    $this->Documento->Cell(35, $this->Interlineado, $ejemplar["material"], 0, 0);
                    $this->Documento->Cell(35, $this->Interlineado, $ejemplar["fecha"], 0, 0);

                    // si hay un resultado
                    if (!empty($ejemplar["resultado"])){
                        $this->Documento->Cell(30, $this->Interlineado, $ejemplar["determinacion"], 0, 0);
                        $this->Documento->Cell(30, $this->Interlineado, $ejemplar["resultado"], 0, 0);
                        $this->Documento->Cell(35, $this->Interlineado, $ejemplar["usuario"], 0, 1);
                    } else {
                        $this->Documento->Cell(95, $this->Interlineado, "Determinación Pendiente", 0, 1);
                    }

                }

                // luego de presentar los datos de las muestras de las 
                // mascotas verificamos si tiene datos clínicos
                $this->verificaClinicaMascota($registro);

            }

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param array vector con el registro de la mascota
     * Método que recibe como parámetro el registro de la tabla 
     * de mascotas y verifica si tiene antecedentes clínicos 
     * en cuyo caso los presenta
     */
    protected function verificaClinicaMascota(array $registro) : void {

        // instanciamos la clase y obtenemos el registro
        $mascota = new SintMascotas();
        $mascota->getDatosSintomas((int) $registro["id"]);

        // fijamos la fuente
        $this->Documento->setFont('DejaVu', 'B', $this->Fuente);

        // insertamos un salto
        $this->Documento->Ln($this->Interlineado);

        // presenta el título 
        $this->Documento->MultiCell(0, $this->Interlineado, "Antecedentes Clínicos de " . $registro["nombre"]);

        // setea la fuente
        $this->Documento->setFont('DejaVu', '', $this->Fuente);

        // si no hay registros 
        if ($mascota->getId() == 0){

            // presenta el texto 
            $this->Documento->MultiCell(0, $this->Interlineado, "No hay antecedentes de " . $registro["nombre"]);

        // si hay un registro activo
        } else {

            // presenta los datos en un esquema de cuatro columnas(por cada sección vamos 
            // a verificar primero si tiene espacio porque no sabemos a ciencia cierta 
            // la posición del cabezal de impresión)

            // verificamos el espacio
            if (!$this->Documento->hayLugar($this->Interlineado)){
                $this->Documento->AddPage();
            }

            // la condición general 
            $this->Documento->MultiCell(0, $this->Interlineado, "Condición General");
            $this->Documento->Cell(40, $this->Interlineado, "Anorexia: " . $mascota->getAnorexia(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Adinamia: " . $mascota->getAdinamia(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Emaciación: " . $mascota->getEmaciacion(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Polidipsia: " . $mascota->getPolidipsia(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

            // verifica el espacio
            if (!$this->Documento->hayLugar($this->Interlineado * 2)){
                $this->Documento->AddPage();
            }

            // los antecedentes neuromusculares
            $this->Documento->MultiCell(0, $this->Interlineado, "Antecedentes Neuromusculares");
            $this->Documento->Cell(40, $this->Interlineado, "Atrofia Musc: " . $mascota->getAtrofia(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Paresia: " . $mascota->getParesia(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Convulsiones: " . $mascota->getConvulsiones(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

            // verifica el espacio
            if (!$this->Documento->hayLugar($this->Interlineado * 2)){
                $this->Documento->AddPage();
            }

            // los antecedentes oftalmológicos
            $this->Documento->MultiCell(0, $this->Interlineado, "Antecedentes Oftalmológicos");
            $this->Documento->Cell(40, $this->Interlineado, "Blefaritis: " . $mascota->getBlefaritis(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Conjuntivitis: " . $mascota->getConjuntivitis(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Queratitis: " . $mascota->getQueratitis(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Uveitis: " . $mascota->getUveitis(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

            // verifica el espacio
            if (!$this->Documento->hayLugar($this->Interlineado * 3)){
                $this->Documento->AddPage();
            }

            // las mucosas
            $this->Documento->MultiCell(0, $this->Interlineado, "Mucosas");
            $this->Documento->Cell(40, $this->Interlineado, "Palidez: " . $mascota->getPalidez(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Epistaxis: " . $mascota->getEpistaxis(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Ulceras: " . $mascota->getUlceras(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Nódulos: " . $mascota->getNodulos(), 0, 1);
            $this->Documento->Cell(40, $this->Interlineado, "Vómitos: " . $mascota->getVomitos(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Diarrea: " . $mascota->getDiarrea(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

            // verifica el espacio
            if (!$this->Documento->hayLugar($this->Interlineado * 3)){
                $this->Documento->AddPage();
            }

            // antecedentes cutáneos
            $this->Documento->MultiCell(0, $this->Interlineado, "Antecedentes Cutáneos");
            $this->Documento->Cell(40, $this->Interlineado, "Eritema: " . $mascota->getEritema(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Prurito: " . $mascota->getPrurito(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Ulcera: " . $mascota->getUlceraCutanea(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Nódulos: " . $mascota->getNodulosCutaneos(), 0, 1);
            $this->Documento->Cell(40, $this->Interlineado, "Alopecía Loc.: " . $mascota->getAlopeciaLocalizada(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Alopecía Gen.: " . $mascota->getAlopeciaGeneralizada(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Hiperqueratosis Nasal: " . $mascota->getHiperqueratosisN(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Hiperqueratosis Plantar: " . $mascota->getHiperqueratosisP(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

            // verifica el espacio
            if (!$this->Documento->hayLugar($this->Interlineado * 5)){
                $this->Documento->AddPage();
            }

            // otros
            $this->Documento->MultiCell(0, $this->Interlineado, "Otros Antecedentes");
            $this->Documento->Cell(40, $this->Interlineado, "Caso Humano: " . $mascota->getCasoHumano(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Flebótomos: " . $mascota->getFlebotomos(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Casa Trampeada: " . $mascota->getCasaTrampeada(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Materia Orgánica: " . $mascota->getMateriaOrganica(), 0, 1);
            $this->Documento->Cell(40, $this->Interlineado, "Fumigación: " . $mascota->getFumigacion(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Repelentes: " . $mascota->getRepelentes(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Frecuencia: " . $mascota->getPeriodicidad(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Donde Duerme: " . $mascota->getDuerme(), 0, 1);
            $this->Documento->Cell(40, $this->Interlineado, "Queda Suelto: " . $mascota->getQuedaLibre(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Adenomegalia: " . $mascota->getAdenomegalia(), 0, 0);
            $this->Documento->Cell(50, $this->Interlineado, "Artritis: " . $mascota->getArtritis(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Onicogrifosis: " . $mascota->getOnicogrifosis(), 0, 1);
            $this->Documento->Cell(40, $this->Interlineado, "Seborrea Grasa: " . $mascota->getSeborreaGrasa(), 0, 0);
            $this->Documento->Cell(40, $this->Interlineado, "Seborrea Escamosa: " . $mascota->getSeborreaEscamosa(), 0, 1);

            // inserta un separador
            $this->Documento->Ln($this->Interlineado);

        }

    }

}
