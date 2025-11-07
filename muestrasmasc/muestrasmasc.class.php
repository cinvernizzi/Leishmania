<?php

/**
 *
 * Class MuestrasMasc | muestrasmasc/MuestrasMasc.class.php
 *
 * @package     Leishmania
 * @subpackage  MuestrasMasc
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (13/08/2025)
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
 * Clase que controla las operaciones sobre la tabla de muestras tomadas
 * a las mascotas
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class MuestrasMasc {

    // definición de variables
    protected $Link;                // puntero a la base
    protected $Id;                  // clave del registro
    protected $Mascota;             // clave de la mascota
    protected $Paciente;            // clave del paciente o tutor
    protected $Material;            // clave del material recibido
    protected $Tecnica;             // clave de la técnica utilizada
    protected $Fecha;               // fecha de recepción
    protected $Resultado;           // resultado obtenido
    protected $Determinacion;       // fecha de la determinación
    protected $Usuario;             // nombre del usuario
    protected $IdUsuario;           // clave del usuario
    protected $Alta;                // fecha de alta del registro

    /**
     * Constructor de la clase, instanciamos la conexión y
     * definimos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // definimos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Mascota = 0;
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
    public function setMaterial(int $material) : void {
        $this->Material = $material;
    }
    public function setTecnica(int $tecnica) : void {
        $this->Tecnica = $tecnica;
    }
    public function setFecha(string $fecha) : void {
        $this->Fecha = $fecha;
    }
    public function setResultado(string $resultado) : void {
        $this->Resultado = $resultado;
    }
    public function setDeterminacion(string $determinacion) : void {
        $this->Determinacion = $determinacion;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getMascota() : int {
        return $this->Mascota;
    }
    public function getPaciente() : int {
        return (int) $this->Paciente;
    }
    public function getMaterial() : int {
        return (int) $this->Material;
    }
    public function getTecnica() : int {
        return $this->Tecnica;
    }
    public function getFecha() : string {
        return $this->Fecha;
    }
    public function getResultado() : string {
        return $this->Resultado;
    }
    public function getDeterminacion() : string {
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
     * ejecuta la consulta de edición o inserción, retorna
     * la clave del registro afectado o cero en caso de
     * error
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
     * Método que ejecuta la consulta de inserción, retorna
     * la clave del nuevo registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function nuevaMuestra() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.muestrasmasc
                            (mascota,
                             paciente,
                             material,
                             tecnica,
                             fecha,
                             resultado,
                             determinacion,
                             usuario)
                            VALUES
                            (:mascota,
                             :paciente,
                             :material,
                             :tecnica,
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :resultado,
                             STR_TO_DATE(:determinacion, '%d/%m/%Y'),
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":mascota",       $this->Mascota);
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
            
        // si hubo un error
        } catch (PDOEXception $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que ejecuta la consulta de edición, retorna
     * la clave del registro afectado o cero en caso de errror
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function editaMuestra(){

        // componemos la consulta
        $consulta = "UPDATE leishmania.muestrasmasc SET
                            material = :material,
                            tecnica = :tecnica,
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            resultado = :resultado,
                            determinacion = STR_TO_DATE(:determinacion, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.muestrasmasc.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
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
            
        // si hubo un error
        } catch (PDOEXception $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe como parámetro la clave de un registro y
     * asigna en las variables de clase los valores del mismo
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmuestra - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosMuestra(int $idmuestra) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_muestrasmasc.id AS id,
                            leishmania.v_muestrasmasc.idmascota AS mascota,
                            leishmania.v_muestrasmasc.idpaciente AS paciente,
                            leishmania.v_muestrasmasc.idmaterial AS material,
                            leishmania.v_muestrasmasc.idtecnica AS tecnica,
                            leishmania.v_muestrasmasc.fecha AS fecha,
                            leishmania.v_muestrasmasc.resultado AS resultado,
                            leishmania.v_muestrasmasc.determinacion AS determinacion,
                            leishmania.v_muestrasmasc.usuario AS usuario,
                            leishmania.v_muestrasmas.alta AS alta
                     FROM leishmania.v_muestrasmasc
                     WHERE leishmania.v_muestrasmasc.id = '$idmuestra'; ";

        // capturamos el error
        try {

            // obtenemos el registro y asignamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->Id = $fila["id"];
            $this->Mascota = $fila["mascota"];
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
        } catch (PDOEXception $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro la clave de una mascota
     * y retorna el vector con todas las muestras tomadas a
     * esa mascota
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmascota - clave de la mascota
     * @return array vector con las muestras
     */
    public function nominaMuestras(int $idmascota) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_muestrasmasc.id AS id,
                            leishmania.v_muestrasmasc.idmaterial AS idmaterial,
                            leishmania.v_muestrasmasc.material AS material,
                            leishmania.v_muestrasmasc.idtecnica AS idtecnica,
                            leishmania.v_muestrasmasc.tecnica AS tecnica,
                            leishmania.v_muestrasmasc.fecha AS fecha,
                            leishmania.v_muestrasmasc.resultado AS resultado,
                            leishmania.v_muestrasmasc.determinacion AS determinacion,
                            leishmania.v_muestrasmasc.usuario AS usuario,
                            leishmania.v_muestrasmasc.alta AS alta
                     FROM leishmania.v_muestrasmasc
                     WHERE leishmania.v_muestrasmasc.idmascota = '$idmascota'; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrión un error
        } catch (PDOEXception $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave de una mascota
     * y la fecha de recepción de la muestra y retorna el vector 
     * con todas las muestras tomadas a esa mascota
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmascota - clave de la mascota
     * @param string $fecha - fecha de recepción
     * @return array vector con las muestras
     */
    public function muestrasFecha(int $idmascota, string $fecha) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_muestrasmasc.id AS id,
                            leishmania.v_muestrasmasc.mascota AS mascota, 
                            leishmania.v_muestrasmasc.idmaterial AS idmaterial,
                            leishmania.v_muestrasmasc.material AS material,
                            leishmania.v_muestrasmasc.idtecnica AS idtecnica,
                            leishmania.v_muestrasmasc.tecnica AS tecnica,
                            leishmania.v_muestrasmasc.fecha AS fecha,
                            leishmania.v_muestrasmasc.resultado AS resultado,
                            leishmania.v_muestrasmasc.determinacion AS determinacion,
                            leishmania.v_muestrasmasc.usuario AS usuario,
                            leishmania.v_muestrasmasc.alta AS alta
                     FROM leishmania.v_muestrasmasc
                     WHERE leishmania.v_muestrasmasc.idmascota = '$idmascota' AND 
                           STR_TO_DATE(leishmania.v_muestrasmasc.fecha, '%d/%m/%Y') = STR_TO_DATE('$fecha', '%d/%m/%Y'); ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrión un error
        } catch (PDOEXception $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave de una muestra
     * y ejecuta la consulta de eliminación, retorna el resultado
     * de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmuestra - clave del registro
     * @return bool resultado de la operación
     */
    public function borraMuestra(int $idmuestra) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.muestrasmasc
                     WHERE leishmania.muestrasmasc.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idmuestra);
            $preparada->execute();

            // retornamos
            return true;

        // si ocurrión un error
        } catch (PDOEXception $e){

            // retornamos
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que obtiene los registros de las muestras
     * de mascotas sin determinación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function getPendientesMascotas() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.mascota AS mascota,
                            leishmania.v_pacientes.materialmasc AS material,
                            leishmania.v_pacientes.tecnicamasc AS tecnica,
                            leishmania.v_pacientes.fechamuestramasc AS fecha_muestra
                     FROM leishmania.v_pacientes
                     WHERE ISNULL(leishmania.v_pacientes.resultadomasc) AND
                           NOT ISNULL(leishmania.v_pacientes.materialmasc)
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y'),
                              leishmania.v_pacientes.nombre; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
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
     * Método que obtiene los registros de las muestras
     * de mascotas sin notificar al sisa
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function getPendientesNotificar() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.mascota AS mascota,
                            leishmania.v_pacientes.materialmasc AS material,
                            leishmania.v_pacientes.tecnicamasc AS tecnica,
                            leishmania.v_pacientes.fechamuestramasc AS fecha_muestra
                     FROM leishmania.v_pacientes
                     WHERE NOT ISNULL(leishmania.v_pacientes.resultadomasc) AND
                           ISNULL(leishmania.v_pacientes.sisa)
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y'),
                              leishmania.v_pacientes.nombre; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

}
