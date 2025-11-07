/*

    Nombre: instituciones.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 01/02/2022
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Diagnóstico
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 instituciones asistenciales

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
 *        de instituciones asistenciales
 */
class Instituciones {

    // constructor de la clase
    constructor(){

        // mostramos el formulario e inicializamos las variables
        this.verFormInstituciones();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initInstituciones(){

        // inicializamos las variables
        this.Id = 0;                  // clave del registro
        this.Nombre = "";             // nombre de la institución
        this.Siisa = "";              // clave del siisa
        this.CodLoc = "";             // clave indec de la localidad
        this.Localidad = "";          // nombre de la localidad
        this.Provincia = "";          // nombre de la provincia
        this.Pais = "";               // nombre del país
        this.Direccion = "";          // dirección postal de la institución
        this.CodPostal = "";          // código postal de la dirección
        this.Telefono = "";           // teléfono con prefijo de área
        this.Mail = "";               // dirección de correo
        this.Responsable = "";        // nombre del responsable
        this.Usuario = "";            // nombre del usuario
        this.Fecha = "";              // fecha de alta del registro
        this.IdDependencia = 0;       // clave de la dependencia
        this.Comentarios = "";        // comentarios del usuario
        this.Coordenadas = "";        // coordenadas gps

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga el formulario de instituciones
     */
    verFormInstituciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // inicializamos
        this.initInstituciones();

        // carga la grilla de instituciones
        $("#form_instituciones").load("instituciones/forminstituciones.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción nueva institución
     */
    nuevaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verifica los permisos
        if(!seguridad.verificaAcceso()){
            return;
        }

        // cargamos el formulario e inicializamos las variables
        this.verFormInstituciones();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al buscar una institución que pide
     * el texto a buscar
     */
    buscaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // pedimos el texto a buscar
        $.messager.prompt({
            title: 'Buscar Instituciones',
            msg: 'Ingrese el texto a buscar:',
            fn: function(r){
                if (r){
                    clase.encuentraInstitucion(r);
                }
            }
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} texto - texto a buscar
     * Método que recibe el texto a buscar y ejecuta
     * la consulta
     */
    encuentraInstitucion(texto){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // ejecutamos la consulta
        $.ajax({
            url: "instituciones/buscainstitucion.php?institucion="+texto,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // llamamos la grilla
                clase.institucionesEncontradas(data);

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con los registros
     * Método que recibe el vector con las instituciones
     * encontradas y las asigna a las variables de clase
     */
    institucionesEncontradas(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si no encontró registros
        if (datos.length == 0){

            // presenta el mensaje
            Mensaje("Error", "Atención", "No se han encontrado registros");
            return;

        }

        // copiamos la matriz
        this.Encontrados = datos.slice();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-instituciones'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_instituciones").append(formulario);

        // cargamos la grilla
        $('#win-instituciones').window({
            width:900,
            height:400,
            modal:true,
            title: "Registros Coincidentes",
            minimizable: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            href: 'instituciones/grillainstituciones.html',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-instituciones').window('center');

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que configura la grilla con las instituciones
    * encontradas
    */
   initGrillaInstituciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-instituciones').datagrid({
            title: "Instituciones encontradas",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaInstituciones(index, field);
            },
            remoteSort: false,
            data: clase.Encontrados,
            columns:[[
                {field:'id',title:'Id',width:50,align:'center'},
                {field:'institucion',title:'Institución',width:250,sortable:true},
                {field:'localidad',title:'Localidad',width:150,sortable:true},
                {field:'provincia',title:'Provincia',width:150,align:'center'},
                {field:'usuario',title:'Usuario',width:100,align:'center'},
                {field:'fecha',title:'Alta',width:100,align:'center'},
                {field:'editar',width:50,align:'center'}
            ]]
        });

   }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} index - clave de la grilla
    * @param {string} field - campo pulsado
    * Método llamado al pulsar sobre la grilla que recibe
    * la clave de la grilla y el nombre del campo sobre
    * el que se pulsó
    */
    eventoGrillaInstituciones(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-instituciones').datagrid('getRows')[index];

        // si está editando
        if (field == "editar"){

            // obtenemos el protocolo y lo mostramos
            this.getDatosInstitucion(row.id);

            // cerramos el layer
            this.cerrarEmergente();

        }

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} idinstitucion - clave del registro
    * Método que recibe como parámetro la clave de un
    * registro y obtiene los valores del mismo
    */
    getDatosInstitucion(idinstitucion){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "instituciones/getinstitucion.php?idinstitucion="+idinstitucion,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro
                clase.verDatosInstitucion(data);

        }});

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {array} datos - vector con el registro
    * Método que a partir de las variables de clase
    * carga los datos en el formulario
    */
    verDatosInstitucion(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos los valores
        $('#idcentro').textbox('setValue', datos.Id);
        $('#nombreinstitucion').textbox('setValue', datos.Institucion);
        $('#siisainstitucion').textbox('setValue', datos.Siisa);
        $('#direccioninstitucion').textbox('setValue', datos.Direccion);
        $('#codpostinstitucion').textbox('setValue', datos.CodPost);
        $('#paisinstitucion').textbox('setValue', datos.Pais);
        $('#nomprovinstitucion').textbox('setValue', datos.Provincia);
        $('#nomlocinstitucion').textbox('setValue', datos.Localidad);
        document.getElementById("codlocinstitucion").value = datos.CodLoc;
        $('#dependenciainstitucion').combobox('setValue', datos.IdDependencia);
        $('#telefonoinstitucion').numberbox('setValue', datos.Telefono);
        $('#emailinstitucion').textbox('setValue', datos.Mail);
        $('#responsableinstitucion').textbox('setValue', datos.Responsable);
        $('#altainstitucion').textbox('setValue', datos.Fecha);
        $('#usuarioinstitucion').textbox('setValue', datos.Usuario);
        $('#observacionesinstitucion').texteditor('setValue', datos.Comentarios);

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que inicializa los componentes del
    * formulario de instituciones
    */
    initFormInstituciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los elementos
        $('#idcentro').textbox();
        $('#nombreinstitucion').textbox();
        $('#siisainstitucion').textbox();
        $('#direccioninstitucion').textbox();
        $('#codpostinstitucion').textbox();
        $('#paisinstitucion').textbox();
        $('#nomprovinstitucion').textbox();
        $('#nomlocinstitucion').textbox();
        $('#btnBuscaLocInstitucion').linkbutton();

        // el combo de dependencia
        $('#dependenciainstitucion').combobox({
            url:'dependencias/nominadependencias.php',
            valueField:'iddependencia',
            textField:'dependencia'
        });

        // seguimos configurando
        $('#telefonoinstitucion').numberbox();
        $('#emailinstitucion').textbox();
        $('#responsableinstitucion').textbox();
        $('#altainstitucion').textbox();
        $('#usuarioinstitucion').textbox();
        $('#observacionesinstitucion').texteditor();
        $('#btnGrabarInstitucion').linkbutton();
        $('#btnCancelarInstitucion').linkbutton();
        $('#btnBorrarInstitucion').linkbutton();

        // fijamos por defecto el usuario y la fecha
        $('#altainstitucion').textbox('setValue', fechaActual());
        $('#usuarioinstitucion').textbox('setValue', sessionStorage.getItem("Usuario"));

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado al pulsar el botón grabar que
    * verifica los datos del formulario
    */
    verificaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verifica los permisos
        if (!seguridad.verificaAcceso()){
            return;
        }

        // si está dando un alta
        if ($('#idcentro').textbox('getValue') == ""){
            this.Id = 0;
        } else {
            this.Id = $('#idcentro').textbox('getValue');
        }

        // si no ingresó el nombre
        if ($('#nombreinstitucion').textbox('getValue') == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique el nombre de la Institución");
            return;

        // si ingresó
        } else {
            this.Nombre = $('#nombreinstitucion').textbox('getValue');
        }

        // el siisa lo permite en blanco
        this.Siisa = $('#siisainstitucion').textbox('getValue');

        // si no seleccionó la dependencia
        if ($('#dependenciainstitucion').combobox('getValue') == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Seleccione la dependencia de la lista");
            return;

        // si seleccionó
        } else {
            this.IdDependencia = $('#dependenciainstitucion').combobox('getValue');
        }

        // si no ingresó la dirección
        if ($('#direccioninstitucion').textbox('getValue') == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Ingrese la dirección postal");
            return;

        // si ingresó
        } else {
            this.Direccion = $('#direccioninstitucion').textbox('getValue');
        }

        // el teléfono lo permite en blanco
        this.Telefono = $('#telefonoinstitucion').numberbox('getValue');

        // si no ingresó el mail
        if ($('#emailinstitucion').textbox('getValue') == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique un mail oficial");
            return;

        // si ingresó verifica
        } else if (!echeck($('#emailinstitucion').textbox('getValue'))){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "El mail parece incorrecto");
            return;

        // si ingresó y es correcto
        } else {
            this.Mail = $('#emailinstitucion').textbox('getValue');
        }

        // el código postal lo permite en blanco
        this.CodPost = $('#codpostinstitucion').textbox('getValue');

        // si no hay un código de localidad válido
        if (document.getElementById("codlocinstitucion").value == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique la localidad");
            return;

        // si hay un código válido
        } else {
            this.CodLoc = document.getElementById("codlocinstitucion").value;
        }

        // el responsable lo permite en blanco
        this.Responsable = $('#responsableinstitucion').textbox('getValue');

        // si ingresó las observaciones
        this.Comentarios = $('#observacionesinstitucion').texteditor('getValue');

        // si está dando un alta
        if (this.Id == 0){
            this.validaInstitucion();
        } else {
            this.grabaInstitucion();
        }

    }

   /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado al insertar un nuevo registro que
    * verifica no esté repetido
    */
    validaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "instituciones/validainstitucion.php?institucion="+clase.Nombre+"&codloc="+clase.CodLoc,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si es correcto
                if (data.Registros == 0){
                    clase.grabaInstitucion();
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa institución ya existe");

                }

            }

        });

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que ejecuta la consulta de grabación
    */
    grabaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosInstitucion = new FormData();

        // declaramos la clase
        let clase = this;

        // asignamos en el formulario
        datosInstitucion.append("IdInstitucion", this.Id);
        datosInstitucion.append("Institucion", this.Nombre);
        datosInstitucion.append("Siisa", this.Siisa);
        datosInstitucion.append("CodLoc", this.CodLoc);
        datosInstitucion.append("Direccion", this.Direccion);
        datosInstitucion.append("CodigoPostal", this.CodPostal);
        datosInstitucion.append("Telefono", this.Telefono);
        datosInstitucion.append("Mail", this.Mail);
        datosInstitucion.append("Responsable", this.Responsable);
        datosInstitucion.append("IdUsuario", sessionStorage.getItem("Id"));
        datosInstitucion.append("IdDependencia", this.IdDependencia);
        datosInstitucion.append("Comentarios", this.Comentarios);
        datosInstitucion.append("Coordenadas", this.Coordenadas);

        // grabamos el registro
        $.ajax({
            url: "instituciones/grabainstitucion.php",
            type: "POST",
            data: datosInstitucion,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

                    // si estaba insertando
                    if (clase.Id == 0){

                        // asignamos la id y la historia
                        $('#idcentro').textbox('setValue', data.Id);

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
     * Método que limpia el formulario de instituciones
     */
    limpiaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos los campos
        $('#idcentro').textbox('setValue', "");
        $('#nombreinstitucion').textbox('setValue', "");
        $('#siisainstitucion').textbox('setValue', "");
        $('#direccioninstitucion').textbox('setValue', "");
        $('#codpostinstitucion').textbox('setValue', "");
        $('#paisinstitucion').textbox('setValue', "");
        $('#nomprovinstitucion').textbox('setValue', "");
        $('#nomlocinstitucion').textbox('setValue', "");
        document.getElementById("codlocinstitucion").value = "";
        $('#dependenciainstitucion').combobox('setValue', "");
        $('#telefonoinstitucion').numberbox('setValue', "");
        $('#emailinstitucion').textbox('setValue', "");
        $('#responsableinstitucion').textbox('setValue', "");
        $('#altainstitucion').textbox('setValue', fechaActual());
        $('#usuarioinstitucion').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#observacionesinstitucion').texteditor('setValue', "");

        // inicializamos las variables
        this.initInstituciones();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón cancelar que
     * según el estado del formulario, lo limpia o lo
     * recarga
    */
    cancelaInstitucion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si estaba insertando
        if ($('#idcentro').textbox('getValue') == ""){

            // limpiamos el formulario
            this.limpiaInstitucion();

        // si estaba editando
        } else {

            // recargamos el registro
            this.getDatosInstitucion($('#idcentro').textbox('getValue'));

        }

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado al pulsar el botón borrar que
    * verifica que la institución no tenga registros
    * hijos
    */
    puedeBorrar(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verifica los permisos
        if(!seguridad.verificaAcceso()){
            return;
        }

        // obtenemos la clave de la institución
        let id = $('#idcentro').textbox('getValue');

        // si no hay un registro activo
        if (id == ""){
            return;
        }

        // verificamos que no tenga hijos
        $.ajax({
            url: "instituciones/puedeborrar.php?id="+id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si puede borrar
                if (data.Registros == 0){

                    // pedimos confirmación
                    clase.confirmaEliminar(id);

                // si encontró registros
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "La institución tiene registros asociados");

                }

        }});

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} id - clave del registro
    * Método que pide confirmación antes de eliminar
    * un registro
    */
    confirmaEliminar(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // declaramos las variables
        let mensaje = 'Está seguro que desea<br>eliminar el registro?';

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                        mensaje,
                        function(r){
                            if (r){
                                clase.borraInstitucion(id);
                            }
                        });

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} id - clave de la instituciòn
    * Método que ejecuta la consulta de eliminación
    */
    borraInstitucion(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos
        $.ajax({
            url: "instituciones/borrar.php?id="+id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si anduvo bien
                if (data.Error){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro eliminado ...");

                    // limpia el formulario
                    clase.limpiaInstitucion();

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado al pulsar el botón buscar localidad
    * que verifica se halla seleccionado parte del
    * texto y ejecuta la búsqueda
    */
    buscaLocalidad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la localidad ingresada
        let localidad = $('#localidadinstitucion').textbox('getValue');

        // si no ingresó texto
        if (localidad == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la localidad");
            return;

        }

        // ejecutamos la consulta
        $.ajax({
            url: "localidades/buscar.php?localidad="+localidad,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // llamamos la grilla
                clase.encuentraLocalidad(data);

        }});

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {array} datos - vector con los registros
    * Método llamado luego de buscar la localidad que
    * recibe el vector con los registros encontrados
    */
    encuentraLocalidad(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si no hay registros
        if (datos.length == 0){

            // presenta el mensaje
            Mensaje("Error", "Atención", "No hay localidades coincidentes");

        // si encontró
        } else {

            // asignamos la matriz
            this.Encontrados = datos.slice();

            // cargamos la grilla
            this.grillaLocalidades();

        }

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que abre el layer emergente con la grilla
    * de localidades
    */
    grillaLocalidades(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-instituciones'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // cargamos la grilla
        $('#win-instituciones').window({
            width:900,
            height:400,
            modal:true,
            title: "Localidades Concidentes",
            minimizable: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            href: 'instituciones/grillalocalidades.html',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-instituciones').window('center');

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que inicializa la grilla de localidades
    */
    initGrillaLocalidades(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-localidades').datagrid({
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaLocalidades(index, field);
            },
            remoteSort: false,
            pagination: true,
            data: clase.Encontrados,
            columns:[[
                {field:'codloc',title:'Id',width:100,align:'center'},
                {field:'pais',title:'Pais',width:150,sortable:true},
                {field:'provincia',title:'Provincia',width:250,sortable:true},
                {field:'localidad',title:'Localidad',width:250,sortable:true},
                {field:'editar',width:50,align:'center'}
            ]]
        });

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * @param {int} index - clave de la grilla
    * @param {string} field - nombre del campo
    * Método llamado al pulsar sobre la grilla de localidades
    * que asigna los valores seleccionados en el formulario
    */
    eventoGrillaLocalidades(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-localidades').datagrid('getRows')[index];

        // si el campo es distinto de editar
        if (field != "editar"){
            return;
        }

        // asignamos en el campo y las variables
        $('#paisinstitucion').textbox('setValue',row.pais);
        $('#nomprovinstitucion').textbox('setValue', row.provincia);
        $('#nomlocinstitucion').textbox('setValue', row.localidad);
        document.getElementById("codlocinstitucion").value = row.codloc;

        // detectamos las coordenadas
        this.detectaCoordenadas();

        // cerramos el layer
        this.cerrarEmergente();

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método llamado luego de seleccionar la localdad que
    * busca las coordenadas gps correspondientes
    */
    detectaCoordenadas(){

        // reiniciamos el contador
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;
        let domicilio;

        // componemos el domicilio a buscar en el formato
        // direccion, localidad, provincia, país
        domicilio = $('#direccioninstitucion').textbox('getValue');
        domicilio += " - " + $('#nomlocinstitucion').textbox('getValue');
        domicilio += " - " + $('#nomprovinstitucion').textbox('getValue');
        domicilio += " - " + $('#paisinstitucion').textbox('getValue');

        // instancia el geocoder
        let geocoder = new google.maps.Geocoder();

        // busca la dirección
        geocoder.geocode( { 'address': domicilio}, function(results, status) {

            // si hubo resultados
            if (status == google.maps.GeocoderStatus.OK) {

                // asignamos las coordenadas
                clase.Coordenadas = results[0].geometry.location;

            // si no encontró
            } else {

                // presenta el mensaje
                let mensaje = "No se ha podido detectar una<br>";
                mensaje += "serie de coordenadas válidas, el<br>";
                mensaje += "error fue: " + status;

                // presenta el mensaje y retorna
                Mensaje("Error", "Atención", mensaje);

            }

        });

    }

    /**
    * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    * Método que presenta la ayuda emergente
    */
    ayudaInstituciones(){

        // reiniciamos
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-instituciones'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-instituciones').window({
            width:850,
            height:550,
            modal:true,
            title: "Ayuda Instituciones Asistenciales",
            minimizable: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            href: 'instituciones/ayuda.html',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-instituciones').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que genera el xls con la nómina completa de
     * instituciones asistenciales registradas
     */
    imprimeInstituciones(){

        // generamos el archivo
        window.open = "instituciones/xls_instituciones.php";

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que cierra el formulario emergente
    */
    cerrarEmergente(){

        // cerramos el layer
        $('#win-instituciones').window('destroy');

    }

}
