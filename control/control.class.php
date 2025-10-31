<?php

/**
 *
 * Class Control | control/control.class.php
 *
 * @package     Leishmania
 * @subpackage  Control
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (30/07/2025)
 * @copyright   Copyright (c) 2025, DsGestión
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
 * Clase que controla las operaciones sobre la tabla de control y
 * seguimiento del paciente
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Control {

    // definimos las variables
    protected $Link;                 // puntero a la base de datos
    protected $Id;                   // clave del registro
    protected $Paciente;             // clave del paciente
    protected $Tratamiento;          // descripción del tratamiento
    protected $Droga;                // nombre de la droga
    protected $Dosis;                // dosis en miligramos
    protected $Contactos;            // si se exploraron contactos
    protected $NroContactos;         // número de contactos explorados
    protected $ContactosPos;         // número de contactos positivos
    protected $Bloqueo;              // si se realizó bloqueo en el peridomicilio
    protected $NroViviendas;         // cantidad de viviendas exploradas
    protected $SitiosRiesgo;         // descripción de los sitios de riesgo controlados
    protected $Insecticida;          // insecticida utilizado
    protected $CantidadInsec;        // cantidad de insecticida utilizado
    protected $Fecha;                // fecha del control (puede haber mas de uno)
    protected $Usuario;              // nombre del usuario
    protected $IdUsuario;            // clave del usuario
    protected $Alta;                 // fecha de alta del registro

    /**
     * Constructor de la clase, instanciamos la conexión y las
     * variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // instanciamos las variables
        $this->Link = new Conexion();
        $this->Id = 0;
        $this->Paciente = 0;
        $this->Tratamiento = "";
        $this->Droga = "";
        $this->Dosis = 0;
        $this->Contactos = "No";
        $this->NroContactos = 0;
        $this->ContactosPos = 0;
        $this->Bloqueo = "No";
        $this->NroViviendas = 0;
        $this->SitiosRiesgo = "No";
        $this->Insecticida = "No";
        $this->CantidadInsec = 0;
        $this->Fecha = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->Alta = date('d/m/Y');

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
    public function setTratamiento(?string $tratamiento) : void {
        $this->Tratamiento = $tratamiento;
    }
    public function setDroga(?string $droga) : void {
        $this->Droga = $droga;
    }
    public function setDosis(?int $dosis) : void {
        $this->Dosis = $dosis;
    }
    public function setContactos(?string $contactos) : void {
        $this->Contactos = $contactos;
    }
    public function setNroContactos(?int $numero) : void {
        $this->NroContactos = $numero;
    }
    public function setContactosPos(?int $contactos) : void {
        $this->ContactosPos = $contactos;
    }
    public function setBloqueo(?string $bloqueo) : void {
        $this->Bloqueo = $bloqueo;
    }
    public function setNroViviendas(?int $numero) : void {
        $this->NroViviendas = $numero;
    }
    public function setSitiosRiesgo(?string $sitios) : void {
        $this->SitiosRiesgo = $sitios;
    }
    public function setInsecticida(?string $insecticida) : void {
        $this->Insecticida = $insecticida;
    }
    public function setCantidadInsec(?int $cantidad) : void {
        $this->CantidadInsec = $cantidad;
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
    public function getTratamiento() : ?string {
        return $this->Tratamiento;
    }
    public function getDroga() : ?string {
        return $this->Droga;
    }
    public function getDosis() : ?int {
        return (int) $this->Dosis;
    }
    public function getContactos() : ?string {
        return $this->Contactos;
    }
    public function getNroContactos() : ?int {
        return (int) $this->NroContactos;
    }
    public function getContactosPos() : ?int {
        return (int) $this->ContactosPos;
    }
    public function getBloqueo() : ?string {
        return $this->Bloqueo;
    }
    public function getNroViviendas() : ?int {
        return (int) $this->NroViviendas;
    }
    public function getSitiosRiesgo() : ?string {
        return $this->SitiosRiesgo;
    }
    public function getInsecticida() : ?string {
        return $this->Insecticida;
    }
    public function getCantidadInsec() : ?int {
        return (int) $this->CantidadInsec;
    }
    public function getFecha() : ?string {
        return $this->Fecha;
    }
    public function getUsuario() : ?string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }

    /**
     * Método que según los valores de las variables de clase
     * genera la consulta de edición o inserción, retorna la
     * clave del registro afectado o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    public function grabaControl() : int {

        // si está insertando
        if ($this->Id == 0){
            $resultado = $this->nuevoControl();
        } else {
            $resultado = $this->editaControl();
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
    protected function nuevoControl() : int {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.control
                            (paciente,
                             tratamiento,
                             droga,
                             dosis,
                             contactos,
                             nrocontactos,
                             contactospos,
                             bloqueo,
                             nroviviendas,
                             sitiosriesgo,
                             insecticida,
                             cantidadinsec,
                             fecha,
                             usuario)
                            VALUES
                            (:paciente,
                             :tratamiento,
                             :droga,
                             :dosis,
                             :contactos,
                             :nrocontactos,
                             :contactospos,
                             :bloqueo,
                             :nroviviendas,
                             :sitiosriesgo,
                             :insecticida,
                             :cantidadinsec,
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :usuario); ";
                             
        // capturamos el error
        try {
        
            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":paciente",      $this->Paciente);
            $preparada->bindParam(":tratamiento",   $this->Tratamiento);
            $preparada->bindParam(":droga",         $this->Droga);
            $preparada->bindParam(":dosis",         $this->Dosis);
            $preparada->bindParam(":contactos",     $this->Contactos);
            $preparada->bindParam(":nrocontactos",  $this->NroContactos);
            $preparada->bindParam(":contactospos",  $this->ContactosPos);
            $preparada->bindParam(":bloqueo",       $this->Bloqueo);
            $preparada->bindParam(":nroviviendas",  $this->NroViviendas);
            $preparada->bindParam(":sitiosriesgo",  $this->SitiosRiesgo);
            $preparada->bindParam(":insecticida",   $this->Insecticida);
            $preparada->bindParam(":cantidadinsec", $this->CantidadInsec);
            $preparada->bindParam(":fecha",         $this->Fecha);
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
     * Método que ejecuta la consulta de actualización, retorna
     * la clave del registo o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro
     */
    protected function editaControl() : int {

        // componemos la consulta
        $consulta = "UPDATE leishmania.control SET
                            tratamiento = :tratamiento,
                            droga = :droga,
                            dosis = :dosis,
                            contactos = :contactos,
                            nrocontactos = :nrocontactos,
                            contactospos = :contactospos,
                            bloqueo = :bloqueo,
                            nroviviendas = :nroviviendas,
                            sitiosriesgo = :sitiosriesgo,
                            insecticida = :insecticida,
                            cantidadinsec = :cantidadinsec,
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            usuario = :usuario
                     WHERE leishmania.control.id = :id; ";
                     
        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":tratamiento",   $this->Tratamiento);
            $preparada->bindParam(":droga",         $this->Droga);
            $preparada->bindParam(":dosis",         $this->Dosis);
            $preparada->bindParam(":contactos",     $this->Contactos);
            $preparada->bindParam(":nrocontactos",  $this->NroContactos);
            $preparada->bindParam(":contactospos",  $this->ContactosPos);
            $preparada->bindParam(":bloqueo",       $this->Bloqueo);
            $preparada->bindParam(":nroviviendas",  $this->NroViviendas);
            $preparada->bindParam(":sitiosriesgo",  $this->SitiosRiesgo);
            $preparada->bindParam(":insecticida",   $this->Insecticida);
            $preparada->bindParam(":cantidadinsec", $this->CantidadInsec);
            $preparada->bindParam(":fecha",         $this->Fecha);
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
     * Método que recibe la clave de un registro y ejecuta la
     * consulta de eliminación, retorna el resultado de la
     * operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idcontrol clave del registro
     * @return bool resultado de la operación
     */
    public function borraControl(int $idcontrol) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.control
                     WHERE leishmania.control.id = :id; ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idcontrol);
            $preparada->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e) {

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetros la fecha del control y
     * la clave del paciente y verifica que no esté repetido
     * el registro, retorna verdadero si puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @param string $fecha fecha del control
     * @return bool verdadero si puede insertar
     */
    public function validaControl(int $idpaciente, string $fecha) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.control.id) AS registros
                     FROM leishmania.control
                     WHERE leishmania.control.paciente = '$idpaciente' AND
                           leishmania.control.fecha = STR_TO_DATE('$fecha', '%d/%m/%Y'); ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
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
     * Método que recibe como parámetro la clave de un paciente
     * y retorna el vector con todas las entradas de control
     * del mismo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente clave el paciente
     * @return array vector con los registros
     */
    public function nominaControl(int $idpaciente) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_control.id AS id,
                            leishmania.v_control.tratamiento AS tratamiento,
                            leishmania.v_control.droga AS droga,
                            leishmania.v_control.contactos AS contactos,
                            leishmania.v_control.bloqueo AS bloqueo,
                            leishmania.v_control.insecticida AS insecticida,
                            leishmania.v_control.fecha AS fecha,
                            leishmania.v_control.usuario AS usuario
                     FROM leishmania.v_control
                     WHERE leishmania.v_control.idpaciente = '$idpaciente'
                     ORDER BY STR_TO_DATE(leishmania.v_control.fecha, '%d/%m/%Y') DESC; ";

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
     * y asigna los valores del mismo a las variables de clase,
     * retorna el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idpaciente - clave del paciente
     * @return bool resultado de la operación
     */
    public function getDatosControl(int $idpaciente) : bool {

        // componemos la consulta, recordar que los pacientes
        // tienen una relación uno a uno con la tabla de control
        $consulta = "SELECT leishmania.v_control.id AS id,
                            leishmania.v_control.idpaciente AS paciente,
                            leishmania.v_control.tratamiento AS tratamiento,
                            leishmania.v_control.droga AS droga,
                            leishmania.v_control.dosis AS dosis,
                            leishmania.v_control.contactos AS contactos,
                            leishmania.v_control.nrocontactos AS nrocontactos,
                            leishmania.v_control.contactospos AS contactospos,
                            leishmania.v_control.bloqueo AS bloqueo,
                            leishmania.v_control.nroviviendas AS nroviviendas,
                            leishmania.v_control.sitiosriesgo AS sitiosriesgo,
                            leishmania.v_control.insecticida AS insecticida,
                            leishmania.v_control.cantidadinsec AS cantidadinsec,
                            leishmania.v_control.fecha AS fecha,
                            leishmania.v_control.usuario AS usuario,
                            leishmania.v_control.alta AS alta
                     FROM leishmania.v_control
                     WHERE leishmania.v_control.idpaciente = '$idpaciente'; ";

        // capturamos el error
        try {

            // ejecutamos y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            
            // si existe un registro
            if ($resultado->rowCount() > 0){

                // obtenemos el registro
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);                

                // asignamos los valores
                $this->Id = $fila["id"];
                $this->Paciente = $fila["paciente"];
                $this->Tratamiento = $fila["tratamiento"];
                $this->Droga = $fila["droga"];
                $this->Dosis = $fila["dosis"];
                $this->Contactos = $fila["contactos"];
                $this->NroContactos = $fila["nrocontactos"];
                $this->ContactosPos = $fila["contactospos"];
                $this->Bloqueo = $fila["bloqueo"];
                $this->NroViviendas = $fila["nroviviendas"];
                $this->SitiosRiesgo = $fila["sitiosriesgo"];
                $this->Insecticida = $fila["insecticida"];
                $this->CantidadInsec = $fila["cantidadinsec"];
                $this->Fecha = $fila["fecha"];
                $this->Usuario = $fila["usuario"];
                $this->Alta = $fila["alta"];
            }

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
