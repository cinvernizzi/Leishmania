<?php

/**
 *
 * enviamail | seguridad/enviamail.php
 *
 * @package     CCE
 * @subpackage  Seguridad
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (24/03/2023)
 * @copyright   Copyright (c) 2017, INP
 *
 * Método que recibe por get la dirección de correo de un usuario
 * la contraseña generada aleatoreamente y la dirección de correo
 * importa la plantilla y envía el correo con los datos de
 * conexión
 *
*/

// importamos la clase plantilla que contiene la configuración
// del correo y solo debemos reemplazar el texto del mensaje
require_once "../clases/correo.class.php";

// definimos el cuerpo del mensaje
$mensaje = "<p style='text-align:justify;'>";
$mensaje .= "Recientemente usted ha sido dado de alta en la Plataforma de
             Control de Calidad Externo del Instituto Nacional de Parasitología,
             Dr. Mario Fatala Chaben, a continuación, le informamos que los datos
             de conexión son los siguientes:</p> ";
$mensaje .= "<p>Usuario: " . $_GET["usuario"] . "<br>";
$mensaje .= "Contraseña: " . $_GET["password"] . "<br>";
$mensaje .= "El mail registrado es " . $_GET["mail"] . "</p>";
$mensaje .= "La ubicación de la plataforma es http://fatalachaben.mooo.com/Leishmania/";
$mensaje .= "<p style='text-align: justify;'>";
$mensaje .= "Al ingresar podrá generar una contraseña de acceso pulsando el enlace ";
$mensaje .= "que se encuentra en la pantalla inicial y posteriormente ingresado ";
$mensaje .= "el correo electrónico anteriormente citado.</p>";
$mensaje .= "<p style='text-align: justify;'>";
$mensaje .= "A vuelta de correo recibirá los datos de conexión para poder ingresar ";
$mensaje .= "a la plataforma.";
$mensaje .= "<p style='text-align: justify;'>";
$mensaje .= "No olvide que ante cualquier inconveniente puede comunicarse
             a cce.inp@gmail.com o diagnostico.inp.anlis@gmail.com donde intentaremos
             resolver sus dificultades.</p>";

// instanciamos la clase
$correo = new Correo();

// fijamos los atributos
$correo->setDestinatario($_GET["mail"]);
$correo->setTema("Alta en Plataforma de Leishmaniasis");
$correo->setHTML($mensaje);

// enviamos el mensaje
$resultado = $correo->enviaMail();

// retornamos
echo json_encode(array("Resultado" => $resultado["Resultado"]));
