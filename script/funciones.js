/*
 * Nombre: funciones.js
 * Autor: Lic. Claudio Invernizzi
 * Fecha: 01/01/2014
 * Licencia: GPL
 * E-Mail: cinvernizzi@dsgestion.site
 * Comentarios: serie de funciones utilizadas por varias rutinas del sitio
 *
 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {string} str - correo a verificar
 * @return {boolean} - resultado de la verificación
 * función que recibe como parámetro una cadena de texto y retorna correcto o
 * falso si es una dirección de mail correcta
 */
function echeck(str) {

    // definimos la expresión regular
    let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    // retornamos
    return emailRegex.test(str);

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {string} cadena - cadena en formato dd/mm/YYYY
 * @return {date} - objeto fecha javascript
 * función que recibe una cadena del objeto input fecha en formato dd/mm/YYY
 * y retorna el objeto fecha
 */
function stringToDate(cadena) {

    // declaración de variables
    let dia = cadena.substring(0, 2);
    let mes = cadena.substring(3, 5);
    let anio = cadena.substring(6, 10);

    // compone la nueva fecha
    cadena = anio + "," + mes + "," + dia;

    // retorna el objeto
    return new Date(cadena);

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {date} fecha - fecha en formato javascript
 * @return {string] cadena - cadena en formato MySQL
 * función que recibe un objeto fecha y retorna una cadena
 * con la fecha en formato mysql YYYY/mm/dd
 */
function dateToString(fecha) {

    // inicialización de variables
    let mes = (fecha.getMonth() + 1).toString();
    let dia = fecha.getDate().toString();

    // convierte
    if(mes.length === 1) {
        mes = "0" + mes;
    }
    if(dia.length === 1) {
        dia = "0" + dia;
    }

    // retorna la cadena
    return fecha.getFullYear() + "-" + mes + "-" + dia;

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {date} fecha - objeto fecha javascript
 * @return {string} - cadena en formato dd/mm/YYYY
 * funcion que recibe un objeto fecha y retorna una cadena
 * con la fecha en formato español
 */
function dateToFecha(fecha){

    // inicialización de variables
    let mes = (fecha.getMonth() + 1).toString();
    let dia = fecha.getDate().toString();

    // convierte
    if(mes.length === 1) {
        mes = "0" + mes;
    }
    if(dia.length === 1) {
        dia = "0" + dia;
    }

    // retorna la cadena
    return dia + "/" + mes + "/" + fecha.getFullYear();

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {date} fecha - objeto fecha javascript
 * @param {date} fecha2 - objeto fecha javascript
 * @return {boolean} - resultado de la comparación
 * función que recibe como dato dos objetos fecha, devuelve
 * verdadero si la segunda fecha es mayor que la primera
 * o si ambas fechas son iguales
 */
function Fecha_Mayor(fecha, fecha2){

    // inicializa la variable de retorno
    let resultado = false;

    // si el segundo año es mayor
    if (fecha2.getFullYear() > fecha.getFullYear()) {

        // retorna verdadero
        resultado = true;

    // si son iguales
    } else if (fecha2.getFullYear() === fecha.getFullYear()) {

        // verifica el mes
        if (fecha2.getMonth() > fecha.getMonth()){

            // retorna verdadero
            resultado = true;

        // si son iguales
        } else if (fecha2.getMonth() === fecha.getMonth()) {

            // verifica el día
            if (fecha2.getDate() > fecha.getDate()){

                // retorna verdadero
                resultado = true;

            }

        }

    }

    // retorna la variable control
    return resultado;

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {date} inicial - objeto fecha javascript
 * @param {date} final - objeto fecha javascript
 * @return {int} - días transcurridos
 * función que recibe dos fechas en formado dd/mm/YYYY y calcula
 * los dias transcurridos entre la primera (inicial) y la
 * segunda (final)
 */
function FechaDiff(inicial,final){

    // calcula la diferencia y los dias transcurridos
    let dif = final - inicial;
    return Math.floor(dif / (1000 * 60 * 60 * 24));

}

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @return {string} - fecha en formato dd/mm/YYYY
 * función que retorna la fecha actual en formato dd/mm/YYYY
 */
function fechaActual(){

    // obtenemos la fecha del sistema
    let ahora = new Date();
    let dia; 
    let mes;

    // si el día es de un solo dígito
    if (ahora.getDate() < 10){
        dia = "0" +  ahora.getDate();
    } else {
        dia = ahora.getDate();
    }

    // si el mes es de un solo dígito
    if (ahora.getMonth() + 1 < 10){
        mes = "0" + (ahora.getMonth() + 1);
    } else {
        mes = ahora.getMonth() + 1;
    }

    // retornamos la cadena
    return (dia + "/" + mes + "/" + ahora.getFullYear());

}

/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {string} fecha - una cadena en formato dd/mm/YYYY
 * @return {string} dia - una cadena con el día de la semana
 * Método que recibe como parámetro una cadena en formato
 * español, crea el objeto fecha de javascript y retorna
 * el día de la semana que corresponde
 */
function diaSemana(fecha){

    // declaración de variables
    let dias = new Array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');

    // convertimos a formato fecha de javascript
    fecha = stringToDate(fecha);

    // obtenemos el día
    return dias[fecha.getDay()];

}


/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * Método que extiende el datebox con el formato
 * castellano, tomado del foro de jquery easyui
 */
$.extend($.fn.datebox.defaults,{
    formatter:function(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
    },
    parser:function(s){
        if (!s) return new Date();
        var ss = s.split('/');
        var d = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var y = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }
});

/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @param {string} tipo - tipo de mensaje
 * @param {string} titulo - título de la ventana
 * @param {string} mensaje - mensaje a presentar
 * Función que recibe como parámetro el título de un
 * diálogo emergente, el texto a mostrar y el tipo 
 * de mensaje (que modifica el fondo de color)
 */
function Mensaje(tipo, titulo, mensaje){

    // si el tipo fue error 
    if (tipo == "Error"){
        mensaje = '<div class="messager-icon messager-error"></div><div>' + mensaje + '</div>';
    } else {
        mensaje = '<div class="messager-icon messager-info"></div><div>' + mensaje + '</div>';
    }

    // presentamos el mensaje
    $.messager.show({
        title: titulo,
        msg: mensaje,
        showType:'slide',
        border: 'thin',
        timeout:3000,
        modal: false,
        closable: false,
        width: 350,
        height: 120,
        style:{
            left:'',
            right:0,
            top:document.body.scrollTop+document.documentElement.scrollTop,
            bottom:''
        }
    });    

}

/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * Método que abre en una nueva pestaña el foro de 
 * discusión
 */
function verForo(){

    // abrimos la pestaña
    window.open('http://fatalachaben.mooo.com/foro', '_blank');

}

/**
 * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * Método que abre en una nueva pestaña la wiki de 
 * control de calidad
 */
function verWiki(){

    // abrimos la pestaña
    window.open('http://fatalachaben.mooo.com/wikicce', '_blank');

}