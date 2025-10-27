<?php

/**
 *
 * Class Viajes | viajes/viajes.class.php
 *
 * @package     Leishmania
 * @subpackage  Viajes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (25/07/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm de los viajes
 * realizados por el paciente
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
class Viajes {

    // declaramos las variables
    protected $Link;          // puntero a la base de datos
    protected $Id;            // clave del registro
    protected $Paciente;      // clave del paciente
    protected $Lugar;         // destino del viaje
    protected $Fecha;         // fecha del viaje
    protected $Usuario;       // nombre del usuario
    protected $IdUsuario;     // clave del usuario
    protected $Alta;          // fecha de alta
    
    /*
     * Constructor de la clase, instanciamos la conexión e
     * inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
    
        // instanciamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Paciente = 0;
        $this->Lugar = "";
        $this->Fecha = "";
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
    
    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setLugar(string $lugar) : void {
        $this->Lugar = $lugar;
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
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getLugar() : string {
        return $this->Lugar;
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
     * Método que según los valores de las variables de clase
     * ejecuta la consulta de inserción o edición, retorna la
     * clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro afectado
     */
    public function grabaViaje() : int {
        
        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevoViaje();
        } else {
            $resultado = $this->editaViaje();
        }
        
        // retornamos
        return (int) $resultado;
        
    }
    
    /**
     * Método que ejecuta la consulta de inserción y retorna
     * la clave del nuevo registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function nuevoViaje() : int {
        
        // componemos la consulta
        $consulta = "INSERT INTO leishmania.viajes
                            (paciente,
                             lugar,
                             fecha,
                             usuario)
                            VALUES
                            (:paciente,
                             :lugar,
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :usuario); ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente", $this->Paciente);
            $preparada->bindParam(":lugar",    $this->Lugar);
            $preparada->bindParam(":fecha",    $this->Fecha);
            $preparada->bindParam(":usuario",  $this->IdUsuario);

            // ejecutamos y retornamos
            $preparada->execute();
            return (int) $this->Link->lastInsertId();

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }
    
    /**
     * Método que ejecuta la consulta de edición del registro
     * y retorna la clave del mismo o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaViaje() : int {
        
        // componemos la consulta
        $consulta = "UPDATE leishmania.viajes SET
                            lugar = :lugar,
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.viajes.id = :id; ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":lugar",    $this->Lugar);
            $preparada->bindParam(":fecha",    $this->Fecha);
            $preparada->bindParam(":usuario",  $this->IdUsuario);
            $preparada->bindParam(":id",       $this->Id);

            // ejecutamos y retornamos
            $preparada->execute();
            return (int) $this->Id;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }
    
    
    /**
     * Método que recibe como parámetro el destino del viaje y
     * la fecha del mismo, verifica que no esté declarado,
     * retorna verdadero si se puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $destino - destino del viaje
     * @param string $fecha - fecha del viaje
     * @return bool verdadero si puede insertar
     */
    public function validaViaje(string $destino, string $fecha) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.viajes.id) AS registros
                     FROM leishmania.viajes
                     WHERE leishmania.viajes.lugar = '$destino' AND
                           leishmania.viajes.fecha = STR_TO_DATE('$fecha', '%d/%m/%Y'); ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // según los registros
            if ($fila["registros"] == 0){
                return true;
            } else {
                return false;
            }
        
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }
    
    /**
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idviaje - clave del registro
     * @return bool resultado de la operación
     */
    public function borraViaje(int $idviaje) : bool {
        
        // componemos la consulta
        $consulta = "DELETE FROM leishmania.viajes
                     WHERE leishmania.viajes.id = :idviaje; ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":idviaje", $idviaje);
            return true;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }
    
    /**
     * Método que recibe como parámetro la clave de un paciente
     * y retorna el vector con todos los viajes de ese paciente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @return array vector con todos sus viajes
     */
    public function nominaViajes(int $idpaciente) : array {
        
        // componemos la consulta
        $consulta = "SELECT leishmania.v_viajes.id AS id,
                            leishmania.v_viajes.idpaciente AS paciente,
                            leishmania.v_viajes.lugar AS lugar,
                            leishmania.v_viajes.fecha AS fecha,
                            leishmania.v_viajes.usuario AS usuario,
                            leishmania.v_viajes.alta AS alta
                     FROM leishmania.v_viajes
                     WHERE leishmania.v_viajes.idpaciente = '$idpaciente'
                     ORDER BY STR_TO_DATE(leishmania.v_viajes.fecha, '%d/%m/%Y') DESC; ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }
    
    /**
     * Método que recibe como parámetro la clave de un registro
     * y asigna sus valores a las variables de clase, retorna
     * el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idviaje - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosViaje(int $idviaje) : bool {
        
        // componemos la consulta
        $consulta = "SELECT leishmania.v_viajes.id AS id,
                            leishmania.v_viajes.idpaciente AS idpaciente,
                            leishmania.v_viajes.lugar AS lugar,
                            leishmania.v_viajes.fecha AS fecha,
                            leishmania.v_viajes.usuario AS usuario,
                            leishmania.v_viajes.alta AS alta
                     FROM leishmania.v_viajes
                     WHERE leishmania.v_viajes.idpaciente = '$idviaje'; ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $resultado = $this->Link->query($consulta);

            // obtenemos el registro y asignamos
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->Id = $fila["id"];
            $this->Paciente = $fila["idpaciente"];
            $this->Lugar = $fila["lugar"];
            $this->Fecha = $fila["fecha"];
            $this->Usuario = $fila["usuario"];
            $this->Alta = $fila["fecha"];

            // retornamos
            return true;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }
        
    }
    
}
