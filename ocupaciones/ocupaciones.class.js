/*

    Nombre: ocupaciones.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 03/06/2022
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Diagnóstico
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones de la
                 tabla de ocupaciones

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Clase que controla las operaciones de la tabla
 *        de ocupaciones
 */
class Ocupaciones {

    // constructor de la clase
    constructor(){

        // definimos la matriz
        this.nominaOcupaciones = "";

        // cargamos la matriz
        this.cargaOcupaciones();

        // inicializamos las variables
        this.initOcupaciones();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initOcupaciones(){

        // definimos las variables
        this.Id = 0;                 // clave del registro
        this.Ocupacion = "";         // descripción de la ocupación
        this.Alta = "";              // fecha de alta del registro
        this.Usuario = "";           // nombre del usuario
        this.ClaveGrilla = "";       // clave de la grilla

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga en el contenedor la grilla de
     * ocupaciones
     */
    verGrillaOcupaciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el formulario
        $("#form_administracion").load("ocupaciones/grillaocupaciones.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga la matriz pública de ocupaciones
     * haciéndola disponible para el resto del sistema
     */
    cargaOcupaciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // cargamos la matriz
        $.ajax({
            url: "ocupaciones/nominaocupaciones.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.length != 0){

                    // asignamos en la matriz
                    clase.nominaOcupaciones = data.slice();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la grilla de
     * ocupaciones que la configura
     */
    initGrillaOcupaciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-ocupaciones').datagrid({
            title: "Ocupaciones Registradas",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.verFormOcupaciones();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaOcupaciones();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaOcupaciones(index, field);
            },
            remoteSort: false,
            pagination: false,
            data: clase.nominaOcupaciones,
            columns:[[
                {field:'id',title:'Id',width:50,align:'center'},
                {field:'ocupacion',title:'Ocupación',width:220,sortable:true},
                {field:'usuario',title:'Usuario',width:100,align:'center'},
                {field:'alta',title:'Alta',width:100,align:'center'},
                {field:'editar',width:50,align:'center'},
                {field:'borrar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar la grilla que recibe como
     * parámetros la clave de la grilla y el nombre del
     * campo pulsado
     */
    eventoGrillaOcupaciones(index, field){

        // verificamos el nivel de acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-ocupaciones').datagrid('getRows')[index];

        // si pulsó en editar
        if (field == "editar"){

            // asignamos la clave
            this.ClaveGrilla = index;

            // presentamos el registro
            this.getDatosOcupacion(row);

        // si pulsó sobre borrar
        } else if (field == "borrar"){

            // eliminamos
            this.puedeBorrar(row, index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con el formulario
     * para el abm de la tabla de ocupaciones
     */
    verFormOcupaciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-ocupaciones'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-ocupaciones').window({
            width:550,
            height:180,
            modal:true,
            title: "Ocupaciones de los Pacientes",
            minimizable: false,
            closable: true,
            href: 'ocupaciones/formocupaciones.html',
            loadingMessage: 'Cargando',
            onClose:function(){clase.cerrarEmergente();},
            border: 'thin'
        });

        // centramos el formulario
        $('#win-ocupaciones').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar el formulario que
     * inicializa sus componentes
     */
    initFormOcupaciones(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los componentes
        $('#idocupacion').textbox();
        $('#nombreocupacion').textbox();
        $('#usuarioocupacion').textbox();
        $('#fechaocupacion').textbox();
        $('#btnGrabarOcupacion').linkbutton();
        $('#btnCancelarOcupacion').linkbutton();

        // si está editando
        if (this.Id != 0){

            // cargamos los valores
            $('#idocupacion').textbox('setValue', this.Id);
            $('#nombreocupacion').textbox('setValue', this.Ocupacion);
            $('#usuarioocupacion').textbox('setValue', this.Usuario);
            $('#fechaocupacion').textbox('setValue', this.Alta);

        // si está insertando
        } else {

            // configuramos la fecha y el usuario
            $('#usuarioocupacion').textbox('setValue', sessionStorage.getItem("Usuario"));
            $('#fechaocupacion').textbox('setValue', fechaActual());

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} row - contenido del registro
     * Método que recibe como parámetro la clave de la grilla
     * y asigna los valores del registro en las variables
     * de clase
     */
    getDatosOcupacion(row){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en las variables de clase
        this.Id = row.id;
        this.Ocupacion = row.ocupacion;
        this.Alta = row.alta;
        this.Usuario = row.usuario;

        // cargamos el formulario
        this.verFormOcupaciones();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que valida el formulario de datos antes de
     * enviarlo al servidor
     */
    verificaOcupacion(){

        // si está editando
        if ($('#idocupacion').textbox('getValue') != ""){
            this.Id = $('#idocupacion').textbox('getValue');
        } else {
            this.Id = 0;
        }

        // verifica el tipo de documento
        if ($('#nombreocupacion').textbox('getValue') != ""){
            this.Ocupacion = $('#nombreocupacion').textbox('getValue');
        } else {

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese la descripción");
            return;

        }

        // si está insertando
        if (this.Id == 0){
            this.validaOcupacion();
        } else {
            this.grabaOcupacion();
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que en caso de un alta verifica que no
     * se encuentre repetida la ocupación
     */
    validaOcupacion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que el tipo no esté repetido
        $.ajax({
            url: "ocupaciones/validar.php?ocupacion="+clase.Ocupacion,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Registros){

                    // grabamos el registro
                    clase.grabaOcupacion();

                // si está repetido
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ocupación ya declarada");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
    grabaOcupacion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosOcupacion = new FormData();

        // declaramos la clase
        let clase = this;

        // agregamos los elementos
        datosOcupacion.append("Id", this.Id);
        datosOcupacion.append("Ocupacion", this.Ocupacion);
        datosOcupacion.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "ocupaciones/grabar.php",
            type: "POST",
            data: datosOcupacion,
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
                        $('#grilla-ocupaciones').datagrid('appendRow',{
                            id: data.Id,
                            ocupacion: clase.Ocupacion,
                            usuario: sessionStorage.getItem("Usuario"),
                            alta: fechaActual(),
                            editar: "<img src='imagenes/meditar.png'>",
                            borrar: "<img src='imagenes/borrar.png'>"
                        });

                    // si está editando
                    } else {

                        // actualizamos la grilla
                        $('#grilla-sexos').datagrid('updateRow', {
                            index: clase.ClaveGrilla,
                            row: {id:clase.Id,
                                  ocupacion:clase.Ocupacion,
                                  usuario: sessionStorage.getItem("Usuario"),
                                  alta: fechaActual(),
                                  editar: "<img src='imagenes/meditar.png'>",
                                  borrar: "<img src='imagenes/borrar.png'>"
                                }
                            });

                    }

                    // cerramos el layer
                    clase.cerrarEmergente();

                    // recargamos la matriz
                    clase.cargaOcupaciones();

                    // recargamos el select de filiación
                    $('#ocupacionpaciente').combobox('reload');

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
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que verifica si puede borrar una ocupación
     */
    puedeBorrar(fila, index){

        // reiniciamos la sesion
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "ocupaciones/puedeborrar.php?id="+fila.id,
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
                    Mensaje("Error", "Atención", "Ocupación con registros asociados");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que pide confirmación antes de eliminar
     * el registro
     */
    confirmaEliminar(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += 'la Ocupación: ' + fila.ocupacion + '?';

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraOcupacion(fila, index);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que ejecuta la consulta de eliminación
     */
    borraOcupacion(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "ocupaciones/borrar.php?id="+fila.id,
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
                    $('#grilla-ocupaciones').datagrid('deleteRow', index);

                    // recargamos la matriz
                    clase.cargaOcupaciones();

                    // recargamos el select de pacientes
                    $('#ocupacionpaciente').combobox('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente y presenta la
     * ayuda de ocupaciones
     */
    ayudaOcupaciones(){

        // reiniciamos
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar
        let formulario = "<div id='win-ocupaciones'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-ocupaciones').window({
            width:700,
            height:600,
            modal:true,
            title: "Ayuda Ocupaciones",
            minimizable: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            href: 'ocupaciones/ayuda.html',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-ocupaciones').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método genérico que cierra el layer emergente de
     * búsquedas
     */
     cerrarEmergente(){

        // reiniciamos las variables
        this.initOcupaciones();

        // cerramos el layer
        $('#win-ocupaciones').window('destroy');

    }


}
