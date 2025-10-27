<?php

/**
 *
 * Class Clinica | clinica/clinica.class.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (16/05/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm de los datos clínicos
 * del paciente
 *
*/

// declaramos el tipeo estricto
declare (strict_types=1);

// inclusión de archivos
require_once "../clases/conexion.class.php";

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
class Clinica {

    // definición de las variables de clase
    protected $Link;            // puntero a la base de datos
    protected $Id;              // clave del registro
    protected $Paciente;        // clave del paciente
    protected $CutaneaUnica;    // lesión cutánea única
    protected $CutaneaMultiple; // lesión cutánea múltiple
    protected $MucosaNasal;     // lesión mucosa nasal
    protected $Bucofaringea;    // lesión bucofaringea
    protected $Laringea;        // lesión laringea
    protected $Visceral;        // lesión visceral
    protected $Fiebre;          // si presenta fiebre
    protected $Inicio;          // fecha de inicio de la fiebre
    protected $Caracteristicas; // características de la fiebre (diurna / nocturna)
    protected $Fatiga;          // si presenta fatiga
    protected $Debilidad;       // si presenta debilidad
    protected $Vomitos;         // si presenta vómitos
    protected $Diarrea;         // si presenta diarrega
    protected $TosSeca;         // si presenta tos seca
    protected $PielGris;        // si presenta piel gris
    protected $Edema;           // si presenta edema
    protected $Escamosa;        // si la piel es escamosa
    protected $Petequias;       // si presenta petequias
    protected $Cabello;         // si presenta debilidad o pérdida de cabello
    protected $Adenomegalia;    // si presenta adenomegalia
    protected $HepatoEspleno;   // hepatoesplenomegalia
    protected $Linfadenopatia;  // si tiene
    protected $PerdidaPeso;     // si ha habido pérdida de peso
    protected $Nodulo;          // si presenta nódulos
    protected $Ulcera;          // si presenta úlceras
    protected $Cicatriz;        // si presenta cicatriz
    protected $LesionMucosa;    // si presenta lesión mucosa
    protected $Alta;            // fecha de alta del registro
    protected $Modificado;      // fecha de modificación del registro
    protected $Usuario;         // nombre del usuario
    protected $IdUsuario;       // clave del usuario
    
