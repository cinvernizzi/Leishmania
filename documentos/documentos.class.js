/*

    Nombre: derivacion.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 31/10/2021
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Diagnóstico
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 tipos de documento

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
 *        de tipos de documento
 */
class Documentos {

    // constructor de la clase
    constructor(){

        // definimos la matriz
        this.nominaDocumentos = "";

        // cargamos la matriz
        this.cargaDocumentos();

        // inicializamos las variables
        this.initDocumentos();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initDocumentos(){

        // inicializamos las variables
        this.Id = 0;                 // clave del registro
        this.TipoDocumento = "";     // tipo de documento
        this.Descripcion = "";       // abreviatura del tipo
        this.Usuario = "";           // nombre del usuario
        this.Fecha = "";             // fecha de alta del registro
        this.ClaveGrilla = "";       // clave de la grilla

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga la matriz con la nómina de documentos
     * llamado desde el constructor o luego de editar / insertar
     * un registro, así queda disponible para todas las
     * aplicaciones del sistema
     */
    cargaDocumentos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // cargamos la matriz
        $.ajax({
            url: "documentos/nominadocumentos.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.length != 0){

                    // asignamos en la matriz
                    clase.nominaDocumentos = data.slice();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga la grilla de tipos de documento
     */
     verGrillaDocumentos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el formulario
        $("#form_administracion").load("documentos/grilladocumentos.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición de la
     * grilla que inicializa los componentes y carga el
     * diccionario de tipos de derivación
     */
     initGrillaDocumentos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-documentos').datagrid({
            title: "Pulse sobre una entrada para editarla",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.formDocumentos();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaDocumentos();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaDocumentos(index, field);
            },
            remoteSort: false,
            pagination: true,
            data: clase.nominaDocumentos,
            columns:[[
                {field:'iddocumento',title:'Id',width:50,align:'center'},
                {field:'tipodocumento',title:'Tipo',width:220,sortable:true},
                {field:'descripcion',title:'Desc.',width:100,sortable:true},
                {field:'usuario',title:'Usuario',width:100,align:'center'},
                {field:'fecha',title:'Fecha',width:100,align:'center'},
                {field:'editar',width:50,align:'center'},
                {field:'borrar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo
     * Método llamado al pulsar sobre la grilla que recibe
     * la clave del registro y el nombre del campo pulsado
     * según este último valor, llama el método de
     * edición o de eliminación
     */
     eventoGrillaDocumentos(index, field){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-documentos').datagrid('getRows')[index];

        // si pulsó en editar
        if (field == "editar"){

            // asignamos la clave
            this.ClaveGrilla = index;

            // presentamos el registro
            this.getDatosDocumento(row);

        // si pulsó sobre borrar
        } else if (field == "borrar"){

            // eliminamos
            this.puedeBorrar(row, index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} row contenido de la fila
     * Método que recibe como parámetro la clave de la
     * grilla y obtiene los valores del registro
     */
     getDatosDocumento(row){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en las variables de clase
        this.Id = row.iddocumento;
        this.TipoDocumento = row.tipodocumento;
        this.Descripcion = row.descripcion;
        this.Fecha = row.fecha;
        this.Usuario = row.usuario;

        // cargamos el formulario
        this.formDocumentos();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el formulario emergente de los
     * tipos de documento
     */
     formDocumentos(){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-documentos'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-documentos').window({
            width:550,
            height:180,
            modal:true,
            title: "Tipos de Documento",
            minimizable: false,
            closable: true,
            href: 'documentos/formdocumentos.html',
            loadingMessage: 'Cargando',
            onClose:function(){clase.cerrarEmergente();},
            border: 'thin'
        });

        // centramos el formulario
        $('#win-documentos').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa los componentes del
     * formulario de tipos de documento
     */
     initFormDocumentos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los componentes
        $('#iddocumento').textbox();
        $('#nombredocumento').textbox();
        $('#descripciondocumento').textbox();
        $('#usuariodocumento').textbox();
        $('#fechadocumento').textbox();
        $('#btnGrabarDocumento').linkbutton();
        $('#btnCancelarDocumento').linkbutton();

        // si está editando
        if (this.Id != 0){

            // cargamos los valores
            $('#iddocumento').textbox('setValue', this.Id);
            $('#nombredocumento').textbox('setValue', this.TipoDocumento);
            $('#descripciondocumento').textbox('setValue', this.Descripcion);
            $('#usuariodocumento').textbox('setValue', this.Usuario);
            $('#fechadocumento').textbox('setValue', this.Fecha);

        // si está insertando
        } else {

            // configuramos la fecha y el usuario
            $('#usuariodocumento').textbox('setValue', sessionStorage.getItem("Usuario"));
            $('#fechadocumento').textbox('setValue', fechaActual());

        }

        // fijamos el foco
        $('#nombredocumento').textbox('textbox').focus();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que verifica el formulario antes de
     * enviar los datos al servidor
     */
     verificaDocumento(){

        // si está editando
        if ($('#iddocumento').textbox('getValue') != ""){
            this.Id = $('#iddocumento').textbox('getValue');
        } else {
            this.Id = 0;
        }

        // verifica el tipo de documento
        if ($('#nombredocumento').textbox('getValue') != ""){
            this.TipoDocumento = $('#nombredocumento').textbox('getValue');
        } else {

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese el tipo de documento");
            return;

        }

        // verifica la abreviatura
        if ($('#descripciondocumento').textbox('getValue') != ""){
            this.Descripcion = $('#descripciondocumento').textbox('getValue');
        } else {

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese la sigla del documento");
            return;

        }

        // si está insertando
        if (this.Id == 0){
            this.validaDocumento();
        } else {
            this.grabaDocumento();
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en el caso de un alta que verifica
     * que el el tipo de documento no esté repetido
     */
     validaDocumento(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que el tipo no esté repetido
        $.ajax({
            url: "documentos/validadocumento.php?tipo_documento="+clase.TipoDocumento+"&descripcion="+clase.Descripcion,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Registros){

                    // grabamos el registro
                    clase.grabaDocumento();

                // si está repetido
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese documento está declarado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
     grabaDocumento(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosDocumento = new FormData();

        // declaramos la clase
        let clase = this;

        // agregamos los elementos
        datosDocumento.append("Id", this.Id);
        datosDocumento.append("TipoDocumento", this.TipoDocumento);
        datosDocumento.append("Descripcion", this.Descripcion);
        datosDocumento.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "documentos/grabadocumento.php",
            type: "POST",
            data: datosDocumento,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

                    // si está insertando
                    if (clase.Id == 0){

                        // agregamos a la grilla
                        $('#grilla-documentos').datagrid('appendRow',{
                            iddocumento: data.Id,
                            tipodocumento: clase.TipoDocumento,
                            descripcion: clase.Descripcion,
                            usuario: sessionStorage.getItem("Usuario"),
                            fecha: fechaActual(),
                            editar: "<img src='imagenes/meditar.png'>",
                            borrar: "<img src='imagenes/borrar.png'>"
                        });

                    // si está editando
                    } else {

                        // actualizamos la grilla
                        $('#grilla-documentos').datagrid('updateRow', {
                            index: clase.ClaveGrilla,
                            row: {iddocumento:clase.Id,
                                  tipodocumento:clase.TipoDocumento,
                                  descripcion: clase.Descripcion,
                                  usuario: sessionStorage.getItem("Usuario"),
                                  fecha: fechaActual(),
                                  editar: "<img src='imagenes/meditar.png'>",
                                  borrar: "<img src='imagenes/borrar.png'>"
                                }
                            });

                    }

                    // cerramos el layer
                    clase.cerrarEmergente();

                    // recargamos la matriz
                    clase.cargaDocumentos();

                    // recargamos el select
                    $('#tipodocumento').combobox('reload');

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
     * @param {array} fila con el registro
     * @param {int} index - clave de la grilla
     * Método que verifica que el registro no tenga
     * hijos
     */
     puedeBorrar(fila, index){

        // reiniciamos la sesion
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "documentos/puedeborrar.php?id="+fila.iddocumento,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si puede borrar
                if (data.Registros){

                    // pedimos confirmación
                    clase.confirmaEliminar(fila, index);

                // si encontró registros
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "El documento tiene registros asociados");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que pide confirmación antes de eliminar el
     * registro
     */
     confirmaEliminar(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // declaramos las variables
        let mensaje = "Está seguro que desea eliminar ";
        mensaje += "el Documento: " + fila.descripcion + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraDocumento(fila, index);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que ejecuta la consulta de eliminación
     */
     borraDocumento(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "documentos/borrar.php?id="+fila.iddocumento,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si está correcto
                if (data.Resultado){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro eliminado");

                    // eliminamos la fila
                    $('#grilla-documentos').datagrid('deleteRow', index);

                    // actualizamos el vector
                    clase.cargaDocumentos();

                    // recargamos el select
                    $('#tipodocumento').combobox('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Registro eliminado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método genérico que cierra el layer emergente de
     * búsquedas
     */
     cerrarEmergente(){

        // reiniciamos las variables
        this.initDocumentos();

        // cerramos el layer
        $('#win-documentos').window('destroy');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta la ayuda para el abm de derivación
     */
    ayudaDocumentos(){

        // reiniciamos
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-documentos'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(win_ayuda);

        // definimos el diálogo y lo mostramos
        $('#ayuda-documentos').window({
            title: "Diccionario de Tipos de Documento",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'documentos/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-documentos').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el formulario
        $('#ayuda-documentos').window('center');

    }

}
