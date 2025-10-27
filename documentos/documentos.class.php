<?php

/**
 *
 * Class Documentos | documentos/documentos.class.php
 *
 * @package     Diagnostico
 * @subpackage  Documentos
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (28/02/2018)
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
 * Clase que controla las operaciones sobre el diccionario de
 * tipos de documento
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Documentos{

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $IdUsuario;             // clave del usuario
    protected $Usuario;               // nombre del usuario
    protected $Link;                  // puntero a la base de datos
    protected $IdDocumento;           // clave del tipo de documento
    protected $TipoDocumento;         // nombre completo del tipo
    protected $DescAbreviada;         // sigla del documento
    protected $FechaAlta;             // fecha de alta del registro

    /**
     * Constructor de la clase, establece la conexión con la base
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct (){

        // inicializamos las variables
        $this->IdDocumento = 0;
        $this->TipoDocumento = "";
        $this->DescAbreviada = "";
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
    public function setIdDocumento(int $iddocumento) : void {
        $this->IdDocumento = $iddocumento;
    }
    public function setTipoDocumento(string $tipodocumento) : void {
        $this->TipoDocumento = $tipodocumento;
    }
    public function setDescripcion(string $descripcion) : void {
        $this->DescAbreviada = $descripcion;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getIdDocumento() : int {
        return $this->IdDocumento;
    }
    public function getTipoDocumento() : string {
        return $this->TipoDocumento;
    }
    public function getDescripcion() : string {
        return $this->DescAbreviada;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }

    /**
     * Método público que retorna la nómina de documentos
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array - vector con la nomina
     */
    public function listaDocumentos() : array {

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_documentos.id AS id_documento,
                            diagnostico.v_documentos.tipodocumento AS tipo_documento,
                            diagnostico.v_documentos.descripcion AS descripcion,
                            diagnostico.v_documentos.usuario AS usuario,
                            diagnostico.v_documentos.fecha AS fecha_alta
                     FROM diagnostico.v_documentos
                     ORDER BY diagnostico.v_documentos.tipodocumento;";

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
     * Método que según el valor de la clave genera la consulta de
     * edición o actualización, retorna la clave del registro afectado
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int - clave del registro insertado / editado
     */
    public function grabaDocumento() : int {

        // si está insertando
        if ($this->IdDocumento == 0){

            // inserta un nuevo registro
            $resultado = $this->nuevoDocumento();

        // si está editando
        } else {

            // actualiza el registro
            $resultado = $this->editaDocumento();

        }

        // retornamos la clave
        return (int) $resultado;

    }

    /**
     * Método que genera la consulta de inserción
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int la clave del registro o cero en caso de error
     */
    protected function nuevoDocumento() : int {

        // componemos la consulta
        $consulta = "INSERT INTO diccionarios.tipo_documento
                            (tipo_documento,
                             des_abreviada,
                             id_usuario)
                            VALUES
                            (:tipo_documento,
                             :descripcion,
                             :id_usuario);";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":tipo_documento", $this->TipoDocumento);
            $psInsertar->bindParam(":descripcion",    $this->DescAbreviada);
            $psInsertar->bindParam(":id_usuario",     $this->IdUsuario);

            // ejecutamos la consulta
            $psInsertar->execute();

            // asignamos la clave
            return (int) $this->Link->lastInsertId();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que genera la consulta de edición
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int clave del registro o cero en caso de error
     */
    protected function editaDocumento() : int{

        // componemos la consulta
        $consulta = "UPDATE diccionarios.tipo_documento SET
                            tipo_documento = :tipo_documento,
                            des_abreviada = :descripcion,
                            id_usuario = :id_usuario
                     WHERE diccionarios.tipo_documento.id_documento = :id_documento;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":tipo_documento", $this->TipoDocumento);
            $psInsertar->bindParam(":descripcion",    $this->DescAbreviada);
            $psInsertar->bindParam(":id_usuario",     $this->IdUsuario);
            $psInsertar->bindParam(":id_documento",   $this->IdDocumento);

            // ejecutamos la consulta
            $psInsertar->execute();

            // retornemoa
            return (int) $this->IdDocumento;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe como parámetro una cadena de texto
     * con el tipo de documento y la descripción y verifica
     * que no se encuentre declarada en la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $tipodocumento - tipo de documento
     * @param string $descripcion - descripción abreviada
     * @return bool si puede insertar
     */
    public function validaDocumento(string $tipodocumento, string $descripcion) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(diagnostico.v_documentos.id) AS registros
                     FROM diagnostico.v_documentos
                     WHERE diagnostico.v_documentos.tipodocumento = '$tipodocumento' OR
                           diagnostico.v_documentos.descripcion = '$descripcion'; ";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
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
     * Método que recibe como parámetro la clave de un registro
     * y verifica que no tenga registros relacionados en la tabla
     * de pacientes, tanto de leishmania como de diagnóstico,
     * retorna verdadero si puede eliminar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $iddocumento - clave del registro
     * @return int $registros - registros encontrados
     */
    public function puedeBorrar(int $iddocumento) : bool {

        // iniciamos el contador
        $contador = 0;

        // componemos la consulta sobre diagnóstico
        $consulta = "SELECT COUNT(diagnostico.personas.protocolo) AS registros
                     FROM diagnostico.personas
                     WHERE diagnostico.personas.tipo_documento = '$iddocumento'; ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $contador += (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            $contador += 1;

        }

        // ahora consultamos la base de leishmania
        $consulta = "SELECT COUNT(leishmania.pacientes.id) AS registros
                     FROM leishmania.pacientes
                     WHERE leishmania.pacientes.tipodoc = '$iddocumento'; ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $contador += (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            $contador += 1;

        }

        // según la cantidad de registros
        return $contador > 0 ? false : true;

    }

    /**
     * Método que recibe como paràmetro la clave de un registro
     * y ejecuta la consulta de eliminación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $iddocumento - clave del registro
     * @return bool resultado de la operación
     */
    public function borraDocumento(int $iddocumento) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM diccionarios.tipo_documento
                     WHERE diccionarios.tipo_documento.id_documento = :id; ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":id", $iddocumento);

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
     * Método que recibe como parámetro la clave de un registro
     * y asigna los valores en las variables de clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $iddocumento - clave del registro
     * @return bool resultado de la operación
     */
    public function getDatosDocumento(int $iddocumento) : bool {

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_documentos.id AS id_documento,
                            diagnostico.v_documentos.tipodocumento AS tipo_documento,
                            diagnostico.v_documentos.descripcion AS descripcion,
                            diagnostico.v_documentos.usuario AS usuario,
                            diagnostico.v_documentos.fecha AS fecha_alta
                     FROM diagnostico.v_documentos
                     WHERE diagnostico.v_documentos.id = '$iddocumento';";

        // capturamos el error
        try {

            // obtenemos el registro y asignamos en la clase
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->IdDocumento = $fila["id_documento"];
            $this->TipoDocumento = $fila["tipo_documento"];
            $this->DescAbreviada = $fila["descripcion"];
            $this->Usuario = $fila["usuario"];
            $this->FechaAlta = $fila["fecha_alta"];

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
