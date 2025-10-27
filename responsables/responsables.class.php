<?php

/**
 *
 * Class Responsables | responsables/responsables.class.php
 *
 * @package     CCE
 * @subpackage  Responsables
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.5.0 (23/03/2023)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que controla las operaciones sobre la tabla de
 * responsables
 *
*/

// declaramos el tipeado estricto
declare (strict_types=1);

// inclusión de archivos
require_once "../clases/conexion.class.php";
require_once "../clases/herramientas.class.php";

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
class Responsables {

    // declaración de variables de la clase, las declaramos
    // como protected para que puedan ser heredadas pero
    // para asignarle el valor debemos crear los métodos
    protected $Link;                  // puntero a la base de datos

    // definición de variables de la base de datos
    protected $IdResponsable;                // clave del registro
    protected $Nombre;                       // nombre del usuario
    protected $Institucion;                  // institución en la que trabaja
    protected $Cargo;                        // descripción del cargo
    protected $Mail;                         // mail del usuario
    protected $Telefono;                     // teléfono del usuario
    protected $Localidad;                    // nombre de la localidad
    protected $IdLocalidad;                  // clave de la localidad
    protected $Provincia;                    // nombre de la provincia
    protected $IdProvincia;                  // clave indec ce la provincia
    protected $Pais;                         // nombre del país de procedencia
    protected $IdPais;                       // clave del país
    protected $Direccion;                    // dirección postal del usuario
    protected $Coordenadas;                  // coordenadas GPS
    protected $CodigoPostal;                 // Código postal
    protected $ResponsableChagas;            // indica si es responsable
    protected $ResponsableLeish;             // si es responsable de leishmania
    protected $Laboratorio;                  // nombre del laboratorio
    protected $IdLaboratorio;                // clave del laboratorio que administra
    protected $Activo;                       // indica si el usuario está activo
    protected $Observaciones;                // observaciones y comentarios
    protected $Usuario;                      // nombre de usuario
    protected $Password;                     // contraseña del usuario
    protected $FechaAlta;                    // fecha de alta del registro
    protected $NivelCentral;                 // indica si el usuario es de nivel central
    protected $Autorizo;                     // nombre del usuario que autorizo el ingreso
    protected $IdAutorizo;                   // clave del usuario que autorizó el ingreso

