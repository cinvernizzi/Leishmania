<?php

/**
 *
 * Class DicTecnicas | tecnicas/dictecnicas.class.php
 *
 * @package     Leishmania
 * @subpackage  Tecnicas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (17/05/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm del diccionario
 * de técnicas utilizadas
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
class DictTecnicas {

    // definición de las variables de clase
    protected $Id;             // clave del registro
    protected $Tecnica;        // nombre de la técnica
    protected $Alta;           // fecha de alta del registro
    protected $Modificado;     // fecha de modificación
    protected $Usuario;        // nombre del usuario
    protected $IdUsuario;      // clave del usuario
    protected $Link;           // puntero a la base de datos
    
    /**
     * Constructor de la clase, instanciamos la conexión
     * e inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // establecemos la conexión
        $this->Link = new Conexion();

        // inicializamos las variables
        $this->Id = 0;
        $this->Tecnica = "";
        $this->Alta = "";
        $this->Modificado = "";
        $this->IdUsuario = 0;
        $this->Usuario = "";
        
    }
    
    /*
     * Destructor de la clase, eliminamos los punteros
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
    public function setTecnica(string $tecnica) : void {
        $this->Tecnica = $tecnica;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }
    
    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getTecnica() : string {
        return $this->Tecnica;
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
     * @param [int] $id clave del registro
     * @return [bool] resultado de la operación
     */
    public function getDatosTecnica(int $id) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dictecnicas.id AS id,
                            leishmania.v_dictecnicas.tecnica AS tecnica,
                            leishmania.v_dictecnicas.alta AS alta,
                            leishmania.v_dictecnicas.modificado AS modificado,
                            leishmania.v_dictecnicas.usuario AS usuario
                     FROM leishmania.v_dictenicas
                     WHERE leishmania.v_dictenicas.id = $id; ";

        // capturamos el error
        try {

            // ejecutamos y asignamos en la clase
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->Id = $fila["id"];
            $this->Tecnica = $fila["tecnica"];
            $this->Alta = $fila["alta"];
            $this->Modificado = $fila["modificado"];
            $this->Usuario = $fila["usuario"];

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
     * Método que retorna la nómina completa de tipos
     * de técnicas utilizadas
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function nominaTecnicas() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dictecnicas.id AS id,
                            leishmania.v_dictecnicas.tecnica AS tecnica,
                            leishmania.v_dictecnicas.alta AS alta,
                            leishmania.v_dictecnicas.modificado AS modificado,
                            leishmania.v_dictecnicas.usuario AS usuario
                     FROM leishmania.v_dictecnicas
                     ORDER BY leishmania.v_dictecnicas.tecnica; ";

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
     * Método que según el estado de las variables
     * ejecuta la consulta de grabación o edición
     * retorna la clave del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro (o cero en caso de error)
     */
    public function grabaTecnica() : int {

        // si está insertando
        if ($this->Id == 0){
            $this->nuevaTecnica();
        } else {
            $this->editaTecnica();
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
     *
     */
    protected function nuevaTecnica() : bool {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.dictecnicas
                            (tecnica,
                             usuario)
                            VALUES
                            (:tecnica,
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":tecnica", $this->Tecnica);
            $preparada->bindParam(":usuario", $this->IdUsuario);
            $preparada->execute();

            // obtenemos la clave y retornamos
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
    protected function editaTecnica() : bool {

        // componemos la consulta
        $consulta = "UPDATE leishmania.dictecnicas SET
                            tecnica = :tecnica,
                            usuario = :usuario
                     WHERE leishmania.dictecnicas.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":tecnica", $this->Tecnica);
            $preparada->bindParam(":usuario", $this->IdUsuario);
            $preparada->bindParam(":id",      $this->Id);
            $preparada->execute();

            // retornamos
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
     * Método que recibe como parámetro la clave
     * de un registro y el nombre de la tecnica y
     * verifica si ya está declarada, retorna
     * verdadero si puede insertar / editar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @param [string] $tecnica - nombre de la técnica
     * @return [bool] verdadero si no lo encontró
     */
    public function validaTecnica(int $id, string $tecnica) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.dictecnicas.id) AS registros
                     FROM leishmania.dictecnicas
                     WHERE leishmania.dictecnicas.id != '$id' AND
                           leishmania.dictecnicas.tecnica = '$tecnica';";

        // capturamos el error
        try {

            // ejecutamos y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // según los registros
            return $fila["registros"] == 0 ? true : false;
            
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;
            
        }
        
    }
    
    /**
     * Método que recibe como parámetro la clave de
     * un registro y verifica que no tenga hijos,
     * (es decir que no esté asignado a ningún paciente)
     * en cuyo caso retorna verdadero, llamado antes
     * de eliminar un registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @return [bool] verdadero si puede eliminar
     */
    public function puedeBorrar(int $id) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.muestras.id) AS registros
                     FROM leishmania.muestras
                     WHERE leishmania.muestras.tecnica = '$id';)";

        // capturamos el error
        try{

            // ejecutamos y obtenemos el registro
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
     * Método que recibe la clave de un registro y ejecuta
     * la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @return [bool] resultado de la operación
     */
    public function borraTecnica(int $id) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.dictecnicas
                     WHERE leishmania.dictecnicas.id = :id; ";

        // capturamos el error
        try {

            // asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $id);
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

}
