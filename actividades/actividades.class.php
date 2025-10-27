<?php

/**
 *
 * Class Actividades | actividades/actividades.class.php
 *
 * @package     Leishmania
 * @subpackage  Actividades
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (24/07/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm de las actividades
 * realizadas por los paciente
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
class Actividades {

    // declaración de variables
    protected $Link;            // puntero a la base de datos
    protected $Id;              // clave del registro
    protected $IdPaciente;      // clave del paciente
    protected $Lugar;           // lugar de la actividad
    protected $Actividad;       // descripción de la actividad
    protected $Fecha;           // fecha de la actividad
    protected $Usuario;         // nombre del usuario
    protected $IdUsuario;       // clave del usuario
    protected $Alta;            // fecha de alta del registro

    /**
     * Constructor de la clase, instanciamos la conexión con la base
     * e inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // instanciamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->IdPaciente = 0;
        $this->Lugar = "";
        $this->Actividad = "";
        $this->Fecha = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = "";
        
    }

    /**
     * Destructor de la clase, elimina el puntero
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
    public function setIdPaciente(int $idpaciente) : void {
        $this->IdPaciente = $idpaciente;
    }
    public function setLugar(string $lugar) : void {
        $this->Lugar = $lugar;
    }
    public function setActividad(string $actividad) : void {
        $this->Actividad = $actividad;
    }
    public function setFecha(string $fecha) : void {
        $this->Fecha = $fecha;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getIdPaciente() : int {
        return (int) $this->IdPaciente;
    }
    public function getLugar() : string {
        return $this->Lugar;
    }
    public function getActividad() : string {
        return $this->Actividad;
    }
    public function getFecha() : string {
        return $this->Fecha;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que según el estado de las variables de clase
     * genera la consulta de inserción o edición, retorna
     * la clave del registro afectado o cero en caso de
     * error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaActividad() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevaActividad();
        } else {
            $resultado = $this->editaActividad();
        }

        // retornamos
        return (int) $resultado;

    }

    /**
     * Método que ejecuta la consulta de inserción de un nuevo
     * registro, retorna la clave del mismo o cero en caso
     * de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function nuevaActividad() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.actividades
                            (paciente,
                             lugar,
                             actividad,
                             fecha,
                             usuario)
                            VALUES
                            (:paciente,
                             :lugar,
                             :actividad,
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente",     $this->IdPaciente);
            $preparada->bindParam(":lugar",        $this->Lugar);
            $preparada->bindParam(":actividad",    $this->Actividad);
            $preparada->bindParam(":fecha",        $this->Fecha);
            $preparada->bindParam(":usuario",      $this->IdUsuario);
            $preparada->execute();

            // obtenemos la clave
            return (int) $this->Link->lastInsertId();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que ejecuta la consulta de edición del registro
     * retorna la clave del registro afectado o cero en
     * caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaActividad() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.actividades SET
                            lugar = :lugar,
                            actividad = :actividad,
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.actividades.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":lugar",        $this->Lugar);
            $preparada->bindParam(":actividad",    $this->Actividad);
            $preparada->bindParam(":fecha",        $this->Fecha);
            $preparada->bindParam(":usuario",      $this->IdUsuario);
            $preparada->bindParam("id",            $this->Id);
            $preparada->execute();

            // retornamos
            return $this->Id;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe como parámetros la descripción de la
     * actividad, el lugar y la fecha de la misma y verifica
     * que no esté repetida, retorna verdadero si puede
     * insertar
     * @author Claudio invernizzi <cinvernizzi@dsgestion.site>
     * @param string $actividad - descripción de la actividad
     * @param string $lugar - lugar de la actividad
     * @param string $fecha - fecha de la actividad
     * @return bool verdadero si puede insertar
     */
    public function validaActividad(string $actividad,
                                    string $lugar,
                                    string $fecha) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.actividades.id) AS registros
                     FROM leishmania.actividades
                     WHERE leishmania.actividades.actividad = '$actividad' AND
                           leishmania.actividades.lugar = '$lugar' AND
                           leishmania.actividades.fecha = STR_TO_DATE('$fecha', '%d/%m/%Y'); ";

        # capturamos el error
        try {

            // ejecutamos y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // según el valor
            return $fila["registros"] == 0 ? true : false;

            // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación, retorna el
     * resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return bool resultado de la operación
     */
    public function borraActividad(int $idactividad) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.actividades
                     WHERE leishmania.actividades.id = :id; ";

        // capturamos el error
        try {

            // preparamos y ejecutamos la consulta
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idactividad);
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
     * y retorna la nómina de actividades de ese paciente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idactividad - clave del registro
     * @return array vector con los registros
     */
    public function nominaActividades(int $idpaciente) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_actividades.id AS id,
                            leishmania.v_actividades.lugar AS lugar,
                            leishmania.v_actividades.actividad AS actividad,
                            leishmania.v_actividades.fecha AS fecha,
                            leishmania.v_actividades.usuario AS usuario,
                            leishmania.v_actividades.alta AS alta
                     FROM leishmania.v_actividades
                     WHERE leishmania.v_actividades.idpaciente = '$idpaciente'
                     ORDER BY STR_TO_DATE(leishmania.v_actividades.fecha, '%d/%m/%Y') DESC; ";

        // capturamos el error
        try {

            // ejecutamos y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
            
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave de un registro
     * y asigna los valores del mismo a las variables de clase
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idactividad - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosActividad(int $idactividad) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_actividades.id AS id,
                            leishmania.v_actividades.paciente AS idpaciente,
                            leishmania.v_actividades.lugar AS lugar,
                            leishmania.v_actividades.fecha AS fecha,
                            leishmania.v_actividades.usuario AS usuario,
                            leishmania.v_actividades.alta AS alta,
                     FROM leishmania.v_actividades
                     WHERE leishmania.v_actividades.id = '$idactividad'; ";

        // capturamos el error
        try {

            // ejecutamos y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            
            // asignamos en la clase
            $this->Id = $fila["id"];
            $this->IdPaciente = $fila["idpaciente"];
            $this->Lugar = $fila["lugar"];
            $this->Actividad = $fila["actividad"];
            $this->Fecha = $fila["fecha"];
            $this->Usuario = $fila["usuario"];
            $this->Alta = $fila["alta"];

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

}

