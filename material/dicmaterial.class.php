<?php

/**
 *
 * Class DicMaterial | material/dicmaterial.class.php
 *
 * @package     Leishmania
 * @subpackage  Material
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (16/05/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm del diccionario
 * de materiales remitidos
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
class DictMaterial {

    // definición de las variables de clase
    protected $Link;        // puntero a la base de datos
    protected $Id;          // clave del registro
    protected $Material;    // descripción del material
    protected $Alta;        // fecha de alta del registro
    protected $Modificado;  // fecha de modificación del registro
    protected $IdUsuario;   // clave del usuario
    protected $Usuario;     // nombre del usuario
    
    /**
     * Constructor de la clase, instanciamos la conexión
     * e inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // instanciamos la conexión
        $this->Link = new Conexion();

        // inicializamos las variables
        $this->Id = 0;
        $this->Material = "";
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

        // eliminamos la conexión
        $this->Link = null;
        
    }
    
    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setMaterial(string $material) : void {
        $this->Material = $material;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }
    
    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getMaterial() : string {
        return $this->Material;
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
    public function getDatosMaterial(int $id) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dicmaterial.id AS id,
                            leishmania.v_dicmaterial.material AS material,
                            leishmania.v_dicmaterial.alta AS alta,
                            leishmania.v_dicmaterial.modificado AS modificado,
                            leishmania.v_dicmaterial.usuario AS usuario
                     FROM leishmania.v_dicmaterial
                     WHERE leishmania.v_dicmaterial.id = '$id'; ";

        // capturamos el error
        try{

            // ejecutamos y asignamos en la clase
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->Id = $fila["id"];
            $this->Material = $fila["material"];
            $this->Alta = $fila["alta"];
            $this->Modificado = $fila["modificado"];
            $this->Usuario = $fila["usuario"];

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            $e->getMessage();
            return false;
            
        }
        
    }
    
    /**
     * Método que retorna la nómina completa de tipos
     * de material recibidos
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function nominaMateriales() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_dicmaterial.id AS id,
                            leishmania.v_dicmaterial.material AS material,
                            leishmania.v_dicmaterial.alta AS alta,
                            leishmania.v_dicmaterial.modificado AS modificado,
                            leishmania.v_dicmaterial.usuario AS usuario
                     FROM leishmania.v_dicmaterial
                     ORDER BY leishmania.v_dicmaterial.material; ";

        // capturamos el error
        try{

            // ejecutamos y retornamos
            $resultado = $this->Link->query($consulta);
            return  $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            $e->getMessage();
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
    public function grabaMaterial() : int {

        // si está insertando
        if ($this->Id == 0){
            $this->nuevoMaterial();
        } else {
            $this->editaMaterial();
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
    protected function nuevoMaterial() : bool {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.dicmaterial
                            (material,
                             usuario)
                            VALUES
                            (:material,
                             :usuario);";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":material", $this->Material);
            $preparada->bindParam(":usuario",  $this->IdUsuario);
            $preparada->execute();

            // asignamos la clave y retornamos
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
    protected function editaMaterial() : bool {

        // componemos la consulta
        $consulta = "UPDATE leishmania.dicmaterial SET
                            material = :material,
                            usuario = :usuario
                     WHERE leishmania.dicmaterial.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":material", $this->Material);
            $preparada->bindParam(":usuario",  $this->IdUsuario);
            $preparada->bindParam(":id",       $this->Id);
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
     * de un registro y el nombre del material y
     * verifica si ya está declarado, retorna
     * verdadero si puede insertar / editar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @param [string] $material - nombre del material
     * @return [bool] verdadero si no lo encontró
     */
    public function validaMaterial(int $id, string $material) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.dicmaterial.id) AS registros
                     FROM leishmania.dicmaterial
                     WHERE leishmania.dicmaterial.id != '$id' AND
                           leishmania.dicmaterial.material = '$material';";

        // capturamos el error
        try {

            // obtenemos el registro
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
        $consulta = "SELECT COUNT(leishmania.muestras.id) As registros
                     FROM leishmania.muestras
                     WHERE leishmania.muestras.material = '$id';";

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
     * Método que recibe la clave de un registro y ejecuta
     * la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $id - clave del registro
     * @return [bool] resultado de la operación
     */
    public function borraMaterial(int $id) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.dicmaterial
                     WHERE leishmania.dicmaterial.id = :id; ";

        // capturamos el error
        try {

            // ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $id);
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }
            
    }

}