    /**
     * Constructor de la clase, instanciamos la conexión
     * e inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // establecemos el puntero
        $this->Link = new Conexion();
     
        // inicializamos las variables
        $this->Id = 0;
        $this->Paciente = 0;
        $this->CutaneaUnica = "No";
        $this->CutaneaMultiple = "No";
        $this->MucosaNasal = "No";
        $this->Bucofaringea = "No";
        $this->Laringea = "No";
        $this->Visceral = "No";
        $this->Fiebre = "No";
        $this->Inicio = "";
        $this->Caracteristicas = "";
        $this->Fatiga = "No";
        $this->Debilidad = "No";
        $this->Vomitos = "No";
        $this->Diarrea = "No";
        $this->TosSeca = "No";
        $this->PielGris = "No";
        $this->Edema = "No";
        $this->Escamosa = "No";
        $this->Petequias = "No";
        $this->Cabello = "No";
        $this->Adenomegalia = "No";
        $this->HepatoEspleno = "No";
        $this->Linfadenopatia = "No";
        $this->PerdidaPeso = "No";
        $this->Nodulo = "No";
        $this->Ulcera = "No";
        $this->Cicatriz = "No";
        $this->LesionMucosa = "No";
        $this->Alta = date('d/m/Y');
        $this->Modificado = date('d/m/Y');
        $this->Usuario = "";
        $this->IdUsuario = 0;

    }
    
    /*
     * Destructor de la clase, eliminamos los punteros
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // elñiminamos el puntero
        $this->Link = null;

    }
    
    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setCutaneaUnica(string $cutanea) : void {
        $this->CutaneaUnica = $cutanea;
    }
    public function setCutaneaMultiple(string $cutanea) : void {
        $this->CutaneaMultiple = $cutanea;
    }
    public function setMucosaNasal(string $mucosa) : void {
        $this->MucosaNasal = $mucosa;
    }
    public function setBucoFaringea(string $bucofaringea) : void {
        $this->Bucofaringea = $bucofaringea;
    }
    public function setLaringea(string $laringea) : void {
        $this->Laringea = $laringea;
    }
    public function setVisceral(string $visceral) : void {
        $this->Visceral = $visceral;
    }
    public function setFiebre(string $fiebre) : void {
        $this->Fiebre = $fiebre;
    }
    public function setInicio(string $inicio) : void {
        $this->Inicio = $inicio;
    }
    public function setCaracteristicas(string $caracteristicas) : void {
        $this->Caracteristicas = $caracteristicas;
    }
    public function setFatiga(string $fatiga) : void {
        $this->Fatiga = $fatiga;
    }
    public function setDebilidad(string $debilidad) : void {
        $this->Debilidad = $debilidad;
    }
    public function setVomitos(string $vomitos) : void {
        $this->Vomitos = $vomitos;
    }
    public function setDiarrea(string $diarrea) : void {
        $this->Diarrea = $diarrea;
    }
    public function setTosSeca(string $tos) : void {
        $this->TosSeca = $tos;
    }
    public function setPielGris(string $pielgris) : void {
        $this->PielGris = $pielgris;
    }
    public function setEdema(string $edema) : void {
        $this->Edema = $edema;
    }
    public function setEscamosa(string $escamosa) : void {
        $this->Escamosa = $escamosa;
    }
    public function setPetequias(string $petequias) : void {
        $this->Petequias = $petequias;
    }
    public function setCabello(string $cabello) : void {
        $this->Cabello = $cabello;
    }
    public function setAdenomegalia(string $adenomegalia) : void {
        $this->Adenomegalia = $adenomegalia;
    }
    public function setHepatoEspleno(string $hepatoespleno) : void {
        $this->HepatoEspleno = $hepatoespleno;
    }
    public function setLinfadenopatia(string $linfa) : void {
        $this->Linfadenopatia = $linfa;
    }
    public function setPerdidaPeso(string $perdidapeso) : void {
        $this->PerdidaPeso = $perdidapeso;
    }
    public function setNodulo(string $nodulo) : void {
        $this->Nodulo = $nodulo;
    }
    public function setUlcera(string $ulcera) :void {
        $this->Ulcera = $ulcera;
    }
    public function setCicatriz(string $cicatriz) : void {
        $this->Cicatriz = $cicatriz;
    }
    public function setLesionMucosa(string $lesion) : void {
        $this->LesionMucosa = $lesion;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }
    
    // métodos de retorno de valores tener en cuenta que
    // si está dando de alta un paciente, estos valores
    // pueden ser todos nulos por eso los inicializamos
    // a No
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getCutaneaUnica() : string {
        return $this->CutaneaUnica;
    }
    public function getCutaneaMultiple() : string {
        return $this->CutaneaMultiple;
    }
    public function getMucosaNasal() : string {
        return $this->MucosaNasal;
    }
    public function getBucofaringea() : string {
        return $this->Bucofaringea;
    }
    public function getLaringea() : string {
        return $this->Laringea;
    }
    public function getVisceral() : string {
        return $this->Visceral;
    }
    public function getFiebre() : string {
        return $this->Fiebre;
    }
    public function getInicio() : ?string {
        return $this->Inicio;
    }
    public function getCaracteristicas() : ?string {
        return $this->Caracteristicas;
    }
    public function getFatiga() : string {
        return $this->Fatiga;
    }
    public function getDebilidad() : string {
        return $this->Debilidad;
    }
    public function getVomitos() : string {
        return $this->Vomitos;
    }
    public function getDiarrea() : string {
        return $this->Diarrea;
    }
    public function getTosSeca() : string {
        return $this->TosSeca;
    }
    public function getPielGris() : string {
        return $this->PielGris;
    }
    public function getEdema() : string {
        return $this->Edema;
    }
    public function getEscamosa() : string {
        return $this->Escamosa;
    }
    public function getPetequias() : string {
        return $this->Petequias;
    }
    public function getCabello() : string {
        return $this->Cabello;
    }
    public function getAdenomegalia() : string {
        return $this->Adenomegalia;
    }
    public function getHepatoEspleno() : string {
        return $this->HepatoEspleno;
    }
    public function getLinfadenopaTia() : string {
        return $this->Linfadenopatia;
    }
    public function getPerdidaPeso() : string  {
        return $this->PerdidaPeso;
    }
    public function getNodulo() : string {
        return $this->Nodulo;
    }
    public function getUlcera() : string {
        return $this->Ulcera;
    }
    public function getCicatriz() : string {
        return $this->Cicatriz;
    }
    public function getLesionMucosa() : string {
        return $this->LesionMucosa;
    }
    public function getAlta() : string {
        return $this->Alta;
    }
    public function getModificado() : string {
        return $this->Modificado;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    
    /**
     * Método que recibe como parámetro la clave de
     * un registro y asigna los valores del mismo
     * en las variables de clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $idpaciente clave del paciente
     * @return [bool] resultado de la operación
     */
    public function getDatosClinica(int $idpaciente) : bool {
        
        // componemos la consulta
        $consulta = "SELECT leishmania.v_clinica.id AS id,
                            leishmania.v_clinica.idpaciente AS paciente,
                            leishmania.v_clinica.cutaneaunica AS cutaneaunica,
                            leishmania.v_clinica.cutaneamultiple AS cutaneamultiple,
                            leishmania.v_clinica.mucosanasal AS mucosanasal,
                            leishmania.v_clinica.bucofaringea AS bucofaringea,
                            leishmania.v_clinica.laringea AS laringea,
                            leishmania.v_clinica.visceral AS visceral,
                            leishmania.v_clinica.fiebre AS fiebre,
                            leishmania.v_clinica.inicio AS inicio,
                            leishmania.v_clinica.caracteristicas AS caracteristicas,
                            leishmania.v_clinica.fatiga AS fatiga,
                            leishmania.v_clinica.debilidad AS debilidad,
                            leishmania.v_clinica.vomitos AS vomitos,
                            leishmania.v_clinica.diarrea AS diarrea,
                            leishmania.v_clinica.tosseca AS tosseca,
                            leishmania.v_clinica.pielgris AS pielgris,
                            leishmania.v_clinica.escamosa AS escamosa,
                            leishmania.v_clinica.petequias As petequias,
                            leishmania.v_clinica.cabello As cabello,
                            leishmania.v_clinica.adenomegalia AS adenomegalia,
                            leishmania.v_clinica.hepatoesplenomegalia AS hepatoesplenomegalia,
                            leishmania.v_clinica.linfadenopatia AS linfadenopatia,
                            leishmania.v_clinica.perdidapeso AS perdidapeso,
                            leishmania.v_clinica.nodulo AS nodulo,
                            leishmania.v_clinica.ulcera AS ulcera,
                            leishmania.v_clinica.cicatriz AS cicatriz,
                            leishmania.v_clinica.lesionmucosa AS lesionmucosa,
                            leishmania.v_clinica.alta AS alta,
                            leishmania.v_clinica.modificado AS modificado,
                            leishmania.v_clinica.usuario AS usuario
                     FROM leishmania.v_clinica
                     WHERE leishmania.v_clinica.idpaciente = '$idpaciente'; ";

        // capturamos el error
        try {

            // obtenemos el registro y asignamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // verificamos ya que puede retornar nulo
            if ($fila){

                // asignamos en la clase
                $this->Id = $fila["id"];
                $this->Paciente = $fila["paciente"];
                $this->CutaneaUnica = $fila["cutaneaunica"];
                $this->CutaneaMultiple = $fila["cutaneamultiple"];
                $this->MucosaNasal = $fila["mucosaNasal"];
                $this->Bucofaringea = $fila["bucofaringea"];
                $this->Laringea = $fila["laringea"];
                $this->Visceral = $fila["visceral"];
                $this->Fiebre = $fila["fiebre"];
                $this->Inicio = $fila["inicio"];
                $this->Caracteristicas = $fila["caracteristicas"];
                $this->Fatiga = $fila["fatiga"];
                $this->Debilidad = $fila["debilidad"];
                $this->Vomitos = $fila["vomitos"];
                $this->Diarrea = $fila["diarrea"];
                $this->TosSeca = $fila["tosseca"];
                $this->PielGris = $fila["pielgris"];
                $this->Edema = $fila["edema"];
                $this->Escamosa = $fila["escamosa"];
                $this->Petequias = $fila["petequias"];
                $this->Cabello = $fila["cabello"];
                $this->Adenomegalia = $fila["adenomegalia"];
                $this->HepatoEspleno = $fila["hepatoesplenomegalia"];
                $this->Linfadenopatia = $fila["linfadenopatia"];
                $this->PerdidaPeso = $fila["perdidapeso"];
                $this->Nodulo = $fila["nodulo"];
                $this->Ulcera = $fila["ulceara"];
                $this->Cicatriz = $fila["cicatriz"];
                $this->LesionMucosa = $fila["lesionmucosa"];
                $this->Alta = $fila["alta"];
                $this->Modificado = $fila["modifiado"];
                $this->Usuario = $fila["usuario"];

            }

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }
    
    /**
     * Método que retorna la nómina completa de datos
     * clínicos de un paciente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $paciente - clave del paciente
     * @return [array] vector con los registros
     */
    public function nominaClinica(int $paciente) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_clinica.id AS id,
                            leishmania.v_clinica.idpaciente AS paciente,
                            leishmania.v_clinica.mucosaunica AS mucosaunica,
                            leishmania.v_clinica.visceral AS visceral,
                            leishmania.v_clinica.fiebre AS fiebre,
                            leishmania.v_clinica.hepatoesplenomegalia AS hepatoesplenomegalia,
                            leishmania.v_clinica.linfadenopatia AS linfadenopatia,
                            leishmania.v_clinica.perdidapeso AS perdidapeso,
                            leishmania.v_clinica.nodulo AS nodulo,
                            leishmania.v_clinica.ulcera AS ulcera,
                            leishmania.v_clinica.cicatriz AS cicatriz,
                            leishmania.v_clinica.lesionmucosa AS lesionmucosa,
                            leishmania.v_clinica.alta AS alta,
                            leishmania.v_clinica.modificado AS modificado,
                            leishmania.v_clinica.usuario AS usuario
                     FROM leishmania.v_clinica
                     WHERE leishmania.v_clinica.idpaciente = '$paciente'; ";

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
     * Método que según el estado de las variables
     * ejecuta la consulta de grabación o edición
     * retorna la clave del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro (o cero en caso de error)
     */
    public function grabaClinica() : int {

        // si está insertando
        if ($this->Id == 0){
            $this->nuevaClinica();
        } else {
            $this->editaClinica();
        }

        // retornamos
        return (int) $this->Id;

    }
    
    /**
     * Método que ejecuta la consulta de inserción de
     * un nuevo registro, retorna el resultado de la
     * operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [bool] resultado de la operación
     *7
     */
    protected function nuevaClinica() : bool {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.clinica
                            (paciente,
                             cutaneaunica,
                             cutaneamultiple,
                             mucosanasal,
                             bucofaringea,
                             laringea,
                             visceral,
                             fiebre,
                             inicio,
                             caracteristicas,
                             fatiga,
                             debilidad,
                             vomitos,
                             diarrea,
                             tosseca,
                             pielgris,
                             edema,
                             escamosa,
                             petequias,
                             cabello,
                             adenomegalia,
                             hepatoesplenomegalia,
                             linfadenopatia,
                             perdidapeso,
                             nodulo,
                             ulcera,
                             cicatriz,
                             usuario)
                            VALUES
                            (:paciente,
                             :cutaneaunica,
                             :cutaneamultiple,
                             :mucosanasal,
                             :bucofaringea,
                             :laringea,
                             :visceral,
                             :fiebre,
                             STR_TO_DATE(:inicio, '%d/%m/%Y'),
                             :caracteristicas,
                             :fatiga,
                             :debilidad,
                             :vomitos,
                             :diarrea,
                             :tosseca,
                             :pielgris,
                             :edema,
                             :escamosa,
                             :petequias,
                             :cabello,
                             :adenomegalia,
                             :hepatoesplenomegalia,
                             :linfadenopatia,
                             :perdidapeso,
                             :nodulo,
                             :ulcera,
                             :cicatriz,
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente",             $this->Paciente);
            $preparada->bindParam(":cutaneaunica",         $this->CutaneaUnica);
            $preparada->bindParam(":cutaneamultiple",      $this->CutaneaMultiple);
            $preparada->bindParam(":mucosanasal",          $this->MucosaNasal);
            $preparada->bindParam(":bucofaringea",         $this->Bucofaringea);
            $preparada->bindParam(":laringea",             $this->Laringea);
            $preparada->bindParam(":visceral",             $this->Visceral);
            $preparada->bindParam(":fiebre",               $this->Fiebre);
            $preparada->bindParam(":inicio",               $this->Inicio);
            $preparada->bindParam(":caracteristicas",      $this->Caracteristicas);
            $preparada->bindParam(":fatiga",               $this->Fatiga);
            $preparada->bindParam(":debilidad",            $this->Debilidad);
            $preparada->bindParam(":vomitos",              $this->Vomitos);
            $preparada->bindParam(":diarrea",              $this->Diarrea);
            $preparada->bindParam(":tosseca",              $this->TosSeca);
            $preparada->bindParam(":pielgris",             $this->PielGris);
            $preparada->bindParam(":edema",                $this->Edema);
            $preparada->bindParam(":escamosa",             $this->Escamosa);
            $preparada->bindParam(":petequias",            $this->Petequias);
            $preparada->bindParam(":cabello",              $this->Cabello);
            $preparada->bindParam(":adenomegalia",         $this->Adenomegalia);
            $preparada->bindParam(":hepatoesplenomegalia", $this->HepatoEspleno);
            $preparada->bindParam(":linfadenopatia",       $this->Linfadenopatia);
            $preparada->bindParam(":perdidapeso",          $this->PerdidaPeso);
            $preparada->bindParam(":nodulo",               $this->Nodulo);
            $preparada->bindParam(":ulcera",               $this->Ulcera);
            $preparada->bindParam(":cicatriz",             $this->Cicatriz);
            $preparada->bindParam(":usuario",              $this->IdUsuario);

            // ejecutamos y retornamos
            $preparada->execute();
            $this->Id = $this->Link->lastInsertId();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            $this->Id = 0;
            return false;

        }

    }
    
    /**
     * Método que ejecuta la consulta de edición de un
     * registro, retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [bool resultado de la operación
     */
    protected function editaClinica() : bool {

        // componemos la consulta
        $consulta = "UPDATE leishmania.clinica SET
                            cutaneaunica = :cutaneaunica,
                            cutaneamultiple = :cutaneamultiple,
                            mucosanasal = :mucosanasal,
                            bucofaringea = :bucofaringea,
                            laringea = :laringea,
                            visceral = :visceral,
                            fiebre = :fiebre,
                            inicio = STR_TO_DATE(:inicio, '%d/%m/%Y'),
                            caracteristicas = :caracteristicas,
                            fatiga = :fatiga,
                            debilidad = :debilidad,
                            vomitos = :vomitos,
                            diarrea = :diarrea,
                            tosseca = :tosseca,
                            pielgris = :pielgris,
                            edema = :edema,
                            escamosa = :escamosa,
                            petequias = :petequias,
                            cabello = :cabello,
                            adenomegalia = :adenomegalia,
                            hepatoesplenomegalia = :hepatoesplenomegalia,
                            linfadenopatia = :linfadenopatia,
                            perdidapeso = :perdidapeso,
                            nodulo = :nodulo,
                            ulcera = :ulcera,
                            cicatriz = :cicatriz,
                            usuario = :usuario
                     WHERE leishmania.clinica.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":cutaneaunica",         $this->CutaneaUnica);
            $preparada->bindParam(":cutaneamultiple",      $this->CutaneaMultiple);
            $preparada->bindParam(":mucosanasal",          $this->MucosaNasal);
            $preparada->bindParam(":bucofaringea",         $this->Bucofaringea);
            $preparada->bindParam(":laringea",             $this->Laringea);
            $preparada->bindParam(":visceral",             $this->Visceral);
            $preparada->bindParam(":fiebre",               $this->Fiebre);
            $preparada->bindParam(":inicio",               $this->Inicio);
            $preparada->bindParam(":caracteristicas",      $this->Caracteristicas);
            $preparada->bindParam(":fatiga",               $this->Fatiga);
            $preparada->bindParam(":debilidad",            $this->Debilidad);
            $preparada->bindParam(":vomitos",              $this->Vomitos);
            $preparada->bindParam(":diarrea",              $this->Diarrea);
            $preparada->bindParam(":tosseca",              $this->TosSeca);
            $preparada->bindParam(":pielgris",             $this->PielGris);
            $preparada->bindParam(":edema",                $this->Edema);
            $preparada->bindParam(":escamosa",             $this->Escamosa);
            $preparada->bindParam(":petequias",            $this->Petequias);
            $preparada->bindParam(":cabello",              $this->Cabello);
            $preparada->bindParam(":adenomegalia",         $this->Adenomegalia);
            $preparada->bindParam(":hepatoesplenomegalia", $this->HepatoEspleno);
            $preparada->bindParam(":linfadenopatia",       $this->Linfadenopatia);
            $preparada->bindParam(":perdidapeso",          $this->PerdidaPeso);
            $preparada->bindParam(":nodulo",               $this->Nodulo);
            $preparada->bindParam(":ulcera",               $this->Ulcera);
            $preparada->bindParam(":cicatriz",             $this->Cicatriz);
            $preparada->bindParam(":usuario",              $this->IdUsuario);
            $preparada->bindParam(":id",                   $this->Id);

            // ejecutamos y retornamos
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            $this->Id = 0;
            return false;

        }

    }
       
    /**
     * Método que recibe la clave de un registro y ejecuta
     * la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @return [bool] resultado de la operación
     */
    public function borraClinica(int $id) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.clinica
                     WHERE id = :id;";

        // capturamos el error
        try {

            // asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $id);
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            $e->getMessage();
            return false;

        }

    }

}
