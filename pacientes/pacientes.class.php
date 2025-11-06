<?php

/**
 *
 * Class Pacientes | clases/pacientes.class.php
 *
 * @package     Leishmania
 * @subpackage  Pacientes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (16/05/2025)
 * @copyright   Copyright (c) 2018, DsGestion
 *
 * Clase que implementa los métodos para el abm de los pacientes
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
class Pacientes {

    // definición de variables
    protected $Link;             // puntero a la base de datos
    protected $Id;               // clave del registro
    protected $Protocolo;        // protocolo asignado por el servicio
    protected $Fecha;            // fecha de denuncia
    protected $Nombre;           // nombre del paciente
    protected $Documento;        // número de documento
    protected $TipoDoc;          // tipo de documento
    protected $IdTipoDoc;        // clave del tipo de documento
    protected $Sexo;             // descripción del sexo
    protected $IdSexo;           // clave del sexo
    protected $Edad;             // edad del paciente
    protected $LocNacimiento;    // clave indec de la localidad de nacimiento
    protected $Localidad;        // nombre de la localidad de nacimiento
    protected $Nacimiento;       // fecha de nacimiento
    protected $Provincia;        // provincia de nacimiento
    protected $IdProvincia;      // clave indec de la provincia de nacimiento
    protected $Nacionalidad;     // nacionalidad del paciente
    protected $IdNacionalidad;   // clave de la nacionalidad
    protected $Coordenadas;      // coordenadas gps
    protected $Domicilio;        // domicilio del paciente
    protected $Urbano;           // tipo de domicilio (urbano / rural)
    protected $TelPaciente;      // teléfono del paciente
    protected $IdOcupacion;      // clave de la ocupación
    protected $Ocupacion;        // descripción de la ocupación
    protected $IdInstitucion;    // clave de la institución
    protected $Institucion;      // nombre de la institución
    protected $ProvInstitucion;  // nombre de la provincia de la institución
    protected $CodProvInstitucion; // clave indec de la provincia de la institución
    protected $NomLocInstitucion;// nombre de la localidad de la institución
    protected $CodLocInstitucion;// clave indec de la localidad de la institución
    protected $Enviado;          // profesional que remitió la muestra
    protected $Mail;             // correo del profesional
    protected $Telefono;         // teléfono del profesional
    protected $Antecedentes;     // antecedentes epidemiológicos
    protected $Notificado;       // fecha notificación al sisa
    protected $Sisa;             // clave notificación al sisa
    protected $IdUsuario;        // clave del usuario
    protected $Usuario;          // nombre del usuario
    protected $Alta;             // fecha de alta del registro
    protected $Modificado;       // fecha de modificación del registro

    /**
     * Constructor de la clase, instanciamos la conexión
     * y definimos las variables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // instanciamos la conexión
        $this->Link = new Conexion();

        // inicializamos las variables
        $this->Id = 0;
        $this->Protocolo = "";
        $this->Fecha = "";
        $this->Nombre = "";
        $this->Documento = "";
        $this->TipoDoc = "";
        $this->IdTipoDoc = 0;
        $this->Edad = 0;
        $this->Sexo = "";
        $this->IdSexo = 0;
        $this->LocNacimiento = "";
        $this->Localidad = "";
        $this->Nacimiento = "";
        $this->Provincia = "";
        $this->IdProvincia = "";
        $this->Nacionalidad = "";
        $this->IdNacionalidad = 0;
        $this->Coordenadas = "";
        $this->Domicilio = "";
        $this->Urbano = "";
        $this->TelPaciente = "";
        $this->IdOcupacion = 0;
        $this->Ocupacion = "";
        $this->IdInstitucion = 0;
        $this->Institucion = "";
        $this->NomLocInstitucion = "";
        $this->CodLocInstitucion = "";
        $this->Enviado = "";
        $this->Mail = "";
        $this->Telefono = "";
        $this->Antecedentes = "";
        $this->Notificado = "";
        $this->Sisa = "";
        $this->IdUsuario = 0;
        $this->Usuario = "";
        $this->Alta = "";
        $this->Modificado = "";

    }

    /**
     * Destructor de la clase, eliminamos los objetos
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
    public function setProtocolo(?string $protocolo) : void {
        $this->Protocolo = $protocolo;
    }
    public function setFecha(string $fecha) : void {
        $this->Fecha = $fecha;
    }
    public function setNombre(string $nombre) : void {
        $this->Nombre = $nombre;
    }
    public function setDocumento(?string $documento) : void {
        $this->Documento = $documento;
    }
    public function setIdTipoDoc(?int $idtipodoc) : void {
        $this->IdTipoDoc = $idtipodoc;
    }
    public function setEdad(?int $edad) : void {
        $this->Edad = $edad;
    }
    public function setIdSexo(int $idsexo) : void {
        $this->IdSexo = $idsexo;
    }
    public function setLocNacimiento(?string $localidad) : void {
        $this->LocNacimiento = $localidad;
    }
    public function setNacimiento(?string $nacimiento) : void {
        $this->Nacimiento = $nacimiento;
    }
    public function setCoordenadas(?string $coordenadas) : void {
        $this->Coordenadas = $coordenadas;
    }
    public function setDomicilio(?string $domicilio) : void {
        $this->Domicilio = $domicilio;
    }
    public function setUrbano(string $urbano) : void {
        $this->Urbano = $urbano;
    }
    public function setTelPaciente(?string $telpaciente) : void {
        $this->TelPaciente = $telpaciente;
    }
    public function setIdOcupacion(?int $idocupacion) : void {
        $this->IdOcupacion = $idocupacion;
    }
    public function setIdInstitucion(int $idinstitucion) : void {
        $this->IdInstitucion = $idinstitucion;
    }
    public function setEnviado(string $enviado) : void {
        $this->Enviado = $enviado;
    }
    public function setMail(?string $mail) : void {
        $this->Mail = $mail;
    }
    public function setTelefono(?string $telefono) : void {
        $this->Telefono = $telefono;
    }
    public function setAntecedentes(?string $antecedentes) : void {
        $this->Antecedentes = $antecedentes;
    }
    public function setNotificado(?string $notificado) : void {
        $this->Notificado = $notificado;
    }
    public function setSisa(?string $sisa) : void {
        $this->Sisa = $sisa;
    }
    public function setIdUsuario(int $idusuario) : void {
        $this->IdUsuario = $idusuario;
    }

    // métodos de retorno de valores
    public function getId() : int {
        return (int) $this->Id;
    }
    public function getProtocolo() : ?string {
        return $this->Protocolo;
    }
    public function getFecha() : string {
        return $this->Fecha;
    }
    public function getNombre() : string {
        return $this->Nombre;
    }
    public function getDocumento() : ?string {
        return $this->Documento;
    }
    public function getIdTipoDoc() : ?int {
        return (int) $this->IdTipoDoc;
    }
    public function getTipoDoc() : ?string {
        return $this->TipoDoc;
    }
    public function getEdad() : ?int {
        return (int) $this->Edad;
    }
    public function getSexo() : string {
        return $this->Sexo;
    }
    public function getIdSexo() : int {
        return (int) $this->IdSexo;
    }
    public function getLocNacimiento() : ?string {
        return $this->LocNacimiento;
    }
    public function getLocalidad() : ?string {
        return $this->Localidad;
    }
    public function getNacimiento() : ?string {
        return $this->Nacimiento;
    }
    public function getIdNacionalidad() : ?int {
        return (int) $this->IdNacionalidad;
    }
    public function getProvincia() : ?string {
        return $this->Provincia;
    }
    public function getIdProvincia() : ?string {
        return $this->IdProvincia;
    }
    public function getNacionalidad() : ?string {
        return $this->Nacionalidad;
    }
    public function getCoordenadas() : ?string {
        return $this->Coordenadas;
    }
    public function getDomicilio() : ?string {
        return $this->Domicilio;
    }
    public function getUrbano() : string {
        return $this->Urbano;
    }
    public function getTelPaciente() : ?string {
        return $this->TelPaciente;
    }
    public function getIdOcupacion() : int {
        return (int) $this->IdOcupacion;
    }
    public function getOcupacion() : string {
        return $this->Ocupacion;
    }
    public function getIdInstitucion() : int {
        return (int) $this->IdInstitucion;
    }
    public function getInstitucion() : string {
        return $this->Institucion;
    }
    public function getProvInstitucion() : string {
        return $this->ProvInstitucion;
    }
    public function getCodProvInstitucion() : string {
        return $this->CodProvInstitucion;
    }
    public function getLocInstitucion() : string {
        return $this->NomLocInstitucion;
    }
    public function getCodLocInstitucion() : string {
        return $this->CodLocInstitucion;
    }
    public function getEnviado() : string {
        return $this->Enviado;
    }
    public function getMail() : ?string {
        return $this->Mail;
    }
    public function getTelefono() : ?string {
        return $this->Telefono;
    }
    public function getAntecedentes() : ?string {
        return $this->Antecedentes;
    }
    public function getNotificado() : ?string {
        return $this->Notificado;
    }
    public function getSisa() : ?string {
        return $this->Sisa;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getAlta() : string {
        return $this->Alta;
    }
    public function getModificado() : string {
        return $this->Modificado;
    }

    /**
     * Método que según las variables de clase, genera la
     * consulta de inserción o edición, retorna la clave
     * del registro o cero en caso de error
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [int] - clave del registro
     */
    public function grabaPaciente() : int {

        // si está editando
        if ($this->Id == 0){
            $this->nuevoPaciente();
        } else {
            $this->editaPaciente();
        }

        // retornamos
        return (int) $this->Id;

    }

    /**
     * Método que ejecuta la consulta de inserción, retorna
     * el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [bool] resultado de la operación
     */
    protected function nuevoPaciente() : bool {

        // componemos la consulta
        $consulta = "INSERT INTO leishmania.pacientes
                            (protocolo, 
                             fecha,
                             nombre,
                             documento,
                             tipodoc,
                             sexo,
                             edad,
                             nacimiento,
                             locnac,
                             coordenadas,
                             domicilio,
                             urbano,
                             telpaciente,
                             ocupacion,
                             institucion,
                             profesional,
                             mail,
                             telefono,
                             antecedentes,
                             notificado,
                             sisa,
                             usuario)
                            VALUES
                            (:protocolo, 
                             STR_TO_DATE(:fecha, '%d/%m/%Y'),
                             :nombre,
                             :documento,
                             :tipodoc,
                             :sexo,
                             :edad,
                             STR_TO_DATE(:nacimiento, '%d/%m/%Y'),
                             :locnac,
                             :coordenadas,
                             :domicilio,
                             :urbano,
                             :telpaciente,
                             :ocupacion,
                             :institucion,
                             :enviado,
                             :mail,
                             :telefono,
                             :antecedentes,
                             STR_TO_DATE(:notificado, '%d/%m/%Y'),
                             :sisa,
                             :usuario); ";

        // capturamos el error
        try {

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":protocolo",    $this->Protocolo);
            $preparada->bindParam(":fecha",        $this->Fecha);
            $preparada->bindParam(":nombre",       $this->Nombre);
            $preparada->bindParam(":documento",    $this->Documento);
            $preparada->bindParam(":tipodoc",      $this->IdTipoDoc);
            $preparada->bindParam(":sexo",         $this->IdSexo);
            $preparada->bindParam(":edad",         $this->Edad);
            $preparada->bindParam(":nacimiento",   $this->Nacimiento);
            $preparada->bindParam(":locnac",       $this->LocNacimiento);
            $preparada->bindParam(":coordenadas",  $this->Coordenadas);
            $preparada->bindParam(":domicilio",    $this->Domicilio);
            $preparada->bindParam(":urbano",       $this->Urbano);
            $preparada->bindParam(":telpaciente",  $this->TelPaciente);
            $preparada->bindParam(":ocupacion",    $this->IdOcupacion);
            $preparada->bindParam(":institucion",  $this->IdInstitucion);
            $preparada->bindParam(":enviado",      $this->Enviado);
            $preparada->bindParam(":mail",         $this->Mail);
            $preparada->bindParam(":telefono",     $this->Telefono);
            $preparada->bindParam(":antecedentes", $this->Antecedentes);
            $preparada->bindParam(":notificado",   $this->Notificado);
            $preparada->bindParam(":sisa",         $this->Sisa);
            $preparada->bindParam(":usuario",      $this->IdUsuario);
            $preparada->execute();

            // obtenemos la clave
            $this->Id = $this->Link->lastInsertId();

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            $this->Id = 0;
            return false;

        }

    }

    /**
     * Método que ejecuta la consulta de edición, retorna
     * el resultado de la operación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [bool] resultado de la operación
     */
    protected function editaPaciente() : bool {

        // componemos la consulta
        $consulta = "UPDATE leishmania.pacientes SET
                            protocolo = :protocolo, 
                            fecha = STR_TO_DATE(:fecha, '%d/%m/%Y'),
                            nombre = :nombre,
                            documento = :documento,
                            tipodoc = :tipodoc,
                            sexo = :sexo,
                            edad = :edad,
                            nacimiento = STR_TO_DATE(:nacimiento, '%d/%m/%Y'),
                            locnac = :locnac,
                            coordenadas = :coordenadas,
                            domicilio = :domicilio,
                            urbano = :urbano,
                            telpaciente = :telpaciente,
                            ocupacion = :ocupacion,
                            institucion = :institucion,
                            profesional = :enviado,
                            mail = :mail,
                            telefono = :telefono,
                            antecedentes = :antecedentes,
                            notificado = STR_TO_DATE(:notificado, '%d/%m/%Y'),
                            sisa = :sisa,
                            usuario = :usuario
                     WHERE leishmania.pacientes.id = :id; ";

        // capturamos el error
        try{

            // preparamos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":protocolo",    $this->Protocolo);
            $preparada->bindParam(":fecha",        $this->Fecha);
            $preparada->bindParam(":nombre",       $this->Nombre);
            $preparada->bindParam(":documento",    $this->Documento);
            $preparada->bindParam(":tipodoc",      $this->IdTipoDoc);
            $preparada->bindParam(":sexo",         $this->IdSexo);
            $preparada->bindParam(":edad",         $this->Edad);
            $preparada->bindParam(":nacimiento",   $this->Nacimiento);
            $preparada->bindParam(":locnac",       $this->LocNacimiento);
            $preparada->bindParam(":coordenadas",  $this->Coordenadas);
            $preparada->bindParam(":domicilio",    $this->Domicilio);
            $preparada->bindParam(":urbano",       $this->Urbano);
            $preparada->bindParam(":telpaciente",  $this->TelPaciente);
            $preparada->bindParam(":ocupacion",    $this->IdOcupacion);
            $preparada->bindParam(":institucion",  $this->IdInstitucion);
            $preparada->bindParam(":enviado",      $this->Enviado);
            $preparada->bindParam(":mail",         $this->Mail);
            $preparada->bindParam(":telefono",     $this->Telefono);
            $preparada->bindParam(":antecedentes", $this->Antecedentes);
            $preparada->bindParam(":notificado",   $this->Notificado);
            $preparada->bindParam(":sisa",         $this->Sisa);
            $preparada->bindParam(":usuario",      $this->IdUsuario);
            $preparada->bindParam(":id",           $this->Id);
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
     * Método que recibe como parámetro la clave de un registro
     * y asigna los valores en las variables de clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $idpaciente - clave del registro
     * @return [bool] resultado de la operación
     */
    public function getDatosPaciente(int $idpaciente) : bool {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.id AS id,
                            leishmania.v_pacientes.protocolo AS protocolo, 
                            leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.iddocumento AS idtipodoc,
                            leishmania.v_pacientes.tipodoc AS tipodoc,
                            leishmania.v_pacientes.sexo AS sexo,
                            leishmania.v_pacientes.idsexo AS idsexo,
                            leishmania.v_pacientes.edad AS edad,
                            leishmania.v_pacientes.nacimiento AS nacimiento,
                            leishmania.v_pacientes.locnacimiento AS locnacimiento,
                            leishmania.v_pacientes.localidad AS localidad,
                            leishmania.v_pacientes.provincia AS provincia,
                            leishmania.v_pacientes.codprov AS codprov,
                            leishmania.v_pacientes.nacionalidad AS nacionalidad,
                            leishmania.v_pacientes.idnacionalidad AS idnacionalidad,
                            leishmania.v_pacientes.domicilio AS domicilio,
                            leishmania.v_pacientes.coordenadas AS coordenadas,
                            leishmania.v_pacientes.urbano AS urbano,
                            leishmania.v_pacientes.telpaciente AS telpaciente,
                            leishmania.v_pacientes.idocupacion AS idocupacion,
                            leishmania.v_pacientes.ocupacion AS ocupacion, 
                            leishmania.v_pacientes.idinstitucion AS idinstitucion,
                            leishmania.v_pacientes.institucion AS institucion,
                            leishmania.v_pacientes.nomlocinstitucion AS nomlocinstitucion,
                            leishmania.v_pacientes.codlocinstitucion AS codlocinstitucion,
                            leishmania.v_pacientes.provinstitucion AS provinstitucion,
                            leishmania.v_pacientes.codprovinstitucion AS codprovinstitucion,
                            leishmania.v_pacientes.profesional AS profesional,
                            leishmania.v_pacientes.mail As mail,
                            leishmania.v_pacientes.telefono AS telefono,
                            leishmania.v_pacientes.antecedentes AS antecedentes,
                            leishmania.v_pacientes.notificado AS notificado,
                            leishmania.v_pacientes.sisa AS sisa,
                            leishmania.v_pacientes.usuario AS usuario,
                            leishmania.v_pacientes.alta AS alta,
                            leishmania.v_pacientes.modificado AS modificado
                     FROM leishmania.v_pacientes
                     WHERE leishmania.v_pacientes.id = '$idpaciente'; ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);

            // asignamos en la clase
            $this->Id = $fila["id"];
            $this->Protocolo = $fila["protocolo"];
            $this->Fecha = $fila["fecha"];
            $this->Nombre = $fila["nombre"];
            $this->Documento = $fila["documento"];
            $this->TipoDoc = $fila["tipodoc"];
            $this->IdTipoDoc = $fila["idtipodoc"];
            $this->Sexo = $fila["sexo"];
            $this->IdSexo = $fila["idsexo"];
            $this->Edad = $fila["edad"];
            $this->Nacimiento = $fila["nacimiento"];
            $this->LocNacimiento = $fila["locnacimiento"];
            $this->Localidad = $fila["localidad"];
            $this->IdProvincia = $fila["codprov"];
            $this->Provincia = $fila["provincia"];
            $this->IdNacionalidad = $fila["idnacionalidad"];
            $this->Nacionalidad = $fila["nacionalidad"];
            $this->Coordenadas = $fila["coordenadas"];
            $this->Domicilio = $fila["domicilio"];
            $this->Coordenadas = $fila["coordenadas"];
            $this->Urbano = $fila["urbano"];
            $this->TelPaciente = $fila["telpaciente"];
            $this->IdOcupacion = $fila["idocupacion"];
            $this->Ocupacion = $fila["ocupacion"];
            $this->IdInstitucion = $fila["idinstitucion"];
            $this->CodLocInstitucion = $fila["codlocinstitucion"];
            $this->NomLocInstitucion = $fila["nomlocinstitucion"];
            $this->CodProvInstitucion = $fila["codprovinstitucion"];
            $this->ProvInstitucion = $fila["provinstitucion"];
            $this->NomLocInstitucion = $fila["nomlocinstitucion"];
            $this->Institucion = $fila["institucion"];
            $this->Enviado = $fila["profesional"];
            $this->Mail = $fila["mail"];
            $this->Telefono = $fila["telefono"];
            $this->Antecedentes = $fila["antecedentes"];
            $this->Notificado = $fila["notificado"];
            $this->Sisa = $fila["sisa"];
            $this->Usuario = $fila["usuario"];
            $this->Alta = $fila["alta"];
            $this->Modificado = $fila["modificado"];

            // retornamos
            return true;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el error y retorna
            echo $e->getMessage();
            return false;

        }

    }

    /**
     * Método que recibe como parámetro una cadena de texto
     * y busca en el nombre, el documento y en el nombre
     * de la mascota la ocurrencia del mismo, luego el
     * desplazamiento del primer registro y el número de
     * registros a retornar, retorna el vector con los
     * registros coincidentes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [string] $texto - cadena a buscar
     * @param [int] $offset - desplazamiento del primer registro
     * @param [int] $registros - número de registros a retornar
     */
    public function buscaPaciente(string $texto,
                                  int $offset,
                                  int $registros) : array {

        // componemos la consulta
        $consulta = "SELECT DISTINCT(leishmania.v_pacientes.id) AS id,
                            leishmania.v_pacientes.protocolo AS protocolo, 
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.institucion AS institucion,
                            leishmania.v_pacientes.profesional AS enviado
                     FROM leishmania.v_pacientes
                     WHERE leishmania.v_pacientes.nombre LIKE '%$texto%' OR
                           leishmania.v_pacientes.documento = '$texto' OR
                           leishmania.v_pacientes.protocolo = '$texto' OR 
                           leishmania.v_pacientes.mascota LIKE '%$texto%'
                     ORDER BY leishmania.v_pacientes.nombre
                     LIMIT $offset, $registros; ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Error" => true);

        }

    }

    /**
     * Método que recibe como parámetro una cadena de texto
     * y retorna el número de registros coincidentes, utilizado
     * en el paginador de la búsqueda de pacientes
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [string] $texto - cadena a buscar
     * @return [int] registros coincidentes
     */
    public function numeroPacientes(string $texto) : int {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.v_pacientes.id) AS registros
                     FROM leishmania.v_pacientes
                     WHERE leishmania.v_pacientes.nombre LIKE '%$texto%' OR
                           leishmania.v_pacientes.documento = '$texto' OR
                           leishmania.v_pacientes.protocolo = '$texto' OR
                           leishmania.v_pacientes.mascota LIKE '%$texto%'; ";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $fila["registros"];

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;

        }
        
    }

    /**
     * Método que recibe como parámetro la clave de un registro y
     * ejecuta la consulta de eliminación, retorna el resultado
     * de la operación
     * @uthor Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $idpaciente - clave del registro
     * @return [bool] resultado de la operación
     */
    public function borraPaciente(int $idpaciente) : bool {

        // componemos la consulta
        $consulta = "DELETE FROM leishmania.pacientes
                     WHERE leishmania.pacientes.id = :id; ";

        // capturamos el error
        try {

            // definimos, asignamos y ejecutamos
            $preparada = $this->Link->prepare($consulta);
            $preparada->bindParam(":id", $idpaciente);
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

    /**
     * Método que recibe como parámetro un número de documento
     * y verifica si ya está declarado, utilizado para evitar
     * los registros duplicados, sin embargo, tener en cuenta
     * que el número de documento es optativo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [string] $documento - documento del paciente
     * @param [int] $id - clave del registro
     * @return [bool] si puede insertar
     */
    public function validaPaciente(string $documento, int $id) : bool {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.pacientes.id) AS registros
                     FROM leishmania.pacientes
                     WHERE leishmania.pacientes.documento = '$documento' AND
                           leishmania.pacientes.id != '$id'; ";

        // capturamos el error
        try {

            // ejecutamos y obtenemos el registro
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
     * Método que recibe como parámetro un año y obtiene 
     * los registros de los pacientes que han sido notificados 
     * en el sisa durante ese año
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - el año a reportar
     * @return [array] vector con los registros
     */
    public function getNotificadosPacientes(int $anio) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.material AS material,
                            leishmania.v_pacientes.tecnica AS tecnica,
                            leishmania.v_pacientes.fecha_muestra AS fecha_muestra,
                            leishmania.v_pacientes.notificado As notificado
                     FROM leishmania.v_pacientes
                     WHERE YEAR(STR_TO_DATE(leishmania.v_pacientes.notificado, '%d/%m/%Y')) = '$anio'
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

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $anio - entero con el año a reportar
     * @return int entero con el número de registros 
     * Método utilizado en la paginación de la grilla de los 
     * resultados notificados al sisa que recibe como parámetro 
     * un año y retorna el número de pacientes notificados 
     * en ese año
     */
    public function numeroNotificados(int $anio) : int {

        // componemos la consulta
        $consulta = "SELECT COUNT(leishmania.v_pacientes.id) AS registros 
                     FROM leishmania.v_pacientes
                     WHERE YEAR(STR_TO_DATE(leishmania.v_pacientes.notificado, '%d/%m/%Y')) = '$anio'; ";

        // capturamos el error
        try {

            // obtenemos el vector y retornamos
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $fila["registros"];
        
        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return 0;

        }
        
    }

    /**
     * Método que recibe como parámetro un año, el desplazamiento
     * del primer registro y el número de registros a retornar 
     * y obtiene los registros de los pacientes que han sido notificados 
     * en el sisa durante ese año
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [int] $anio - el año a reportar
     * @return [array] vector con los registros
     */
    public function getNotificadosPaginados(int $anio,
                                            int $offset, 
                                            int $registros) : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.id AS id, 
                            leishmania.v_pacientes.fecha AS fecha,
                            leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.documento AS documento,
                            leishmania.v_pacientes.material AS material,
                            leishmania.v_pacientes.tecnica AS tecnica,
                            leishmania.v_pacientes.fecha_muestra AS fecha_muestra
                            leishmania.v_pacientes.notificado AS notificado
                     FROM leishmania.v_pacientes
                     WHERE YEAR(STR_TO_DATE(leishmania.v_pacientes.notificado, '%d/%m/%Y')) = '$anio'
                     ORDER BY STR_TO_DATE(leishmania.v_pacientes.fecha, '%d/%m/%Y),
                              leishmania.v_pacientes.nombre
                     LIMIT $offset, $registros; ";

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