    /**
     * Constructor de la clase, establece la conexión con la base
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct (){

        // nos conectamos a la base de datos
        $this->Link = new Conexion();

        // inicializamos las variables de clase
        $this->IdResponsable = 0;
        $this->Nombre = "";
        $this->Institucion = "";
        $this->Cargo = "";
        $this->Mail = "";
        $this->Telefono = "";
        $this->Localidad = "";
        $this->IdLocalidad = "";
        $this->Provincia = "";
        $this->IdProvincia = "";
        $this->Pais = "";
        $this->IdPais = 0;
        $this->Direccion = "";
        $this->Coordenadas = "";
        $this->CodigoPostal = "";
        $this->ResponsableChagas = "";
        $this->ResponsableLeish = "";
        $this->Laboratorio = "";
        $this->IdLaboratorio = 0;
        $this->Activo = "";
        $this->Observaciones = "";
        $this->Usuario = "";
        $this->Password = "";
        $this->FechaAlta = "";
        $this->NivelCentral = "";
        $this->Autorizo = "";
        $this->IdAutorizo = 0;

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
    public function setIdResponsable(int $idresponsable) : void {
        $this->IdResponsable = $idresponsable;
    }
    public function setNombre(string $nombre) : void {
        $this->Nombre = $nombre;
    }
    public function setInstitucion(string $institucion) : void {
        $this->Institucion = $institucion;
    }
    public function setCargo(string $cargo) : void {
        $this->Cargo = $cargo;
    }
    public function setMail(string $mail) : void {
        $this->Mail = $mail;
    }
    public function setTelefono(string $telefono) : void {
        $this->Telefono = $telefono;
    }
    public function setIdLocalidad(string $idlocalidad) : void {
        $this->IdLocalidad = $idlocalidad;
    }
    public function setIdPais(int $idpais) : void {
        $this->IdPais = $idpais;
    }
    public function setDireccion(string $direccion) : void {
        $this->Direccion = $direccion;
    }
    public function setCoordenadas(string $coordenadas) : void {
        $this->Coordenadas = $coordenadas;
    }
    public function setCodigoPostal(string $codigopostal) : void {
        $this->CodigoPostal = $codigopostal;
    }
    public function setResponsableChagas(string $responsable) : void {
        $this->ResponsableChagas = $responsable;
    }
    public function setResponsableLeish(string $responsable) : void {
        $this->ResponsableLeish = $responsable;
    }
    public function setIdLaboratorio(int $idlaboratorio) : void {
        $this->IdLaboratorio = $idlaboratorio;
    }
    public function setActivo(string $activo) : void {
        $this->Activo = $activo;
    }
    public function setObservaciones(string $observaciones) : void {
        $this->Observaciones = $observaciones;
    }
    public function setNivelCentral(string $nivelcentral) : void {
        $this->NivelCentral = $nivelcentral;
    }
    public function setUsuario(string $usuario) : void {
        $this->Usuario = $usuario;
    }
    public function setIdAutorizo(int $idautorizo) : void {
        $this->IdAutorizo = $idautorizo;
    }
    public function setPassword(string $password) : void {
        $this->Password = $password;
    }

    // métodos de obtención de valores
    public function getIdResponsable() : int {
        return (int) $this->IdResponsable;
    }
    public function getNombre() : string {
        return $this->Nombre;
    }
    public function getInstitucion() : string {
        return $this->Institucion;
    }
    public function getCargo() : string {
        return $this->Cargo;
    }
    public function getMail() : string {
        return $this->Mail;
    }
    public function getTelefono() : ?string {
        return $this->Telefono;
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
    public function getPais() : string {
        return $this->Pais;
    }
    public function getIdPais() : int {
        return (int) $this->IdPais;
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
    public function getResponsableChagas() : string {
        return $this->ResponsableChagas;
    }
    public function getResponsableLeish() : string {
        return $this->ResponsableLeish;
    }
    public function getLaboratorio() : ?string {
        return $this->Laboratorio;
    }
    public function getIdLaboratorio() : ?int {
        return (int) $this->IdLaboratorio;
    }
    public function getActivo() : string {
        return $this->Activo;
    }
    public function getObservaciones() : ?string {
        return $this->Observaciones;
    }
    public function getUsuario() : string {
        return $this->Usuario;
    }
    public function getFechaAlta() : string {
        return $this->FechaAlta;
    }
    public function getNivelCentral() : string {
        return $this->NivelCentral;
    }
    public function getAutorizo() : ?string {
        return $this->Autorizo;
    }

    /**
     * Método utilizado en el formulario de responsables que lista los
     * responsables activos de la jurisdicción que recibe como parámetro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} $jurisdiccion - código indec ce la jurisdicción
     * @return array
     */
    public function listaResponsables(string $jurisdiccion) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_responsables.responsable AS responsable,
                            cce.vw_responsables.id AS id
                     FROM cce.vw_responsables
                     WHERE cce_vw_responsables.idprovincia = '$jurisdiccion' AND
                           cce.vw_responsables.activo = 'Si' AND
                           cce.vw_responsables.responsable_chagas = 'Si'
                     ORDER BY cce.responsables.responsable;";

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
     * Método que recibe una dirección de correo y la clave
     * del usuario si es una edición, verifica si ya se encuentra
     * definido el correo en la base y retorna el número de
     * registros encontrados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $mail - cadena con el correo del usuario
     * @param int $id - entero con la clave del usuario
     * @return int
     */
    public function verificaMail(string $mail, int $id = 0) : int {

        // verificamos que no la tenga otro usuario
        $consulta = "SELECT COUNT(*) AS registros
                        FROM cce.responsables
                        WHERE cce.responsables.e_mail = '$mail' AND
                              cce.responsables.id != '$id';";

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
            return 1;

        }

    }

    /**
     * Método que verifica si el nombre de usuario ya se encuentra
     * declarado en la base retorna el número de registros encontados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $usuario - nombre de usuario de la tabla responsables
     * @return int
     */
    public function verificaUsuario(string $usuario) : int {

        // definimos la consulta
        $consulta = "SELECT COUNT(*) AS registros
                     FROM cce.responsables
                     WHERE cce.responsables.usuario = '$usuario';";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            return (int) $fila["registros"];

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 1;

        }

    }

    /**
     * Método que busca en la tabla de responsables los usuarios que
     * coincidan con el texto recibido
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $texto - un texto a buscar
     * @return array
     */
    public function buscaResponsable($texto){

        // componemos la consulta
        $consulta = "SELECT cce.vw_responsables.id AS idresponsable,
                            cce.vw_responsables.responsable AS nombre,
                            cce.vw_responsables.cargo AS cargo,
                            cce.vw_responsables.institucion AS institucion,
                            cce.vw_responsables.localidad AS localidad,
                            cce.vw_responsables.provincia AS provincia
                     FROM cce.vw_responsables
                     WHERE cce.vw_responsables.responsable LIKE '%$texto%' OR
                           cce.vw_responsables.institucion LIKE '%$texto%' OR
                           cce.vw_responsables.localidad LIKE '%$texto%' OR
                           cce.vw_responsables.provincia LIKE '%$texto%'
                     ORDER BY cce.vw_responsables.responsable;";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();

        }

    }

    /**
     * Método que a partir de la id del usuario busca y asigna a
     * las variables de clase los valores del registro
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idresponsable - clave del registro
     */
    public function getResponsable(int $idresponsable){

        // componemos la consulta
        $consulta = "SELECT cce.vw_responsables.id AS idresponsable,
                            cce.vw_responsables.responsable AS nombre,
                            cce.vw_responsables.institucion AS institucion,
                            cce.vw_responsables.cargo AS cargo,
                            cce.vw_responsables.mail AS mail,
                            cce.vw_responsables.telefono AS telefono,
                            cce.vw_responsables.pais AS pais,
                            cce.vw_responsables.idpais AS idpais,
                            cce.vw_responsables.localidad AS localidad,
                            cce.vw_responsables.idlocalidad AS idlocalidad,
                            cce.vw_responsables.provincia AS provincia,
                            cce.vw_responsables.idprovincia AS idprovincia,
                            cce.vw_responsables.direccion AS direccion,
                            cce.vw_responsables.codigopostal AS codigopostal,
                            cce.vw_responsables.coordenadas AS coordenadas,
                            cce.vw_responsables.responsable_chagas AS responsable_chagas,
                            cce.vw_responsables.responsable_leish AS responsable_leish,
                            cce.vw_responsables.laboratorio AS laboratorio,
                            cce.vw_responsables.idlaboratorio AS idlaboratorio,
                            cce.vw_responsables.activo AS activo,
                            cce.vw_responsables.observaciones AS observaciones,
                            cce.vw_responsables.usuario AS usuario,
                            cce.vw_responsables.fecha_alta AS fecha_alta,
                            cce.vw_responsables.nivelcentral AS nivelcentral,
                            cce.vw_responsables.autorizo AS autorizo
                     FROM cce.vw_responsables
                     WHERE cce.vw_responsables.id = '$idresponsable';";

        // capturamos el error
        try {

            // obtenemos el registro
            $resultado = $this->Link->query($consulta);
            $registro = $resultado->fetch(PDO::FETCH_ASSOC);

            // asignamos a las variables de clase
            $this->IdResponsable = $registro["idresponsable"];
            $this->Nombre = $registro["nombre"];
            $this->Institucion = $registro["institucion"];
            $this->Cargo = $registro["cargo"];
            $this->Mail = $registro["mail"];
            $this->Telefono = $registro["telefono"];
            $this->Pais = $registro["pais"];
            $this->IdPais = $registro["idpais"];
            $this->Localidad = $registro["localidad"];
            $this->IdLocalidad = $registro["idlocalidad"];
            $this->Provincia = $registro["provincia"];
            $this->IdProvincia = $registro["idprovincia"];
            $this->Direccion = $registro["direccion"];
            $this->Coordenadas = $registro["coordenadas"];
            $this->CodigoPostal = $registro["codigopostal"];
            $this->ResponsableChagas = $registro["responsable_chagas"];
            $this->ResponsableLeish = $registro["responsable_leish"];
            $this->Laboratorio = $registro["laboratorio"];
            $this->IdLaboratorio = $registro["idlaboratorio"];
            $this->Activo = $registro["activo"];
            $this->Observaciones = $registro["observaciones"];
            $this->Usuario = $registro["usuario"];
            $this->FechaAlta = $registro["fecha_alta"];
            $this->NivelCentral = $registro["nivelcentral"];
            $this->Autorizo = $registro["autorizo"];

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();

        }

    }

    /**
     * Método que produce la consulta de actualización o inserción
     * según el caso y retorna la id del registro afectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array la clave del registro y el password del usuario
     */
    public function grabaResponsable() : array {

        // si está editando
        if ($this->IdResponsable != 0){
            $this->editaResponsable();
        } else {
            $this->nuevoResponsable();
         }

        // retornamos la id
        return array("Id" => $this->IdResponsable,
                     "Password" => $this->Password);

    }

    /**
     * Método que inserta un nuevo registro en la tabla de responsables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function nuevoResponsable(){

        // generamos la contraseña al azar
        $herramientas = new Herramientas();
        $this->Password = $herramientas->generaPass();

        // compone la consulta de inserción
        $consulta = "INSERT INTO cce.responsables
                                (nombre,
                                 institucion,
                                 cargo,
                                 e_mail,
                                 telefono,
                                 pais,
                                 localidad,
                                 direccion,
                                 codigo_postal,
                                 responsable_chagas,
                                 responsable_leish,
                                 laboratorio,
                                 activo,
                                 nivel_central,
                                 observaciones,
                                 coordenadas,
                                 usuario,
                                 password,
                                 autorizo)
                                VALUES
                                (:nombre,
                                 :institucion,
                                 :cargo,
                                 :e_mail,
                                 :telefono,
                                 :pais,
                                 :localidad,
                                 :direccion,
                                 :codigo_postal,
                                 :responsable_chagas,
                                 :responsable_leish,
                                 :laboratorio,
                                 :activo,
                                 :nivelcentral,
                                 :observaciones,
                                 :coordenadas,
                                 :usuario,
                                 MD5(:pass),
                                 :autorizo);";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":nombre", $this->Nombre);
            $psInsertar->bindParam(":institucion", $this->Institucion);
            $psInsertar->bindParam(":cargo", $this->Cargo);
            $psInsertar->bindParam(":e_mail", $this->Mail);
            $psInsertar->bindParam(":telefono", $this->Telefono);
            $psInsertar->bindParam(":pais", $this->IdPais);
            $psInsertar->bindParam(":localidad", $this->IdLocalidad);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":responsable_chagas", $this->ResponsableChagas);
            $psInsertar->bindParam(":responsable_leish", $this->ResponsableLeish);
            $psInsertar->bindParam(":laboratorio", $this->IdLaboratorio);
            $psInsertar->bindParam(":activo", $this->Activo);
            $psInsertar->bindParam(":nivelcentral", $this->NivelCentral);
            $psInsertar->bindParam(":observaciones", $this->Observaciones);
            $psInsertar->bindParam(":coordenadas", $this->Coordenadas);
            $psInsertar->bindParam(":usuario", $this->Usuario);
            $psInsertar->bindParam(":pass", $this->Password);
            $psInsertar->bindParam(":autorizo", $this->IdAutorizo);

            // ejecutamos la edición
            $psInsertar->execute();

            // obtiene la id del registro insertado
            $this->IdResponsable = $this->Link->lastInsertId();

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje y asignamos la clave
            $this->IdResponsable = 0;
            echo $e->getMessage();

        }

    }

    /**
     * Método que edita el registro de la tabla de responsables
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function editaResponsable(){

        // compone la consulta de edición
        $consulta = "UPDATE cce.responsables SET
                            nombre = :nombre,
                            institucion = :institucion,
                            cargo = :cargo,
                            e_mail = :e_mail,
                            telefono = :telefono,
                            pais = :pais,
                            localidad = :localidad,
                            direccion = :direccion,
                            codigo_postal = :codigo_postal,
                            responsable_chagas = :responsable_chagas,
                            responsable_leish = :responsable_leish,
                            laboratorio = :laboratorio,
                            activo = :activo,
                            observaciones = :observaciones,
                            nivel_central = :nivel_central,
                            autorizo = :autorizo
                     WHERE cce.responsables.id = :id_responsable;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":nombre", $this->Nombre);
            $psInsertar->bindParam(":institucion", $this->Institucion);
            $psInsertar->bindParam(":cargo", $this->Cargo);
            $psInsertar->bindParam(":e_mail", $this->Mail);
            $psInsertar->bindParam(":telefono", $this->Telefono);
            $psInsertar->bindParam(":pais", $this->IdPais);
            $psInsertar->bindParam(":localidad", $this->IdLocalidad);
            $psInsertar->bindParam(":direccion", $this->Direccion);
            $psInsertar->bindParam(":codigo_postal", $this->CodigoPostal);
            $psInsertar->bindParam(":responsable_chagas", $this->ResponsableChagas);
            $psInsertar->bindParam(":responsable_leish", $this->ResponsableLeish);
            $psInsertar->bindParam(":laboratorio", $this->IdLaboratorio);
            $psInsertar->bindParam(":activo", $this->Activo);
            $psInsertar->bindParam(":observaciones", $this->Observaciones);
            $psInsertar->bindParam(":nivel_central", $this->NivelCentral);
            $psInsertar->bindParam(":autorizo", $this->IdAutorizo);
            $psInsertar->bindParam(":id_responsable", $this->IdResponsable);

            // ejecutamos la edición
            $psInsertar->execute();

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje y asignamos la clave
            $this->IdResponsable = 0;
            echo $e->getMessage();

        }

    }

    /**
     * Método que retorna el array con la nómina de responsables sin georreferenciar
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return array
     */
     public function sinGeorreferenciar() : array {

         // componemos la consulta en la vista
         $consulta = "SELECT cce.vw_responsables.id AS id,
                             UPPER(cce.vw_responsables.responsable) AS responsable,
                             cce.vw_responsables.pais AS pais,
                             cce.vw_responsables.provincia AS provincia,
                             cce.vw_responsables.localidad AS localidad,
                             cce.vw_responsables.direccion AS direccion
                       FROM vw_responsables
                       WHERE vw_responsables.coordenadas = '' OR
                             ISNULL(vw_responsables.coordenadas) OR
                             vw_responsables.coordenadas = 'undefined' OR
                             vw_responsables.coordenadas = '(0.0,0.0)'
                       ORDER BY cce.vw_responsables.provincia,
                                cce.vw_responsables.responsable;";

         // capturamos el error
         try {

            // obtenemos el array y retornamos
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
     * Método que recibe como parámetros la id de un responsable y las
     * coordenadas gps, actualiza entonces la base de datos
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $id - clave del registro
     * @param string $coordenadas - conjunto de coordenadas gps
     * @return boolean resultado de la operación
     */
    public function grabaCoordenadas(int $id, string $coordenadas) : bool {

        // componemos la consulta y ejecutamos la consulta
        $consulta = "UPDATE cce.responsables SET
                            coordenadas = :coordenadas
                     WHERE cce.responsables.id = :id;";
    
        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los parámetros de la consulta
            $psInsertar->bindParam(":coordenadas", $coordenadas);
            $psInsertar->bindParam(":id",          $id);

            // ejecutamos la edición y retornamos
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
     * Método que recibe como parámetro la clave de una provincia
     * y obtiene los datos del primer responsable activo de esa
     * jurisdicción, utilizado en el envío de mails a la provincia
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $provincia - clave indec de la provincia
     * @return array datos del responsable
     */
    public function responsableProvincia(string $provincia) : array {

        // componemos la consulta
        $consulta = "SELECT cce.vw_responsables.responsable AS responsable,
                            cce.vw_responsables.cargo AS cargo,
                            cce.vw_responsables.mail AS mail,
                            cce.vw_responsables.provincia AS provincia
                     FROM cce.vw_responsables
                     WHERE cce.vw_responsables.activo = 'Si' AND
                           cce.vw_responsables.nivelcentral = 'No' AND
                           cce.vw_responsables.idprovincia = '$provincia' AND
                           cce.vw_responsables.responsable_chagas = 'Si' AND
                           (cce.vw_responsables.idlaboratorio = 0 OR ISNULL(cce.vw_responsables.idlaboratorio))
                     LIMIT 1; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y obtenemos el registro
            $resultado = $this->Link->query($consulta);
            return $resultado->fetch(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe como parámetro la clave de uin referente y
     * retorna el vector con los años de los operativos en los cuales
     * la provincia participó de los controles de calidad (tanto de
     * leishmania como de serología), utilizado en la generación de
     * certificados
     * @author Claudio Invernizzi <cinvernnizzi@gmail.com>
     * @param $idresponsable - entero con la clave del referente
     * @return array con la nómina de años de participación
     */
    public function aniosCertificados(int $idresponsable) : array {

        // componemos la consulta
        $consulta = "SELECT DISTINCT(YEAR(cce.operativos_chagas.FECHA_INICIO)) AS anio
                     FROM cce.vw_responsables INNER JOIN cce.vw_laboratorios ON cce.vw_responsables.idprovincia = cce.vw_laboratorios.idprovincia
                                              INNER JOIN cce.chag_datos ON cce.vw_laboratorios.id = cce.chag_datos.LABORATORIO
                                              INNER JOIN cce.operativos_chagas ON cce.chag_datos.OPERATIVO = cce.operativos_chagas.id
                     WHERE (cce.vw_responsables.responsable_chagas= 'Si' OR
                            cce.vw_responsables.responsable_leish = 'Si') AND
                            cce.vw_responsables.id = '$idresponsable'
                     ORDER BY YEAR(cce.operativos_chagas.fecha_inicio) DESC;";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch(PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que recibe la clave de un usuario y el password y
     * verifica que coincida con el password declarado en la
     * base, utilizado en el cambio de contraseña
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idusuario - clave del usuario
     * @param string $password - contraseña actual
     * @return int registros encontrados (normalmente 1 o 0)
     */
    public function validaPassword(int $idusuario, string $password) : int {

        // componemos la consulta
        $consulta = "SELECT COUNT(cce.vw_responsables.id) AS registros
                     FROM cce.vw_responsables
                     WHERE cce.vw_responsables.id = '$idusuario' AND
                           cce.vw_responsables.password = MD5('$password'); ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
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
     * Método que efectúa el cambio de contraseña en la base de datos
     * de usuarios, asume que ya fueron inicializadas las variables
     * de clase, verifica si los valores son correctos y actualiza
     * en la base de datos
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return integer 0 si hubo error, de otra forma la clave del
     *         registro
     */
    public function nuevoPassword() : int {

        // encriptamos el nuevo password usando la función de mysql Y
        // componemos la consulta de actualización
        $consulta = "UPDATE cce.responsables SET
                            cce.responsables.password = MD5(:nuevopass)
                     WHERE cce.responsables.id = :id;";

        // capturamos el error
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":nuevopass", $this->Password);
            $psInsertar->bindParam(":id", $this->IdResponsable);

            // ejecutamos la consulta y obtenemos la clave
            $psInsertar->execute();
            return (int) $this->IdResponsable;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje y asignamos la clave
            echo $e->getMessage();
            return 0;

        }

    }

}
