/*

    Nombre: responsables.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 27/03/2021
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: CCE
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones sobre el
                 formulario de datos de responsables registrados

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// declaración de la clase
class Responsables {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initFormResponsables();

        // cargamos el formulario de responsables
        this.verFormResponsables();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initResponsables(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // inicializamos las variables
        this.Id = 0;                       // clave del registro
        this.Nombre = "";                  // nombre del responsable
        this.Usuario = "";                 // nombre de usuario para la base
        this.Institucion = "";             // nombre de la institución
        this.Cargo = "";                   // cargo que ocupa
        this.Mail = "";                    // dirección de correo
        this.Telefono = "";                // número de teléfono
        this.Pais = "";                    // nombre del país
        this.IdPais = 0;                   // clave del país
        this.Provincia = "";               // nombre de la provincia
        this.Localidad = "";               // nombre de la localidad
        this.CodProv = "";                 // clave de la provincia
        this.CodLoc = "";                  // clave indec de la localidad
        this.Direccion = "";               // dirección postal
        this.CodigoPostal = "";            // código postal
        this.Coordenadas = "";             // coordenadas gps
        this.ResponsableChagas = "";       // si es responsable de chagas
        this.ResponsableLeish = "";        // si es responsable de leishmania
        this.Laboratorio = "";             // si no es responsable nombre del laboratorio
        this.IdLaboratorio = 0;            // si no es responsable clave del laboratorio
        this.Activo = "";                  // si está activo
        this.NivelCentral = "";            // si es de nivel central
        this.Autorizo = "";                // usuario que autorizó el ingreso
        this.Observaciones = "";           // observaciones y comentarios
        this.FechaAlta = "";               // fecha de alta del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que carga en el
     * contenedor el formulario de datos
     */
    verFormResponsables(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el formulario
        $("#form_usuarios").load("responsables/formresponsables.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar el formulario de datos
     * que lo configura
     */
    initFormResponsables(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos el formulario
        $('#idresponsable').textbox();
        $('#nombreresponsable').textbox();
        $('#usuarioresponsable').textbox();
        $('#cargoresponsable').textbox();
        $('#institucionresponsable').textbox();
        $('#mailresponsable').textbox();
        $('#telefonoresponsable').textbox();
        $('#paisresponsable').textbox();
        $('#provinciaresponsable').textbox();
        $('#localidadresponsable').textbox();
        $('#btnBuscaLocResponsable').linkbutton();
        $('#direccionresponsable').textbox();
        $('#codpostresponsable').textbox();
        $('#chagasresponsable').checkbox();
        $('#leishresponsable').checkbox();
        $('#activoresponsable').checkbox();
        $('#centralresponsable').checkbox();
        $('#laboratorioresponsable').textbox();
        $('#btnBuscaLabResponsable').linkbutton();
        $('#autorizoresponsable').textbox();
        $('#altaresponsable').textbox();
        $('#btnGrabarResponsable').linkbutton();
        $('#btnCancelarResponsable').linkbutton();
        $('#observacionesresponsable').texteditor();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el cuadro de búsqueda de un responsable
     */
    buscaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // pedimos el texto a buscar
        $.messager.prompt({
            title: 'Buscar Responsables',
            msg: 'Ingrese el texto a buscar:',
            fn: function(r){
                if (r){
                    clase.encuentraResponsable(r);
                }
            }
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} texto - cadena a buscar
     * Método que ejecuta la consulta de búsqueda en el
     * servidor, recibe como parámetro la cadena de texto
     * a buscar
     */
    encuentraResponsable(texto){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "responsables/buscar.php?texto="+texto,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.length == 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "No hay registros coincidentes");

                } else {

                    // llamamos la grilla
                    clase.grillaResponsables(data);

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos vector con los registros
     * Método llamado cuando la búsqueda fue exitosa y
     * presenta la grilla con los registros encontrados
     */
    grillaResponsables(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // asignamos el array
        let nomina = datos.slice();

        // definimos el contenido a agregar
        let grilla = "<div id='win-responsables'>";
            grilla += "<table id='grilla-responsables' style='width:100%;'>";
            grilla += "</table></div>";

        // agregamos la definición de la grilla al dom
        $("#form_usuarios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-responsables').window({
            title: "Registros encontrados",
            modal:true,
            maximizable: true,
            width: 1100,
            height: 500,
            closed: false,
            closable: true,
            method: 'post',
            onClose:function(){$('#win-responsables').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-responsables').window('center');

        // ahora cargamos la grilla
        $('#grilla-responsables').datagrid({
            title: "Pulse sobre un registro para verlo",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.getIdResponsable(index, field);
            },
            remoteSort: false,
            data: nomina,
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Nombre',title:'Nombre',width:200,sortable:true},
                {field:'Institucion',title:'Institución',width:250,sortable:true},
                {field:'Cargo',title:'Cargo',width:200,align:'left'},
                {field:'Provincia',title:'Provincia',width:150,align:'left'},
                {field:'Localidad',title:'Localidad',width:150,align:'left'},
                {field:'editar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre un elemento en la
     * grilla de búsqueda que recibe como parámetro la clave
     * de la grilla y el nombre del campo pulsado
     */
    getIdResponsable(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-responsables').datagrid('getRows')[index];

        // si pulsó sobre editar
        if (field == "editar"){

            // cargamos el registro
            this.getDatosResponsable(row.Id);

            // destruimos el layer
            $('#win-responsables').window('destroy');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idresponsable - clave del registro
     * Método que recibe como parámetro la clave de un
     * registro y obtiene los datos del mismo
     */
    getDatosResponsable(idresponsable){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "responsables/getdatos.php?id="+idresponsable,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro
                clase.verDatosResponsable(data);

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con el registro
     * Método llamado al obtener los datos de un responsable
     * que recibe el array con el registro y lo presenta en
     * el formulario e datos
     */
    verDatosResponsable(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en el formulario
        $('#idresponsable').textbox('setValue', datos.Id);
        $('#nombreresponsable').textbox('setValue', datos.Nombre);
        $('#usuarioresponsable').textbox('setValue',datos.Usuario);
        $('#cargoresponsable').textbox('setValue',datos.Cargo);
        $('#institucionresponsable').textbox('setValue',datos.Institucion);
        $('#mailresponsable').textbox('setValue', datos.Mail);
        $('#telefonoresponsable').textbox('setValue', datos.Telefono);
        $('#paisresponsable').textbox('setValue', datos.Pais);
        $('#provinciaresponsable').textbox('setValue', datos.Provincia);
        $('#localidadresponsable').textbox('setValue', datos.Localidad);
        $('#direccionresponsable').textbox('setValue', datos.Direccion);
        $('#codpostresponsable').textbox('setValue', datos.CodigoPostal);
        if (datos.ResponsableChagas == "Si"){
            $('#chagasresponsable').checkbox('check');
        } else {
            $('#chagasresponsable').checkbox('uncheck');
        }
        if (datos.ResponsableLeish == "Si"){
            $('#leishresponsable').checkbox('check');
        } else {
            $('#leishresponsable').checkbox('uncheck');
        }
        if (datos.Activo == "Si"){
            $('#activoresponsable').checkbox('check');
        } else {
            $('#activoresponsable').checkbox('uncheck');
        }
        if (datos.NivelCentral == "Si"){
            $('#centralresponsable').checkbox('check');
        } else {
            $('#centralresponsable').checkbox('uncheck');
        }
        $('#laboratorioresponsable').textbox('setValue', datos.Laboratorio);
        $('#autorizoresponsable').textbox('setValue', datos.Autorizo);
        $('#altaresponsable').textbox('setValue', datos.FechaAlta);
        $('#observacionesresponsable').texteditor('setValue', datos.Observaciones);

        // asignamos en las variables de clase
        this.IdPais = datos.IdPais;
        this.CodLoc = datos.IdLocalidad;
        this.CodProv = datos.CodProv;
        this.Coordenadas = datos.Coordenadas;
        this.IdLaboratorio = datos.IdLaboratorio;

        // verifica la seguridad
        this.autorizaResponsable();

        // si es responsable de un laboratorio
        if (this.IdLaboratorio != 0){

            // cargamos el registro
            laboratorios.getDatosLaboratorio(this.IdLaboratorio);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón grabar que verifica
     * los datos del formulario antes de enviarlo al servidor
     */
    verificaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en las variables de clase
        if ($('#idresponsable').textbox('getValue') == ""){
            this.Id = 0;
        } else {
            this.Id = $('#idresponsable').textbox('getValue');
        }

        // verifica el nombre
        this.Nombre = $('#nombreresponsable').textbox('getValue');
        if (this.Nombre == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Ingrese el nombre completo");
            return;

        }

        // si es un alta verifica el usuario
        this.Usuario = $('#usuarioresponsable').textbox('getValue');
        if (this.Usuario == "" && this.Id == 0){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe indicar un nombre de usuario");
            return;

        }

        // verifica la institución
        this.Institucion = $('#institucionresponsable').textbox('getValue');
        if (this.Institucion == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Ingrese la Institución");
            return;

        }

        // verifica el cargo
        this.Cargo = $('#cargoresponsable').textbox('getValue');
        if (this.Cargo == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Ingrese el cargo del usuario");
            return;

        }

        // verifica el mail
        this.Mail = $('#mailresponsable').textbox('getValue');
        if (this.Mail == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe ingresar un mail de contacto");
            return;

        // verifica el formato del mail
        } else if (!echeck(this.Mail)){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "El formato del mail parece incorrecto");
            return;

        }

        // el teléfono lo permite en blanco
        this.Telefono = $('#telefonoresponsable').textbox('getValue');

        // país, provincia y localidad lo verificamos a través del valor
        // de codloc ya que el sistema lo asigna automáticamente
        if (this.CodLoc == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe indicar la localidad");
            return;

        }

        // verifica la dirección
        this.Direccion = $('#direccionresponsable').textbox('getValue');
        this.CodigoPostal = $('#codpostresponsable').textbox('getValue');
        if (this.Dirección == "" || this.CodigoPostal == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la Dirección Completa");
            return;

        }

        // verifica si es responsable
        let estado = $('#chagasresponsable').checkbox('options');
        if (estado.checked){
            this.ResponsableChagas = "Si";
        } else {
            this.ResponsableChagas = "No";
        }

        // verifica si es responsable leishmania
        estado = $('#leishresponsable').checkbox('options');
        if ( estado.checked){
            this.ResponsableLeish = "Si";
        } else {
            this.ResponsableLeish = "No";
        }

        // verifica si está activo
        estado = $('#activoresponsable').checkbox('options');
        if ( estado.checked){
            this.Activo = "Si";
        } else {
            this.Activo = "No";
        }

        // verifica el nivel central
        estado = $('#centralresponsable').checkbox('options');
        if (estado.checked){
            this.NivelCentral = "Si";
        } else {
            this.NivelCentral = "No";
        }

        // las observaciones las permite en blanco
        this.Observaciones = $('#observacionesresponsable').texteditor('getValue');

        // ahora verificamos que halla seleccionado un laboratorio
        // si no es responsable y no es de nivel central
        if (this.ResponsableChagas == "No" &&
            this.ResponsableLeish == "No" &&
            this.IdLaboratorio == 0 &&
            this.NivelCentral == "No"){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Debe indicar un laboratorio");
            return;

        }

        // si está dando un alta
        if (this.Id == 0){

            // verifica el nombre de usuario
            this.validaResponsable();

        // si está editando
        } else {

            // grabamos directamente
            this.grabaResponsable();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en caso de alta que verifica que el
     * nombre de usuario no se encuentre repetido
     */
    validaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "responsables/validar.php?usuario="+this.Usuario,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.Registros != 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese nombre de usuario ya está en uso");

                // si no hay registros
                } else {

                    // verificamos el mail
                    clase.validaMail();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en caso de un alta que verifica que
     * la dirección de mail no se encuentre repetida
     */
    validaMail(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "responsables/validarmail.php?mail="+this.Mail,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.Registros != 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese E-Mail ya está en uso");

                // si no hay registros
                } else {

                    // grabamos el registro
                    clase.grabaResponsable();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en
     * la base
     */
    grabaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos las variables
        let datosResponsable = new FormData();
        let clase = this;

        // asignamos en la clase
        datosResponsable.append("Id", this.Id);
        datosResponsable.append("Nombre", this.Nombre.toUpperCase());
        datosResponsable.append("Usuario", this.Usuario);
        datosResponsable.append("Institucion", this.Institucion.toUpperCase());
        datosResponsable.append("Cargo", this.Cargo.toUpperCase());
        datosResponsable.append("Mail", this.Mail.toLowerCase());
        datosResponsable.append("Telefono", this.Telefono);
        datosResponsable.append("IdPais", this.IdPais);
        datosResponsable.append("CodLoc", this.CodLoc);
        datosResponsable.append("Direccion", this.Direccion.toUpperCase());
        datosResponsable.append("CodigoPostal", this.CodigoPostal);
        datosResponsable.append("RespChagas", this.ResponsableChagas);
        datosResponsable.append("RespLeish", this.ResponsableLeish);
        datosResponsable.append("IdLaboratorio", this.IdLaboratorio);
        datosResponsable.append("Activo", this.Activo);
        datosResponsable.append("NivelCentral", this.NivelCentral);
        datosResponsable.append("Autorizo", seguridad.Id);
        datosResponsable.append("Observaciones", this.Observaciones);

        // grabamos el registro
        $.ajax({
            url: "responsables/grabar.php",
            type: "POST",
            data: datosResponsable,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

                    // si está dando un alta
                    if (clase.Id == 0){

                        // actualizamos la clave
                        $('#idresponsable').textbox('setValue', data.Id);

                        // enviamos el mensaje de bienvenida
                        clase.bienvenidaResponsable(data.Password);

                    }

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
     * @param {string} password la nueva contraseña de acceso
     * Método llamado en caso de un alta que envía al
     * usuario un mail de bienvenida con los datos de
     * conexión
     */
    bienvenidaResponsable(password){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        var clase = this;

        // enviamos el correo
        $.ajax({
            url: "responsables/enviamail.php?mail="+clase.Mail+"&usuario="+clase.Usuario+"&password="+password,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si pudo enviar
                if (data.Resultado == null){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Se ha enviado la bienvenida a " + clase.Mail);

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ocurrió un error al enviar el correo");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que limpia el formulario de datos y permite
     * el alta de un nuevo responsable
     */
    nuevoResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verifica el nivel de acceso
        if (!seguridad.verificaAcceso()){

            // retornamos
            return;

        // si está autorizado
        } else {

            // limpiamos el formulario
            this.limpiaFormulario();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón cancelar que recarga
     * el registro o limpia el formulario según el caso
     */
    cancelaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if ($('#idresponsable').textbox('getValue') != ""){

            // recargamos el registro
            this.getDatosResponsable($('#idresponsable').textbox('getValue'));

        // si estaba dando un alta
        } else {

            // limpiamos el formulario
            this.limpiaFormulario();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que limpia el formulario de datos
     */
    limpiaFormulario(){

        // reiniciamos la sesion
        sesion.reiniciar();

        // limpiamos el formulario
        $('#idresponsable').textbox('setValue', "");
        $('#nombreresponsable').textbox('setValue', "");
        $('#usuarioresponsable').textbox('setValue', "");
        $('#cargoresponsable').textbox('setValue', "");
        $('#institucionresponsable').textbox('setValue', "");
        $('#mailresponsable').textbox('setValue', "");
        $('#telefonoresponsable').textbox('setValue', "");
        $('#paisresponsable').textbox('setValue', "");
        $('#provinciaresponsable').textbox('setValue', "");
        $('#localidadresponsable').textbox('setValue', "");
        $('#direccionresponsable').textbox('setValue', "");
        $('#codpostresponsable').textbox('setValue', "");
        $('#chagasresponsable').checkbox('uncheck');
        $('#leishresponsable').checkbox('uncheck');
        $('#activoresponsable').checkbox('uncheck');
        $('#centralresponsable').checkbox('uncheck');
        $('#laboratorioresponsable').textbox('setValue', "");
        $('#autorizoresponsable').textbox('setValue', seguridad.Usuario);
        $('#altaresponsable').textbox('setValue', fechaActual());
        $('#observacionesresponsable').texteditor('setValue', "");

        // si no es de nivel central desactivamos el check
        if (seguridad.NivelCentral == "No"){
            $('#chagasresponsable').checkbox('disable');
            $('#centralresponsable').checkbox('disable');
            $('#leishresponsable').checkbox('disable');
        } else {
            $('#chagasresponsable').checkbox('enable');
            $('#centralresponsable').checkbox('enable');
            $('#leishresponsable').checkbox('enable');
        }

        // si es de nivel central o referente
        if (seguridad.NivelCentral == "Si" ||
            seguridad.ResponsableChagas == "Si" ||
            seguridad.ResponsableLeish == "Si"){

            // activamos el botón grabar
            $('#btnGrabarResponsable').linkbutton('enable');

        }

        // iniciamos las variables de clase
        this.initResponsables();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar sobre el botón busca localidad
     * verifica se halla ingresado un texto y luego llama
     * el layer con la selección de localidades
     */
    buscaLocalidad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos que halla ingresado un texto
        let localidad = $('#localidadresponsable').textbox('getValue');
        if ( localidad == ""){

            // presenta el mensaje y retorna
            Mensaje("Ingrese parte del nombre de la localidad");
            return;

        }

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "localidades/buscar.php?localidad="+localidad,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.length == 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "No hay registros coincidentes");

                // si no encontró
                } else {

                    // llamamos la grilla
                    clase.grillaLocalidades(data);

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos vector con los registros
     * Método llamado desde la búsqueda de localidades que
     * recibe como parámetro el vector con los registros
     * coincidentes y los presenta en la grilla
     */
    grillaLocalidades(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // asignamos el array
        let nomina = datos.slice();

        // definimos el contenido a agregar
        let grilla = "<div id='win-responsables'>";
            grilla += "<table id='grilla-localidades' style='width:100%;'>";
            grilla += "</table></div>";

        // agregamos la definición de la grilla al dom
        $("#form_usuarios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-responsables').window({
            title: "Registros encontrados",
            modal:true,
            maximizable: true,
            width: 600,
            height: 500,
            closed: false,
            closable: true,
            method: 'post',
            onClose:function(){$('#win-responsables').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-responsables').window('center');

        // ahora cargamos la grilla
        $('#grilla-localidades').datagrid({
            title: "Pulse sobre un registro para seleccionarlo",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaLocalidades(index, field);
            },
            remoteSort: false,
            data: nomina,
            columns:[[
                {field:'codloc', hidden:true},
                {field:'pais', title:'País', width:150,sortable:true},
                {field:'idpais', hidden:true},
                {field:'provincia',title:'Provincia',width:170},
                {field:'localidad',title:'Localidad',width:170},
                {field:'editar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo
     * Método llamado al pulsar sobre la grilla de localidades
     * que recibe como parámetro la clave de la grilla y el
     * nombre del campo pulsado, obtiene los valores y los
     * asigna en la clase y en el formulario
     */
    eventoGrillaLocalidades(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-localidades').datagrid('getRows')[index];

        // si pulsó sobre editar
        if (field == "editar"){

            // asignamos en la clase
            this.IdPais = row.idpais;
            this.CodLoc = row.codloc;

            // mostramos en el formulario
            $('#paisresponsable').textbox('setValue', row.pais);
            $('#provinciaresponsable').textbox('setValue', row.provincia);
            $('#localidadresponsable').textbox('setValue', row.localidad);

            // destruimos el layer
            $('#win-responsables').window('destroy');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón buscar laboratorio
     * que verifica se halla ingresado un texto y luego
     * abre el layer con la selección de laboratorios
     */
    buscaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos que halla ingresado un texto
        let laboratorio = $('#laboratorioresponsable').textbox('getValue');
        if ( laboratorio == ""){

            // presenta el mensaje y retorna
            Mensaje("Ingrese parte del nombre del laboratorio");
            return;

        }

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "laboratorios/buscar.php?laboratorio="+laboratorio,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.length == 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "No hay registros coincidentes");

                } else {

                    // llamamos la grilla
                    clase.grillaLaboratorios(data);

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con los registros
     * Método llamado desde la búsqueda de laboratorios que
     * recibe el vector con los registros coindicentes y
     * los presenta en la grilla
     */
    grillaLaboratorios(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // asignamos el array
        let nomina = datos.slice();

        // definimos el contenido a agregar
        let grilla = "<div id='win-responsables'>";
            grilla += "<table id='grilla-laboratorios' style='width:100%;'>";
            grilla += "</table></div>";

        // agregamos la definición de la grilla al dom
        $("#form_usuarios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-responsables').window({
            title: "Registros encontrados",
            modal:true,
            maximizable: true,
            width: 750,
            height: 500,
            closed: false,
            closable: true,
            method: 'post',
            onClose:function(){$('#win-responsables').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-responsables').window('center');

        // ahora cargamos la grilla
        $('#grilla-laboratorios').datagrid({
            title: "Pulse sobre un registro para seleccionarlo",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaLaboratorios(index, field);
            },
            remoteSort: false,
            data: nomina,
            columns:[[
                {field:'idlaboratorio', hidden:true},
                {field:'laboratorio', title:'Laboratorio', width:350,sortable:true},
                {field:'provincia',title:'Provincia',width:160},
                {field:'localidad',title:'Localidad',width:160},
                {field:'editar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado desde la grilla de laboratorios que
     * recibe como parámetro la clave de la grilla y el
     * nombre del campo pulsado, asigna los valores en el
     * formulario y la clase
     */
    eventoGrillaLaboratorios(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-laboratorios').datagrid('getRows')[index];

        // si pulsó sobre editar
        if (field == "editar"){

            // asignamos en la clase
            this.IdLaboratorio = row.idlaboratorio;

            // mostramos en el formulario
            $('#laboratorioresponsable').textbox('setValue', row.laboratorio);

            // destruimos el layer
            $('#win-responsables').window('destroy');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar un registro que verifica
     * el nivel de acceso y si el usuario puede grabar los
     * cambios
     */
    autorizaResponsable(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si es administrador o está editando su registro
        if (sessionStorage.getItem("Administrador") == "Si" ||
            $('#idresponsable').textbox('getValue') == sessionStorage.getItem("IdUsuario")){

            // activamos el botón grabar
            $('#btnGrabarResponsable').linkbutton('enable');

        // en cualquier otro caso
        } else {

            // desactivamos el botón
            $('#btnGrabarResponsable').linkbutton('disable');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el diálogo emergente pidiendo el
     * nuevo password
     */
    cambiaPassword(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // creamos el div
        $("#form_usuarios").append("<div id='win-responsables'></div>");

        // definimos el diálogo y lo mostramos
        $('#win-responsables').window({
            width:400,
            height:290,
            modal:true,
            title: "Nuevo Password",
            minimizable: false,
            closable: true,
            href: 'responsables/password.html',
            onClose:function(){$('#win-responsables').window('destroy');},
            method: 'post',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-responsables').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar el formulario de cambio de
     * contraseña que configura los eventos del mismo
     */
    initFormPassword(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los elementos del formulario
        $('#passwordactual').textbox();
        $('#passwordnuevo').textbox();
        $('#passwordverifica').textbox();
        $('#btnNuevoPassword').linkbutton();
        $('#btnCancelaPassword').linkbutton();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que verifica el formulario de cambio de
     * contraseña antes de enviarlo al servidor
     */
    nuevoPassword(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si indicó el password actual
        if ($('#passwordactual').textbox('getValue') == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Debe ingresar su contraseña");
            return;

        }

        // verificamos si ingresó el nuevo password
        if ($('#passwordnuevo').textbox('getValue') == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese el nuevo password");
            return;

        }

        // verificamos si coincide
        if ($('#passwordnuevo').textbox('getValue') != $('#passwordverifica').textbox('getValue')){

            // presenta el mensaje
            Mensaje("Error", "Atención", "La contraseña y la verificación<br>no coinciden");
            return;

        }

        // verificamos si el password actual coincide
        this.validaPassword();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que verifica que en el cambio de contraseña
     * el password actual coincida con el declarado en
     * la base, en caso de coincidir actualiza
     */
    validaPassword(){

        // reiniciamos la sesion
        sesion.reiniciar();

        // declaramos la clase
        var clase = this;

        // obtenemos el password actual
        var passwordactual = $('#passwordactual').textbox('getValue');

        // validamos que sea correcto
        $.ajax({
            url: "responsables/validapassword.php?idusuario="+sessionStorage.getItem("IdUsuario")+"&password="+passwordactual,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si coincide
                if (data.Resultado != 0){

                    // asignamos en la sesión
                    clase.grabaPassword();

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "El password actual no coincide");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que actualiza el password de ingreso
     */
    grabaPassword(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos el usuario y el nuevo pass
        var password = $('#passwordnuevo').textbox('getValue');

        // actualizamos el password
        $.ajax({
            url: "responsables/grabapassword.php?idusuario="+sessionStorage.getItem("IdUsuario")+"&password="+password,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si pudo grabar
                if (data.Resultado == 1){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Contraseña actualizada");

                    // cierra el diálogo
                    $('#win-responsables').window('destroy');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta la ayuda del sistema
     */
    ayudaResponsables(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let grilla = "<div id='win-responsables'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_usuarios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-responsables').window({
            title: "Ayuda Usuarios",
            modal:true,
            maximizable: true,
            width: 1100,
            height: 700,
            closed: false,
            closable: true,
            href: "responsables/ayuda.html",
            method: 'post',
            onClose:function(){$('#win-responsables').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-responsables').window('center');

    }

}
