<?php

/**
 *
 * Class Herramientas | clases/herramientas.class.php
 *
 * @package     CCE
 * @subpackage  Clases
 * @author      Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @version     v.4.0 (16/08/2018)
 * @copyright   Copyright (c) 2018, INP
 *
 * Clase que implemente una serie de procedimientos utilizados
 * por el sistema
 *
*/

// declaramos el tipeo estricto
declare (strict_types=1);

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
class Herramientas {

    // aquí no tenemos un constructor ni variables de clase

    /**
     * Método que recibe como parámetro la fecha y retorna una
     * cadena con la fecha en letras
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $fecha en formato dd/mm/YYYY
     * @return string
     */
    public function fechaLetras(string $fecha) : string {

        // declaración de variables
        $mesLetras = "";

        // verificamos la longitud de la cadena
        if (strlen($fecha) != 10){

            // abandona por error
            echo $fecha;
            echo "La cadena es incorrecta, debe ser dd/mm/YYYY";
            exit;

        }

        // obtenemos el día
        $dia = substr($fecha, 0, 2);

        // si el día no es numérico
        if (!is_numeric($dia)){

            // abandona por error
            echo "El día debe ser un número";
            exit;

        }

        // obtenemos el mes
        $mes = substr($fecha, 3, 2);

        // si el mes no es numérico
        if (!is_numeric($mes)){

            // abandona por error
            echo "El mes debe ser un número";
            exit;

        }

        // obtenemos el año
        $anio = substr($fecha, 6, 4);

        // si el año no es un número
        if (!is_numeric($anio)){

            // abandona por error
            echo "El año debe ser un número";
            exit;

        }

        // convertimos el mes a número para eliminar el 0
        $mes = intval($mes);

        // verificamos que el mes se encuentre entre 1 y 12
        if ($mes < 1 || $mes > 12){

            // abandona por error
            echo "El mes debe estar comprendido entre 1 y 12";
            exit;

        }

        // convertimos el día a número
        $dia = intval($dia);

        // verificamos que el día no sea mayor de 31
        if ($dia < 1 || $dia > 31){

            // abandona por error
            echo "El día no puede ser mayor de 31";
            exit;

        }

        // según el mes verificamos que el día no sea mayor de 30
        if (($mes == 4 || $mes == 6 || $mes == 9 || $mes == 10) && $dia > 30 ){

            // abandona por error
            echo "Algunos meses solo pueden tener 30 días";
            exit;

        }

        // si es febrero verificamos que el día no sea mayor de
        // 28 o 29 si el año es biciesto
        if ($mes == 2){

            // si es biciesto
            if ($anio % 4 == 0){

                // verifica que no sea mayor de 29
                if ($dia > 29){

                    // abandona por error
                    echo "Febrero solo puede tener 29 días";
                    exit;

                }

            // si no es biciesto
            } else {

                // verifica que no sea mayor de 28
                if ($dia > 28){

                    // abandona por error
                    echo "Febrero solo puede tener 28 días";
                    exit;

                }

            }

        }

        // según el mes convertimos a letras
        switch ($mes){

            // según el mes
            case 1:
                $mesLetras = "Enero";
                break;
            case 2:
                $mesLetras = "Febrero";
                break;
            case 3:
                $mesLetras = "Marzo";
                break;
            case 4:
                $mesLetras = "Abril";
                break;
            case 5:
                $mesLetras = "Mayo";
                break;
            case 6:
                $mesLetras = "Junio";
                break;
            case 7:
                $mesLetras = "Julio";
                break;
            case 8:
                $mesLetras = "Agosto";
                break;
            case 9:
                $mesLetras = "Septiembre";
                break;
            case 10:
                $mesLetras = "Octubre";
                break;
            case 11:
                $mesLetras = "Noviembre";
                break;
            case 12:
                $mesLetras = "Diciembre";
                break;
            default:
                $mesLetras = "Desconocido";
                break;

        }

        // componemos la cadena
        return $dia . " días del mes de " . $mesLetras . " de " . $anio;

    }

    /**
     * Método que recibe como parámetro una cadena en formato
     * dd/mm/YY y retorna el día de la semana correspondiente
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $cadena - la cadena a convertir
     * @return string el día de la semana
     */
    public function diaSemana(string $cadena) : string {

        // primero convertimos la cadena a un objeto fecha
        $fecha = date_create_from_format("d/m/Y", $cadena);

        // definimos el array con los días de la semana
        $semana = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");

        // ahora obtenemos el número del día
        $dia = date('w', strtotime(date_format($fecha, 'Y/m/d')));

        // ahora retornamos el día en letras
        return $semana[$dia];

    }

