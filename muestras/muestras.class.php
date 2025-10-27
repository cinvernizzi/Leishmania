<?php

/**
 *
 * Class Muestras | muestras/muestras.class.php
 *
 * @package     Leishmania
 * @subpackage  Muestras
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (30/07/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm de las muestras
 * recibidas de un paciente
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
 * Definición de la clase, no vamos a validar las muestras porque
 * en teoría es posible que sobre una misma muestra se aplique
 * varias veces la misma técnica en caso de resultados
 * discordantes o dudosos
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Muestras {

    // definición de variables
    protected $Link;            // puntero a la base de datos
    protected $Id;              // clave del registro
    protected $Paciente;        // clave del paciente
    protected $Material;        // clave del material
    protected $Tecnica;         // clave de la técnica utilizada
    protected $Fecha;           // fecha de recepción de la muestra
    protected $Resultado;       // resultado obtenido
    protected $Determinacion;   // fecha de la determinación
    protected $Usuario;         // nombre del usuario
    protected $IdUsuario;       // clave del usuario
    protected $Alta;            // fecha de alta del registro
    
    /**
     * Constructor de la clase, instanciamos la conexión e
     * inicializamos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // inicializamos
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Paciente = 0;
        $this->Material = 0;
        $this->Tecnica = 0;
        $this->Fecha = "";
        $this->Resultado = "";
        $this->Determinacion = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = "";
        
    }
    
    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // destruimos el puntero
        $this->Link = null;
        
    }
    
    // métodos de asignación de valores
    public function setId(int $id) : void {
        $this->Id = $id;
    }
    public function setPaciente(int $paciente) : void {
        $this->Paciente = $paciente;
    }
    public function setMaterial(int $material) : void {
        $this->Material = $material;
    }
    public function setTecnica(int $tecnica) : void {
        $this->Tecnica = $tecnica;
    }
    public function setFecha(string $fecha) : void {
        $this->Fecha = $fecha;
    }
    public function setResultado(?string $resultado) : void {
        $this->Resultado = $resultado;
    }
    public function setDeterminacion(?string $fecha) : void {
        $this->Determinacion = $fecha;
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
    public function getMaterial() : int {
        return (int) $this->Material;
    }
    public function getTecnica() : int {
        return (int) $this->Tecnica;
    }
    public function getFecha() : string {
        return $this->Fecha;
    }
    public function getResultado() : ?string {
        return $this->Resultado;
    }
    public function getDeterminacion() : ?string {
        return $this->Determinacion;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }
    
    /**
     * Método que según el estado de las variables de clase
     * llama la consulta de edición o inserción, retorna la
     * clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaMuestra() : int {
        
        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevaMuestra();
        } else {
            $resultado = $this->editaMuestra();
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
    protected function nuevaMuestra() : int {
        
        // componemos la consulta
        $consulta = "INSERT INTO leishmania.muestras
                            (paciente,
                             material,
                             tecnica,
                             fecha,
                             resultado,
                             determinacion,
                             usuario)
                            VALUES
                            (:paciente,
                             :material,
                             :tecnica,
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :resultado,
                             STR_TO_DATE(:determinacion, '%d/%m/%Y'),
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente",      $this->Paciente);
            $preparada->bindParam(":material",      $this->Material);
            $preparada->bindParam(":tecnica",       $this->Tecnica);
            $preparada->bindParam(":fecha",         $this->Fecha);
            $preparada->bindParam(":resultado",     $this->Resultado);
            $preparada->bindParam(":determinacion", $this->Determinacion);
            $preparada->bindParam(":usuario",       $this->IdUsuario);
            $preparada->execute();

            // retornamos
            return (int) $this->Link->lastInsertId();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;

        }

    }
    
    /**
     * Método que ejecuta la consulta de actualización y
     * retorna la clave del registro afectado o cero en
     * caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaMuestra() : int {
        
        // componemos la consulta
        $consulta = "UPDATE leishmania.muestras SET
                            material = :material,
                            tecnica = :tecnica,
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            resultado = :resultado,
                            determinacion = STR_TO_DATE(:determinacion, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.muestras.id = :id; ";

        // capturamos el error
        try {

            // preparamos asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":material",      $this->Material);
            $preparada->bindParam(":tecnica",       $this->Tecnica);
            $preparada->bindParam(":fecha",         $this->Fecha);
            $preparada->bindParam(":resultado",     $this->Resultado);
            $preparada->bindParam(":determinacion", $this->Determinacion);
            $preparada->bindParam(":usuario",       $this->IdUsuario);
            $preparada->bindParam(":id",            $this->Id);
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
     * Método que recibe como parámetro la clave de un
     * registro y ejecuta la consulta de eliminación,
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $iodmuestra - clave del registro
     * @return bool resultado de la operación
     */
    public function borraMuestra(int $idmuestra) : bool {
        
        // componemos la consulta
        $consulta = "DELETE FROM leishmania.muestras
                     WHERE leishmania.muestras.id = :id; ";

        // capturamos el error
        try {

            // preparamos asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idmuestra);
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave de un
     * paciente y retorna el vector con todas las muestras
     * de ese paciente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente clave del paciente
     * @return array vector con los registros
     */
    public function nominaMuestras(int $idpaciente) : array {
        
        // componemos la consulta
        $consulta = "SELECT leishmania.v_muestras.id AS id,
                            leishmania.v_muestras.idpaciente AS paciente,
                            leishmania.v_muestras.idmaterial AS idmaterial,
                            leishmania.v_muestras.material AS material,
                            leishmania.v_muestras.idtecnica AS idtecnica,
                            leishmania.v_muestras.tecnica AS tecnica,
                            leishmania.v_muestras.fecha AS fecha,
                            leishmania.v_muestras.resultado AS resultado,
                            leishmania.v_muestras.determinacion AS determinacion,
                            leishmania.v_muestras.usuario AS usuario,
                            leishmania.v_muestras.alta AS alta
                     FROM leishmania.v_muestras
                     WHERE leishmania.v_muestras.idpaciente = '$idpaciente'
                     ORDER BY STR_TO_DATE(leishmania.v_muestras.alta, '%d/%m/%Y') DESC; ";

        // capturamos el error
        try {

            // obtenemos el vector
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }
    
    /**
     * Método que recibe como parámetro la clave de un registro
     * y asigna los valores del mismo a las variables de clase
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmuestra - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosMuestra(int $idmuestra) : bool {

        $consulta = "SELECT leishmania.v_muestras.id AS id,
                            leishmania.v_muestras.idpaciente AS paciente,
                            leishmania.v_muestras.idmaterial AS material,
                            leishmania.v_muestras.idtecnica AS tecnica,
                            leishmania.v_muestras.fecha AS fecha,
                            leishmania.v:muestras.resultado AS resultado,
                            leishmania.v_muestras.determinacion AS determinacion,
                            leishmania.v_muestras.usuario AS usuario,
                            leishmania.v_muestras.alta AS alta
                     FROM leishmania.v_muestras
                     WHERE leishmania.v_muestras.id = '$idmuestra'; ";
                
        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // asignamos en la clase
            $this->Id = $fila["id"];
            $this->Paciente = $fila["paciente"];
            $this->Material = $fila["material"];
            $this->Tecnica = $fila["tecnica"];
            $this->Fecha = $fila["fecha"];
            $this->Resultado = $fila["resultado"];
            $this->Determinacion = $fila["determinacion"];
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
