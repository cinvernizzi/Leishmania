/*

    Nombre: laboratorios.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 29/03/2021
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: CCE
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones sobre el
                 formulario de datos de los laboratorios registrados

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// definición de la clase
class Laboratorios {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initLaboratorios();

        // cargamos el formulario de datos
        this.verFormLaboratorios();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o luego de grabar
     * un registro que inicializa las variables de clase
     */
    initLaboratorios(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // inicializamos las variables
        this.Id = 0;                    // clave del registro
        this.Laboratorio = "";          // nombre del laboratorio
        this.Responsable = "";          // nombre del responsable
        this.IdPais = 0;                // clave del país
        this.CodLoc = "";               // clave indec de la localidad
        this.CodProv = "";              // código de la provincia
        this.Direccion = "";            // dirección postal del laboratorio
        this.CodigoPostal = "";         // código postal del laboratorio
        this.IdDependencia = 0;         // clave de la dependencia
        this.Mail = "";                 // dirección de correo electrónico
        this.FechaAlta = "";            // fecha de alta del laboratorio
        this.Activo = "";               // si el laboratorio está activo
        this.RecibeChagas = "";         // si participa de serología
        this.RecibePcr = "";            // si participa de pcr
        this.RecibeLeish = "";          // si participa de leishmaniasis
        this.Muestras = 0;              // número de muestras de leishmania
        this.Observaciones = "";        // observaciones y comentarios

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que carga en
     * el div central el formulario de datos
     */
    verFormLaboratorios(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el formulario
        $("#form_laboratorios").load("laboratorios/formlaboratorios.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar el formulario de datos
     * que configura los componentes
     */
    initFormLaboratorios(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los controles
        $('#idlaboratorio').textbox();
        $('#nombrelaboratorio').textbox();
        $('#responsablelaboratorio').textbox();
        $('#direccionlaboratorio').textbox();
        $('#codpostlaboratorio').textbox();

        // cargamos las dependencias
        $('#dependencialaboratorio').combobox({
            url:'dependencias/nominadependencias.php',
            valueField:'iddependencia',
            textField:'dependencia',
            limitToList: true,
            panelHeight: 200
        });

        // seguimos configurando
        $('#paislaboratorio').textbox();
        $('#provincialaboratorio').textbox();
        $('#localidadlaboratorio').textbox();
        $('#btnBuscaLocLaboratorio').linkbutton();
        $('#maillaboratorio').textbox();
        $('#activolaboratorio').combobox({
            limitToList: true,
            panelHeight: 100
        });
        $('#chagaslaboratorio').combobox({
            limitToList: true,
            panelHeight: 100
        });
        $('#pcrlaboratorio').combobox({
            limitToList: true,
            panelHeight: 100
        });
        $('#leishlaboratorio').combobox({
            limitToList: true,
            panelHeight: 110
        });
        $('#observacioneslaboratorio').texteditor();
        $('#altalaboratorio').textbox();
        $('#usuariolaboratorio').textbox();
        $('#btnGrabarLaboratorio').linkbutton();
        $('#btnCancelarLaboratorio').linkbutton();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón buscar que abre el
     * diálogo emergente pidiendo el criterio
     */
    buscaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // pedimos el texto a buscar
        $.messager.prompt({
            title: 'Buscar Laboratorios',
            msg: 'Ingrese el texto a buscar:',
            fn: function(r){
                if (r){
                    clase.encuentraLaboratorio(r);
                }
            }
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} texto - cadena a buscar
     * Método que recibe como parámetro la cadena de texto
     * a buscar y ejecuta la búsqueda en la base de datos
     */
    encuentraLaboratorio(texto){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "laboratorios/buscar.php?laboratorio="+texto,
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
     * @param {array} datos vector con los registros
     * Método llamado luego de buscar en la base que recibe
     * el vector con la nómina de registros encontrados,
     * define el layer emergente y lo presenta
     */
    grillaLaboratorios(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // asignamos el array
        let nomina = datos.slice();

        // definimos el contenido a agregar
        let grilla = "<div id='win-laboratorios'>";
            grilla += "<table id='grilla-laboratorios' style='width:100%;'>";
            grilla += "</table></div>";

        // agregamos la definición de la grilla al dom
        $("#form_laboratorios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-laboratorios').window({
            title: "Registros encontrados",
            modal:true,
            maximizable: true,
            width: 1100,
            height: 500,
            method: "post",
            closed: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-laboratorios').window('center');

        // ahora cargamos la grilla
        $('#grilla-laboratorios').datagrid({
            title: "Pulse sobre un registro para verlo",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.getClaveLaboratorio(index, field);
            },
            remoteSort: false,
            data: nomina,
            columns:[[
                {field:'idlaboratorio',title:'Id',width:50,align:'center'},
                {field:'laboratorio',title:'Laboratorio',width:400,sortable:true},
                {field:'responsable',title:'Responsable',width:250,sortable:true},
                {field:'provincia',title:'Provincia',width:150,align:'left'},
                {field:'localidad',title:'Localidad',width:150,align:'left'},
                {field:'editar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado en el evento click de la grilla que
     * recibe como parámetro la clave de la grilla y el
     * nombre del campo pulsado, si es editar, obtiene
     * la clave del registro y lo presenta
     */
    getClaveLaboratorio(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-laboratorios').datagrid('getRows')[index];

        // si pulsó sobre editar
        if (field == "editar"){

            // cargamos el registro
            this.getDatosLaboratorio(row.idlaboratorio);

            // destruimos el layer
            this.cerrarEmergente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idlaboratorio - clave del registro
     * Método que recibe como parámetro la clave de un
     * registro y obtiene los datos de la base
     */
    getDatosLaboratorio(idlaboratorio){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "laboratorios/getdatos.php?id="+idlaboratorio,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro
                clase.verDatosLaboratorio(data);

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con el registro
     * Método llamado luego de obtener el registro de un
     * laboratorio, que recibe el array con los datos del
     * mismo y los presenta en el formulario
     */
    verDatosLaboratorio(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en el formulario
        $('#idlaboratorio').textbox('setValue', datos.Id);
        $('#nombrelaboratorio').textbox('setValue', datos.Laboratorio);
        $('#responsablelaboratorio').textbox('setValue', datos.Responsable);
        $('#direccionlaboratorio').textbox('setValue', datos.Direccion);
        $('#codpostlaboratorio').textbox('setValue', datos.CodigoPostal);
        $('#dependencialaboratorio').combobox('setValue', datos.IdDependencia);
        $('#paislaboratorio').textbox('setValue', datos.Pais);
        $('#provincialaboratorio').textbox('setValue', datos.Provincia);
        $('#localidadlaboratorio').textbox('setValue', datos.Localidad);
        $('#maillaboratorio').textbox('setValue', datos.Mail);
        $('#activolaboratorio').combobox('setValue', datos.Activo);
        $('#chagaslaboratorio').combobox('setValue', datos.RecibeChagas);
        $('#pcrlaboratorio').combobox('setValue', datos.RecibePcr);

        // según las muestras de leishmania
        if (datos.RecibeLeish == "Si" && datos.Muestras == 2){

            // asignamos como entrenamiento
            $('#leishlaboratorio').combobox('setValue', "Entrenamiento");

        // si es de evaluación
        } else if (datos.RecibeLeish == "Si" && datos.Muestras == 10){

            // asignamos como evaluación
            $('#leishlaboratorio').combobox('setValue', "Evaluación");

        // de otra forma
        } else {

            // asignamos
            $('#leishlaboratorio').combobox('setValue', datos.RecibeLeish);

        }

        // continúa asignando
        $('#observacioneslaboratorio').texteditor('setValue', datos.Observaciones);
        $('#altalaboratorio').textbox('setValue', datos.FechaAlta);
        $('#usuariolaboratorio').textbox('setValue', datos.Usuario);

        // ahora asignamos en las variables de clase
        this.IdPais = datos.IdPais;
        this.CodLoc = datos.CodLoc;
        this.CodProv = datos.CodProv;

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón grabar que verifica
     * los datos del formulario antes de enviarlo
     */
    verificaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está dando un alta
        this.Id = $('#idlaboratorio').textbox('getValue');
        if (this.Id == ""){
            this.Id = 0;
        }

        // verifica el nombre
        this.Laboratorio = $('#nombrelaboratorio').textbox('getValue');
        if (this.Laboratorio == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique el nombre del laboratorio");
            return;

        }

        // verifica el responsable
        this.Responsable = $('#responsablelaboratorio').textbox('getValue');
        if (this.Responsable == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Indique el responsable del laboratorio");
            return;

        }

        // verifica la dirección y el código postal
        this.Direccion = $('#direccionlaboratorio').textbox('getValue');
        this.CodigoPostal = $('#codpostlaboratorio').textbox('getValue');
        if (this.Direccion == "" || this.CodigoPostal == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Ingrese la dirección postal completa");
            return;

        }

        // verifica la dependencia
        this.IdDependencia = $('#dependencialaboratorio').combobox('getValue');
        if (this.IdDependencia == "" || this.IdDependencia == 0){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Seleccione la dependencia");
            return;

        }

        // verifica la localidad
        if (this.CodLoc == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique la localidad del laboratorio");
            return false;

        }

        // verifica el mail
        this.Mail = $('#maillaboratorio').textbox('getValue');
        if (this.Mail == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese el Mail del laboratorio");
            return;

        // verifica que el mail sea correcto
        } else if (!echeck(this.Mail)){

            // presenta el mensaje
            Mensaje("El mail parece incorrecto");
            return;

        }

        // verifica si está activo
        this.Activo = $('#activolaboratorio').combobox('getValue');
        if (this.Activo == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique si está activo");
            return;

        }

        // verifica si participa de chagas
        this.RecibeChagas = $('#chagaslaboratorio').combobox('getValue');
        if (this.RecibeChagas == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique si participa de Serología");
            return;

        }

        // verifica si participa de pcr
        this.RecibePcr = $('#pcrlaboratorio').combobox('getValue');
        if (this.Recibe == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique si participa de PCR");
            return;

        }

        // verifica si participa de leishmania
        this.RecibeLeish = $('#leishlaboratorio').combobox('getValue');
        if (this.RecibeLeish == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique si participa de Leishmania");
            return;

        // si es evaluación
        } else if (this.RecibeLeish == "Evaluación"){

            // asignamos en la clase
            this.RecibeLeish = "Si";
            this.Muestras = 10;

        // si es de entrenamiento
        } else if (this.RecibeLeish == "Entrenamiento"){

            // asignamos en la clase
            this.RecibeLeish = "Si";
            this.Muestras = 2;

        // si no cumple ninguna de las opciones anteriores queda como que
        // no recibe muestras de leishmania
        } else {

            this.RecibeLeish = "No";
            this.Muestras = 0;

        }

        // asigna las observaciones
        this.Observaciones = $('#observacioneslaboratorio').texteditor('getValue');

        // si está dando un alta
        if (this.Id == 0){
            this.validaLaboratorio();
        } else {
            this.grabaLaboratorio();
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en el caso de un alta que verifica
     * que el laboratorio no se encuentre repetido
     */
    validaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos
        $.ajax({
            url: "laboratorios/validar.php?laboratorio="+clase.Laboratorio+"&codloc="+clase.CodLoc,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.Registros != 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese laboratorio ya está declarado");

                } else {

                    // verificamos el mail
                    clase.validaMail();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en caso de un alta que verifica que
     * el mail del laboratorio no se encuentre repetido
     */
    validaMail(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos
        $.ajax({
            url: "laboratorios/validamail.php?mail="+clase.Mail,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si hubo registros
                if (data.Registros != 0){

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese mail ya está declarado");

                } else {

                    // grabamos el registro
                    clase.grabaLaboratorio();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
    grabaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos las variables
        let datosLaboratorio = new FormData();

        // agregamos los valores
        datosLaboratorio.append("Id", this.Id);
        datosLaboratorio.append("Laboratorio", this.Laboratorio.toUpperCase());
        datosLaboratorio.append("Responsable", this.Responsable.toUpperCase());
        datosLaboratorio.append("IdPais", this.IdPais);
        datosLaboratorio.append("CodLoc", this.CodLoc);
        datosLaboratorio.append("Direccion", this.Direccion.toUpperCase());
        datosLaboratorio.append("CodigoPostal", this.CodigoPostal);
        datosLaboratorio.append("IdDependencia", this.IdDependencia);
        datosLaboratorio.append("Mail", this.Mail.toLowerCase());
        datosLaboratorio.append("Activo", this.Activo);
        datosLaboratorio.append("RecibeChagas", this.RecibeChagas);
        datosLaboratorio.append("RecibePcr", this.RecibePcr);
        datosLaboratorio.append("RecibeLeish", this.RecibeLeish);
        datosLaboratorio.append("Muestras", this.Muestras);
        datosLaboratorio.append("Observaciones", this.Observaciones);
        datosLaboratorio.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "laboratorios/grabar.php",
            type: "POST",
            data: datosLaboratorio,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío todo bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

                    // actualizamos la clave
                    $('#idlaboratorio').textbox('setValue', data.Id);

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
     * Método llamado al pulsar sobre el botón buscar
     * localidad que ejecuta la consulta de búsqueda en
     * el servidor
     */
    buscaLocalidad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos que halla ingresado un texto
        let localidad = $('#localidadlaboratorio').textbox('getValue');
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

                } else {

                    // llamamos la grilla
                    clase.grillaLocalidades(data);

                }

        }});           

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con los registros
     * Método que recibe el vector con las localidades 
     * coincidentes y abre el layer emergente con la grilla
     * de resultados
     */
    grillaLocalidades(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // asignamos el array 
        let nomina = datos.slice();
    
        // definimos el contenido a agregar
        let grilla = "<div id='win-laboratorios'>";
            grilla += "<table id='grilla-localidades' style='width:100%;'>";
            grilla += "</table></div>";

        // agregamos la definición de la grilla al dom
        $("#form_laboratorios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-laboratorios').window({
            title: "Registros encontrados",
            modal:true,
            maximizable: true,
            width: 600,
            height: 500,
            method: "post",
            closed: false,
            closable: true,            
            onClose:function(){clase.cerrarEmergente();},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-laboratorios').window('center');

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
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla de localidades
     * que obtiene los valores del registro y los asigna en 
     * las variables de clase y en el formulario de datos
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
            $('#paislaboratorio').textbox('setValue', row.pais);
            $('#provincialaboratorio').textbox('setValue', row.provincia);
            $('#localidadlaboratorio').textbox('setValue', row.localidad);

            // destruimos el layer
            this.cerrarEmergente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que limpia el formulario de datos (llamado 
     * al cancelar o también al insertar un nuevo registro)
     */
    nuevoLaboratorio(){

        // verifica el nivel de acceso
        if (!seguridad.verificaAcceso()){

            // retornamos
            return;

        // si alguna de las tres es vardadera
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

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los controles
        $('#idlaboratorio').textbox('setValue', "");
        $('#nombrelaboratorio').textbox('setValue', "");
        $('#responsablelaboratorio').textbox('setValue', "");
        $('#direccionlaboratorio').textbox('setValue', "");
        $('#codpostlaboratorio').textbox('setValue', "");
        $('#dependencialaboratorio').combobox('setValue', "");
        $('#paislaboratorio').textbox('setValue', "");
        $('#provincialaboratorio').textbox('setValue', "");
        $('#localidadlaboratorio').textbox('setValue', "");
        $('#maillaboratorio').textbox('setValue', "");
        $('#activolaboratorio').combobox('setValue', "");
        $('#chagaslaboratorio').combobox('setValue', "");
        $('#pcrlaboratorio').combobox('setValue', "");
        $('#leishlaboratorio').combobox('setValue', "");
        $('#observacioneslaboratorio').texteditor('setValue', "");
        $('#altalaboratorio').textbox('setValue', fechaActual());
        $('#usuariolaboratorio').textbox('setValue', sessionStorage.getItem("Usuario"));

        // inicializamos las variables
        this.initLaboratorios();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón cancelar que 
     * según el caso, limpia el formulario o recarga el 
     * registro actual
     */
    cancelaLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if ($('#idlaboratorio').textbox('getValue') != ""){

            // recargamos el registro
            this.getDatosLaboratorio($('#idlaboratorio').textbox('getValue'));

        // si estaba insertando
        } else {

            // limpiamos el formulario
            this.limpiaFormulario();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que según el nivel de acceso, habilita o
     * desabilita las acciones autorizadas al usuario
     */
    seguridadLaboratorio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verifica el nivel de acceso
        if (seguridad.verificaAcceso()){

            // activamos el botón grabar
            $('#btnGrabarLaboratorio').linkbutton('enable');

        // en cualquier otro caso
        } else {

            // desactivamos el botón 
            $('#btnGrabarLaboratorio').linkbutton('disable');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con la ayuda del 
     * sistema
     */
    ayudaLaboratorios(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos las variables
        let clase = this;
        
        // definimos el contenido a agregar
        let grilla = "<div id='win-laboratorios'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_laboratorios").append(grilla);

        // ahora abrimos el diálogo
        $('#win-laboratorios').window({
            title: "Ayuda Laboratorios",
            modal:true,
            maximizable: true,
            width: 1100,
            height: 700,
            method: "post",
            closed: false,
            closable: true,            
            href: "laboratorios/ayuda.html",
            onClose:function(){clase.cerrarEmergente();},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-laboratorios').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente y presenta los laboratorios
     * registrados de la jurisdicción del usuario (siempre que este 
     * sea un responsable)
     */
    reporteRegistrados(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el vector con los valores del combo
        let datosActivo = [{"valor": "Si"},
                           {"valor": "No"}];   

        // definimos la clase
        let clase = this;
 
        // definimos el contenido a agregar
        let grilla = "<div id='win-laboratorios'>";
            grilla += "<table id='grilla-registrados' style='width:100%;'>";
            grilla += "</table></div>";
 
        // agregamos la definición de la grilla al dom
        $("#form_laboratorios").append(grilla);
 
        // ahora abrimos el diálogo
        $('#win-laboratorios').window({
            title: "Laboratorios Registrados",
            modal:true,
            maximizable: true,
            width: 1300,
            height: 500,
            method: "post",
            closed: false,
            closable: true,            
            onClose:function(){clase.cerrarEmergente();},
            cache: false,
            border: 'thin'
        });
 
         // centramos el diálogo
         $('#win-laboratorios').window('center');
 
        // ahora cargamos la grilla
        $('#grilla-registrados').datagrid({
            title: "Pulse sobre un registro para verlo",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoRegistrados(index, field);
            },
            remoteSort: false,
            pagination: false,
            method: "post",
            url: "laboratorios/reporteprovincia.php?provincia="+seguridad.CodProv,
            columns:[[
                {field:'idlaboratorio',title:'Id',width:50,align:'center'},
                {field:'laboratorio',title:'Laboratorio',width:400,sortable:true},
                {field:'responsable',title:'Responsable',width:250,sortable:true},
                {field:'localidad',title:'Localidad',width:150,align:'left'},
                {field:'activo',title:'Activo',width:100,align:'center',
                        editor:{type:'combobox',
                        options:{data: datosActivo,
                                 valueField: 'valor',
                                 textField: 'valor'
                }}},
                {field:'chagas',title:'Chagas',width:100,align:'center',
                        editor:{type:'combobox',
                        options:{data: datosActivo,
                                 valueField: 'valor',
                                 textField: 'valor',
                                 panelHeight: 'auto'
                }}},
                {field:'pcr',title:'Pcr',width:100,align:'center',
                        editor:{type:'combobox',
                        options:{data: datosActivo,
                                 valueField: 'valor',
                                 textField: 'valor',
                                 panelHeight: 'auto'
                }}},
                {field:'leishmania',title:'Leish',width:100,align:'center',
                        editor:{type:'combobox',
                        options:{data: datosActivo,
                                 valueField: 'valor',
                                 textField: 'valor',
                                 panelHeight: 'auto'
                }}},
                {field:'editar',width:50,align:'center'}
            ]],
            onBeforeEdit:function(index,row){
                row.editing = true;
                $(this).datagrid('refreshRow', index);
            },
            onAfterEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            },
            onCancelEdit:function(index,row){
                row.editing = false;
                $(this).datagrid('refreshRow', index);
            }
        });          
        
    }
    
    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla de laboratorios
     * que recibe como parámetro la clave de la grilla y el 
     * nombre del campo pulsado, según este último, inicia 
     * la edición o graba el registro
     */
    eventoRegistrados(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // terminamos la edición de todas las filas
        let filas = $('#grilla-registrados').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-registrados').datagrid('endEdit', i);

        }

        // si pulsó sobre el estado
        if (field == "activo" || field == "chagas" || field == "pcr" || field == "leishmania"){

            // activamos la edición
            $('#grilla-registrados').datagrid('beginEdit', index);

        // si pulsó sobre editar
        } else if (field == "editar"){

            // verificamos y grabamos
            this.grabaEstadoLaboratorio(index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index clave de la grilla
     * Método llamado al pulsar el botón grabar en la grilla 
     * del reporte de laboratorios, que recibe como parámetro
     * la clave de la grilla y actualiza el registro en 
     * la base
     */
    grabaEstadoLaboratorio(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // terminamos la edición de todas las filas
        let filas = $('#grilla-registrados').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-registrados').datagrid('endEdit', i);

        }

        // obtenemos el registro
        let row = $('#grilla-registrados').datagrid('getRows')[index];

        // declaramos el formulario
        let datosLaboratorio = new FormData();

        // agregamos los elementos
        datosLaboratorio.append("Id", row.idlaboratorio);
        datosLaboratorio.append("Activo", row.activo);
        datosLaboratorio.append("Chagas", row.chagas);
        datosLaboratorio.append("Pcr", row.pcr);
        datosLaboratorio.append("Leishmania", row.leishmania);
        datosLaboratorio.append("Usuario", seguridad.Id);

        // grabamos el registro
        $.ajax({
            url: "laboratorios/actualizar.php",
            type: "POST",
            data: datosLaboratorio,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío todo bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro actualizado ...");

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
     * Método llamado desde el menú principal que abre el 
     * layer emergente con la nómina de laboratorios y 
     * permite filtrar por tipo de participación 
     */
    listaLaboratorios(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formlaboratorios = "<div id='win-laboratorios'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_laboratorios").append(formlaboratorios);

        // ahora abrimos el diálogo
        $('#win-laboratorios').window({
            title: "Laboratorios Participantes",
            modal:true,
            maximizable: true,
            width: 1100,
            height: 500,
            method: "post",
            href: "laboratorios/grilla.html",
            closed: false,
            closable: true,            
            onClose:function(){clase.cerrarEmergente();},
            cache: false,
            border: 'thin'
        });

        // centramos el layer
        $('#win-laboratorios').window('center');
        
    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición del 
     * layer de laboratorios que configura la grilla y 
     * carga los registros por defecto
     */
    initGrillaLaboratorios(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // configuramos la barra
        $('#checkleishmania').switchbutton({
            checked: true,
            onText: 'Si',
            offText: 'No',
            width: 60,
            onChange: function(checked){
                clase.filtraLaboratorios(checked);
            }
        });
        $('#checkserologia').switchbutton({
            checked: true,
            onText: 'Si',
            offText: 'No',
            width: 60,
            onChange: function(checked){
                clase.filtraLaboratorios(checked);
            }
        });
        $('#checkpcr').switchbutton({
            checked: true,
            onText: 'Si',
            offText: 'No',
            width: 60,
            onChange: function(checked){
                clase.filtraLaboratorios(checked);
            }
        });
        $('#textolaboratorio').textbox();
        $('#btnFiltraLaboratorios').linkbutton();

        // definimos la grilla, cargando por defecto todos los 
        // laboratorios de la jurisdicción y de todas las 
        // pruebas
        // ahora cargamos la grilla
        $('#grilla-laboratorios').datagrid({
            title: "Use la barra de herramientas para filtrar",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.getClaveLaboratorio(index, field);
            },
            url:'laboratorios/nomina.php',
            remoteSort: false,
            pagination: true,
            columns:[[
                {field:'idlaboratorio',title:'Id',width:50,align:'center'},
                {field:'laboratorio',title:'Laboratorio',width:400,sortable:true},
                {field:'responsable',title:'Responsable',width:250,sortable:true},
                {field:'provincia',title:'Provincia',width:150,align:'left'},
                {field:'localidad',title:'Localidad',width:150,align:'left'},
                {field:'activo', title:'Activo', width:50, align:'center'},
                {field:'editar',width:50,align:'center'}
            ]]
        });          

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón filtrar o alguno 
     * de los switch que obtiene los valores y recarga
     * la grilla 
     */
    filtraLaboratorios(){

        // reiniciamos la sesión 
        sesion.reiniciar();
        
        // obtenemos las variables
        let leishmania = "";
        let serologia = "";
        let pcr = "";
        if ($('#checkleishmania').switchbutton('options').checked){
            leishmania = "Si";
        } else {
            leishmania = "No";
        }
        if ($('#checkserologia').switchbutton('options').checked){
            serologia = "Si";
        } else {
            serologia = "No";
        }
        if ($('#checkpcr').switchbutton('options').checked){
            pcr = "Si";
        } else {
            pcr = "No";
        }

        // recargamos la grilla
        $('#grilla-laboratorios').datagrid('load',{
            Laboratorio: $('#textolaboratorio').val(),
            Leishmania: leishmania,
            Serologia: serologia, 
            Pcr: pcr
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón imprimir que 
     * genera la hoja de cálculo con el reporte de los 
     * laboratorios 
     */
    imprimeLaboratorios(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // cargamos el reporte xls
        window.open("laboratorios/xlslaboratorios.php");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método genérico que cierra el formulario emergente
     */
    cerrarEmergente(){

        // destruimos el layer
        $('#win-laboratorios').window('destroy');

    }

}
