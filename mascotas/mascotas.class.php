<?php

/**
 *
 * Class Mascotas | mascotas/mascotas.class.php
 *
 * @package     Leishmania
 * @subpackage  Mascotas
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
 * Clase que controla las operaciones sobre la tabla de mascotas
 * del paciente
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Mascotas {

    // declaración de variables
    protected $Link;              // puntero a la base de datos
    protected $Id;                // clave del registro
    protected $Paciente;          // clave del paciente
    protected $Nombre;            // nombre de la mascota
    protected $Edad;              // edad en años
    protected $Origen;            // descripción del origen
    protected $Usuario;           // nombre del usuario
    protected $IdUsuario;         // clave del usuario
    protected $Alta;              // fecha de alta del registro

    /**
     * Constructor de la clase, inicializamos las variables y
     * el puntero a la base de datos
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // inicializamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Paciente = 0;
        $this->Nombre = "";
        $this->Edad = 0;
        $this->Origen = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = "";

    }

    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct() {
        
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
    public function setNombre(string $nombre) : void {
        $this->Nombre = $nombre;
    }
    public function setEdad(int $edad) : void {
        $this->Edad = $edad;
    }
    public function setOrigen(string $origen) : void {
        $this->Origen = $origen;
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
    public function getNombre() : string {
        return $this->Nombre;
    }
    public function getEdad() : int {
        return (int) $this->Edad;
    }
    public function getOrigen() : string {
        return $this->Origen;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que según el estado de las variables de clase
     * genera la consulta de inserción o edición, retorna la
     * clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaMascota() : int {

        // so está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevaMascota();
        } else {
            $resultado = $this->editaMascota();
        }

        // retornamos
        return (int) $resultado;

    }

    /**
     * Método que ejecuta la consulta de inserción, retorna la
     * clave del nuevo registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function nuevaMascota() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.mascotas
                            (paciente,
                             nombre,
                             edad,
                             origen,
                             usuario)
                            VALUES
                            (:paciente,
                             :nombre,
                             :edad,
                             :origen,
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos y asignamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente", $this->Paciente);
            $preparada->bindParam(":nombre",   $this->Nombre);
            $preparada->bindParam(":edad",     $this->Edad);
            $preparada->bindParam(":origen",   $this->Origen);
            $preparada->bindParam(":usuario",  $this->IdUsuario);

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
     * Método que ejecuta la consulta de actualización, retorna
     * la clave del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaMascota() : int {

            // componemos la consulta
            $consulta = "UPDATE leishmania.mascotas SET
                                nombre = :nombre,
                                edad = :edad,
                                origen = :origen,
                                usuario = :usuario
                         WHERE leishmania.mascotas.id = :id; ";

        // capturamos el error
        try {

            // preparamos y asignamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":nombre",   $this->Nombre);
            $preparada->bindParam(":edad",     $this->Edad);
            $preparada->bindParam(":origen",   $this->Origen);
            $preparada->bindParam(":usuario",  $this->IdUsuario);
            $preparada->bindParam(":id",       $this->Id);

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
     * Método que recibe la clave de un registro y ejecuta la
     * consulta de eliminación, retorna el resultado de la
     * operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmascota - clave del registro
     * @return bool resultado de la operación
     */
    public function borraMascota(int $idmascota) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.mascotas
                     WHERE leishmania.mascotas.id = :id; ";

        // capturamos el error
        try {

            // asignamos la consulta y los parámetros
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idmascota);
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
     * y retorna el vector con todas las mascotas de ese paciente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @return array vector con los registros
     */
    public function nominaMascotas(int $idpaciente) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_mascotas.id AS id,
                            leishmania.v_mascotas.idpaciente AS paciente,
                            leishmania.v_mascotas.nombre AS nombre,
                            leishmania.v_mascotas.edad AS edad,
                            leishmania.v_mascotas.origen AS origen,
                            leishmania.v_mascotas.usuario AS usuario,
                            leishmania.v_mascotas.alta AS alta
                     FROM leishmania.v_mascotas
                     WHERE leishmania.v_mascotas.idpaciente = '$idpaciente'
                     ORDER BY leishmania.v_mascotas.nombre; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave de un registro
     * y asigna los valores del mismo en las variables de clase
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idmascota - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosMascota(int $idmascota) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_mascotas.id AS id,
                            leishmania.v_mascotas.idpaciente AS paciente,
                            leishmania.v_mascotas.nombre AS nombre,
                            leishmania.v_mascotas.edad AS edad,
                            leishmania.v_mascotas.origen AS origen,
                            leishmania.v_mascotas.usuario AS usuario
                            leishmania.v_mascotas.alta AS alta
                     FROM leishmania.v_mascotas
                     WHERE leishmania.v_mascotas.id = '$idmascota'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // asignamos en la clase
            $this->Id = $fila["id"];
            $this->Paciente = $fila["paciente"];
            $this->Nombre = $fila["nombre"];
            $this->Edad = $fila["edad"];
            $this->Origen = $fila["origen"];
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

    /**
     * Método que recibe como parámetro el año a reportar
     * y obtiene los registros de las muestras de mascotas
     * notificadas al sisa en ese año
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - año a reportar
     * @return [array] vector con los registros
     */
    public function getNotificadosMascotas(int $anio) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.mascota AS mascota,
                            leishmania.v_pacientes.materialmasc AS material,
                            leishmania.v_pacientes.tecnicamasc AS tecnica,
                            leishmania.v_pacientes.fechamuestramasc AS fecha_muestra
                     FROM leishmania.v_pacientes
                     WHERE YEAR(STR_TO_DATE(leishmania.v_pacientes.notificado, '%d/%m/%Y')) = '$anio' AND
                           NOT ISNULL(leishmania.v_pacientes.materialmasc)
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y),
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
