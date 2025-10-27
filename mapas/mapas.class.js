/*

    Nombre: mapas.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 05/05/2022
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Diagnóstico
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla la presentación de los 
                 mapas

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Clase que controla la presentación de los mapas
 */
 class Mapas {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initMapa();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initMapa(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // inicializamos las variables
        this.Latitud = "";                  // latitud 
        this.Longitud = "";                 // longitud
        this.Titulo = "";                   // título del marcador
        this.Tipo = "";                     // tipo de mapa (adulto o congénito)
        this.Map = "";                      // objeto mapa

    }

    // métodos de asignación de valores
    setLatitud(latitud){
        this.Latitud = parseFloat(latitud);
    }
    setLongitud(longitud){
        this.Longitud = parseFloat(longitud);
    }
    setTitulo(titulo){
        this.Titulo = titulo;
    }
    setTipo(tipo){
        this.Tipo = tipo;
    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que a partir de las variables de clase 
     * presenta el mapa
     */
    verMapa(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // mostramos el mapa
        this.Map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: clase.Latitud, lng: clase.Longitud },
                    zoom: 12
        });
        
        // agregamos el marcador
        this.addMarker(this.Latitud, this.Longitud, this.Titulo);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} codloc - clave indec de la provincia
     * Método que a partir de la clave de la localidad
     * obtiene la nómina de laboratorios de esa localidad
     * y agrega los marcadores en el mapa
     */
    nominaLaboratorios(codloc){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase y las variables
        let clase = this;
        let latitud;
        let longitud;
        let posicion;

        // obtenemos el vector
        $.ajax({
            url: "laboratorios/nominalocalidad.php?codloc="+codloc,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.length != 0){

                    // recorremos el vector
                    for(let i=0; i < data.length; i++){

                        // obtenemos la posición de la coma
                        posicion = data[i].coordenadas.indexOf(',');
            
                        // obtenemos la latitud y longitud
                        latitud = data[i].coordenadas.substring(1, posicion);
                        longitud = data[i].coordenadas.substring(posicion + 1, data[i].coordenadas.length -1); 
                        
                        // agregamos el marcador
                        clase.addMarker(latitud, longitud, data[i].laboratorio);
            
                    }
            
                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} latitud 
     * @param {string} longitud
     * @param {titulo} titulo - texto a presentar
     * Método que recibe como parámetro las coordenadas y 
     * el título de un marcador y lo agrega al mapa
     */
    addMarker(latitud, longitud, titulo) {

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // agregamos el marcador
        new google.maps.Marker({
          position: { lat: latitud, lng: longitud },
          title: titulo,
          map: clase.Map,
        });

    }

}