    /**
     * Método que recibe como parámetros dos números y retorna el
     * porcentaje de esos dos números formateado
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param int $mayor - el primer número
     * @param int $menor - el segundo número
     * @return string $porcentaje
     */
    public function Porcentaje(int $mayor, int $menor) : string {

        // verifica que los dos sean un número
        if (!is_numeric($mayor)){

            // abandona por error
            echo "El primer valor debe ser un número";
            exit;

        // si el segundo no es un número
        } elseif (!is_numeric($menor)){

            // abandona por error
            echo "El segundo valor debe ser un número";
            exit;

        // si cumple con ambas condiciones
        } else {

            // calculamos el porcentaje y lo formateamos
            return number_format((($menor / $mayor) * 100), 2) + " %";

        }

    }

    /**
     * Método que genera una contraseña aleatoria
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return string contraseña generada
     */
    public function generaPass(){

        // Se define una cadena de caractares desordenada para mejorar
        $cadena = "qrstuvPQRSTDEFGHa6789bcdIJKABCLMNOUVWXYZefghijklmnopwxyz123450";

        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);

        // Definimos la variable que va a contener la contraseña
        $pass = "";

        // Se define la longitud de la contraseña
        $longitudPass=8;

        //Creamos la contraseña recorriendo la cadena
        for($i=1 ; $i<=$longitudPass ; $i++){

            // Definimos numero aleatorio entre 0 y la longitud de
            // la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);

            //Vamos formando la contraseña con cada carácter aleatorio.
            $pass .= substr($cadena,$pos,1);

        }

