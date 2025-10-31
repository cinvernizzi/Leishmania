<?php

/**
 *
 * Class Conexion | clases/conexion.class.php
 *
 * @package     Siresa
 * @subpackage  Clases
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     1.0 (11/05/2016)
 * @copyright   Copyright (c) 2017, INP
 *
 */

 /**
 * Clase que sobrecarga el constructor de PDO
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class Conexion extends PDO {

    /**
     * Constructor de la clase, sobrecarga el constructor
     * de PDO y establece la conexión con la base
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct() {

        // leemos el archivo de configuración
        $config = parse_ini_file("config.ini");

        // verificamos que las constantes no estén definidas
        if (!defined('HOST')){
            DEFINE ("HOST",        $config["Host"]);
            DEFINE ("BASE",        $config["Base"]);
            DEFINE ("USUARIO",     $config["Usuario"]);
            DEFINE ("CONTRASEGNA", $config["Password"]);
            DEFINE ("ESTADO",      $config["Estado"]);
        }

        // según el estado del servidor
        if (ESTADO == "Desarrollo") {

            // activamos la depuración
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);


        // si está en producción
        } else {

            // desactivamos la depuración
            ini_set('display_errors', 'Off');
            error_reporting(E_ALL&~E_DEPRECATED);

        }

        // Sobreescribo el método constructor de la clase PDO
        // y utilizamos la captura de errores al mismo tiempo
        // fijamos que retorna en minusculas, el emulate
        // prepares a false disminuye ligeramente el rendimiento
        // pero mejora la captura de errores y mejora la
        // seguridad (mas difícil para la inyección sql)
        // por otro lado, al ponerlo en false, mysql lanza
        // el error prepared statement need to be re prepared
        try {

            // establecemos las opciones de la conexión
            $options = array(PDO::ATTR_PERSISTENT => true,
                             PDO::ATTR_EMULATE_PREPARES => true,
                             PDO::ATTR_CASE => PDO::CASE_LOWER,
                             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                             PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'");

            // llamamos al constructor del padre
            parent::__construct('mysql:host='.HOST.';dbname='.BASE, USUARIO, CONTRASEGNA, $options);

        // si hubo algún error lo presentamos
        } catch (PDOException $e) {

            // presenta el error
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: '.$e->getMessage();
            exit;

        }

    }

}
