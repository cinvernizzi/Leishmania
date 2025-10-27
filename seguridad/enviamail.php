<?php

/**
 *
 * enviamail | seguridad/enviamail.php
 *
 * @package     Leishmaniasis
 * @subpackage  Seguridad
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (27/08/2025)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la dirección de correo de un usuario
 * la contraseña generada aleatoreamente y la dirección de correo
 * importa la plantilla y envía el correo con los datos de
 * conexión
 *
*/

// incluimos la clase
require_once("../clases/correo.class.php");

// obtenemos el destinatario
$destinatario = $_GET["mail"];

// definimos el cuerpo del mensaje
$mensaje = "<p style='text-align:justify'>";
$mensaje .= "Recientemente usted ha solicitado la recuperación de la contraseña ";
$mensaje .= "de acceso a la Plataforma de Control de Calidad Externo, a continuación, ";
$mensaje .= "le informamos que los datos de conexión son los siguientes:</p>";
$mensaje .= "<p>Usuario: " . $_GET["usuario"] . "<br>";
$mensaje .= "Contraseña: " . $_GET["password"] . "</p>";
$mensaje .= "<p style='text-align:justify'>";
$mensaje .= "Al ingresar podrá actualizar la contraseña, por una nueva solo conocida ";
$mensaje .= "por usted.</p>";
$mensaje .= "<p style='text-align:justify'>";
$mensaje .= "No olvide que ante cualquier inconveniente puede comunicarse ";
$mensaje .= "a cce.inp@gmail.com o diagnostico.inp.anlis@gmail.com donde intentaremos ";
$mensaje .= "resolver sus dificultades.</p>";

// instanciamos la clase y fijamos las propiedades
$correo = new Correo();
$correo->setDestinatario($_GET["mail"]);
$correo->setTema("Recuperación de Contraseña");
$correo->setHTML($mensaje);

// enviamos el correo
$resultado = $correo->enviaMail();

// retornamos
echo json_encode(array("Resultado" => true));
