<?php

/**
 *
 * Class Ocupaciones | ocupaciones/ocupaciones.class.php
 *
 * @package     leishmania
 * @subpackage  Ocupaciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (03/06/2022)
 * @copyright   Copyright (c) 2017, INP
 *
 */

// declaramos el tipeado estricto
declare(strict_types=1);

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
 * Clase que controla las operaciones sobre la tabla de ocupaciones
 * de los pacientes
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Ocupaciones {

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $Link;                // puntero a la base de datos
    protected $Id;                  // clave del registro
    protected $Ocupacion;           // descripción de la ocupación
    protected $Alta;                // fecha de alta del registro
    protected $IdUsuario;           // clave del usuario
    protected $Usuario;             // nombre del usuario

    // constructor de la clase
    public function __construct(){

        // inicializamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Ocupacion = "";
        $this->Alta = "";
        $this->IdUsuario = 0;
        $this->Usuario = "";

    }

    // destructor de la clase
    public function __destruct(){
        
        // eliminamos el puntero
        $this->Link = null;

    }

    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setOcupacion(string $ocupacion) : void {
        $this->Ocupacion = $ocupacion;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getOcupacion() : string {
        return $this->Ocupacion;
    }
    public function getAlta() : string {
        return $this->Alta;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }

    /**
     * Método que retorna la nómina completa de ocupaciones
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array vector con los registros
     */
    public function nominaOcupaciones() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_ocupaciones.id AS id,
                            leishmania.v_ocupaciones.ocupacion AS ocupacion,
                            leishmania.v_ocupaciones.alta AS alta,
                            leishmania.v_ocupaciones.usuario AS usuario
                     FROM leishmania.v_ocupaciones
                     ORDER BY leishmania.v_ocupaciones.ocupacion;";


        // capturamos el error
        try {

            // ejecutamos y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e) {

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que según el valor de la clave inserta
     * o edita el registro, retorna la clave del
     * registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int - clave del registro
     */
    public function grabaOcupacion() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevaOcupacion();
        } else {
            $resultado = $this->editaOcupacion();
        }

        // retornamos la clave
        return (int) $resultado;

    }

    /**
     * Método que genera la consulta de inserción
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro o cero en caso de error
     */
    protected function nuevaOcupacion() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.ocupaciones
                            (ocupacion,
                             usuario)
                            VALUES
                            (:ocupacion,
                             :usuario); ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":ocupacion", $this->Ocupacion);
            $psInsertar->bindParam(":usuario",   $this->IdUsuario);

            // la ejecutamos
            $psInsertar->execute();

            // obtenemos la clave
            return (int) $this->Link->lastInsertId();
        
        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que genera la consulta de edición
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro o cero en caso de error
     */
    protected function editaOcupacion() : int{

        // componemos la consulta
        $consulta = "UPDATE leishmania.ocupaciones SET
                            ocupacion = :ocupacion,
                            usuario = :usuario
                     WHERE leishmania.ocupaciones.id = :id;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":ocupacion", $this->Ocupacion);
            $psInsertar->bindParam(":usuario",   $this->IdUsuario);
            $psInsertar->bindParam(":id",        $this->Id);

            // la ejecutamos
            $psInsertar->execute();

            // retornamos
            return (int) $this->Id;


        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe como parámetro el nombre de una
     * ocupación y verifica que no esté declarada,
     * retorna verdadero si puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $ocupacion - nombre de la ocupación
     * @return bool si puede insertar
     */
    public function validaOcupacion(string $ocupacion) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.v_ocupaciones.id) As registros
                     FROM leishmania.v_ocupaciones
                     WHERE leishmania.v_ocupaciones.ocupacion = '$ocupacion';";
        $resultado = $this->Link->query($consulta);
        
        // capturamos el error
        try {

            // obtenemos el registro y retornamos
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return $fila["registros"] == 0 ? true : false;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave de un
     * registro y asigna en las variables de clase
     * los valores del mismo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idocupacion - clave del registro
     */
    public function getDatosOcupacion(int $idocupacion){

        // componemos la consulta
        $consulta = "SELECT leishmania.v_ocupaciones.id AS id,
                            leishmania.v_ocupaciones.ocupacion AS ocupacion,
                            leishmania.v_ocupaciones.alta AS alta,
                            leishmania.v_ocupaciones.usuario AS usuario
                     FROM leishmania.v_ocupaciones
                     WHERE leishmania.v_ocupaciones.id = '$idocupacion';";
        $resultado = $this->Link->query($consulta);

        // obtenemos el registro y asignamos
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        $this->Id = $fila["id"];
        $this->Ocupacion = $fila["ocupacion"];
        $this->Alta = $fila["alta"];
        $this->Usuario = $fila["usuario"];

    }

    /**
     * Método que verifica que la ocupación no tenga
     * registros hijos, retorna si puede eliminar el
     * registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idocupacion - clave del registro
     * @return bool verdadero si puede borrar
     */
    public function puedeBorrar(int $idocupacion) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.pacientes.id) AS registros
                     FROM leishmania.pacientes
                     WHERE leishmania.pacientes.ocupacion = '$idocupacion';";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            
            // según los registros
            return $fila["registros"] == 0 ? true : false;

        // si ocurrió un error
        } catch (PDOException $e){

            // retornamos
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que ejecuta la consulta de eliminación
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idocupacion - clave del registro
     * @return bool resultado de la operación
     */
    public function borraOcupacion(int $idocupacion) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.ocupaciones
                     WHERE leishmania.ocupaciones.id = :id;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":id", $idocupacion);

            // la ejecutamos y retornamos
            $psInsertar->execute();
            return true;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return false;

        }

    }

}
