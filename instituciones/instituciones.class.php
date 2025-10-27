<?php

/**
 *
 * Class Instituciones | instituciones/instituciones.class.php
 *
 * @package     Leishmania
 * @subpackage  Instituciones
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (12/01/2018)
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
 * Clase que controla las operaciones sobre la tabla de
 * instituciones asistenciales
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Instituciones {

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $Link;                  // puntero a la base de datos
    protected $IdLaboratorio;         // clave del laboratorio del usuario
    protected $IdUsuario;             // clave del usuario activo

    // variables de la base de datos
    protected $IdInstitucion;         // clave de la institución
    protected $Institucion;           // nombre de la institución
    protected $Siisa;                 // clave siisa de la institución
    protected $CodLoc;                // clave indec de la localidad
    protected $Localidad;             // nombre de la localidad
    protected $CodProv;               // clave indec de la provincia
    protected $Provincia;             // nombre de la provincia
    protected $IdPais;                // clave del país
    protected $Pais;                  // nombre del país
    protected $Direccion;             // dirección postal
    protected $CodigoPostal;          // código postal de la dirección
    protected $Telefono;              // teléfono de la institución
    protected $Mail;                  // correo electrónico
    protected $Responsable;           // responsable o director
    protected $Usuario;               // nombre del usuario
    protected $IdDependencia;         // clave de la dependencia
    protected $Dependencia;           // nombre de la dependencia
    protected $FechaAlta;             // fecha de alta del registro
    protected $Comentarios;           // comentarios y observaciones
    protected $Coordenadas;           // coordenadas gps

    /**
     * Constructor de la clase, establece la conexión con la base
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct (){

        // nos conectamos a la base de datos
        $this->Link = new Conexion();

        // iniciamos las variables de la base de datos
        $this->IdInstitucion = 0;
        $this->Institucion = "";
        $this->Siisa = "";
        $this->CodLoc = "";
        $this->Localidad = "";
        $this->CodProv = "";
        $this->Provincia = "";
        $this->IdPais = 0;
        $this->Pais = "";
        $this->Direccion = "";
        $this->CodigoPostal = "";
        $this->Telefono = "";
        $this->Mail = "";
        $this->Responsable = "";
        $this->Usuario = "";
        $this->IdDependencia = 0;
        $this->Dependencia = "";
        $this->FechaAlta = "";
        $this->Comentarios = "";
        $this->Coordenadas = "";
        $this->IdUsuario = 0;
        $this->IdLaboratorio = 0;

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
    public function setIdInstitucion(int $idinstitucion) : void {
        $this->IdInstitucion = $idinstitucion;
    }
    public function setInstitucion(string $institucion) : void {
        $this->Institucion = $institucion;
    }
    public function setSiisa(string $siisa) : void {
        $this->Siisa = $siisa;
    }
    public function setCodLoc(string $codloc) : void {
        $this->CodLoc = $codloc;
    }
    public function setLocalidad(string $localidad) : void {
        $this->Localidad = $localidad;
    }
    public function setCodProv(string $codprov) : void {
        $this->CodProv = $codprov;
    }
    public function setProvincia(string $provincia) : void {
        $this->Provincia = $provincia;
    }
    public function setIdPais(int $idpais) : void {
        $this->IdPais = $idpais;
    }
    public function setPais(string $pais) : void {
        $this->Pais = $pais;
    }
    public function setDireccion(string $direccion) : void {
        $this->Direccion = $direccion;
    }
    public function setCodigoPostal(string $codigopostal) : void {
        $this->CodigoPostal = $codigopostal;
    }
    public function setTelefono(string $telefono) : void {
        $this->Telefono = $telefono;
    }
    public function setMail(string $mail) : void {
        $this->Mail = $mail;
    }
    public function setResponsable(string $responsable) : void {
        $this->Responsable = $responsable;
    }
    public function setIdDependencia(int $iddependencia) : void {
        $this->IdDependencia = $iddependencia;
    }
    public function setDependencia(string $dependencia) : void {
        $this->Dependencia = $dependencia;
    }
    public function setComentarios(string $comentarios) : void {
        $this->Comentarios = $comentarios;
    }
    public function setCoordenadas(string $coordenadas) : void {
        $this->Coordenadas = $coordenadas;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }
    public function setIdLaboratorio(int $idlaboratorio) : void {
        $this->IdLaboratorio = $idlaboratorio;
    }

    // métodos de retorno de valores
    public function getIdInstitucion() : int {
        return (int) $this->IdInstitucion;
    }
    public function getInstitucion() : string {
        return $this->Institucion;
    }
    public function getSiisa() : ?string {
        return $this->Siisa;
    }
    public function getCodLoc() : string {
        return $this->CodLoc;
    }
    public function getLocalidad() : string {
        return $this->Localidad;
    }
    public function getCodProv() : string {
        return $this->CodProv;
    }
    public function getProvincia() : string {
        return $this->Provincia;
    }
    public function getIdPais() : int {
        return (int) $this->IdPais;
    }
    public function getPais() : string {
        return $this->Pais;
    }
    public function getDireccion() : string {
        return $this->Direccion;
    }
    public function getCodigoPostal() : ?string {
        return $this->CodigoPostal;
    }
    public function getTelefono() : ?string {
        return $this->Telefono;
    }
    public function getMail() : ?string {
        return $this->Mail;
    }
    public function getResponsable() : ?string {
        return $this->Responsable;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getIdDependencia() : int {
        return (int) $this->IdDependencia;
    }
    public function getDependencia() : string {
        return $this->Dependencia;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }
    public function getComentarios() : ?string {
        return $this->Comentarios;
    }
    public function getCoordenadas() : ?string {
        return $this->Coordenadas;
    }

    /**
     * Método que recibe una cadena y busca la ocurrencia de esa cadena en la
     * tabla de instituciones, retorna un array con los registros encontrados
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $texto - cadena a buscar en la base
     * @return array $nomina
     */
    public function buscaInstitucion(string $texto) : array {

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_instituciones.id_centro AS id,
                            diagnostico.v_instituciones.nombre_centro AS institucion,
                            diagnostico.v_instituciones.localidad AS localidad,
                            diagnostico.v_instituciones.provincia AS provincia,
                            diagnostico.v_instituciones.responsable AS responsable,
                            diagnostico.v_instituciones.usuario AS usuario,
                            diagnostico.v_instituciones.fecha_alta AS fecha
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.nombre_centro LIKE '%$texto%' OR
                           diagnostico.v_instituciones.localidad LIKE '%$texto%' OR
                           diagnostico.v_instituciones.provincia LIKE '%$texto%' OR
                           diagnostico.v_instituciones.responsable LIKE '%$texto%'
                     ORDER BY diagnostico.v_instituciones.provincia,
                              diagnostico.v_instituciones.nombre_centro;";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // retornamos el vector
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Método que recibe una como parámetro la clave indec de una
     * localidad y retorna el vector con las instituciones de
     * esa localidad, utilizada en el abm de pacientes para
     * seleccionar la institución
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $codloc - clave de la localidad
     * @return array $nomina
     */
    public function localidadInstitucion(string $codloc) : array {

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_instituciones.id_centro AS id,
                            diagnostico.v_instituciones.nombre_centro AS institucion,
                            diagnostico.v_instituciones.localidad AS localidad
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.cod_loc = '$codloc'
                     ORDER BY diagnostico.v_instituciones.nombre_centro;";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // retornamos el vector
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Método que recibe como parámetro la clave de una institución y asigna
     * en las variables de clase los valores del registro
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $clave - clave del registro
     */
    public function getDatosInstitucion(int $clave){

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_instituciones.id_centro AS id_institucion,
                            diagnostico.v_instituciones.nombre_centro AS institucion,
                            diagnostico.v_instituciones.siisa AS siisa,
                            diagnostico.v_instituciones.cod_loc AS codloc,
                            diagnostico.v_instituciones.localidad AS localidad,
                            diagnostico.v_instituciones.cod_prov As codprov,
                            diagnostico.v_instituciones.provincia AS provincia,
                            diagnostico.v_instituciones.pais AS pais,
                            diagnostico.v_instituciones.id_pais AS idpais,
                            diagnostico.v_instituciones.direccion AS direccion,
                            diagnostico.v_instituciones.codigo_postal AS codigo_postal,
                            diagnostico.v_instituciones.telefono AS telefono,
                            diagnostico.v_instituciones.mail AS mail,
                            diagnostico.v_instituciones.responsable AS responsable,
                            diagnostico.v_instituciones.id_usuario AS idusuario,
                            diagnostico.v_instituciones.usuario AS usuario,
                            diagnostico.v_instituciones.id_dependencia AS id_dependencia,
                            diagnostico.v_instituciones.dependencia AS dependencia,
                            diagnostico.v_instituciones.fecha_alta AS fecha_alta,
                            diagnostico.v_instituciones.comentarios AS comentarios,
                            diagnostico.v_instituciones.coordenadas AS coordenadas
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.id_centro = '$clave';";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // obtenemos el registro y asignamos
        $registro = $resultado->fetch(PDO::FETCH_ASSOC);

        // asignamos en las variables de clase
        $this->IdInstitucion = $registro["id_institucion"];
        $this->Institucion = $registro["institucion"];
        $this->Siisa = $registro["siisa"];
        $this->CodLoc = $registro["codloc"];
        $this->Localidad = $registro["localidad"];
        $this->CodProv = $registro["codprov"];
        $this->Provincia = $registro["provincia"];
        $this->IdPais = $registro["idpais"];
        $this->Pais = $registro["pais"];
        $this->Direccion = $registro["direccion"];
        $this->CodigoPostal = $registro["codigo_postal"];
        $this->Telefono = $registro["telefono"];
        $this->Mail = $registro["mail"];
        $this->Responsable = $registro["responsable"];
        $this->Usuario = $registro["usuario"];
        $this->IdDependencia = $registro["id_dependencia"];
        $this->Dependencia = $registro["dependencia"];
        $this->FechaAlta = $registro["fecha_alta"];
        $this->Comentarios = $registro["comentarios"];
        $this->Coordenadas = $registro["coordenadas"];

    }

    /**
     * Método que según el caso llama la consulta de edición o inserción,
     * retorna la clave del registro afectado
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int $idinstitucion - clave del registro insertado / editado
     */
    public function grabaInstitucion() : int {

        // si está insertando
        if ($this->IdInstitucion == 0){

            // inserta el registro
            $this->nuevaInstitucion();

        // si está editando
        } else {

            // actualiza
            $this->editaInstitucion();

        }

        // retornamos la id
        return (int) $this->IdInstitucion;

    }

    /**
     * Método llamado al insertar una institución
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function nuevaInstitucion(){

        // componemos la consulta
        $consulta = "INSERT INTO diagnostico.centros_asistenciales
                            (nombre,
                             siisa,
                             localidad,
                             direccion,
                             codigo_postal,
                             telefono,
                             mail,
                             responsable,
                             id_usuario,
                             dependencia,
                             comentarios,
                             coordenadas)
                            VALUES
                            (:nombre,
                             :siisa,
                             :idlocalidad,
                             :direccion,
                             :codigo_postal,
                             :telefono,
                             :mail,
                             :responsable,
                             :idusuario,
                             :dependencia,
                             :comentarios,
                             :coordenadas);";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // establecemos los parámetros
            $psInsertar->bindParam(":nombre", $this->Institucion);
            $psInsertar->bindParam(":siisa", $this->Siisa);
            $psInsertar->bindParam(":idlocalidad", $this->CodLoc);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":telefono", $this->Telefono);
            $psInsertar->bindParam(":mail", $this->Mail);
            $psInsertar->bindParam(":responsable", $this->Responsable);
            $psInsertar->bindParam(":idusuario", $this->IdUsuario);
            $psInsertar->bindParam(":dependencia", $this->IdDependencia);
            $psInsertar->bindParam(":comentarios", $this->Comentarios);
            $psInsertar->bindParam(":coordenadas", $this->Coordenadas);
            $psInsertar->bindParam(":idlocalidad", $this->CodLoc);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":telefono", $this->Telefono);
            $psInsertar->bindParam(":mail", $this->Mail);
            $psInsertar->bindParam(":responsable", $this->Responsable);
            $psInsertar->bindParam(":idusuario", $this->IdUsuario);
            $psInsertar->bindParam(":dependencia", $this->IdDependencia);
            $psInsertar->bindParam(":comentarios", $this->Comentarios);
            $psInsertar->bindParam(":coordenadas", $this->Coordenadas);

            // ejecutamos la edición
            $psInsertar->execute();

            // obtiene la id del registro insertado
            $this->IdInstitucion = $this->Link->lastInsertId();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            $this->IdInstitucion = 0;

        }

    }

    /**
     * Método llamado al editar una institución
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function editaInstitucion(){

        // componemos la consulta
        $consulta = "UPDATE diagnostico.centros_asistenciales SET
                            nombre = :nombre,
                            siisa = :siisa,
                            localidad = :idlocalidad,
                            direccion = :direccion,
                            codigo_postal = :codigo_postal,
                            telefono = :telefono,
                            mail = :mail,
                            responsable = :responsable,
                            id_usuario = :idusuario,
                            dependencia = :dependencia,
                            comentarios = :comentarios,
                            coordenadas = :coordenadas
                     WHERE diagnostico.centros_asistenciales.id = :idinstitucion;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":nombre", $this->Institucion);
            $psInsertar->bindParam(":siisa", $this->Siisa);
            $psInsertar->bindParam(":idlocalidad", $this->CodLoc);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":telefono", $this->Telefono);
            $psInsertar->bindParam(":mail", $this->Mail);
            $psInsertar->bindParam(":responsable", $this->Responsable);
            $psInsertar->bindParam(":idusuario", $this->IdUsuario);
            $psInsertar->bindParam(":dependencia", $this->IdDependencia);
            $psInsertar->bindParam(":comentarios", $this->Comentarios);
            $psInsertar->bindParam(":coordenadas", $this->Coordenadas);
            $psInsertar->bindParam(":idinstitucion", $this->IdInstitucion);

            // ejecutamos la edición
            $psInsertar->execute();

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            $this->IdInstitucion = 0;

        }

    }

    /**
     * Método que recibe como parámetro el nombre de la institución y la clave de
     * la localidad, retorna verdadero si ya existe, utilizado para evitar
     * la inserción de duplicados
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $institucion - nombre de la institución a verificar
     * @param string $codloc - código indec de la localidad
     * @return boolean
     */
    public function validaInstitucion(string $institucion, string $codloc) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(diagnostico.v_instituciones.id_centro) AS registros
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.nombre_centro = '$institucion' AND
                           diagnostico.v_instituciones.cod_loc = '$codloc'; ";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // lo pasamos a minúsculas porque según la versión de
        // pdo lo devuelve en mayúsculas o minúsculas
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);

        // si hay registros
        return $fila["registros"] != 0 ? true : false;

    }

    /**
     * Método que recibe un mail y verifica que no esté asignado a
     * una institución, retorna el número de registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $mail - mail de la institución
     * @return int registros encontrados
     */
    public function validaMail(string $mail) : int {

        // componemos la consulta
        $consulta = "SELECT COUNT(diagnostico.v_instituciones.id_centro) AS registros
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.mail = '$mail';";
        $resultado = $this->Link->query($consulta);

        // obtenemos el registro y retornamos
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        return (int) $fila["registros"];

    }

    /**
     * Método que retorna el array con todas las instituciones
     * declaradas
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array nómina de instituciones
     */
    public function listadoInstituciones() : array {

        $consulta = "SELECT diagnostico.v_instituciones.id_centro AS id,
                            diagnostico.v_instituciones.nombre_centro AS institucion,
                            diagnostico.v_instituciones.siisa AS siisa,
                            diagnostico.v_instituciones.pais AS pais,
                            diagnostico.v_instituciones.provincia AS provincia,
                            diagnostico.v_instituciones.localidad AS localidad,
                            diagnostico.v_instituciones.direccion AS direccion,
                            diagnostico.v_instituciones.codigo_postal AS codigo_postal,
                            diagnostico.v_instituciones.telefono AS telefono,
                            diagnostico.v_instituciones.mail AS mail,
                            diagnostico.v_instituciones.dependencia AS dependencia,
                            diagnostico.v_instituciones.responsable AS responsable,
                            diagnostico.v_instituciones.usuario AS usuario,
                            diagnostico.v_instituciones.fecha_alta AS fecha
                     FROM diagnostico.v_instituciones
                     ORDER BY diagnostico.v_instituciones.provincia,
                              diagnostico.v_instituciones.nombre_centro;";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // lo pasamos a minúsculas porque según la versión de
        // pdo lo devuelve en mayúsculas o minúsculas
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Método que recibe como parámetro la clave de una provincia
     * y retorna el array json con la nómina de instituciones
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $codprov - clave de la provincia
     * @return array nómina de instituciones
     */
    public function nominaInstituciones(string $codprov) : array {

        $consulta = "SELECT diagnostico.v_instituciones.id_centro AS id,
                            diagnostico.v_instituciones.nombre_centro AS institucion,
                            diagnostico.v_instituciones.localidad AS localidad,
                            diagnostico.v_instituciones.dependencia AS dependencia,
                            diagnostico.v_instituciones.usuario AS usuario,
                            diagnostico.v_instituciones.fecha_alta AS fecha
                     FROM diagnostico.v_instituciones
                     WHERE diagnostico.v_instituciones.cod_prov = '$codprov'
                     ORDER BY diagnostico.v_instituciones.provincia,
                              diagnostico.v_instituciones.nombre_centro;";

        // ejecutamos la consulta
        $resultado = $this->Link->query($consulta);

        // lo pasamos a minúsculas porque según la versión de
        // pdo lo devuelve en mayúsculas o minúsculas
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Método que recibe como parámetro la clave de una institución
     * y verifica que no esté asignada a ningún paciente, retorna
     * la cantidad de registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idinstitucion - clave de la institución
     * @return int número de registros encontrados
     */
    public function puedeBorrar(int $idinstitucion) : int {

        // veriricamos las entradas en la tabla congénito
        $consulta = "SELECT COUNT(diagnostico.congenito.id) AS registros
                     FROM diagnostico.congenito
                     WHERE diagnostico.congenito.institucion = '$idinstitucion';";
        $resultado = $this->Link->query($consulta);

        // obtenemos el registro y retornamos
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        return (int) $fila["registros"];
        
    }

    /**
     * Método que ejecuta la consulta de eliminación de una
     * institución
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idinstitucion - clave del registro
     * @return bool resultado de la operación
     */
    public function borraInstitucion(int $idinstitucion) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM diagnostico.centros_asistenciales
                     WHERE diagnostico.centros_asistenciales.id = :id;";
  
        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":id", $idinstitucion);

            // ejecutamos la edición
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
