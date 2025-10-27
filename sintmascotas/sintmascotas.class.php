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
    protected $Nodulos;             // si presenta nódulos
    protected $Vomitos;             // si presenta vómitos
    protected $Artritis;            // si presenta artritis
    protected $Eritema;             // si presenta eritema
    protected $Prurito;             // si presenta prurito
    protected $UlceraCutanea;       // si presenta úlceras cutáneas
    protected $NodulosCutaneos;     // si presenta nódulos cutáneos
    protected $AlopeciaLocalidaza;  // si hay alopecía localidada
    protected $AlopeciaGeneralizada;// si hay alopecía generalizada
    protected $Hiperqueratosis;     // si presenta hiperqueratosis
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
        $this->Nodulos = 'No';
        $this->Vomitos = 'No';
        $this->Artritis = 'No';
        $this->Eritema = 'No';
        $this->Prurito = 'No';
        $this->UlceraCutanea = 'No';
        $this->NodulosCutaneos = 'No';
        $this->AlopeciaLocalidaza = 'No';
        $this->AlopeciaGeneralizada = 'No';
        $this->Hiperqueratosis = 'No';
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
                             pelo,
                             adelgazamiento,
                             ulceras,
                             pocoactivo,
                             usuario)
                            VALUES
                            (:mascota,
                             :paciente,
                             STR_TO_DATE(:pelo, '%d/%m/%Y'),
                             STR_TO_DATE(:adelgazamiento, '%d/%m/%Y'),
                             STR_TO_DATE(:ulceras, '%d/%m/%Y'),
                             STR_TO_DATE(:pocoactivo, '%d/%m/%Y'),
                             :usuario); ";
    
        // capturamos el error
        try {
            
            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":mascota",        $this->Mascota);
            $preparada->bindParam(":paciente",       $this->Paciente);
            $preparada->bindParam(":pelo",           $this->Pelo);
            $preparada->bindParam(":adelgazamiento", $this->Adelgazamiento);
            $preparada->bindParam(":ulceras",        $this->Ulceras);
            $preparada->bindParam(":pocoactivo",     $this->PocoActivo);
            $preparada->bindParam(":usuario",        $this->IdUsuario);
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
                            pelo = STR_TO_DATE(:pelo, '%d/%m/%Y'),
                            adelgazamiento = STR_TO_DATE(:adelgazamiento, '%d/%m/%Y'),
                            ulceras = STR_TO_DATE(:ulceras, '%d/%m/%Y'),
                            pocoactivo = STR_TO_DATE(:pocoactivo, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.sintmascotas.id = :id; ";

        // capturamos el error
        try {
            
            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":pelo",           $this->Pelo);
            $preparada->bindParam(":adelgazamiento", $this->Adelgazamiento);
            $preparada->bindParam(":ulceras",        $this->Ulceras);
            $preparada->bindParam(":pocoactivo",     $this->PocoActivo);
            $preparada->bindParam(":usuario",        $this->IdUsuario);
            $preparada->bindParam(":id",             $this->Id);
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
                            leishmania.v_sintmascotas.pelo As pelo,
                            leishmania.v_sintmascotas.adelgazamiento AS adelgazamiento,
                            leishmania.v_sintmascotas.ulceras AS ulceras,
                            leishmania.v_sintmascotas.pocoactivo AS pocoactivo,
                            leishmania.v_sintmascotas.usuario AS usuario,
                            leishmania.v_sintmascotas.alta AS alta
                     FROM leishmania.v_sintmascotas
                     WHERE leishmania.v_sintmascotas.idmascota = '$idmascota'; ";

        // capturamos el error
        try {


            // ejecutamos y asignamos en la clase
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // si hay registros
            if ($fila){

                // asignamos en la clase
                $this->Id = $fila["id"];
                $this->Mascota = $fila["idmascota"];
                $this->Paciente = $fila["idpaciente"];
                $this->Pelo = $fila["pelo"];
                $this->Adelgazamiento = $fila["adelgazamiento"];
                $this->Ulceras = $fila["ulceras"];
                $this->PocoActivo = $fila["pocoactivo"];
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
