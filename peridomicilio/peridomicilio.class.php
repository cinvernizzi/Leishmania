<?php

/**
 *
 * Class Peridomicilio | peridomicilio/peridomicilio.class.php
 *
 * @package     Leishmania
 * @subpackage  Peridomicilio
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.5.0 (24/07/2025)
 * @copyright   Copyright (c) 2025, INP
 *
 * Clase que controla las operaciones sobre la tabla de datos del
 * peridomicilio
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
 * Definición de la clase
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Peridomicilio {

    // declaración de variables
    protected $Link;            // puntero a la base de datos
    protected $Id;              // clave del registro
    protected $Animal;          // clave del animal
    protected $Paciente;        // clave del paciente
    protected $Distancia;       // distancia del animal u objeto
    protected $Cantidad;        // cantidad de animales u objetos
    protected $Usuario;         // nombre del usuario
    protected $IdUsuario;       // clave del usuario
    protected $Alta;            // fecha de alta

    /**
     * Constructor de la clase, instanciamos las variables y
     * el puntero a la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct() {
        
        // instanciamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Animal = 0;
        $this->Paciente = 0;
        $this->Distancia = 0;
        $this->Cantidad = 0;
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = "";

    }

    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // destruimos la conexión
        $this->Link = null;

    }

    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setAnimal(int $animal) : void {
        $this->Animal = $animal;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setDistancia(int $distancia) : void {
        $this->Distancia = $distancia;
    }
    public function setCantidad(int $cantidad) : void {
        $this->Cantidad = $cantidad;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getAnimal() : int {
        return (int) $this->Animal;
    }
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getDistancia() : int {
        return (int) $this->Distancia;
    }
    public function getCantidad() : int {
        return $this->Cantidad;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que según los valores de las variables de clase
     * ejecuta la consulta de edición o inserción retorna la
     * clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaPeridomicilio() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevoPeridomicilio();
        } else {
            $resultado = $this->editaPeridomicilio();
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
    protected function nuevoPeridomicilio() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.peridomicilio
                            (animal,
                             paciente,
                             distancia,
                             cantidad,
                             usuario)
                            VALUES
                            (:animal,
                             :paciente,
                             :distancia,
                             :cantidad,
                             :usuario); ";

        // capturamsos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":animal",    $this->Animal);
            $preparada->bindParam(":paciente",  $this->Paciente);
            $preparada->bindParam(":distancia", $this->Distancia);
            $preparada->bindParam(":cantidad",  $this->Cantidad);
            $preparada->bindParam(":usuario",   $this->IdUsuario);
            $preparada->execute();

            // retornamos
            return (int) $this->Link->lastInsertId();

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que ejecuta la consulta de edición y retorna la
     * clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaPeridomicilio() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.peridomicilio SET
                            animal = :animal,
                            distancia = :distancia,
                            cantidad = :cantidad,
                            usuario = :usuario
                     WHERE leishmania.peridomicilio.id = :id; ";

        // capturamos el error
        try {

            // preparamos y asignamos los valores
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":animal",    $this->Animal);
            $preparada->bindParam(":distancia", $this->Distancia);
            $preparada->bindParam(":cantidad",  $this->Cantidad);
            $preparada->bindParam(":usuario",   $this->IdUsuario);
            $preparada->bindParam(":id",        $this->Id);
            $preparada->execute();

            // retornamos
            return (int) $this->Id;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe como parámetros la clave del animal
     * y del paciente y verifica que no esté declarado en la
     * base, retorna verdadero si puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idanimal - clave del animal
     * @param int $idpaciente - clave del paciente
     * @return bool verdadero si puede insertar
     */
    public function validaPeridomicilio(int $idanimal, int $idpaciente) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.peridomicilio.id) AS registros
                     FROM leishmania.peridomicilio
                     WHERE leishmania.peridomicilio.animal = '$idanimal' AND
                           leishmania.peridomicilio.paciente = '$idpaciente'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // según los registros
            return $fila["registros"] == 0 ? true : false;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave del registro y
     * ejecuta la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int idperidomicilio - clave del registro
     * @return bool resultado de la operación
     */
    public function borraPeridomicilio(int $idperidomicilio) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.peridomicilio
                     WHERE leishmania.peridomicilio.id = :id; ";

        // capturamos el error
        try {

            // asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idperidomicilio);
            $preparada->execute();

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
     * Método que recibe como parámetro la clave de un paciente
     * y retorna el vector con todos los registros del mismo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @return array vector con los registros
     */
    public function nominaPeridomicilio(int $idpaciente) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_peridomicilio.id AS id,
                            leishmania.v_peridomicilio.idanimal AS idanimal,
                            leishmania.v_peridomicilio.animal As animal,
                            leishmania.v_peridomicilio.idpaciente AS idpaciente,
                            leishmania.v_peridomicilio.distancia AS distancia,
                            leishmania.v_peridomicilio.cantidad AS cantidad,
                            leishmania.v_peridomicilio.usuario AS usuario,
                            leishmania.v_peridomicilio.alta AS alta
                     FROM leishmania.v_peridomicilio
                     WHERE leishmania.v_peridomicilio.idpaciente = '$idpaciente'
                     ORDER BY leishmania.v_peridomicilio.animal; ";

        // capturamos el error
        try {

            // ejecutamos y retornamos
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
     * Método que recibe como parámetro la clave de un registro
     * y asigna en las variables de clase los valores del mismo
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idperidomicilio - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosPeridomicilio(int $idperidomicilio) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_peridomicilio.id AS id,
                            leishmania.v_peridomicilio.idanimal AS idanimal,
                            leishmania.v_peridomicilio.idpaciente AS idpaciente,
                            leishmania.v_peridomicilio.distancia AS distancia,
                            leishmania.v_peridomicilio.cantidad AS cantidad,
                            leishmania.v_peridomicilio.usuario AS usuario,
                            leishmania.v_peridomicilio.alta AS alta
                     FROM leishmania.v_peridomicilio
                     WHERE leishmania.v_peridomicilio.id = '$idperidomicilio'; ";

        // capturamos el error
        try {

            // ejecutamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch();

            // asignamos
            $this->Id = $fila["id"];
            $this->Animal = $fila["idanimal"];
            $this->Paciente = $fila["idpaciente"];
            $this->Distancia = $fila["distancia"];
            $this->Cantidad = $fila["cantidad"];
            $this->Usuario = $fila["usuario"];
            $this->Alta = $fila["alta"];

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }
    
}
