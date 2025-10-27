<?php

/**
 *
 * Class mapas | reportes/mapas.class.php
 *
 * @package     Leishmania
 * @subpackage  Reportes
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.1.0 (26/08/2025)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que obtiene las coordenadas gps de los pacientes y de las
 * mascotas y las retorna como un array
 *
*/

// declaramos el tipeado estricto
declare(strict_types=1);

// incluimos las clases
require_once "../clases/conexion.class.php";

// declaración de la clase
class Mapas {

    // definición de variables
    protected $Link;        // puntero a la base de datos

    /**
     * Constructor de la clase, instanciamos la conexión y
     * las variables de clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __construct(){
        
        // instanciamos la conexión
        $this->Link = new Conexion();

    }

    /**
     * Destructor de la clase
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     */
    public function __destruct(){
        
        // eliminamos el puntero
        $this->Link = null;

    }

    /**
     * Método que retorna el vector con las coordenadas de
     * los pacientes ingresados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function getCoordenadasPacientes() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.nombre AS nombre,
                            leishmania.v_pacientes.coordenadas AS coordenadas
                     FROM leishmania.v_pacientes
                     WHERE leishmania.v_pacientes.coordenadas != ''; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

    /**
     * Método que retorna el vector con las coordenadas de
     * las mascotas y animales ingresados
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return [array] vector con los registros
     */
    public function getCoordenadasMascotas() : array {

        // componemos la consulta
        $consulta = "SELECT leishmania.v_pacientes.mascota AS mascota,
                            leishmania.v_pacientes.coordenadas AS coordenadas
                     FROM leishmania.v_pacientes
                     WHERE leishmania.v_pacientes.coordenadas != '' AND
                           leishmania.v_pacientes.mascota != ''; ";

        // capturamos el error
        try {

            // ejecutamos la consulta y retornamos
            $resultado = $this->Link->query($consulta);
            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        // si hubo un error
        } catch (PDOException $e){

            // presenta el error
            echo $e->getMessage();
            return array("Resultado" => false);

        }

    }

}
