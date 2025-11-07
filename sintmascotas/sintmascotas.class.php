<?php

/**
 *
 * Class SintMascotas | sintmascotas/sintmascotas.class.php
 *
 * @package     Leishmania
 * @subpackage  SintMascotas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (04/08/2025)
 * @copyright   Copyright (c) 2025, DsGestion
 *
 * Clase que implementa los métodos para el abm de los síntomas de
 * las mascotas
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
class SintMascotas {

    // declaración de variables
    protected $Link;                // puntero a la base de datos
    protected $Id;                  // clave del registro
    protected $Mascota;             // clave de la mascota
    protected $Paciente;            // clave del paciente
    protected $Anorexia;            // si presenta anorexia
    protected $Adinamia;            // si presenta adinamia
    protected $Emaciacion;          // si presenta emaciación
    protected $Polidipsia;          // si presenta polidipsia
    protected $Atrofia;             // si presenta atrofia
    protected $Paresia;             // si presenta paresia
    protected $Convulsiones;        // si presenta convulsiones
    protected $Adenomegalia;        // si presenta adenomegalia
    protected $Blefaritis;          // si presenta blefaritis
    protected $Conjuntivitis;       // si presenta conjuntivitis
    protected $Queratitis;          // si presenta queratitis
    protected $Uveitis;             // si presenta uveitis
    protected $Palidez;             // si presenta palidez
    protected $Epistaxis;           // si presenta epistaxis
    protected $Ulceras;             // si presenta úlceras
    protected $Diarrea;             // si presenta diarrea
    protected $Nodulos;             // si presenta nódulos
    protected $Vomitos;             // si presenta vómitos
    protected $Artritis;            // si presenta artritis
    protected $Eritema;             // si presenta eritema
    protected $Prurito;             // si presenta prurito
    protected $UlceraCutanea;       // si presenta úlceras cutáneas
    protected $NodulosCutaneos;     // si presenta nódulos cutáneos
    protected $AlopeciaLocalizada;  // si hay alopecía localidada
    protected $AlopeciaGeneralizada;// si hay alopecía generalizada
    protected $HiperqueratosisN;    // si presenta hiperqueratosis nasal
    protected $HiperqueratosisP;    // si presenta hiperqueratosis plantar
    protected $SeborreaGrasa;       // si presenta seborrea grasa
    protected $SeborreaEscamosa;    // si presenta seborrea escamosa
    protected $Onicogrifosis;       // si presenta onicogrifosis
    protected $CasoHumano;          // si existe un caso humano
    protected $Flebotomos;          // si presenta flebótomos
    protected $CasaTrampeada;       // si la casa está trampeada
    protected $Fumigacion;          // si se realiza fumigación
    protected $MateriaOrganica;     // si hay presencia de materia orgánica
    protected $Repelentes;          // si se utilizan repelentes
    protected $Periodicidad;        // frecuencia de utilización (semanal, mensual, etc.)
    protected $Duerme;              // donde duerme (adentro / afuera)
    protected $QuedaLibre;          // si dejan libre al animal en la calle
    protected $Antecedentes;        // antecedentes epidemiológicos
    protected $Usuario;             // nombre del usuario
    protected $IdUsuario;           // clave del usuario
    protected $Alta;                // fecha de alta del registro

    /**
     * Constructor de la clase, inicializamos las variables e
     * instanciamos la conexión con la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // instanciamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Mascota = 0;
        $this->Paciente = 0;
        $this->Anorexia = 'No';
        $this->Adinamia = 'No';
        $this->Emaciacion = 'No';
        $this->Polidipsia = 'No';
        $this->Atrofia = 'No';
        $this->Paresia = 'No';
        $this->Convulsiones = 'No';
        $this->Adenomegalia = 'No';
        $this->Blefaritis = 'No';
        $this->Conjuntivitis = 'No';
        $this->Queratitis = 'No';
        $this->Uveitis = 'No';
        $this->Palidez = 'No';
        $this->Epistaxis = 'No';
        $this->Ulceras = 'No';
        $this->Diarrea = 'No';
        $this->Nodulos = 'No';
        $this->Vomitos = 'No';
        $this->Artritis = 'No';
        $this->Eritema = 'No';
        $this->Prurito = 'No';
        $this->UlceraCutanea = 'No';
        $this->NodulosCutaneos = 'No';
        $this->AlopeciaLocalizada = 'No';
        $this->AlopeciaGeneralizada = 'No';
        $this->HiperqueratosisN = 'No';
        $this->HiperqueratosisP = 'No';
        $this->SeborreaGrasa = 'No';
        $this->SeborreaEscamosa = 'No';
        $this->Onicogrifosis = 'No';
        $this->CasoHumano = 'No';
        $this->Flebotomos = 'No';
        $this->CasaTrampeada = 'No';
        $this->Fumigacion = 'No';
        $this->MateriaOrganica = 'No';
        $this->Repelentes = 'No';
        $this->Periodicidad = '';
        $this->Duerme = '';
        $this->QuedaLibre = 'No';
        $this->Antecedentes = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = date('d/m/Y');

    }

    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // eliminamos el puntero
        $this->Link = null;

    }

    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setMascota(int $mascota) : void {
        $this->Mascota = $mascota;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setAnorexia(string $anorexia) : void {
        $this->Anorexia = $anorexia;
    }
    public function setAdinamia(string $adinamia) : void {
        $this->Adinamia = $adinamia;
    }
    public function setEmaciacion(string $emaciacion) : void {
        $this->Emaciacion = $emaciacion;
    }
    public function setPolidipsia(string $polidipsia) : void {
        $this->Polidipsia = $polidipsia;
    }
    public function setAtrofia(string $atrofia) : void {
        $this->Atrofia = $atrofia;
    }
    public function setParesia(string $paresia) : void {
        $this->Paresia = $paresia;
    }
    public function setConvulsiones(string $convulsiones) : void {
        $this->Convulsiones = $convulsiones;
    }
    public function setAdenomegalia(string $adenomegalia) : void {
        $this->Adenomegalia = $adenomegalia;
    }
    public function setBlefaritis(string $blefaritis) : void {
        $this->Blefaritis = $blefaritis;
    }
    public function setConjuntivitis(string $conjuntivitis) : void {
        $this->Conjuntivitis = $conjuntivitis;
    }
    public function setQueratitis(string $queratitis) : void {
        $this->Queratitis = $queratitis;
    }
    public function setUveitis(string $uveitis) : void {
        $this->Uveitis = $uveitis;
    }
    public function setPalidez(string $palidez) : void {
        $this->Palidez = $palidez;
    }
    public function setEpistaxis(string $epistaxis) : void {
        $this->Epistaxis = $epistaxis;
    }
    public function setUlceras(string $ulceras) : void {
        $this->Ulceras = $ulceras;
    }
    public function setNodulos(string $nodulos) : void {
        $this->Nodulos = $nodulos;
    }
    public function setVomitos(string $vomitos) : void {
        $this->Vomitos = $vomitos;
    }
    public function setDiarrea(string $diarrea) : void {
        $this->Diarrea = $diarrea;
    }
    public function setArtritis(string $artritis) : void {
        $this->Artritis = $artritis;
    }
    public function setEritema(string $eritema) : void {
        $this->Eritema = $eritema;
    }
    public function setPrurito(string $prurito) : void {
        $this->Prurito = $prurito;
    }
    public function setUlceraCutanea(string $ulcera) : void {
        $this->UlceraCutanea = $ulcera;
    }
    public function setNodulosCutaneos(string $nodulos) : void {
        $this->NodulosCutaneos = $nodulos;
    }
    public function setAlopeciaLocalizada(string $alopecia) : void {
        $this->AlopeciaLocalizada = $alopecia;
    }
    public function setAlopeciaGeneralizada(string $alopecia) : void {
        $this->AlopeciaGeneralizada = $alopecia;
    }
    public function setHiperqueratosisN(string $hiperqueratosis) : void {
        $this->HiperqueratosisN = $hiperqueratosis;
    }
    public function setHiperqueratosisP(string $hiperqueratosis) : void {
        $this->HiperqueratosisP = $hiperqueratosis;
    }
    public function setSeborreaGrasa(string $seborrea) : void {
        $this->SeborreaGrasa = $seborrea;
    }
    public function setSeborreaEscamosa(string $seborrea) : void {
        $this->SeborreaEscamosa = $seborrea;
    }
    public function setOnicogrifosis(string $onicogrifosis) : void {
        $this->Onicogrifosis = $onicogrifosis;
    }
    public function setCasoHumano(string $casohumano) : void {
        $this->CasoHumano = $casohumano;
    }
    public function setFlebotomos(string $flebotomos) : void {
        $this->Flebotomos = $flebotomos;
    }
    public function setCastaTrampeada(string $casatrampeada) : void {
        $this->CasaTrampeada = $casatrampeada;
    }
    public function setFumigacion(string $fumigacion) : void {
        $this->Fumigacion = $fumigacion;
    }
    public function setMateriaOrganica(string $materia) : void {
        $this->MateriaOrganica = $materia;
    }
    public function setRepelentes(string $repelentes) : void {
        $this->Repelentes = $repelentes;
    }
    public function setPeriodicidad(string $periodicidad) : void {
        $this->Periodicidad = $periodicidad;
    }
    public function setDuerme(string $duerme) : void {
        $this->Duerme = $duerme;
    }
    public function setQuedaLibre(string $quedalibre) : void {
        $this->QuedaLibre = $quedalibre;
    }
    public function setAntecedentes(?string $antecedentes) : void {
        $this->Antecedentes = $antecedentes;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getMascota() : int {
        return (int) $this->Mascota;
    }
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getAnorexia() : string {
        return $this->Anorexia;
    }
    public function getAdinamia() : string {
        return $this->Adinamia;
    }
    public function getEmaciacion() : string {
        return $this->Emaciacion;
    }
    public function getPolidipsia() : string {
        return $this->Polidipsia;
    }
    public function getAtrofia() : string {
        return $this->Atrofia;
    }
    public function getParesia() : string {
        return $this->Paresia;
    }
    public function getConvulsiones() : string {
        return $this->Convulsiones;
    }
    public function getAdenomegalia() : string {
        return $this->Adenomegalia;
    }
    public function getBlefaritis() : string {
        return $this->Blefaritis;
    }
    public function getConjuntivitis() : string {
        return $this->Conjuntivitis;
    }
    public function getQueratitis() : string {
        return $this->Queratitis;
    }
    public function getUveitis() : string {
        return $this->Uveitis;
    }
    public function getPalidez() : string {
        return $this->Palidez;
    }
    public function getEpistaxis() : string {
        return $this->Epistaxis;
    }
    public function getUlceras() : string {
        return $this->Ulceras;
    }
    public function getDiarrea() : string {
        return $this->Diarrea;
    }
    public function getNodulos() : string {
        return $this->Nodulos;
    }
    public function getVomitos() : string {
        return $this->Vomitos;
    }
    public function getArtritis() : string {
        return $this->Artritis;
    }
    public function getEritema() : string {
        return $this->Eritema;
    }
    public function getPrurito() : string {
        return $this->Prurito;
    }
    public function getUlceraCutanea() : string {
        return $this->UlceraCutanea;
    }
    public function getNodulosCutaneos() : string {
        return $this->NodulosCutaneos;
    }
    public function getAlopeciaLocalizada() : string {
        return $this->AlopeciaLocalizada;
    }
    public function getAlopeciaGeneralizada() : string {
        return $this->AlopeciaGeneralizada;
    }
    public function getHiperqueratosisN() : string {
        return $this->HiperqueratosisN;
    }
    public function getHiperqueratosisP() : string {
        return $this->HiperqueratosisP;
    }
    public function getSeborreaGrasa() : string {
        return $this->SeborreaGrasa;
    }
    public function getSeborreaEscamosa() : string {
        return $this->SeborreaEscamosa;
    }
    public function getOnicogrifosis() : string {
        return $this->Onicogrifosis;
    }
    public function getCasoHumano() : string {
        return $this->CasoHumano;
    }
    public function getFlebotomos() : string {
        return $this->Flebotomos;
    }
    public function getCasaTrampeada() : string {
        return $this->CasaTrampeada;
    }
    public function getFumigacion() : string {
        return $this->Fumigacion;
    }
    public function getMateriaOrganica() : string {
        return $this->MateriaOrganica;
    }
    public function getRepelentes() : string {
        return $this->Repelentes;
    }
    public function getPeriodicidad() : string {
        return $this->Periodicidad;
    }
    public function getDuerme() : string {
        return $this->Duerme;
    }
    public function getQuedaLibre() : string {
        return $this->QuedaLibre;
    }
    public function getAntecedentes() : ?string {
        return $this->Antecedentes;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que ejecuta la consulta de edición o grabación
     * según el estado de las variables de clase, retorna
     * la clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaSintoma() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevoSintoma();
        } else {
            $resultado = $this->editaSintoma();
        }
        
        // retornamos
        return (int) $resultado;
        
    }
    
    /**
     * Método que genera la consulta de inserción de un nuevo
     * registro y retorna la clave del mismo o cero en caso
     * de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function nuevoSintoma() : int {
        
        // componemos la consulta
        $consulta = "INSERT INTO leishmania.sintmascotas
                            (mascota,
                             paciente,
                             anorexia, 
                             adinamia,
                             emaciacion, 
                             polidipsia, 
                             atrofia, 
                             paresia, 
                             convulsiones, 
                             adenomegalia,
                             blefaritis, 
                             conjuntivitis, 
                             queratitis, 
                             uveitis, 
                             palidez, 
                             epistaxis, 
                             ulceras, 
                             diarrea,
                             nodulos, 
                             vomitos, 
                             artritis,
                             eritema,
                             prurito, 
                             ulceracutanea,
                             noduloscutaneos,
                             alopecialocalizada,
                             alopeciageneralizada,
                             hiperqueratosisn,
                             hiperqueratosisp,
                             seborreagrasa,
                             seborreaescamosa,
                             onicogrifosis,
                             casohumano,
                             flebotomos,
                             casatrampeada,
                             fumigacion,
                             materiaorganica,
                             repelentes,
                             periodicidad,
                             duerme, 
                             quedalibre,
                             antecedentes,
                             usuario)
                            VALUES
                            (:mascota,
                             :paciente,
                             :anorexia, 
                             :adinamia,
                             :emaciacion, 
                             :polidipsia, 
                             :atrofia,
                             :paresia, 
                             :convulsiones,
                             :adenomegalia,
                             :blefaritis,
                             :conjuntivitis, 
                             :queratitis,
                             :uveitis, 
                             :palidez,
                             :epistaxis, 
                             :ulceras,
                             :diarrea,
                             :nodulos,
                             :vomitos,
                             :artritis,
                             :eritema,
                             :prurito,
                             :ulceracutanea,
                             :noduloscutaneos,
                             :alopecialocalizada,
                             :alopeciageneralizada,
                             :hiperqueratosisn,
                             :hiperqueratosisp,
                             :seborreagrasa,
                             :seborreaescamosa,
                             :onicogrifosis,
                             :casohumano,
                             :flebotomos,
                             :casatrampeada,
                             :fumigacion, 
                             :materiaorganica,
                             :repelentes,
                             :periodicidad,
                             :duerme,
                             :quedalibre,
                             :antecedentes,
                             :usuario); ";
    
        // capturamos el error
        try {
            
            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":mascota",              $this->Mascota);
            $preparada->bindParam(":paciente",             $this->Paciente);
            $preparada->bindParam(":anorexia",             $this->Anorexia);
            $preparada->bindParam(":adinamia",             $this->Adinamia);
            $preparada->bindParam(":emaciacion",           $this->Emaciacion);
            $preparada->bindParam(":polidipsia",           $this->Polidipsia);
            $preparada->bindParam(":atrofia",              $this->Atrofia);
            $preparada->bindParam(":paresia",              $this->Paresia);
            $preparada->bindParam(":convulsiones",         $this->Convulsiones);
            $preparada->bindParam(":adenomegalia",         $this->Adenomegalia);
            $preparada->bindParam(":blefaritis",           $this->Blefaritis);
            $preparada->bindParam(":conjuntivitis",        $this->Conjuntivitis);
            $preparada->bindParam(":queratitis",           $this->Queratitis);
            $preparada->bindParam(":uveitis",              $this->Uveitis);
            $preparada->bindParam(":palidez",              $this->Palidez);
            $preparada->bindParam(":epistaxis",            $this->Epistaxis);
            $preparada->bindParam(":ulceras",              $this->Ulceras);
            $preparada->bindParam(":diarrea",              $this->Diarrea);
            $preparada->bindParam(":nodulos",              $this->Nodulos);
            $preparada->bindParam(":vomitos",              $this->Vomitos);
            $preparada->bindParam(":artritis",             $this->Artritis);
            $preparada->bindParam(":eritema",              $this->Eritema);
            $preparada->bindParam(":prurito",              $this->Prurito);
            $preparada->bindParam(":ulceracutanea",        $this->UlceraCutanea);
            $preparada->bindParam(":noduloscutaneos",      $this->NodulosCutaneos);
            $preparada->bindParam(":alopecialocalizada",   $this->AlopeciaLocalizada);
            $preparada->bindParam(":alopeciageneralizada", $this->AlopeciaGeneralizada);
            $preparada->bindParam(":hiperqueratosisn",     $this->HiperqueratosisN);
            $preparada->bindParam(":hiperqueratosisp",     $this->HiperqueratosisP);
            $preparada->bindParam(":seborreagrasa",        $this->SeborreaGrasa);
            $preparada->bindParam(":seborreaescamosa",     $this->SeborreaEscamosa);
            $preparada->bindParam(":onicogrifosis",        $this->Onicogrifosis);
            $preparada->bindParam(":casohumano",           $this->CasoHumano);
            $preparada->bindParam(":flebotomos",           $this->Flebotomos);
            $preparada->bindParam(":casatrampeada",        $this->CasaTrampeada);
            $preparada->bindParam(":fumigacion",           $this->Fumigacion);
            $preparada->bindParam(":materiaorganica",      $this->MateriaOrganica);
            $preparada->bindParam(":repelentes",           $this->Repelentes);
            $preparada->bindParam(":periodicidad",         $this->Periodicidad);
            $preparada->bindParam(":duerme",               $this->Duerme);
            $preparada->bindParam(":quedalibre",           $this->QuedaLibre);
            $preparada->bindParam(":antecedentes",         $this->Antecedentes);
            $preparada->bindParam(":usuario",              $this->IdUsuario);
            $preparada->execute();
            return (int) $this->Link->lastInsertId();
            
        // si ocurrió un error
        } catch (PDOException $e){
            
            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;
            
        }
        
    }
 
    /**
     * Método que ejecuta la consulta de edición a partir de
     * los valores de las variables de clase y retorna la
     * clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function editaSintoma() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.sintmascotas SET
                            anorexia = :anorexia, 
                            adinamia = :adinamia,
                            emaciacion = :emaciacion, 
                            polidipsia = :polidipsia, 
                            atrofia = :atrofia, 
                            paresia = :paresia, 
                            convulsiones = :convulsiones, 
                            adenomegalia = :adenomegalia, 
                            blefaritis = :blefaritis, 
                            conjuntivitis = :conjuntivitis, 
                            queratitis = :queratitis, 
                            uveitis = :uveitis, 
                            palidez = :palidez, 
                            epistaxis = :epistaxis, 
                            ulceras = :ulceras, 
                            diarrea = :diarrea,
                            nodulos = :nodulos, 
                            vomitos = :vomitos, 
                            artritis = :artritis,
                            eritema = :eritema, 
                            prurito = :prurito, 
                            ulceracutanea = :ulceracutanea, 
                            noduloscutaneos = :noduloscutaneos, 
                            alopecialocalizada = :alopecialocalizada, 
                            alopeciageneralizada = :alopeciageneralizada, 
                            hiperqueratosisn = :hiperqueratosisn, 
                            hiperqueratosisp = :hiperqueratosisp,
                            seborreagrasa = :seborreagrasa, 
                            seborreaescamosa = :seborreaescamosa, 
                            onicogrifosis = :onicogrifosis, 
                            casohumano = :casohumano, 
                            flebotomos = :flebotomos, 
                            casatrampeada = :casatrampeada, 
                            fumigacion = :fumigacion, 
                            materiaorganica = :materiaorganica, 
                            repelentes = :repelentes, 
                            periodicidad = :periodicidad, 
                            duerme = :duerme, 
                            quedalibre = :quedalibre, 
                            antecedentes = :antecedentes,
                            usuario = :usuario
                     WHERE leishmania.sintmascotas.id = :id; ";

        // capturamos el error
        try {
            
            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":anorexia",             $this->Anorexia);
            $preparada->bindParam(":adinamia",             $this->Adinamia);
            $preparada->bindParam(":emaciacion",           $this->Emaciacion);
            $preparada->bindParam(":polidipsia",           $this->Polidipsia);
            $preparada->bindParam(":atrofia",              $this->Atrofia);
            $preparada->bindParam(":paresia",              $this->Paresia);
            $preparada->bindParam(":convulsiones",         $this->Convulsiones);
            $preparada->bindParam(":adenomegalia",         $this->Adenomegalia);
            $preparada->bindParam(":blefaritis",           $this->Blefaritis);
            $preparada->bindParam(":conjuntivitis",        $this->Conjuntivitis);
            $preparada->bindParam(":queratitis",           $this->Queratitis);
            $preparada->bindParam(":uveitis",              $this->Uveitis);
            $preparada->bindParam(":palidez",              $this->Palidez);
            $preparada->bindParam(":epistaxis",            $this->Epistaxis);
            $preparada->bindParam(":ulceras",              $this->Ulceras);
            $preparada->bindParam(":diarrea",              $this->Diarrea);
            $preparada->bindParam(":nodulos",              $this->Nodulos);
            $preparada->bindParam(":vomitos",              $this->Vomitos);
            $preparada->bindParam(":artritis",             $this->Artritis);
            $preparada->bindParam(":eritema",              $this->Eritema);
            $preparada->bindParam(":prurito",              $this->Prurito);
            $preparada->bindParam(":ulceracutanea",        $this->UlceraCutanea);
            $preparada->bindParam(":noduloscutaneos",      $this->NodulosCutaneos);
            $preparada->bindParam(":alopecialocalizada",   $this->AlopeciaLocalizada);
            $preparada->bindParam(":alopeciageneralizada", $this->AlopeciaGeneralizada);
            $preparada->bindParam(":hiperqueratosisn",     $this->HiperqueratosisN);
            $preparada->bindParam(":hiperqueratosisp",     $this->HiperqueratosisP);
            $preparada->bindParam(":seborreagrasa",        $this->SeborreaGrasa);
            $preparada->bindParam(":seborreaescamosa",     $this->SeborreaEscamosa);
            $preparada->bindParam(":onicogrifosis",        $this->Onicogrifosis);
            $preparada->bindParam(":casohumano",           $this->CasoHumano);
            $preparada->bindParam(":flebotomos",           $this->Flebotomos);
            $preparada->bindParam(":casatrampeada",        $this->CasaTrampeada);
            $preparada->bindParam(":fumigacion",           $this->Fumigacion);
            $preparada->bindParam(":materiaorganica",      $this->MateriaOrganica);
            $preparada->bindParam(":repelentes",           $this->Repelentes);
            $preparada->bindParam(":periodicidad",         $this->Periodicidad);
            $preparada->bindParam(":duerme",               $this->Duerme);
            $preparada->bindParam(":quedalibre",           $this->QuedaLibre);
            $preparada->bindParam(":antecedentes",         $this->Antecedentes);
            $preparada->bindParam(":usuario",              $this->IdUsuario);
            $preparada->bindParam(":id",                   $this->Id);
            $preparada->execute();
            return (int) $this->Id;
            
        // si ocurrió un error
        } catch (PDOException $e){
            
            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;
            
        }

    }

    /**
     * Método que recibe como parámetro la clave de una mascota
     * y asigna en las variables de clase los valores del registro
     * (usamos la clave de la mascota porque se asume que tiene
     * que haber una relación de uno a uno, cada mascota solo
     * podrá tener una entrada en la tabla y a su vez, obtenemos
     * la clave de la mascota de la grilla correspondiente)
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmascota - clave de la mascota
     * @return bool resultado de la operación
     */
    public function getDatosSintomas(int $idmascota) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_sintmascotas.id AS id,
                            leishmania.v_sintmascotas.idmascota AS idmascota,
                            leishmania.v_sintmascotas.idpaciente AS idpaciente,
                            leishmania.v_sintmascotas.anorexia AS anorexia, 
                            leishmania.v_sintmascotas.adinamia AS adinamia, 
                            leishmania.v_sintmascotas.emaciacion AS emaciacion, 
                            leishmania.v_sintmascotas.polidipsia AS polidipsia,
                            leishmania.v_sintmascotas.atrofia AS atrofia, 
                            leishmania.v_sintmascotas.paresia AS paresia, 
                            leishmania.v_sintmascotas.convulsiones AS convulsiones,
                            leishmania.v_sintmascotas.adenomegalia AS adenomegalia, 
                            leishmania.v_sintmascotas.blefaritis AS blefaritis, 
                            leishmania.v_sintmascotas.conjuntivitis AS conjuntivitis, 
                            leishmania.v_sintmascotas.queratitis AS queratitis, 
                            leishmania.v_sintmascotas.uveitis AS uveitis, 
                            leishmania.v_sintmascotas.palidez AS palidez, 
                            leishmania.v_sintmascotas.epistaxis AS epistaxis, 
                            leishmania.v_sintmascotas.ulceras AS ulceras, 
                            leishmania.v_sintmascotas.diarrea AS diarrea,
                            leishmania.v_sintmascotas.nodulos AS nodulos, 
                            leishmania.v_sintmascotas.vomitos AS vomitos, 
                            leishmania.v_sintmascotas.artritis AS artritis, 
                            leishmania.v_sintmascotas.eritema AS eritema, 
                            leishmania.v_sintmascotas.prurito AS prurito, 
                            leishmania.v_sintmascotas.ulceracutanea AS ulceracutanea, 
                            leishmania.v_sintmascotas.noduloscutaneos AS noduloscutaneos, 
                            leishmania.v_sintmascotas.alopecialocalizada AS alopecialocalizada, 
                            leishmania.v_sintmascotas.alopeciageneralizada AS alopeciageneralizada,
                            leishmania.v_sintmascotas.hiperqueratosisn AS hiperqueratosisn, 
                            leishmania.v_sintmascotas.hiperqueratosisp AS hiperqueratosisp,
                            leishmania.v_sintmascotas.seborreagrasa AS seborreagrasa, 
                            leishmania.v_sintmascotas.seborreaescamosa AS seborreaescamosa, 
                            leishmania.v_sintmascotas.onicogrifosis AS onicogrifosis, 
                            leishmania.v_sintmascotas.casohumano AS casohumano, 
                            leishmania.v_sintmascotas.flebotomos AS flebotomos, 
                            leishmania.v_sintmascotas.casatrampeada AS casatrampeada, 
                            leishmania.v_sintmascotas.fumigacion AS fumigacion, 
                            leishmania.v_sintmascotas.materiaorganica AS materiaorganica,
                            leishmania.v_sintmascotas.repelentes AS repelentes, 
                            leishmania.v_sintmascotas.periodicidad AS periodicidad, 
                            leishmania.v_sintmascotas.duerme AS duerme, 
                            leishmania.v_sintmascotas.quedalibre AS quedalibre, 
                            leishmania.v_sintmascotas.antecedentes AS antecedentes,
                            leishmania.v_sintmascotas.usuario AS usuario,
                            leishmania.v_sintmascotas.alta AS alta
                     FROM leishmania.v_sintmascotas
                     WHERE leishmania.v_sintmascotas.idmascota = '$idmascota'; ";

        // capturamos el error
        try {


            // ejecutamos y asignamos en la clase
            $resultado = $this->Link->query($consulta);

            // si hay registros
            if ($resultado->rowCount() > 0){

                // obtenemos el registro
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);

                // asignamos en la clase
                $this->Id = $fila["id"];
                $this->Mascota = $fila["idmascota"];
                $this->Paciente = $fila["idpaciente"];
                $this->Anorexia = $fila["anorexia"];
                $this->Adinamia = $fila["adinamia"];
                $this->Emaciacion = $fila["emaciacion"];
                $this->Polidipsia = $fila["polidipsia"];
                $this->Atrofia = $fila["atrofia"];
                $this->Paresia = $fila["paresia"];
                $this->Convulsiones = $fila["convulsiones"];
                $this->Adenomegalia = $fila["adenomegalia"];
                $this->Blefaritis = $fila["blefaritis"];
                $this->Conjuntivitis = $fila["conjuntivitis"];
                $this->Queratitis = $fila["queratitis"];
                $this->Uveitis = $fila["uveitis"];
                $this->Palidez = $fila["palidez"];
                $this->Epistaxis = $fila["epistaxis"];
                $this->Ulceras = $fila["ulceras"];
                $this->Diarrea = $fila["diarrea"];
                $this->Nodulos = $fila["nodulos"];
                $this->Vomitos = $fila["vomitos"];
                $this->Artritis = $fila["artritis"];
                $this->Eritema = $fila["eritema"];
                $this->Prurito = $fila["prurito"];
                $this->UlceraCutanea = $fila["ulceracutanea"];
                $this->NodulosCutaneos = $fila["noduloscutaneos"];
                $this->AlopeciaLocalizada = $fila["alopecialocalizada"];
                $this->AlopeciaGeneralizada = $fila["alopeciageneralizada"];
                $this->HiperqueratosisN = $fila["hiperqueratosisn"];
                $this->HiperqueratosisP = $fila["hiperqueratosisp"];
                $this->SeborreaGrasa = $fila["seborreagrasa"];
                $this->SeborreaEscamosa = $fila["seborreaescamosa"];
                $this->Onicogrifosis = $fila["onicogrifosis"];
                $this->CasoHumano = $fila["casohumano"];
                $this->Flebotomos = $fila["flebotomos"];
                $this->CasaTrampeada = $fila["casatrampeada"];
                $this->Fumigacion = $fila["fumigacion"];
                $this->MateriaOrganica = $fila["materiaorganica"];
                $this->Repelentes = $fila["repelentes"];
                $this->Periodicidad = $fila["periodicidad"];
                $this->Duerme = $fila["duerme"];
                $this->QuedaLibre = $fila["quedalibre"];
                $this->Antecedentes = $fila["antecedentes"];
                $this->Usuario = $fila["usuario"];
                $this->Alta = $fila["alta"];

            }

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // retornamos
            echo $e->getMessage();
            return false;

        }

    }

}
