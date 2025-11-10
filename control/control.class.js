/*

    Nombre: control.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 04/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 los datos de control y seguimiento

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
 *        de control y seguimiento
 */
class Control {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, instanciamos las variables
     */
    constructor(){

        // instanciamos las variables
        this.initControl();

        // cargamos el formulario
        $("#form_control").load("control/formcontrol.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initControl(){

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

        // iniciamos el resto de las variables
        this.Id = 0;                    // clave del registro
        this.Tratamiento = "";          // descripción del tratamiento
        this.Droga = "";                // nombre de la droga
        this.Dosis = 0;                 // dosis en miligramos
        this.Contactos = "";            // si se exploraron contactos
        this.NroContactos = 0;          // nro de contactos explorados
        this.ContactosPos = 0;          // número de contactos positivos
        this.Bloqueo = "";              // si se realizó bloqueo epidemiológico
        this.NroViviendas = 0;          // cantidad de viviendas exploradas
        this.SitiosRiesgo = "";         // si se exploraron sitios de riesgo
        this.Insecticida = "";          // nombre del insecticida utilizado
        this.CantidadInsec = 0;         // cantidad de insecticida utilizado
        this.Fecha = "";                // fecha en que se realizó el control
        this.Usuario = "";              // nombre del usuario
        this.Alta = "";                 // fecha de alta del registro

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado luego de cargar la definición del formulario
    * que lo configura
    */
    initFormControl(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los elementos
        $('#idcontrol').textbox();
        $('#fechacontrol').datebox();
        $('#tratamientocontrol').textbox();
        $('#drogacontrol').textbox();
        $('#dosiscontrol').numberspinner();
        $('#contactoscontrol').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#nrocontactoscontrol').numberspinner();
        $('#positivoscontrol').numberspinner();
        $('#bloqueocontrol').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#viviendascontrol').numberspinner();
        $('#riesgocontrol').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#insecticidacontrol').textbox();
        $('#cantidadinseccontrol').numberspinner();
        $('#usuariocontrol').textbox();
        $('#altacontrol').textbox();
        $('#btnGrabarControl').linkbutton();
        $('#btnCancelarControl').linkbutton();
        $('#btnAyudaControl').linkbutton();

        // definimos los valores
        $('#usuariocontrol').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altacontrol').textbox('setValue', fechaActual());

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} idpaciente - clave del paciente
    * Método llamado desde el formulario de datos de filiación
    * al cargar un registro que recibe la clave del paciente
    * y obtiene los datos del registro de control
    */
    getDatosControl(idpaciente){

        // asignamos en la clase
        this.Paciente = idpaciente;

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "control/getdatos.php?id="+idpaciente,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro
                clase.cargaDatosControl(data);

        }});

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {array} datos - vector con el registro
    * Método que recibe como parámetro el vector con los datos
    * del registro y los presenta en el formulario
    */
    cargaDatosControl(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos los valores en el formulario
        $('#idcontrol').textbox('setValue', datos.Id);
        $('#fechacontrol').datebox('setValue', datos.Fecha);
        $('#tratamientocontrol').textbox('setValue', datos.Tratamiento);
        $('#drogacontrol').textbox('setValue', datos.Droga);
        $('#dosiscontrol').numberspinner('setValue', datos.Dosis);
        if (datos.Contactos == "Si"){
            $('#contactoscontrol').switchbutton('check');
        } else {
            $('#contactoscontrol').switchbutton('uncheck');
        }
        $('#nrocontactoscontrol').numberspinner('setValue', datos.NroContactos);
        $('#positivoscontrol').numberspinner('setValue', datos.ContactosPos);
        if (datos.Bloqueo == "Si") {
            $('#bloqueocontrol').switchbutton('check');
        } else {
            $('#bloqueocontrol').switchbutton('uncheck');
        }
        $('#viviendascontrol').numberspinner('setValue', datos.NroViviendas);
        if (datos.SitiosRiesgo == "Si") {
            $('#riesgocontrol').switchbutton('check');
        } else {
            $('#riesgocontrol').switchbutton('uncheck');
        }
        $('#insecticidacontrol').textbox('setValue', datos.Insecticida);
        $('#cantidadinseccontrol').numberspinner('setValue', datos.CantidadInsec);
        $('#altacontrol').textbox('setValue', datos.Alta);

        // si recibió el usuario
        if (datos.Usuario == ""){
            $('#usuariocontrol').textbox('setValue', sessionStorage.getItem("Usuario"));
        } else {
            $('#usuariocontrol').textbox('setValue', datos.Usuario);
        }

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado desde el formulario de datos de filiación
    * al declarar un nuevo paciente que inicializa los valores
    * del formulario
    */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos el formulario
        $('#idcontrol').textbox('setValue', "");
        $('#fechacontrol').datebox('setValue', "");
        $('#tratamientocontrol').textbox('setValue', "");
        $('#drogacontrol').textbox('setValue', "");
        $('#dosiscontrol').numberspinner('setValue', "");
        $('#contactoscontrol').switchbutton('uncheck');
        $('#nrocontactoscontrol').numberspinner('setValue', "");
        $('#positivoscontrol').numberspinner('setValue', "");
        $('#bloqueocontrol').switchbutton('uncheck');
        $('#viviendascontrol').numberspinner('setValue', "");
        $('#riesgocontrol').switchbutton('uncheck');
        $('#insecticidacontrol').textbox('setValue', "");
        $('#cantidadinseccontrol').numberspinner('setValue', "");
        $('#usuariocontrol').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altacontrol').textbox('setValue', fechaActual());

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado al pulsar el botón grabar que verifica
    * los datos del formulario
    */
    verificaControl(){

        /**
         * Como todos los datos son optativos por ahora esta
         * rutina lo único que hace es asignar los valores
         * del formulario a las variables de clase
         */

        // verificamos que exista un paciente activo
        if (this.Paciente == 0 || this.Paciente == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe tener un paciente activo");
            return;

        }

        // asignamos en las variables de clase
        if ($('#idcontrol').textbox('getValue') == ""){
            this.Id = 0;
        } else {
            this.Id = $('#idcontrol').textbox('getValue');
        }
        this.Fecha = $('#fechacontrol').datebox('getValue');
        this.Tratamiento = $('#tratamientocontrol').textbox('getValue');
        this.Droga = $('#drogacontrol').textbox('getValue');
        this.Dosis = $('#dosiscontrol').numberspinner('getValue');
        if ($('#contactoscontrol').switchbutton('options').checked){
            this.Contactos = "Si";
        } else {
            this.Contactos = "No";
        }
        this.NroContactos = $('#nrocontactoscontrol').numberspinner('getValue');
        this.ContactosPos = $('#positivoscontrol').numberspinner('getValue');
        if ($('#bloqueocontrol').switchbutton('options').checked){
            this.Bloqueo = "Si";
        } else {
            this.Bloqueo = "No";
        }
        this.NroViviendas = $('#viviendascontrol').numberspinner('getValue');
        if ($('#riesgocontrol').switchbutton('options').checked){
            this.SitiosRiesgo = "Si";
        } else {
            this.SitiosRiesgo = "No";
        }
        this.Insecticida = $('#insecticidacontrol').textbox('getValue');
        this.CantidadInsec = $('#cantidadinseccontrol').numberspinner('getValue');

        // grabamos el registro
        this.grabaControl();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que envía los datos al servidor para su
     * actualización
     */
    grabaControl(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosControl = new FormData();

        // agregamos los elementos
        datosControl.append("Id", this.Id);
        datosControl.append("Fecha", this.Fecha);
        datosControl.append("Paciente", this.Paciente);
        datosControl.append("Tratamiento", this.Tratamiento);
        datosControl.append("Droga", this.Droga);
        datosControl.append("Dosis", this.Dosis);
        datosControl.append("Contactos", this.Contactos);
        datosControl.append("NroContactos", this.NroContactos);
        datosControl.append("ContactosPos", this.ContactosPos);
        datosControl.append("Bloqueo", this.Bloqueo);
        datosControl.append("NroViviendas", this.NroViviendas);
        datosControl.append("SitiosRiesgo", this.SitiosRiesgo);
        datosControl.append("Insecticida", this.Insecticida);
        datosControl.append("CantidadInsec", this.CantidadInsec);
        datosControl.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "control/grabar.php",
            type: "POST",
            data: datosControl,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado > 0){

                    // actualizamos en el formulario
                    $('#idcontrol').textbox('setValue', data.Resultado);

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
     * estado del formulario lo inicializa o recarga sus datos
     */
    cancelaControl(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if ($('#idcontrol').textbox('getValue') != "") {

            // recargamos
            this.getDatosControl($('#idcontrol').textbox('getValue'));

        // si está insertando
        } else {

            // limpiamos
            this.nuevoPaciente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con la página de ayuda
     * del sistema
     */
    ayudaControl(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-control'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-evolucion").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-control').window({
            title: "Ayuda en el Control del Paciente",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'control/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-control').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-control').window('center');

    }

}
