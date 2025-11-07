<?php

/**
 *
 * Class Evolucion | evolucion/evolucion.class.php
 *
 * @package     Leishmania
 * @subpackage  Evolucion
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (29/07/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 */

// declaramos el tipeado estricto
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
 * Clase que controla las operaciones sobre los datos de la evolución
 * del paciente
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Evolucion {

    // declaración de variables
    protected $Link;             // puntero a la base
    protected $Id;               // clave del registro
    protected $Paciente;         // clave del paciente
    protected $Hospitalizacion;  // fecha de hospitalización
    protected $FechaAlta;        // cual fue la fecha de alta
    protected $Defuncion;        // fecha de defunción
    protected $Condicion;        // condición del alta
    protected $Clasificacion;    // clasificación final del diagnóstico
    protected $Usuario;          // nombre del usuario
    protected $IdUsuario;        // clave del usuario
    protected $Alta;             // fecha de alta del registro

    /**
     * Constructor de la clase, instanciamos la conexión e inicializamos
     * las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // instanciamos la conexión y las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Paciente = 0;
        $this->Hospitalizacion = "";
        $this->FechaAlta = "";
        $this->Defuncion = "";
        $this->Condicion = "";
        $this->Clasificacion = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = "";

    }

    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // eliminamos el puntero
        $this->Link = null;

    }

    // métodos de asignación de parámetros
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setHospitalizacion(string $fecha) : void {
        $this->Hospitalizacion = $fecha;
    }
    public function setFechaAlta(string $fecha) : void {
        $this->FechaAlta = $fecha;
    }
    public function setDefuncion(string $fecha) : void {
        $this->Defuncion = $fecha;
    }
    public function setCondicion(string $condicion) : void {
        $this->Condicion = $condicion;
    }
    public function setClasificacion(string $clasificacion) : void {
        $this->Clasificacion = $clasificacion;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de parámetros
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getHospitalizacion() : string {
        return $this->Hospitalizacion;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }
    public function getDefuncion() : string {
        return $this->Defuncion;
    }
    public function getCondicion() : string {
        return $this->Condicion;
    }
    public function getClasificacion() : string {
        return $this->Clasificacion;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que según el estado de las variables de clase, genera
     * la consulta de inserción o edición, retorna la clave del
     * registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaEvolucion() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevaEvolucion();
        } else {
            $resultado = $this->editaEvolucion();
        }

        // retornamos
        return (int) $resultado;

    }

    /**
     * Método que inserta un nuevo registro en la base, retorna la
     * clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function nuevaEvolucion() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.evolucion
                            (paciente,
                             hospitalizacion,
                             fechaalta,
                             defuncion,
                             condicion,
                             clasificacion,
                             usuario)
                            VALUES
                            (:paciente,
                             STR_TO_DATE(:hospitalizacion, '%d/%m/%Y'),
                             STR_TO_DATE(:fechaalta, '%d/%m/%Y'),
                             STR_TO_DATE(:defuncion, '%d/%m/%Y'),
                             :condicion,
                             :clasificacion,
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos la consulta y asignamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente",        $this->Paciente);
            $preparada->bindParam(":hospitalizacion", $this->Hospitalizacion);
            $preparada->bindParam(":fechaalta",       $this->FechaAlta);
            $preparada->bindParam(":defuncion",       $this->Defuncion);
            $preparada->bindParam(":condicion",       $this->Condicion);
            $preparada->bindParam(":clasificacion",   $this->Clasificacion);
            $preparada->bindParam(":usuario",         $this->IdUsuario);

            // ejecutamos y retornamos
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
     * Método que edita el registro de la evolución, retorna
     * la clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaEvolucion() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.evolucion SET
                            hospitalizacion = STR_TO_DATE(:hospitalizacion, '%d/%m/%Y'),
                            fechaalta = STR_TO_DATE(:fechaalta, '%d/%m/%Y'),
                            defuncion = STR_TO_DATE(:defuncion, '%d/%m/%Y'),
                            condicion = :condicion,
                            clasificacion = :clasificacion,
                            usuario = :usuario
                     WHERE leishmania.evolucion.id = :id; ";

        // capturamos el error
        try {

            // preparamos la consulta y asignamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":hospitalizacion", $this->Hospitalizacion);
            $preparada->bindParam(":fechaalta",       $this->FechaAlta);
            $preparada->bindParam(":defuncion",       $this->Defuncion);
            $preparada->bindParam(":condicion",       $this->Condicion);
            $preparada->bindParam(":clasificacion",   $this->Clasificacion);
            $preparada->bindParam(":usuario",         $this->IdUsuario);
            $preparada->bindParam(":id",              $this->Id);

            // ejecutamos y retornamos
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
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación, retorna el
     * resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return bool resultado de la operación
     */
    public function borraEvolucion(int $idevolucion) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.evolucion
                     WHERE leishmania.evolucion.id = :id; ";
                     
        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idevolucion);
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave de un paciente
     * y asigna los valores de ese registro en las variables
     * de clase (cada paciente tiene un solo registro de
     * evolución)
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @return bool - resultado de la operación
     */
    public function getDatosEvolucion(int $idpaciente) : bool {
        
        // creamos la consulta
        $consulta = "SELECT leishmania.v_evolucion.id AS id,
                            leishmania.v_evolucion.idpaciente AS paciente,
                            leishmania.v_evolucion.hospitalizacion AS hospitalizacion,
                            leishmania.v_evolucion.fechaalta AS fechaalta,
                            leishmania.v_evolucion.defuncion AS defuncion,
                            leishmania.v_evolucion.condicion AS condicion,
                            leishmania.v_evolucion.clasificacion AS clasificacion,
                            leishmania.v_evolucion.usuario AS usuario,
                            leishmania.v_evolucion.alta AS alta
                     FROM leishmania.v_evolucion
                     WHERE leishmania.v_evolucion.idpaciente = '$idpaciente'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);

            // verificamos que tenga registros
            if ($resultado->rowCount() > 0){

                // obtenemos el registro
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);

                // asignamos en la clase
                $this->Id = $fila["id"];
                $this->Paciente = $fila["paciente"];
                $this->Hospitalizacion = $fila["hospitalizacion"];
                $this->FechaAlta = $fila["fechaalta"];
                $this->Defuncion = $fila["defuncion"];
                $this->Condicion = $fila["condicion"];
                $this->Clasificacion = $fila["clasificacion"];
                $this->Usuario = $fila["usuario"];
                $this->Alta = $fila["alta"];

            }
            
            // retornamos
            return true;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return false;

        }

    }

}
