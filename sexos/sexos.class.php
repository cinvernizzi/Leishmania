<?php

/**
 *
 * Class Sexos | sexos/sexos.class.php
 *
 * @package     Leishmania
 * @subpackage  Sexos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (06/03/2018)
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
 * Clase que controla las operaciones sobre la tabla de sexos
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Sexos{

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $IdUsuario;             // clave del usuario
    protected $Usuario;               // nombre del usuario
    protected $Link;                  // puntero a la base de datos
    protected $FechaAlta;             // fecha de alta del registro
    protected $IdSexo;                // clave del sexo
    protected $Sexo;                  // nombre del sexo

    /**
     * Constructor de la clase, establece la conexión con la base
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct (){

        // inicializamos las variables
        $this->IdSexo = 0;
        $this->Sexo = "";
        $this->Usuario = "";
        $this->FechaAlta = "";
        $this->IdUsuario = 0;

        // nos conectamos a la base de datos
        $this->Link = new Conexion();

    }

    /**
     * Destructor de la clase, cierra la conexión con la base
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){

        // elimina el enlace a la base
        $this->Link = null;

    }

    // métodos de asignación de valores
    public function setIdSexo(int $idsexo) : void {
        $this->IdSexo = $idsexo;
    }
    public function setSexo(string $sexo) : void {
        $this->Sexo = $sexo;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getIdSexo() : int {
        return (int) $this->IdSexo;
    }
    public function getSexo() : string {
        return $this->Sexo;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getIdUsuario() : int {
        return (int) $this->IdUsuario;
    }

    /**
     * Método público que retorna un array asociativo con la tabla de sexos
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array
     */
    public function nominaSexos() : array {

        // componemos la consulta
        $consulta = "SELECT diccionarios.v_sexos.id AS id_sexo,
                            diccionarios.v_sexos.sexo AS sexo,
                            diccionarios.v_sexos.fecha_alta AS fecha_alta,
                            diccionarios.v_sexos.usuario AS usuario
                     FROM diccionarios.v_sexos;";
        $resultado = $this->Link->query($consulta);

        // obtenemos el vector y retornamos
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Método que recibe la clave de un sexo como parámetro
     * y verfica que no halla sido asignado a ningún paciente
     * retorna verdadero si puede eliminar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idsexo - clave del registro
     * @return bool verdadero si puede eliminar
     */
     public function puedeBorrar(int $idsexo) : bool {

        // definimos el contador
        $contador = 0;

        // componemos la consulta
        $consulta = "SELECT COUNT(diagnostico.v_personas.protocolo) AS registros
                     FROM diagnostico.v_personas
                     WHERE diagnostico.v_personas.id_sexo = '$idsexo';";

        // capturamos el error
        try {
            // obtenemos el registro y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $contador += (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            $contador += 1;

        }

        // ahora consultamos sobre la tabla de leishmania
        $consulta = "SELECT COUNT(leishmania.pacientes.id) AS registros
                     FROM leishmania.pacientes
                     WHERE leishmania.pacientes.sexo = '$idsexo'; ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $contador += (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            $contador += 1;

        }

        // según los registros
        return $contador == 0 ? true : false;

     }

    /**
     * Método que recibe como parámetro la clave del registro
     * y ejecuta la consulta de eliminación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idsexo - clave del registro
     * @return bool resultado de la operación
     */
    public function borraSexo(int $idsexo) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM diccionarios.sexos
                     WHERE diccionarios.sexos.id = :id;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":id", $idsexo);

            // ejecutamos la consulta y retornamos
            $psInsertar->execute();
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que verifica si un sexo ya se encuentra
     * registrado, retorna verdadero si puede insertar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $sexo - descripció del sexo
     * @return bool verdadero si puede insertar
     */
    public function validaSexo(string $sexo) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(diccionarios.v_sexos.id) AS registros
                     FROM diccionarios.v_sexos
                     WHERE diccionarios.v_sexos.sexo = '$sexo';";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
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
     * Método que ejecuta la consulta de inserción o
     * edición según corresponda, retorna la clave
     * del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function grabaSexo() : int {

        // si está insertando
        if ($this->IdSexo == 0){
            $this->nuevoSexo();
        } else {
            $this->editaSexo();
        }

        // retornamos la clave
        return (int) $this->IdSexo;

    }

    /**
     * Método que ejecuta la consulta de inserción
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function nuevoSexo(){

        // componemos la consulta
        $consulta = "INSERT INTO diccionarios.sexos
                            (sexo,
                             usuario)
                            VALUES
                            (:sexo,
                             :usuario);";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":sexo",    $this->Sexo);
            $psInsertar->bindParam(":usuario", $this->IdUsuario);

            // ejecutamos la consulta y obtenemos la id
            $psInsertar->execute();
            $this->IdSexo = $this->Link->lastInsertId();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            $this->IdSexo = 0;

        }

    }

    /**
     * Método que ejecuta la consulta de edición
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function editaSexo(){
  
        // componemos la consulta
        $consulta = "UPDATE diccionarios.sexos SET
                            sexo = :sexo,
                            usuario = :usuario
                     WHERE diccionarios.sexos.id = :id; ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":sexo",    $this->Sexo);
            $psInsertar->bindParam(":usuario", $this->IdUsuario);
            $psInsertar->bindParam(":id",      $this->IdSexo);

            // ejecutamos la consulta
            $psInsertar->execute();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            $this->IdSexo = 0;

        }
        
    }

}
