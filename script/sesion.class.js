/**
 * Nombre: sesiones.js
 * Autor: Claudio Invernizzi
 * Fecha: 17/11/2017
 * Proyecto: CCE
 * Producido en: INP - Dr. Mario Fatabla Chaben
 * Licencia: GPL
 * Comentarios: Clase que controla la operación del contador de tiempo
 *              para finalizar las sesiones
 */

/**
 *
 * Atención, utilizamos el nuevo estandard definido en ECMAScript 2015 (ES6)
 * este permite definir clases con el mètodo ya utilizado en php y java
 * como creo que es mas claro lo utilizaremos, la compatibilidad está
 * anunciada para firefox y chrome así que no deberìa haber problemas
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Contador de tiempo de sesiones de usuario
 */
class Sesiones {

    /**
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @constructor
     */
    constructor(){

        // declaramos las variables de clase
        this.Temporizador = "";         // el contador de tiempo

        // iniciamos el temporizador
        this.Temporizador = window.setTimeout(this.cerrarSesion, 900000);

    }

    /**
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al finalizar el tiempo, cierra la
     * sesión tanto php como del objeto javascript
     */
    cerrarSesion(){

        // si no existen las variables de sesión
        if (seguridad.IdUsuario == null){
            return;
        }

        // destruimos el temporizador
        window.clearTimeout(this.Temporizador);

        // presenta el mensaje y espera la entrada del 
        // usuario para redirigir el navegador
        $.messager.alert('Atención',
                         'Ha finalizado la sesión',
                         'info', 
                         function(r){
                            if (r){
                                salir();
                            }
                        });

    }

    /**
     * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado para reiniciar el contador de tiempo
     */
    reiniciar(){

        // primero lo reseteamos
        window.clearTimeout(this.Temporizador);

        // lo iniciamos
        this.Temporizador = window.setTimeout(this.cerrarSesion, 900000);

    }

}