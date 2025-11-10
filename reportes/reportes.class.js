/*

    Nombre: reportes.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 22/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que implementa la presentación de los
                 reportes del sistema

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Clase que controla las operaciones del formulario
 *        de elementos del peridomicilio del paciente
 */
class Reportes {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta en el contenedor el mapa con la
     * distribución geográfica de los casos evaluados
     * (positivos, negativos, pacientes y animales) distinguidos
     * a través de íconos
     */
    georreferenciar(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el contenedor
        $("#form_reportes").load("reportes/formmapa.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la definición del contenedor
     * del mapa que instancia el mismo
     */
    initMapa(){

        // reiniciamos la sesión
        sesion.reiniciar();

        this.Map = new google.maps.Map(document.getElementById("mapapacientes"), {
                    center: { lat: -31.40648, lng: -64.18853 },
                    zoom: 5
        });

        // ahora obtenemos los pacientes georreferenciados
        this.getCoordenadasPacientes();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que obtiene las coordenadas gps de los pacientes
     * y agrega los marcadores al mapa
     */
    getCoordenadasPacientes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // obtenemos las coordenadas
        $.ajax({
            url: "reportes/getcoordenadas.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // recorremos el vector 
                for (let i=0; i < data.length; i++){

                    // agregamos el marcador
                    clase.agregaMarcador(data[i].coordenadas, data[i].nombre);

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} coordenadas - coordenadas gps
     * @param {string} titulo - título del marcador
     * Método que recibe como parámetro un conjunto de coordenadas
     * gps y agrega el marcador correspondiente
     */
    agregaMarcador(coordenadas, titulo){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la latitud y longitud 
        // convertimos a string y obtenemos la posición de la coma
        coordenadas = coordenadas.toString();
        let posicion = coordenadas.indexOf(',');

        // obtenemos la latitud y longitud
        let latitud = parseFloat(coordenadas.substring(1, posicion));
        let longitud = parseFloat(coordenadas.substring(posicion + 1, coordenadas.length -1));

        // definimos la clase
        let clase = this;

        // agregamos el marcador
        new google.maps.Marker({
          position: { lat: latitud, lng: longitud },
          title: titulo,
          map: clase.Map
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta el formulario con el año a informar
     * del panel de control
     */
    anioPanelControl(){

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa el formulario con los años a
     * informar del panel de control
     */
    initAnioControl(){

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} anio - el año a reportar
     * Método que recibe como parámetro el año a reportar y
     * genera el panel de control correspondiente
     */
    panelControl(anio){

    }

}
