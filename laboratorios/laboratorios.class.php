<?php

/**
 *
 * Class Laboratorios | laboratorios/laboratorios.class.php
 *
 * @package     CCE
 * @subpackage  Laboratorios
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.5.0 (23/03/2023)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que controla las operaciones sobre la tabla de laboratorios
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
 * Definición de la clase
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Laboratorios {

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $Link;                  // puntero a la base de datos

    // definición de las variables de la base de datos
    protected $IdLaboratorio;             // clave del laboratorio
    protected $Nombre;                    // nombre del laboratorio
    protected $Responsable;               // responsable del laboratorio
    protected $Pais;                      // país donde queda
    protected $IdPais;                    // clave del país
    protected $Localidad;                 // nombre de la localidad
    protected $IdLocalidad;               // clave indec de la localidad
    protected $Provincia;                 // nombre de la provincia
    protected $IdProvincia;               // clave indec de la provincia
    protected $Direccion;                 // dirección postal
    protected $CodigoPostal;              // código postal correspondiente
    protected $Coordenadas;               // coordenadas GPS del laboratorio
    protected $Dependencia;               // nombre de la dependencia
    protected $IdDependencia;             // clave de la dependencia
    protected $EMail;                     // dirección de correo electrónico
    protected $FechaAlta;                 // fecha de alta del registro
    protected $Activo;                    // indica si participa de los controles
    protected $RecibeMuestrasChagas;      // indica si participa de serología
    protected $RecibeMuestrasPcr;         // indica si participa de pcr
    protected $RecibeMuestrasLeish;       // indica si procesa leishmaniasis
    protected $Muestras;                  // número de muestras leish que recibe
    protected $IdRecibe;                  // clave del responsable que
                                          // recibe las muestras
    protected $NombreRecibe;              // nombre del responsable que
                                          // recibe las muestras
    protected $Observaciones;             // observaciones y comentarios
    protected $Usuario;                   // usuario que actualizó / insertó
    protected $IdUsuario;                 // clave del responsable

    // declaración de variables usadas por la clase
    protected $NivelCentral;              // si el usuario es de nivel central
    protected $RespJurisdiccional;        // indica si el usuario es reponsable
    protected $RespLaboratorio;           // el laboratorio del usuario actual
    protected $Jurisdiccion;              // jurisdicción del responsable

    /**
     * Constructor de la clase, establece la conexión con la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct (){

        // nos conectamos a la base de datos
        $this->Link = new Conexion();

        // inicializamos las variables de clase
        $this->IdLaboratorio = 0;
        $this->Nombre = "";
        $this->Responsable = "";
        $this->Pais = "";
        $this->IdPais = 0;
        $this->Localidad = "";
        $this->IdLocalidad = "";
        $this->Provincia = "";
        $this->IdProvincia = "";
        $this->Direccion = "";
        $this->CodigoPostal = "";
        $this->Dependencia = "";
        $this->Coordenadas = "";
        $this->IdDependencia = 0;
        $this->EMail = "";
        $this->FechaAlta = "";
        $this->Activo = "";
        $this->RecibeMuestrasChagas = "";
        $this->RecibeMuestrasPcr = "";
        $this->RecibeMuestrasLeish = "";
        $this->Muestras = 0;
        $this->IdRecibe = 0;
        $this->NombreRecibe = "";
        $this->Observaciones = "";
        $this->Usuario = "";
        $this->IdUsuario = 0;
        $this->NivelCentral = "";
        $this->RespJurisdiccional = "";
        $this->RespLaboratorio = "";
        $this->Jurisdiccion = "";

    }

    /**
     * Destructor de la clase, cierra la conexión con la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){

        // elimina el enlace a la base
        $this->Link = null;

    }

    // métodos de asignación de valores
    public function setIdLaboratorio(int $idlaboratorio) : void {
        $this->IdLaboratorio = $idlaboratorio;
    }
    public function setNombre(string $nombre) : void {
        $this->Nombre = $nombre;
    }
    public function setResponsable(string $responsable) : void {
        $this->Responsable = $responsable;
    }
    public function setIdPais(int $idpais) : void {
        $this->IdPais = $idpais;
    }
    public function setIdLocalidad(string $idlocalidad) : void {
        $this->IdLocalidad = $idlocalidad;
    }
    public function setDireccion(string $direccion) : void {
        $this->Direccion = $direccion;
    }
    public function setCodigoPostal(string $codigopostal) : void {
        $this->CodigoPostal = $codigopostal;
    }
    public function setCoordenadas(string $coordenadas) : void {
        $this->Coordenadas = $coordenadas;
    }
    public function setIdDependencia(int $iddependencia) : void {
        $this->IdDependencia = $iddependencia;
    }
    public function setEmail(string $email) : void {
        $this->EMail = $email;
    }
    public function setActivo(string $activo) : void {
        $this->Activo = $activo;
    }
    public function setRecibeMuestrasChagas(string $recibemuestras) : void {
        $this->RecibeMuestrasChagas = $recibemuestras;
    }
    public function setRecibeMuestrasPcr(string $pcr) : void {
        $this->RecibeMuestrasPcr = $pcr;
    }
    public function setRecibeMuestrasLeish(string $leish) : void {
        $this->RecibeMuestrasLeish = $leish;
    }
    public function setMuestras(int $muestras) : void {
        $this->Muestras = $muestras;
    }
    public function setIdRecibe(int $idrecibe) : void {
        $this->IdRecibe = $idrecibe;
    }
    public function setObservaciones(string $observaciones) : void {
        $this->Observaciones = $observaciones;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de obtención de datos
    public function getIdLaboratorio() : int {
        return (int) $this->IdLaboratorio;
    }
    public function getNombre() : string {
        return $this->Nombre;
    }
    public function getResponsable() : ?string {
        return $this->Responsable;
    }
    public function getPais() : string {
        return $this->Pais;
    }
    public function getIdPais() : int {
        return (int) $this->IdPais;
    }
    public function getLocalidad() : string {
        return $this->Localidad;
    }
    public function getIdLocalidad() : string {
        return $this->IdLocalidad;
    }
    public function getProvincia() : string {
        return $this->Provincia;
    }
    public function getIdProvincia() : string {
        return $this->IdProvincia;
    }
    public function getDireccion() : ?string {
        return $this->Direccion;
    }
    public function getCodigoPostal() : ?string {
        return $this->CodigoPostal;
    }
    public function getCoordenadas() : ?string {
        return $this->Coordenadas;
    }
    public function getDependencia() : string {
        return $this->Dependencia;
    }
    public function getIdDependencia() : int {
        return $this->IdDependencia;
    }
    public function getEmail() : ?string {
        return $this->EMail;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }
    public function getActivo() : string {
        return $this->Activo;
    }
    public function getRecibeMuestrasChagas() : ?string {
        return $this->RecibeMuestrasChagas;
    }
    public function getRecibeMuestrasPcr() : ?string {
        return $this->RecibeMuestrasPcr;
    }
    public function getRecibeMuestrasLeish() : ?string {
        return $this->RecibeMuestrasLeish;
    }
    public function getMuestras() : ?int {
        return (int) $this->Muestras;
    }
    public function getNombreRecibe() : ?string {
        return $this->NombreRecibe;
    }
    public function getIdRecibe() : ?int {
        return (int) $this->IdRecibe;
    }
    public function getObservaciones() : ?string {
        return $this->Observaciones;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }

    /**
     * Método que recibe un texto y lo busca en la tabla de laboratorios
     * retorna el vector con los registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $texto - cadena a buscar
     * @return array
     */
    public function buscaLaboratorio(string $texto) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS idlaboratorio,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.provincia AS provincia
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.laboratorio LIKE '%$texto%' OR
                           cce.vw_laboratorios.responsable LIKE '%$texto%' OR
                           cce.vw_laboratorios.localidad LIKE '%$texto%' OR
                           cce.vw_laboratorios.provincia LIKE '%$texto%'
                     ORDER BY cce.vw_laboratorios.laboratorio,
                              cce.vw_laboratorios.provincia; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
            
        // si ocurrió un error
        } catch (Exception $ex) {

            // presenta el mensaje
            echo $ex->getMessage();
            return array("Resultado" => false);
            
        }

    }

    /**
     * Método que recibe la clave del laboratorio e instancia las variables
     * de clase con los valores del registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idlaboratorio - clave del registro
     */
    public function getDatosLaboratorio(int $idlaboratorio){

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.pais AS pais,
                            cce.vw_laboratorios.idpais AS idpais,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.idlocalidad AS idlocalidad,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.idprovincia AS idprovincia,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.codigopostal AS codigopostal,
                            cce.vw_laboratorios.coordenadas AS coordenadas,
                            cce.vw_laboratorios.dependencia AS dependencia,
                            cce.vw_laboratorios.iddependencia AS iddependencia,
                            cce.vw_laboratorios.mail AS mail,
                            cce.vw_laboratorios.fecha_alta AS fecha_alta,
                            cce.vw_laboratorios.activo AS activo,
                            cce.vw_laboratorios.recibe_muestras_chagas AS recibe_muestras_chagas,
                            cce.vw_laboratorios.recibe_muestras_pcr AS recibe_muestras_pcr,
                            cce.vw_laboratorios.recibe_muestras_leish AS recibe_muestras_leish,
                            cce.vw_laboratorios.muestras AS muestras,
                            cce.vw_laboratorios.nombre_recibe AS responsable_muestras,
                            cce.vw_laboratorios.idrecibe AS idrecibe,
                            cce.vw_laboratorios.observaciones AS observaciones,
                            cce.vw_laboratorios.usuario AS usuario
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.id = '$idlaboratorio';";

        // capturamos el error
        try {
            
            // ejecutamos la consulta y asignamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->IdLaboratorio = $fila["id"];
            $this->Nombre = $fila["laboratorio"];
            $this->Responsable = $fila["responsable"];
            $this->Pais = $fila["pais"];
            $this->IdPais = $fila["idpais"];
            $this->Localidad = $fila["localidad"];
            $this->IdLocalidad = $fila["idlocalidad"];
            $this->Provincia = $fila["provincia"];
            $this->IdProvincia = $fila["idprovincia"];
            $this->Direccion = $fila["direccion"];
            $this->CodigoPostal = $fila["codigopostal"];
            $this->Coordenadas = $fila["coordenadas"];
            $this->Dependencia = $fila["dependencia"];
            $this->IdDependencia = $fila["iddependencia"];
            $this->EMail = $fila["mail"];
            $this->FechaAlta = $fila["fecha_alta"];
            $this->Activo = $fila["activo"];
            $this->RecibeMuestrasChagas = $fila["recibe_muestras_chagas"];
            $this->RecibeMuestrasPcr = $fila["recibe_muestras_pcr"];
            $this->RecibeMuestrasLeish = $fila["recibe_muestras_leish"];
            $this->Muestras = $fila["muestras"];
            $this->NombreRecibe = $fila["responsable_muestras"];
            $this->IdRecibe = $fila["idrecibe"];
            $this->Observaciones = $fila["observaciones"];
            $this->Usuario = $fila["usuario"];

        // si ocurrió un error
        } catch (PDOException $e){
        
            // presenta el mensaje
            echo $e->getMessage();
            
        }
        
    }

    /**
     * Método que produce la consulta de inserción o edición según
     * el caso y retorna la id del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return int
     */
    public function grabarLaboratorio() : int {

        // si está definida la clave
        if ($this->IdLaboratorio != 0){
            $this->editaLaboratorio();
        } else {
            $this->nuevoLaboratorio();
        }

        // retorna la id
        return (int) $this->IdLaboratorio;

    }

    /**
     * Método que inserta un nuevo registro en la tabla de laboratorios
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function nuevoLaboratorio(){

        // produce la consulta de inserción
        $consulta = "INSERT INTO cce.laboratorios
                            (NOMBRE,
                             RESPONSABLE,
                             PAIS,
                             LOCALIDAD,
                             DIRECCION,
                             CODIGO_POSTAL,
                             DEPENDENCIA,
                             E_MAIL,
                             ACTIVO,
                             RECIBE_MUESTRAS_CHAGAS,
                             RECIBE_MUESTRAS_PCR,
                             RECIBE_MUESTRAS_LEISH,
                             muestras,
                             ID_RECIBE,
                             OBSERVACIONES,
                             USUARIO)
                             VALUES
                            (:nombre,
                             :responsable,
                             :idpais,
                             :idlocalidad,
                             :direccion,
                             :codigo_postal,
                             :iddependencia,
                             :e_mail,
                             :activo,
                             :recibe_muestras_chagas,
                             :recibe_muestras_pcr,
                             :recibe_muestras_leish,
                             :muestras,
                             :id_recibe,
                             :observaciones,
                             :idusuario);";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":nombre", $this->Nombre);
            $psInsertar->bindParam(":responsable", $this->Responsable);
            $psInsertar->bindParam(":idpais", $this->IdPais);
            $psInsertar->bindParam(":idlocalidad", $this->IdLocalidad);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":iddependencia", $this->IdDependencia);
            $psInsertar->bindParam(":e_mail", $this->EMail);
            $psInsertar->bindParam(":activo", $this->Activo);
            $psInsertar->bindParam(":recibe_muestras_chagas", $this->RecibeMuestrasChagas);
            $psInsertar->bindParam(":recibe_muestras_pcr", $this->RecibeMuestrasPcr);
            $psInsertar->bindParam(":recibe_muestras_leish", $this->RecibeMuestrasLeish);
            $psInsertar->bindParam(":muestras", $this->Muestras);
            $psInsertar->bindParam(":id_recibe", $this->IdRecibe);
            $psInsertar->bindParam(":observaciones", $this->Observaciones);
            $psInsertar->bindParam(":idusuario", $this->IdUsuario);

            // ejecutamos la edición
            $psInsertar->execute();

            // obtiene la id del registro insertado
            $this->IdLaboratorio = $this->Link->lastInsertId();

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            $this->IdLaboratorio = 0;
            echo $e->getMessage();

        }

    }

    /**
     * Método que edita el registro de la tabla de laboratorios
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function editaLaboratorio(){

        // produce la consulta de edición
        $consulta = "UPDATE cce.laboratorios SET
                            NOMBRE = :nombre,
                            RESPONSABLE = :responsable,
                            PAIS = :idpais,
                            LOCALIDAD = :idlocalidad,
                            DIRECCION = :direccion,
                            CODIGO_POSTAL = :codigo_postal,
                            DEPENDENCIA = :iddependencia,
                            E_MAIL = :e_mail,
                            ACTIVO = :activo,
                            RECIBE_MUESTRAS_CHAGAS = :recibe_muestras_chagas,
                            RECIBE_MUESTRAS_PCR = :recibe_muestras_pcr,
                            RECIBE_MUESTRAS_LEISH = :recibe_muestras_leish,
                            muestras = :muestras,
                            ID_RECIBE = :idrecibe,
                            OBSERVACIONES = :observaciones,
                            USUARIO = :idusuario
                     WHERE cce.laboratorios.ID = :idlaboratorio;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":nombre", $this->Nombre);
            $psInsertar->bindParam(":responsable", $this->Responsable);
            $psInsertar->bindParam(":idpais", $this->IdPais);
            $psInsertar->bindParam(":idlocalidad", $this->IdLocalidad);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":iddependencia", $this->IdDependencia);
            $psInsertar->bindParam(":e_mail", $this->EMail);
            $psInsertar->bindParam(":activo", $this->Activo);
            $psInsertar->bindParam(":recibe_muestras_chagas", $this->RecibeMuestrasChagas);
            $psInsertar->bindParam(":recibe_muestras_pcr", $this->RecibeMuestrasPcr);
            $psInsertar->bindParam(":recibe_muestras_leish", $this->RecibeMuestrasLeish);
            $psInsertar->bindParam(":muestras", $this->Muestras);
            $psInsertar->bindParam(":idrecibe", $this->IdRecibe);
            $psInsertar->bindParam(":observaciones", $this->Observaciones);
            $psInsertar->bindParam(":idusuario", $this->IdUsuario);
            $psInsertar->bindParam(":idlaboratorio", $this->IdLaboratorio);

            // ejecutamos la edición
            $psInsertar->execute();

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            $this->IdLaboratorio = 0;
            echo $e->getMessage();

        }

    }

    /**
     * Método que recibe como parámetro el nombre de un laboratorio y la
     * provincia del mismo (puede haber mas de un laboratorio con el mismo
     * nombre) y retorna la clave del laboratorio
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $provincia - nombre de la provincia
     * @param string $laboratorio - nombre del laboratorio
     * @return int
     */
    public function getClaveLaboratorio(string $provincia, string $laboratorio) : int {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.laboratorio = '$laboratorio' AND
                           cce.vw_laboratorios.provincia = '$provincia'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            $registro = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $registro["id_laboratorio"];

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método utilizado en el abm de usuarios para autorizar a cargar
     * específicamente un laboratorio, recibe parte del nombre del
     * laboratorio y la provincia y retorna los registros coincidentes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $laboratorio - nombre del laboratorio
     * @param string $provincia - nombre de la provincia
     * @return array
     */
    public function nominaLaboratorios(string $laboratorio, string $provincia) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS idlaboratorio,
                            cce.vw_laboratorios.laboratorio AS laboratorio
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.provincia = '$provincia' AND
                           cce.vw_laboratorios.laboratorio LIKE '%$laboratorio%'
                     ORDER BY cce.vw_laboratorios.laboratorio; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método llamado en la edición de usuarios, recibe como parámetros
     * el pais, la jurisdicción y parte del nombre de un laboratorio
     * retorna un array con los registros que cumplen con el criterio
     * que luego el sistema muestra en una grilla
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $pais - nombre del país
     * @param string $laboratorio - nombre del laboratorio
     * @param string $provincia - nombre de la provincia
     */
    public function listaLaboratorios(string $pais,
                                      string $laboratorio,
                                      ?string $provincia = null) : array{

        // si la provincia es nulo
        if ($provincia == null){

            // Compone la consulta
            $consulta = "SELECT cce.vw_laboratorios.id AS id,
                                cce.vw_laboratorios.pais AS pais,
                                cce.vw_laboratorios.laboratorio AS laboratorio
                         FROM cce.vw_laboratorios
                         WHERE cce.vw_laboratorios.laboratorio LIKE '%$laboratorio%' AND
                               cce.vw_laboratorios.pais = '$pais'
                         ORDER BY cce.vw_laboratorios.laboratorio; ";

        // si recibió provincia
        } else {

            // Compone la consulta
            $consulta = "SELECT cce.vw_laboratorios.id AS id,
                                cce.vw_laboratorios.laboratorio AS laboratorio,
                                cce.vw_laboratorios.provincia AS jurisdiccion
                         FROM cce.vw_laboratorios
                         WHERE cce.vw_laboratorios.laboratorio LIKE '%$laboratorio%' AND
                               cce.vw_laboratorios.pais = '$pais' AND
                               cce.vw_laboratorios.provincia = '$provincia'
                         ORDER BY cce.vw_laboratorios.laboratorio; ";

        }

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que retorna un vector con los laboratorios
     * activos de esa provincia que recibe como parámetro
     * junto con el referente de quien recibe las muestras
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $provincia - nombre de la jurisdicción
     * @return vector con la nómina de laboratorios
     */
    public function laboratoriosParticipantes(string $provincia) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_aboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.codigopostal AS codigopostal,
                            cce.vw_laboratorios.dependencia AS dependencia,
                            cce.vw_laboratorios.recibe_muestras_chagas AS recibe_chagas,
                            cce.vw_laboratorios.recibe_muestras_pcr AS recibe_pcr,
                            cce.vw_laboratorios.recibe_muestras_leish AS recibe_leish,
                            cce.vw_laboratorios.nombre_recibe AS recibe_muestras
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.provincia = '$provincia' AND
                           cce.vw_laboratorios.activo = 'Si'
                     ORDER BY cce.vw_laboratorios.laboratorio,
                              cce.vw_laboratorios.localidad;";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave indec de una jurisdicción
     * y retorna el vector con los datos de todos los laboratorios, utilizado
     * para armar la grilla de selección de laboratorios en la generación de
     * etiquetas
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $idprovincia - clave indec de la jurisdicción
     * @return array nómina de laboratorios
     */
    public function laboratoriosProvincia(string $idprovincia) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.dependencia AS dependencia,
                            cce.vw_laboratorios.recibe_muestras AS recibe,
                            cce.vw_laboratorios.pcr As pcr,
                            cce.vw_laboratorios.activo AS activo
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.idprovincia = '$idprovincia'
                     ORDER BY cce.vw_laboratorios.laboratorio,
                              cce.vw_laboratorios.localidad;";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }
    
    /**
     * Método utilizado en las altas para evitar el duplicado de registros
     * recibe como parámetros el nombre del laboratorio y la clave indec
     * de la localidad y retorna el número de registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $laboratorio - nombre del laboratorio
     * @param string $codloc - clave indec de la localidad
     * @return int registros encontrados
     */
    public function verificaLaboratorio(string $laboratorio, string $codloc) : int {

        // componemos la consulta
        $consulta = "SELECT COUNT(cce.vw_laboratorios.id) AS registros
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.laboratorio = '$laboratorio' AND
                           cce.vw_laboratorios.idlocalidad = '$codloc'; ";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 1;

        }

    }

    /**
     * Método utilizado en las altas y ediciones para evitar el duplicado
     * de direcciones de correo, retorna el número de registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $mail - la dirección a verificar
     * @return int
     */
    public function verificaMail(string $mail) : int {

        // compone la consulta
        $consulta = "SELECT COUNT(*) AS registros
                        FROM cce.laboratorios
                        WHERE cce.laboratorios.e_mail = '$mail';";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
            $resultado = $this->Link->query($consulta);
            $registro = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $registro["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que retorna el array con la nómina de laboratorios
     * sin georreferenciar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array
     */
     public function sinGeorreferenciar() : array {

        // componemos la consulta en la vista
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.pais AS pais,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.direccion AS direccion
                    FROM vw_laboratorios
                    WHERE vw_laboratorios.coordenadas = '' OR
                            ISNULL(vw_laboratorios.coordenadas) OR
                            vw_laboratorios.coordenadas = 'undefined'
                    ORDER BY cce.vw_laboratorios.provincia,
                            cce.vw_laboratorios.laboratorio;";

        // capturamos el error
        try {

            // obtenemos el array y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

     }

    /**
     * Método que recibe como parámetros la id de un laboratorio y las
     * coordenadas gps, actualiza entonces la base de datos
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del laboratorio
     * @param string $coordenadas - coordenadas gps
     * @return bool resultado de la operación
     */
    public function grabaCoordenadas(int $id, string $coordenadas) : bool {

        // definimos las variables
        $resultado = false;

        // componemos la consulta y ejecutamos la consulta
        $consulta = "UPDATE cce.laboratorios SET
                            coordenadas = :coordenadas
                     WHERE cce.laboratorios.id = :id;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":coordenadas", $coordenadas);
            $psInsertar->bindParam(":id",          $id);

            // ejecutamos la edición
            $psInsertar->execute();
            $resultado = true;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            echo $e->getMessage();

        }

        // retornamos
        return (bool) $resultado;

    }

    /**
     * Método que actualiza el registro del laboratorio indicando
     * si recibe o no muestras directamente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $idlaboratorio - clave del laboratorio
     * @param $recibe - texto (si / no) indicando si recibe
     * @return bool resultado de la operación
     */
    public function recibeMuestras(int $idlaboratorio, string $recibe) : bool {
        
        // componemos la consulta
        $consulta = "UPDATE cce.laboratorios SET
                            recibe_muestras_chagas = :recibe
                     WHERE cce.laboratorios.id = :idlaboratorio; ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":recibe",        $recibe);
            $psInsertar->bindParam(":idlaboratorio", $idlaboratorio);

            // ejecutamos la edición
            $psInsertar->execute();
            return true;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que actualiza el registro del laboratorio indicando
     * si se encuentra activo o no
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $idlaboratorio - clave del laboratorio
     * @param $activo - texto (si / no) indicando el estado
     * @return bool resultado de la operación
     */
    public function activoMuestras(int $idlaboratorio, string $activo) : bool {

        // declaramos las variables
        $resultado = false;

        // componemos la consulta
        $consulta = "UPDATE cce.laboratorios SET
                            activo = :activo
                     WHERE cce.laboratorios.id = :idlaboratorio; ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":activo",        $activo);
            $psInsertar->bindParam(":idlaboratorio", $idlaboratorio);

            // ejecutamos la edición
            $psInsertar->execute();
            $resultado = true;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            echo $e->getMessage();

        }

        // retornamos
        return (bool) $resultado;

    }

    /**
     * Método que retorna el listado de todos los laboratorios
     * que participan con muestras pcr
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array vector con los resultados
     */
    public function listaPcr() : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.codigopostal AS codigo_postal
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.activo = 'Si' AND
                           cce.vw_laboratorios.recibe_muestras_pcr = 'Si'
                     ORDER BY cce.vw_laboratorios.laboratorio;";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método utilizado en la generación de notas y etiquetas que
     * recibe como parámetro la clave indec de una provincia y
     * retorna el vector con los datos de los laboratorios activos
     * que participan de las muestras de serología
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $idprovincia - clave indec de la provincia
     * @return array vector con los laboratorios activos
     */
    public function nominaSerologia(string $idprovincia) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.codigopostal AS codigo_postal
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.activo = 'Si' AND
                           cce.vw_laboratorios.recibe_muestras_chagas = 'Si' AND
                           cce.vw_laboratorios.idprovincia = '$idprovincia'
                     ORDER BY cce.vw_laboratorios.laboratorio;";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método utilizado en la generación de notas y etiquetas que
     * que participan de las muestras de leishmania
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array vector con los laboratorios activos
     */
    public function nominaLeishmania() : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.direccion AS direccion,
                            cce.vw_laboratorios.codigopostal AS codigo_postal,
                            cce.vw_laboratorios.activo AS activo,
                            cce.vw_laboratorios.muestras AS muestras
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.recibe_muestras_leish = 'Si'
                     ORDER BY cce.vw_laboratorios.provincia,
                              cce.vw_laboratorios.laboratorio;";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe la clave de una provincia y retorna
     * el vector con los laboratorios registrados de esa
     * jurisdicción
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $codprov - clave indec de la provincia
     * @return array - vector con los registros
     */
    public function reporteLaboratorios(string $codprov) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.activo AS activo,
                            cce.vw_laboratorios.recibe_muestras_chagas AS chagas,
                            cce.vw_laboratorios.recibe_muestras_pcr AS pcr,
                            cce.vw_laboratorios.recibe_muestras_leish AS leishmania
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.idprovincia = '$codprov'
                     ORDER BY cce.vw_laboratorios.laboratorio;";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe la clave de un laboratorio, su estado
     * (activo o no) y la clave del usuario y actualiza la
     * base de datos, retorna la clave del registro afectado
     * o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idlaboratorio - clave del laboratorio
     * @param string $estado - activo o no
     * @param string $chagas - si recibe muestras chagas
     * @param string $pcr - si recibe muestras pcr
     * @param string $leishmania - si recibe muestras leish
     * @param int $usuario - clave del usuario
     * @return int resultado de la operación
     */
    public function actualizaEstado(int $idlaboratorio,
                                    string $estado,
                                    string $chagas,
                                    string $pcr,
                                    string $leishmania,
                                    int $usuario) : int {

        // componemos la consulta
        $consulta = "UPDATE cce.laboratorios SET
                            activo = :estado,
                            recibe_muestras_chagas = :chagas,
                            recibe_muestras_pcr = :pcr,
                            recibe_muestras_leish = :leish,
                            usuario = :usuario
                     WHERE cce.laboratorios.id = :id; ";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":estado",  $estado);
            $psInsertar->bindParam(":chagas",  $chagas);
            $psInsertar->bindParam(":pcr",     $pcr);
            $psInsertar->bindParam(":leish",   $leishmania);
            $psInsertar->bindParam(":usuario", $usuario);
            $psInsertar->bindParam(":id",      $idlaboratorio);

            // ejecutamos la edición
            $psInsertar->execute();

            // retornamos la id
            return (int) $idlaboratorio;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje
            echo $e->getMessage();
            return 0;

        }
        
    }

    /**
     * Método utilizado en la grilla de laboratorios que recibe como
     * parámetro parte del nombre del laboratorio, si debe listar
     * leishmania, serología o pcr y retorna el número de laboratorios
     * coincidentes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $laboratorio - parte del nombre del laboratorio
     * @param $leishmania - si lista leishmania
     * @param $serología - si lista serología
     * @param $pcr - si lista pcr
     * @return int número de registros coincidentes
     */
    public function numeroLaboratorios(string $laboratorio,
                                       string $leishmania,
                                       string $serologia,
                                       string $pcr) : int {

    
        // componemos la consulta
        $consulta = "SELECT COUNT(cce.vw_laboratorios.id) AS registros
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.laboratorio LIKE '%$laboratorio%' AND
                           cce.vw_laboratorios.recibe_muestras_leish = '$leishmania' AND
                           cce.vw_laboratorios.recibe_muestras_chagas = '$serologia' AND
                           cce.vw_laboratorios.recibe_muestras_pcr = '$pcr'; ";

        // capturamos el error
        try {

            // obtenemos el registro y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $fila["registros"];

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método que recibe parte del nombre de un laboratorio, si participa
     * de las determinaciones de leishmania, serología y pcr y retorna el
     * vector con los registros de los laboratorios coincidentes.
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $laboratorio - cadena con el nombre del laboratorio
     * @param $leishmania - si participa de leishmaniasis
     * @param $serologia - si participa de serologia
     * @param $pcr - si participa de pcr
     * @param $offset - desplazamiento del primer registro
     * @param $registros - número de registros a retornar
     * @return array vector con los registros
     */
    public function laboratoriosPaginados(string $laboratorio,
                                          string $leishmania,
                                          string $serologia,
                                          string $pcr,
                                          int $offset,
                                          int $registros) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.activo AS activo
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.laboratorio LIKE '%$laboratorio%' AND
                           cce.vw_laboratorios.recibe_muestras_chagas = '$serologia' AND
                           cce.vw_laboratorios.recibe_muestras_pcr = '$pcr' AND
                           cce.vw_laboratorios.recibe_muestras_leish = '$leishmania'
                     ORDER BY vw_laboratorios.provincia,
                              vw_laboratorios.laboratorio
                     LIMIT $offset, $registros; ";

        // capturamos el error
        try {

            // ejecutamos y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presnta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }
    }

    /**
     * Método utilizado en la generación del reporte de laboratorios
     * participantes, recibe como parámetro si el usuario es de
     * nivel central y el nombre de la jurisdicción, de acuerdo a
     * estos valores, genera el reporte nacional o provincial
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param $nivelcentral - cadena indicando si es de nivel central
     * @param $provincia - cadena con el nombre de la provincia
     * @return array - vector con los registros
     */
    public function getLaboratorios(string $nivelcentral, string $provincia) : array {

        // si es de nivel central
        if ($nivelcentral == "Si"){
            $provincia = "";
        }

        // componemos la consulta
        $consulta = "SELECT cce.vw_laboratorios.id AS id,
                            cce.vw_laboratorios.laboratorio AS laboratorio,
                            cce.vw_laboratorios.responsable AS responsable,
                            cce.vw_laboratorios.provincia AS provincia,
                            cce.vw_laboratorios.localidad AS localidad,
                            cce.vw_laboratorios.activo AS activo,
                            cce.vw_laboratorios.dependencia AS dependencia,
                            cce.vw_laboratorios.recibe_muestras_chagas AS chagas,
                            cce.vw_laboratorios.recibe_muestras_leish AS leishmania,
                            cce.vw_laboratorios.recibe_muestras_pcr AS pcr,
                            cce.vw_laboratorios.fecha_alta AS alta
                     FROM cce.vw_laboratorios
                     WHERE cce.vw_laboratorios.provincia LIKE '%$provincia%'
                     ORDER BY vw_laboratorios.provincia,
                              vw_laboratorios.laboratorio; ";

        // capturamos el error
        try {

            // ejecutamos y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave del laboratorio
     * y retorna la serie de concordancia tanto de leishmania
     * como de serología en los distintos años que partició,
     * utilizado para graficar la evolución de la concordancia del
     * laboratorio (luego la rutina javascript debe determinar si
     * grafica las dos tablas o una sola)
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $idlaboratorio - clave del laboratorio
     * @return [array] vector con los registros
     */
    public function getConcordancia(int $idlaboratorio){

        // componemos la consulta filtrando los operativos
        // en los cuales han cargado resultados, agrupando
        // por el año de los operativos
        $consulta = "SELECT SUBSTRING(vw_datos.operativo, 3, 4) AS operativo,
                            vw_datos.provincia AS provincia,
                            vw_datos.laboratorio AS laboratorio,
                            vw_datos.tipo AS tipo,
                            COUNT(vw_datos.muestra) AS muestras,
                            SUM(CASE WHEN vw_datos.determinacion = vw_datos.correcto AND vw_datos.tipo = 'Leishmania' THEN 1
                            ELSE 0
                            END) AS correctasleish,
                            SUM(CASE WHEN vw_datos.determinacion != vw_datos.correcto AND vw_datos.tipo = 'Leishmania' THEN 1
                            ELSE 0
                            END) AS incorrectasleish,
                            SUM(CASE WHEN vw_datos.determinacion = vw_datos.correcto AND vw_datos.tipo = 'Serología' THEN 1
                            ELSE 0
                            END) AS correctassero,
                            SUM(CASE WHEN vw_datos.determinacion != vw_datos.correcto AND vw_datos.tipo = 'Serología' THEN 1
                            ELSE 0
                            END) AS incorrectassero
                     FROM vw_datos
                     WHERE vw_datos.idlaboratorio = '$idlaboratorio' AND
                           vw_datos.tipo != 'PCR'
                     GROUP BY SUBSTRING(vw_datos.operativo, 3, 4)
                     HAVING muestras > 0;";

        // capturamos el error
        try {

            // ejecutamos y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

}
