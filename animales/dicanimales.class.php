<?php

/**
 *
 * Class DicAnimales | animales/dicanimales.class.php
 *
 * @package     Leishmania
 * @subpackage  Animales
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (24/07/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm del diccionario de
 * anilales y objetos del peridomicilio
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
class DicAnimales {

    // declaración de variables
    protected $Link;            // puntero a la base de datos
    protected $Id;              // clave del registro
    protected $Animal;          // descripción del animal
    protected $IdUsuario;       // clave del usuario
    protected $Usuario;         // nombre del usuario
    protected $Alta;            // fecha de alta del registro

    /**
     * Constructor de la clase, instanciamos la conexión e
     * inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct() {
        
        // definimos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Animal = "";
        $this->IdUsuario = 0;
        $this->Usuario = "";
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
    public function setAnimal(string $animal) : void {
        $this->Animal = $animal;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getAnimal() : string {
        return $this->Animal;
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
     * la clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaAnimal() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevoAnimal();
        } else {
            $resultado = $this->editaAnimal();
        }
        
        // retornamos
        return (int) $resultado;

    }

    /**
     * Método que ejecuta la consulta de inserción, retorna
     * la clave del nuevo registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function nuevoAnimal() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.dicanimales
                            (animal,
                             usuario)
                            VALUES
                            (:animal,
                             :usuario); ";
                             
        // capturamos el error
        try {
            
            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":animal",  $this->Animal);
            $preparada->bindParam(":usuario", $this->IdUsuario);
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
     * Método que ejecuta la consulta de edición retorna la
     * clave del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function editaAnimal() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.dicanimales SET
                            animal = :animal,
                            usuario = :usuario
                     WHERE leishmania.dicanimales.id = :id; ";
                     
        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":animal",  $this->Animal);
            $preparada->bindParam(":usuario", $this->IdUsuario);
            $preparada->bindParam(":id",      $this->Id);
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
     * Método que recibe como parámetro el nombre de un
     * animal y verifica que no se encuentre declarado,
     * retorna verdadero si puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $animal - descripción del animal
     * @param int $id - clave del registro cero en caso de alta
     * @return bool verdadero si puede insertar
     */
    public function validaAnimal(string $animal, int $id) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.dicanimales.id) AS registros
                     FROM leishmania.dicanimales
                     WHERE leishmania.dicanimales.animal = '$animal' AND
                           leishmania.dicanimales.id != '$id'; ";
                           
        // capturamos el error
        try {
            
            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return $fila["registros"] == 0 ? true : false;
            
        // si ocurrió un error
        } catch (PDOException $e) {
            
            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;
            
        }
        
    }

    /**
     * Método que recibe como parámetro la clave de un registro
     * y verifica que no tenga registros hijos en la tabla de
     * peridomicilio, si puede ser eliminado retorna verdadero
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idanimal - clave del registro
     * @return bool verdadero si puede eliminar
     */
    public function puedeBorrar(int $idanimal) : bool {
        
        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.peridomicilio.id) AS registros
                     FROM leishmania.peridomicilio
                     WHERE leishmania.peridomicilio.id = '$idanimal'; ";
                     
        // capturamos el error
        try {
            
            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            if ($fila["registros"] == 0){
                return true;
            } else {
                return false;
            }

        // si hubo un error
        } catch (PDOException $e){
            
            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;
            
        }

    }

    /**
     * Método que recibe la clave de un registro y ejecuta
     * la consulta de eliminación, retorna el resultado de
     * la operación
     */
    public function borraAnimal(int $idanimal) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.dicanimales
                     WHERE leishmania.dicanimales.id = :id; ";

        // capturamos el error
        try {

            // ejecutamos y retornamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idanimal);
            $preparada->execute();
            return true;

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que retorna el diccionario completo con la nómina
     * de animales y objetos registrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array - vector con los registros
     */
    public function nominaAnimales() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dicanimales.id AS id,
                            leishmania.v_dicanimales.animal AS animal,
                            leishmania.v_dicanimales.usuario AS usuario,
                            leishmania.v_dicanimales.alta AS alta
                     FROM leishmania.v_dicanimales
                     ORDER BY leishmania.v_dicanimales.animal; ";

        // capturamos el error
        try {

            // ejecutamos y retornamos
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
     * Método que recibe la clave de un registro y asigna
     * los valores de este en las variables de clase,
     * retorna el resultado de la operación
     */
    public function getDatosAnimal(int $idanimal) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dicanimales.id AS id,
                            leishmania.v_dicanimales.animal AS animal,
                            leishmania.v_dicanimales.usuario AS usuario,
                            leishmania.v_dicanimales.alta AS alta
                     FROM leishmania.v_dicanimales
                     WHERE leishmania.v_dicanimales.id = '$idanimal'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // asignamos en la clase
            $this->Id = $fila["id"];
            $this->Animal = $fila["animal"];
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
