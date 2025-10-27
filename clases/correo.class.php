<?php

/**
 *
 * Class correo.class.php | clases/correo.class.php
 *
 * @package     Tareas
 * @subpackage  Clases
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (15/05/2025)
 * @copyright   Copyright (c) 2025, DsGestión
 *
 */

// importamos en el espacio de nombres
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// incluimos los archivos
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

/**
 * Definición de la clase, leemos el archivo de
 * configuración y definimos las variables de
 * clase
 */
class Correo{

    // definimos las variables de clase
    private $Host;           // la url del servidor de correo
    private $Puerto;         // el puerto del servidor de correo
    private $Usuario;        // nombre de usuario (también sender)
    private $Pass;           // el password
    private $Tsl;            // si usa tsl
    private $Mail;           // la instancia del php mailer

    /**
     * Constructor de la clase, instanciamos la
     * clase php mailer y definimos la configuración
     * del correo
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){

        // leemos el archivo de configuración
        $config = parse_ini_file("config.ini");
        $this->Host    = $config["SMTP"];
        $this->Puerto  = $config["Puerto"];
        $this->Usuario = $config["UserSMTP"];
        $this->Pass    = $config["PassSMTP"];
        $this->Tsl     = $config["TSL"];

        // instanciamos la clase
        $this->Mail = new PHPMailer();
        $this->Mail->IsSMTP();

        // configuramos la conexión
        $this->Mail->CharSet="UTF-8";
        $this->Mail->Host = $this->Host;
        $this->Mail->SMTPDebug = 1;
        $this->Mail->Port = $this->Puerto;
        $this->Mail->SMTPAuth = true;
        $this->Mail->IsHTML(true);

        // si usa tsl
        if ($this->Tsl == 1){
            $this->Mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } else {
            $this->Mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }

        // nos autenticamos
        $this->Mail->Username = $this->Usuario;
        $this->Mail->Password = $this->Pass;

        // fijamos el sender
        $this->Mail->SetFrom($this->Usuario);

    }

    /**
     * Método que recibe como parámetro una dirección
     * de correo (que asume verificada) y la asigna
     * como destinatario
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function setDestinatario($destinatario){

        // asignamos en la clase
        $this->Mail->AddAddress($destinatario);

    }

    /**
     * Método que recibe como parámetro una cadena de
     * texto y la fija como tema del mensaje
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function setTema($tema){

        // fijamos el tema
        $this->Mail->Subject = $tema;

    }

    /**
     * Método que recibe una cadena de texto plano y
     * la fija como contenido del mensaje
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function setContenido($mensaje){

        // fijamos el texto
        $this->Mail->AltBody = $mensaje;

    }

    /**
     * Método que recibe como parámetro un texto con formato
     * html y lo fija como contenido del mensaje
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function setHTML($mensaje){

        // fijamos el contenido
        $this->Mail->msgHTML($mensaje);

    }

    /**
     * Método que recibe como parámetro la ruta absoluta a
     * un archivo y lo agrega como adjunto del mensaje
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function setAdjunto($ruta){

        // lo agregamos
        $this->Mail->addAttachment($ruta);

    }

    /**
     * Método que envía el mensaje ya configurado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return bool resultado de la operación
     */
    public function enviaMail(){

        // si no pudo enviar
        return !$this->Mail->Send() ?  false : true;

    }

}
