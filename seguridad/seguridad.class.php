<?php

/**
 *
 * Class Seguridad | seguridad/seguridad.class.php
 *
 * @package     Tareas
 * @subpackage  Areas
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (03/02/2025)
 * @copyright   Copyright [(c) 2025, Claudio Invernizzi
 *
*/

// declaramos el tipo estricto
declare (strict_types=1);

// inclusión de archivos
require_once '../clases/conexion.class.php';
require_once '../clases/herramientas.class.php';

// leemos el archivo de configuración
$config = parse_ini_file("../clases/config.ini");
DEFINE ("URI", $config["URI"]);
DEFINE ("URL", $config["URL"]);

// convención para la nomenclatura de las propiedades, comienzan con una
// letra mayúscula, de tener mas de una palabra no se utilizan separadores
// y la inicial de cada palabra va en mayúscula
// para las variables recibidas como parámetro el criterio es todas en
// minúscula

// convención para la nomenclatura de los metodos, comienzan con set o get
// según asignen un valor o lo lean y luego el nombre del valor a obtener

/**
 * Clase que provee los métodos para verificar las credenciales
 * de un usuario
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Seguridad {

    // declaración de variables
    protected $Id;                        // clave del registro
    protected $IdUsuario;                 // clave del usuario
    protected $Ingreso;                   // datetime con la fecha de ingreso
    protected $Egreso;                    // datetime con la fecha de egreso
    protected $IpLocal;                   // ip local del cliente
    protected $IpPublica;                 // ip pública del cliente
    protected $Sistema;                   // sistema operativo del cliente
    protected $Estacion;                  // nombre de la estación
    protected $Version;                   // versión del sistema operativo
    protected $Hardware;                  // 32 o 64 bits
    protected $Navegador;                 // navegador del usuario
    protected $Usuario;                   // nombre de usuario fallido
    protected $Password;                  // password fallido utilizado
    protected $NuevoPass;                 // nueva contraseña del usuario
    protected $Link;                      // enlace a la base de datos

    /**
     * Constructor de la clase, inicializamos las variables
     * y establecemos la conexión con la base
     */
    public function __construct(){
     
        // inicializamos las variables
        $this->Id        = 0;
        $this->Ingreso   = date('Y/m/d H:i');
        $this->Egreso    = date('Y/m/d H:i');
        $this->IpLocal   = "";
        $this->IpPublica = "";
        $this->Sistema   = "";
        $this->Estacion  = "";
        $this->Version   = "";
        $this->Hardware  = "";
        $this->Navegador = "";
        $this->Link =    new Conexion();
        $this->IdUsuario = 0;
        $this->Usuario = "";
        $this->Password = "";
        $this->NuevoPass = "";

        // obtenemos los datos del cliente
        $this->obtenerDatos();
        
    }

    /**
     * Método que recibe como parámetro un nombre de usuario
     * y una contraseña y verifica los datos de acceso, en
     * caso de ser correcto retorna el vector con las
     * credenciales y los permisos de acceso
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [string] $usuario - nombre de usuario
     * @param [string] $password - contraseña sin encriptar
     * @return [array] vector con las credenciales
     */
    public function validaIngreso(string $usuario, string $password) : array {

        // componemos la consulta
        $consulta = "SELECT diagnostico.v_usuarios.idusuario AS id,
                            diagnostico.v_usuarios.usuario AS usuario,
                            diagnostico.v_usuarios.departamento AS area,
                            diagnostico.v_usuarios.id_departamento AS idarea,
                            diagnostico.v_usuarios.administrador AS administrador,
                            diagnostico.v_usuarios.activo AS activo
                     FROM diagnostico.v_usuarios
                     WHERE diagnostico.v_usuarios.nivelcentral = 'Si' AND
                           diagnostico.v_usuarios.usuario = '$usuario' AND
                           diagnostico.v_usuarios.password = MD5('$password'); ";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);

            // si no hubo registros
            if ($resultado->rowCount() == 0){

                // grabamos la incidencia y retornamos
                $this->errorIngreso($usuario, $password);
                return array("Resultado" => false);

            // si encontró registros
            } else {

                // obtenemos el registro
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);

                // iniciamos la sesión
                $sesion = $this->ingresaUsuario((int) $fila["id"]);

                // componemos el array y retornamos
                return array("Resultado"      => true,
                             "Sesion" =>      $sesion,
                             "IdUsuario"      => $fila["id"],
                             "Usuario"        => $fila["usuario"],
                             "Area"           => $fila["area"],
                             "IdArea"         => $fila["idarea"],
                             "Administrador"  => $fila["administrador"],
                             "Activo"         => $fila["activo"]);

            }

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje y retorna
            echo $e->getMessage();
            return array("Resultado" => false);

        }
        
    }

    /**
     * Método llamado al ingresar el usuario que inserta un
     * nuevo registro en la tabla de logs
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idusuario - clave del usuario
     */
    public function ingresaUsuario(int $idusuario) : int {

        // inicializamos el cliente
        $idcliente = 1;

        // componemos la consulta de inserción
        $consulta = "INSERT INTO diagnostico.logusuarios
                            (usuario,
                             idcliente,
                             ingreso,
                             iplocal,
                             ippublica,
                             sistema,
                             estacion,
                             version,
                             hardware)
                            VALUES
                            (:usuario,
                             :idcliente,
                             :ingreso,
                             :iplocal,
                             :ippublica,
                             :sistema,
                             :estacion,
                             :version,
                             :hardware); ";

        // asignamos la consulta
        $psInsertar = $this->Link->prepare($consulta);

        // capturamos el error
        try {

            // asignamos los valores
            $psInsertar->bindParam(":usuario",   $idusuario);
            $psInsertar->bindParam("idcliente",  $idcliente);
            $psInsertar->bindParam(":ingreso",   $this->Ingreso);
            $psInsertar->bindParam(":iplocal",   $this->IpLocal);
            $psInsertar->bindParam(":ippublica", $this->IpPublica);
            $psInsertar->bindParam(":sistema",   $this->Sistema);
            $psInsertar->bindParam(":estacion",  $this->Estacion);
            $psInsertar->bindParam(":version",   $this->Navegador);
            $psInsertar->bindParam(":hardware",  $this->Hardware);

            // ejecutamos la consulta
            $psInsertar->execute();

            // obtenemos la clave del registro y la retornamos
            $sesion = $this->Link->lastInsertId();
            return (int) $sesion;

        // si ocurrió un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return 0;

        }

    }

    /**
     * Método llamado al cerrar sesión que recibe como parámetro
     * la clave del registro y actualiza con la fecha de salida
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $idregistro - clave del registro
     * @return bool resultado de la operación
     */
    public function egresaUsuario(int $idregistro) : bool {

        // componemos la consulta de actualización
        $consulta = "UPDATE diagnostico.logusuarios SET
                            diagnostico.logusuarios.egreso = :egreso
                     WHERE diagnostico.logusuarios.id = :id;";

        // asignamos la consulta
        $psInsertar = $this->Link->prepare($consulta);

        // capturamos el error
        try {

            // asignamos los valores
            $psInsertar->bindParam(":egreso", $this->Egreso);
            $psInsertar->bindParam(":id",     $idregistro);

            // ejecutamos la consulta
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
     * Método llamado en caso de no validar las credenciales
     * que graba la incidencia en la tabla de errores de
     * ingreso
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param [string] $usuario - nombre con que quiso entrar
     * @param [string] $password - contraseña que utilizó
     * @return [bool] resultado de la operación
     */
    protected function errorIngreso(string $usuario, string $password) : bool {

        // componemos la consulta
        $consulta = "INSERT INTO diagnostico.logerrores
                            (usuario,
                             password,
                             iplocal,
                             ippublica,
                             sistema,
                             estacion,
                             version,
                             hardware)
                            VALUES
                            (:usuario,
                             :password,
                             :iplocal,
                             :ippublica,
                             :sistema,
                             :estacion,
                             :version,
                             :hardware);";
                             
        // habiliamos la captura de errores
        try {

            // asignamos la consulta
            $psInsertar = $this->Link->prepare($consulta);

            // asignamos los valores
            $psInsertar->bindParam(":usuario",   $usuario);
            $psInsertar->bindParam(":password",  $password);
            $psInsertar->bindParam(":iplocal",   $this->IpLocal);
            $psInsertar->bindParam(":ippublica", $this->IpPublica);
            $psInsertar->bindParam(":sistema",   $this->Sistema);
            $psInsertar->bindParam(":estacion",  $this->Estacion);
            $psInsertar->bindParam(":version",   $this->Navegador);
            $psInsertar->bindParam(":hardware",  $this->Hardware);

            // ejecutamos la consulta
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
     * Método llamado desde el constructor que obtiene los
     * datos del cliente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function obtenerDatos() : void {

        // obtenemos la cabezera
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // obtenemos el navegador
        $this->obtenerNavegador($user_agent);

        // obtenemos el sistema operativo
        $this->obtenerSistema($user_agent);

        // obtenemos la ip pública
        $this->obtenerIpPublica();

        // obtenemos la ip local
        $this->obtenerIpLocal();
        
    }

    /**
     * Método que a partir de las variables de sesión obtiene
     * el navegador del usuario y lo asigna a las variables
     * de clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $user_agent - cabecera del navegador
     */
    protected function obtenerNavegador($user_agent) : void {

        // buscamos la ocurrencia del navegador
        if (strpos($user_agent, 'MSIE') !== false) {
            $this->Navegador = 'Internet explorer';
        } elseif (strpos($user_agent, 'Edge') !== false) {
            $this->Navegador = 'Microsoft Edge';
        } elseif (strpos($user_agent, 'Trident') !== false) {
            $this->Navegador = 'Internet explorer';
        } elseif (strpos($user_agent, 'Opera Mini') !== false) {
            $this->Navegador = "Opera Mini";
        } elseif (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== false) {
            $this->Navegador = "Opera";
        } elseif (strpos($user_agent, 'Firefox') !== false) {
            $this->Navegador = 'Mozilla Firefox';
        } elseif (strpos($user_agent, 'Chrome') !== false) {
            $this->Navegador = 'Google Chrome';
        } elseif (strpos($user_agent, 'Safari') !== false) {
            $this->Navegador = "Safari";
        } else {
            $this->Navegador = 'Navegador Desconocido';
        }

    }

    /**
     * Método que recibe como parámetro la cabecera del navegador
     * y retorna el sistema operativo del mismo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $user_agent - cabecera del navegador
     */
    protected function obtenerSistema($user_agent) : void {

        // inicializamos las variables
        $this->Sistema = "No detectado";

        // declaramos el array de sistemas
        $plataformas = array(
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        );

        // ahora buscamos en la cadena del navegador
        foreach ($plataformas as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $this->Sistema = $value;
            }
        }

    }

    /**
     * Método que a partir de las cabeceras obtiene la ip
     * pública del cliente conectado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function obtenerIpPublica() : void {

        // según la cabecera
        if (getenv('HTTP_CLIENT_IP')) {
            $this->IpPublica = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $this->IpPublica = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $this->IpPublica = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $this->IpPublica = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $this->IpPublica = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $this->IpPublica = getenv('REMOTE_ADDR');
        } else {
            $this->IpPublica = 'Desconocida';
        }

        // si no lo encontró por ese método
        if ($this->IpPublica == "Desconocida"){

            // probamos haciendo un ping
            $this->IpPublica = file_get_contents(URI);

        }

    }

    /**
     * Método que obtiene la ip local de la estación
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    protected function obtenerIpLocal() : void {

        // inicializamos las variables
        $name = "";
        
        // probamos a través del socket
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_connect($sock, URL, 53);
        socket_getsockname($sock, $name);
        $this->IpLocal = $name;
        socket_close($sock);

    }

    /**
     * Método que recibe como parámetro el mail de un usuario
     * verifica si está registrado y en ese caso actualiza
     * la contraseña de acceso, retorna el resutado de la
     * operación y las credenciales de acceso
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $mail - correo del usuario
     * @return array - vector con las credenciales
     */
    public function recuperaMail(string $mail) : array {
     
        // verificamos si el mail existe
        $resultado = $this->getIdCorreo($mail);

        // si encontró y está activo
        if ($resultado["Resultado"] && $resultado["Activo"] == "Si"){

            // creamos una contraseña aleatoria
            $herramientas = new Herramientas();
            $contrasenia = $herramientas->generaPass();

            // asignamos en la clase
            $this->Id = (int) $resultado["IdUsuario"];
            $this->NuevoPass = $contrasenia;

            // actualizamos la contraseña
            $this->nuevoPassword();

            // retornamos el array
            return array("Resultado" => true,
                         "Usuario" =>   $resultado["Usuario"],
                         "Password" =>  $contrasenia);

        // si no encontró asignamos en falso
        // todos los campos para inicializarlos
        } else {
            
            // retornamos
            return array("Resultado" => false,
                         "Usuario" =>   false,
                         "Password" =>  false);
            
        }

    }

   /**
     * Método que recibe una dirección de correo (la cual es única)
     * retorna el vector con los datos del usuario para enviarlos
     * por mail
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $mail - correo a buscar en la base
     * @return array vector con los datos
     */
    public function getIdCorreo(string $mail) : array {
       
        // componemos la consulta, que exista el mail ya lo
        // verificamos antes
        $consulta = "SELECT cce.vw_responsables.id AS id,
                            cce.vw_responsables.responsable AS responsable,
                            cce.vw_responsables.institucion AS institucion,
                            cce.vw_responsables.activo AS activo,
                            cce.vw_responsables.usuario AS usuario
                     FROM cce.vw_responsables
                     WHERE cce.vw_responsables.mail = '$mail';";

        // capturamos el error
        try {

            // ejecutamos la consulta
            $resultado = $this->Link->query($consulta);

            // si hay registros
            if ($resultado->rowCount() != 0){

                // obtenemos el registro
                $fila = $resultado->fetch(PDO::FETCH_ASSOC);

                // retornamos el vector
                return array("Resultado" =>   true,
                             "IdUsuario" =>   $fila["id"],
                             "Nombre" =>      $fila["responsable"],
                             "Institucion" => $fila["institucion"],
                             "Activo" =>      $fila["activo"],
                             "Usuario" =>     $fila["usuario"]);

            // si no encontró registros
            } else {
                return array("Resultado" => false);
            }

        // si hubo un error
        } catch (PDOException $e){

            // presenta el mensaje
            echo $e->getMessage();
            return array("Resultado" => false);

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
            $psInsertar->bindParam(":nuevopass", $this->NuevoPass);
            $psInsertar->bindParam(":id", $this->Id);

            // ejecutamos la consulta y obtenemos la clave
            $psInsertar->execute();
            return (int) $this->Id;

        // si hubo un error
        } catch (PDOException $e) {

            // mostramos el mensaje y asignamos la clave
            echo $e->getMessage();
            return 0;

        }

    }

}
