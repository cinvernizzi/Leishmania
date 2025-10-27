/*

    Nombre: evolucion.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 04/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 la evolución del paciente

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
 *        de evolución del paciente
 */
class Evolucion {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, cargamos la definición del 
     * formulario e inicializamos las variables
     */
    constructor(){

        // inicializamos las variables
        this.initEvolucion();

        // cargamos la definición del formulario
        $("#form_evolucion").load("evolucion/formevolucion.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Inicializamos las variables de clase
     */
    initEvolucion(){

        // verificamos si está editando porque esta rutina
        // la llamamos también luego de grabar o borrar
        // verificando si el elemento está definido porque
        // también lo llamamos desde el constructor
        if ($('#idpaciente').length == 0){
            this.Paciente = 0;
        // si está definido
        } else {
            this.Paciente = $('#idpaciente').textbox('getValue') == "" ? 0 : $('#idpaciente').textbox('getValue');
        }

        // configuramos el resto de las variables
        this.Id = 0;                // clave del registro
        this.Hospitalizacion = "";  // fecha de la hospitalización 
        this.FechaAlta = "";        // fecha de alta del hospital
        this.Defuncion = "";        // fecha de defunción 
        this.Condicion = "";        // condición del alta
        this.Clasificacion = "";    // clasificación final del caso
        this.Usuario = "";          // nombre del usuario
        this.Alta = "";             // fecha de alta

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar el formulario de datos que 
     * configura el mismo
     */
    initFormEvolucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos el formulario
        $('#idevolucion').textbox();        
        $('#hospitalizacionevolucion').datebox({
            width: "120px"
        });
        $('#fechaaltaevolucion').datebox({
            width: "120px"
        });
        $('#defuncionevolucion').datebox({
            width: "120px"
        });
        $('#condicionevolucion').textbox();        
        $('#clasificacionevolucion').textbox();        
        $('#usuarioevolucion').textbox();        
        $('#altaevolucion').textbox();        
        $('#btnGrabarEvolucion').linkbutton();
        $('#btnCancelarEvolucion').linkbutton();
        $('#btnAyudaEvolucion').linkbutton();

        // definimos los valores
        $('#usuarioevolucion').textbox('setValue', sessionStorage.getItem("Usuario"));        
        $('#altaevolucion').textbox('setValue', fechaActual());        

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idpaciente - clave del paciente
     * Método que recibe como parámetro la clave de un registro 
     * normalmente llamado desde el formulario de datos de 
     * filiación del paciente, que obtiene los datos del 
     * registro
     */
    getDatosEvolucion(idpaciente){

        // asignamos en la clase
        this.Paciente = idpaciente;

        // reiniciamos la sesión 
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro 
        $.ajax({
            url: "evolucion/getdatos.php?id="+idpaciente,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Id != 0){

                    // mostramos el registro
                    clase.cargaDatosEvolucion(data);

                // de otra forma
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @autor Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} vector con el registro
     * Método llamado luego de obtener los datos del registro
     * que presenta los mismos en el formulario
     */
    cargaDatosEvolucion(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en el formulario 
        $('#idevolucion').textbox('setValue', datos.Id);
        $('#hospitalizacionevolucion').datebox('setValue', datos.Hospitalizacion);
        $('#fechaaltaevolucion').datebox('setValue', datos.FechaAlta);
        $('#defuncionevolucion').datebox('setValue', datos.Defuncion);
        $('#condicionevolucion').textbox('setValue', datos.Condicion);
        $('#clasificacionevolucion').textbox('setValue', datos.Clasificacion);
        $('#usuarioevolucion').textbox('setValue', datos.Usuario);
        $('#altaevolucion').textbox('setValue', datos.Alta);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el formulario de datos de filiación
     * que limpia el formulario para el alta de un nuevo
     * registro
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en el formulario
        $('#idevolucion').textbox('setValue', "");
        $('#hospitalizacionevolucion').datebox('setValue', "");
        $('#fechaaltaevolucion').datebox('setValue', "");
        $('#defuncionevolucion').datebox('setValue', "");
        $('#condicionevolucion').textbox('setValue', "");
        $('#clasificacionevolucion').textbox('setValue', "");
        $('#usuarioevolucion').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altaevolucion').textbox('setValue', fechaActual());

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al grabar el formulario que verifica los
     * datos del mismo antes de enviarlo al servidor
     */
    verificaEvolucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        /**
         * Por ahora permitimos que todos los campos estén en blanco
         * pero si en un futuro se deciden algunos obligatorios
         * se verificarán aquí
         */

        // verificamos que exista un paciente activo
        if (this.Paciente == 0 || this.Paciente == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe tener un paciente activo");
            return;
        }

        // asignamos en la clase
        this.Id = $('#idevolucion').textbox('getValue');
        this.Hospitalizacion = $('#hospitalizacionevolucion').datebox('getValue');
        this.FechaAlta = $('#fechaaltaevolucion').datebox('getValue');
        this.Defuncion = $('#defuncionevolucion').datebox('getValue');
        this.Condicion = $('#condicionevolucion').textbox('getValue');
        this.Clasificacion = $('#clasificacionevolucion').textbox('getValue');

        // grabamos el registro
        this.grabaEvolucion();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en el
     * servidor
     */
    grabaEvolucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos las variables
        let datosEvolucion = new FormData();

        // agregamos los parámetros
        datosEvolucion.append("Id", this.Id);
        datosEvolucion.append("Paciente", this.Paciente);
        datosEvolucion.append("Hospitalizacion", this.Hospitalizacion);
        datosEvolucion.append("FechaAlta", this.FechaAlta);
        datosEvolucion.append("Defuncion", this.Defuncion);
        datosEvolucion.append("Condicion", this.Condicion);
        datosEvolucion.append("Clasificacion", this.Clasificacion);
        datosEvolucion.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "evolucion/grabar.php",
            type: "POST",
            data: datosEvolucion,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // actualizamos en el formulario 
                    $('#idevolucion').textbox('setValue', data.Resultado);

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

                // si hubo algún error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

            }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón cancelar que según el
     * caso, recarga el registro o inicializa el formulario
     */
    cancelaEvolucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if ($('#idevolucion').textbox('getValue') != 0) {

            // recargamos
            this.getDatosEvolucion($('#idevolucion').textbox('getValue') != 0);

        // si está insertando
        } else {

            // limpiamos
            this.nuevoPaciente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con la ayuda del
     * sistema
     */
    ayudaEvolucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-evolucion'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-evolucion").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-evolucion').window({
            title: "Ayuda en la Evolución del Paciente",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'evolucion/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-evolucion').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-evolucion').window('center');

    }

}