        // retornamos
        return $pass;

    }

    /**
     * Función que recibe como parámetro una cadena de texto (normalmente el
     * nombre de un laboratorio, busca la ocurrencia de ciertos términos y
     * los reemplaza por su abreviatura, usada en la impresión de etiquetas
     * para aquellas cadenas con mucha longitud
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param string $laboratorio - texto a resumir
     * @return string la cadena abreviada
     */
    public function Abreviar($laboratorio){

        // reemplaza las ocurrencias
        $laboratorio = str_replace("SANATORIO", "SANAT.", $laboratorio);
        $laboratorio = str_replace("HOSPITAL", "HOSP.", $laboratorio);
        $laboratorio = str_replace("SERVICIO", "SERV.", $laboratorio);
        $laboratorio = str_replace("REGIONAL", "REG.", $laboratorio);
        $laboratorio = str_replace("ANÁLISIS", "AN.", $laboratorio);
        $laboratorio = str_replace("ANALISIS", "AN.", $laboratorio);
        $laboratorio = str_replace("CLÍNICOS", "CLIN.", $laboratorio);
        $laboratorio = str_replace("CLINICOS", "CLIN.", $laboratorio);
        $laboratorio = str_replace("ASISTENCIAL", "ASIST.",$laboratorio);
        $laboratorio = str_replace("CENTRO", "CTRO.", $laboratorio);
        $laboratorio = str_replace("HEMOTERAPIA", "HEMOT.", $laboratorio);
        $laboratorio = str_replace("GOBERNADOR", "GOB.", $laboratorio);
        $laboratorio = str_replace("PRESIDENTE", "PRES.", $laboratorio);
        $laboratorio = str_replace("SANITARIO", "SANIT.", $laboratorio);
        $laboratorio = str_replace("SANITARIA", "SANIT.", $laboratorio);
        $laboratorio = str_replace("INTERMEDIA", "INT.", $laboratorio);
        $laboratorio = str_replace("ESTABLECIMIENTO", "EST.", $laboratorio);
        $laboratorio = str_replace("DISTRITAL", "DIST", $laboratorio);
        $laboratorio = str_replace("CENTRAL", "CENT.", $laboratorio);
        $laboratorio = str_replace("INTERZONAL", "INT.", $laboratorio);
        $laboratorio = str_replace("LABORATORIO", "LAB.", $laboratorio);
        $laboratorio = str_replace("LABORATORIOS", "LAB.", $laboratorio);
        $laboratorio = str_replace("MATERNIDAD", "MAT.", $laboratorio);
        $laboratorio = str_replace("GENERAL", "GRAL.", $laboratorio);
        $laboratorio = str_replace("AGUDOS", "AG.", $laboratorio);
        $laboratorio = str_replace("INTERZONAL", "INT.", $laboratorio);
        $laboratorio = str_replace("DOCTOR", "DR.", $laboratorio);
        $laboratorio = str_replace("DIRECCION", "DIR.", $laboratorio);
        $laboratorio = str_replace("DIRECCIÓN", "DIR.", $laboratorio);
        $laboratorio = str_replace("DOCTOR", "DR.", $laboratorio);
        $laboratorio = str_replace("PATOLOGÍAS", "PAT.", $laboratorio);
        $laboratorio = str_replace("PATOLOGIAS", "PAT.", $laboratorio);
        $laboratorio = str_replace("PREVALENTES", "PREV.", $laboratorio);
        $laboratorio = str_replace("COORDINADOR", "CORD.", $laboratorio);
        $laboratorio = str_replace("DEPARTAMENTO", "DEPTO.", $laboratorio);
        $laboratorio = str_replace("COORDINACION", "CORD.", $laboratorio);
        $laboratorio = str_replace("HERMANDAD", "HDAD.", $laboratorio);
        $laboratorio = str_replace("ARGENTINO", "ARG.", $laboratorio);
        $laboratorio = str_replace("ARGENTINA", "ARG", $laboratorio);
        $laboratorio = str_replace("PRODUCCION", "PROD.", $laboratorio);
        $laboratorio = str_replace("PRODUCCIÓN", "PROD.", $laboratorio);
        $laboratorio = str_replace("PEDIATRICO", "PED.", $laboratorio);
        $laboratorio = str_replace("PEDIÁTRICO", "PED.", $laboratorio);
        $laboratorio = str_replace("BARRIO", "Bº", $laboratorio);
        $laboratorio = str_replace("PUERTO", "PTO.", $laboratorio);
        $laboratorio = str_replace("SANTA", "STA.", $laboratorio);
        $laboratorio = str_replace("MARÍA", "M.", $laboratorio);
        $laboratorio = str_replace("MARIA", "M.", $laboratorio);
        $laboratorio = str_replace("ALBERTO", "A.", $laboratorio);
        $laboratorio = str_replace("MAMERTO", "M.", $laboratorio);
        $laboratorio = str_replace("NACIONAL", "NAC.", $laboratorio);
        $laboratorio = str_replace("ROBERTO", "R.", $laboratorio);
        $laboratorio = str_replace("SEGUNDO", "S.", $laboratorio);
        $laboratorio = str_replace("HERRERA", "H.", $laboratorio);
        $laboratorio = str_replace("JOSE", "M.", $laboratorio);
        $laboratorio = str_replace("LABORATORIO", "LAB.", $laboratorio);
        $laboratorio = str_replace("FACULTAD", "FAC.", $laboratorio);
        $laboratorio = str_replace("CIENCIAS", "Cs.", $laboratorio);
        $laboratorio = str_replace("EXACTAS", "EX.", $laboratorio);
        $laboratorio = str_replace("PUBLICA", "PUB.", $laboratorio);
        $laboratorio = str_replace("PÚBLICA", "PUB.", $laboratorio);
        $laboratorio = str_replace("MUNICIPAL", "MUN.", $laboratorio);
        $laboratorio = str_replace("SUBZONAL", "SUB.", $laboratorio);
        $laboratorio = str_replace("MATERNO", "MAT.", $laboratorio);
        $laboratorio = str_replace("INFANTIL", "INF.", $laboratorio);
        $laboratorio = str_replace("DESCENTRALIZADO", "DESC.", $laboratorio);
        $laboratorio = str_replace("ATENCION", "AT.", $laboratorio);
        $laboratorio = str_replace("ATENCIÓN", "AT.", $laboratorio);
        $laboratorio = str_replace("MEDICINA", "MED.", $laboratorio);
        $laboratorio = str_replace("PREVENTIVA", "PREV.", $laboratorio);
        $laboratorio = str_replace("UNIDAD", "UN.", $laboratorio);
        $laboratorio = str_replace("ESPECIALIZADO", "ESP.", $laboratorio);
        $laboratorio = str_replace("COLONIA", "COL.", $laboratorio);
        $laboratorio = str_replace("REHABILITACION", "REHAB.", $laboratorio);
        $laboratorio = str_replace("REHABILITACIÓN", "REHAB.", $laboratorio);
        $laboratorio = str_replace("INSTITUTO", "INST.", $laboratorio);
        $laboratorio = str_replace("EPIDEMIOLOGIA", "EPID.", $laboratorio);
        $laboratorio = str_replace("EPIDEMIOLOGÍA", "EPID.", $laboratorio);
        $laboratorio = str_replace("PROVINCIA", "PROV.", $laboratorio);
        $laboratorio = str_replace("UNIVERSIDAD", "UNIV.", $laboratorio);
        $laboratorio = str_replace("BIOQUIMICA", "BIOQ.", $laboratorio);
        $laboratorio = str_replace("BIOQUÍMICA", "BIOQ.", $laboratorio);
        $laboratorio = str_replace("FARMACIA", "FARM.", $laboratorio);
        $laboratorio = str_replace("MÉDICAS", "MED.", $laboratorio);
        $laboratorio = str_replace("MEDICAS", "MED.", $laboratorio);
        $laboratorio = str_replace("MÉDICA", "MED.", $laboratorio);
        $laboratorio = str_replace("MEDICA", "MED.", $laboratorio);
        $laboratorio = str_replace("PARASITOLOGÍA", "PARASIT.", $laboratorio);
        $laboratorio = str_replace("PARASITOLOGIA", "PARASIT.", $laboratorio);
        $laboratorio = str_replace("DIVISIÓN", "DIV.", $laboratorio);
        $laboratorio = str_replace("DIVISION", "DIV.", $laboratorio);
        $laboratorio = str_replace("COMPLEJIDAD", "COMP.", $laboratorio);
        $laboratorio = str_replace("ENFERMEDADES", "ENF.", $laboratorio);
        $laboratorio = str_replace("INFECCIOSAS", "INF.", $laboratorio);
        $laboratorio = str_replace("CLÍNICA", "CLIN.", $laboratorio);
        $laboratorio = str_replace("CLINICA", "CLIN.", $laboratorio);
        $laboratorio = str_replace("DISPENSARIO", "DISP.", $laboratorio);
        $laboratorio = str_replace("DERMATOLÓGICO", "DERM.", $laboratorio);
        $laboratorio = str_replace("DERMATOLOGICO", "DERM.", $laboratorio);
        $laboratorio = str_replace("REFERENCIA", "REF.", $laboratorio);
        $laboratorio = str_replace("TRANSMISIBLES", "TRANS.", $laboratorio);
        $laboratorio = str_replace("PROGRAMA", "PROG.", $laboratorio);
        $laboratorio = str_replace("TROPICALES", "TROP.", $laboratorio);
        $laboratorio = str_replace("MICROBIOLOGIA", "MICROB.", $laboratorio);
        $laboratorio = str_replace("MICROBIOLOGÍA", "MICROB.", $laboratorio);
        $laboratorio = str_replace("SAN", "S.", $laboratorio);
        $laboratorio = str_replace("MIGUEL", "M.", $laboratorio);
        $laboratorio = str_replace("SANTIAGO", "SGO.", $laboratorio);
        $laboratorio = str_replace("DALMIRO", "D.", $laboratorio);
        $laboratorio = str_replace("DIAGNOSTICO", "DIAG.", $laboratorio);
        $laboratorio = str_replace("JOSE", "J.", $laboratorio);
        $laboratorio = str_replace("IGNACIO", "I.", $laboratorio);
        $laboratorio = str_replace("OESTE", "(O)", $laboratorio);
        $laboratorio = str_replace("CENTRO", "CTRO.", $laboratorio);
        $laboratorio = str_replace("CIVICO", "CIV.", $laboratorio);
        $laboratorio = str_replace("CÍVICO", "CIV.", $laboratorio);
        $laboratorio = str_replace("LAMARQUE", "LAM.", $laboratorio);
        $laboratorio = str_replace("ANTIGUO", "ANT.", $laboratorio);
        $laboratorio = str_replace("PANTALEON", "PANT.", $laboratorio);
        $laboratorio = str_replace("NESTOR", "N.", $laboratorio);
        $laboratorio = str_replace("CIUDAD", "CDAD.", $laboratorio);
        $laboratorio = str_replace("BUENOS", "BS.", $laboratorio);
        $laboratorio = str_replace("AIRES", "AS.", $laboratorio);
        $laboratorio = str_replace("FERNANDO", "F.", $laboratorio);
        $laboratorio = str_replace("CIVICO", "CIV.", $laboratorio);
        $laboratorio = str_replace("GUILLERMO", "G.", $laboratorio);
        $laboratorio = str_replace("MOLECULARES", "MOL.", $laboratorio);
        $laboratorio = str_replace("METABOLICOS", "MET.", $laboratorio);
        $laboratorio = str_replace("METABÓLICOS", "MET.", $laboratorio);
        $laboratorio = str_replace("COMODORO", "CDRO.", $laboratorio);
        $laboratorio = str_replace("ESCUELA", "ESC.", $laboratorio);
        $laboratorio = str_replace("ESTERO", "EST.", $laboratorio);

        // retorna la cadena abreviada
        return $laboratorio;

    }

}
