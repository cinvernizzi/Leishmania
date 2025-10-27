/*

    Nombre: actividades.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 01/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 actividades realizadas por el paciente

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
 *        de actividades realizadas por el paciente
 */
class Actividades {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initActividades();

        // cargamos en el contenedor la grilla
        $("#form-actividades").load("actividades/grillaactividades.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initActividades(){

        // definimos las variables
        this.Id = 0;                  // clave del registro
        this.Actividad = "";          // descripción de la actividad
        this.Lugar = "";              // lugar de la actividad
        this.Fecha = "";              // fecha de la actividad

        // verificamos si está editando porque esta rutina
        // la llamamos también luego de grabar o borrar
        // verificando si el elemento está definido porque
        // también lo llamamos desde el constructor
        if ($('#idpaciente').length == 0){
            this.Paciente = 0;
        // si está definido
        } else {
            if ($('#idpaciente').textbox('getValue') == ""){
                this.Paciente = 0;
            } else {
                this.Paciente = $('#idpaciente').textbox('getValue');
            }
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición de la grilla
     * que la configura
     */
    initGrillaActividades(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-actividades').datagrid({
            title: "Actividades realizadas por el paciente",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevaActividad();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaActividades();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaActividades(index, field);
            },
            remoteSort: false,
            pagination: false,
            url:'actividades/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Lugar',title:'Lugar',width:250,
                    editor:{type:'textbox'}
                },
                {field:'Actividad',title:'Actividad',width:250,
                    editor:{type:'textbox'}
                },
                {field:'Fecha',title:'Fecha',width:120,
                    editor:{type:'datebox'}
                },
                {field:'Alta',title:'Alta',width:100,align:'center'},
                {field:'Usuario',title:'Usuario',width:100,align:'center'},
                {field:'Editar',width:50,align:'center'},
                {field:'Borrar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idpaciente - clave del paciente
     * Método llamado desde el formulario de pacientes al
     * cargar un registro que recibe como parámetro la clave
     * del paciente y recarga la grilla
     */
    cargaActividades(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        let clase = this;
        this.Paciente = idpaciente;

        // recargamos la grilla
        $('#grilla-actividades').datagrid('load',{
            idpaciente: clase.Paciente
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el formulario de pacientes al
     * ingresar un nuevo registro que se asegura de limpiar
     * la grilla e inicializar las variables
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos las variables
        this.initActividades();

        // limpiamos el datagrid
        $('#grilla-actividades').datagrid('loadData',[]);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla que recibe
     * como parámetro la clave de la grilla y el nombre
     * del campo pulsado, según su valor, inicia la edición
     * la grabación del registro o la eliminación del mismo
     */
    eventoGrillaActividades(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-actividades').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-actividades').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaActividad(index);

            // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-actividades').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción nueva actividad
     * que agrega un registro en blanco al inicio de la grilla
     */
    nuevaActividad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si hay un paciente activo
        if (this.Paciente == 0){

            // presenta el mensaje
            let mensaje = "Primero debe tener un Paciente en ";
            mensaje += "pantalla para agregar actividades. ";
            $.messager.alert('Atención',mensaje);
            return;

        }

        // agregamos un registro al inicio de la grilla
        $('#grilla-actividades').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Lugar: "",
                Actividad: "",
                Fecha: fechaActual(),
                Alta: fechaActual(),
                Usuario: sessionStorage.getItem("Usuario"),
                Editar: "<img src='imagenes/save.png'>",
                Borrar: "<img src='imagenes/borrar.png'>"
            }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método llamado al pulsar el botón grabar que recibe
     * como parámetro la clave de la grilla y verifica los
     * datos del formulario
     */
    verificaActividad(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición
        $('#grilla-actividades').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-actividades').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Lugar = row.Lugar;
        this.Actividad = row.Actividad;
        this.Fecha = row.Fecha;

        // si no indicó el tipo
        if (this.Actividad == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Describa la actividad");
            return;

        }

        // si no declaró
        if (this.Lugar == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el lugar de la actividad");
            return;
        }


        // si no ingresó la fecha
        if (this.Fecha == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la fecha de la actividad");
            return;

        }

        // verificamos que no esté repetido
        this.validaActividad();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado antes de grabar el registro que verifica
     * que este no se encuentre repetido
     */
    validaActividad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "actividades/validar.php?actividad="+clase.Actividad+"&lugar="+clase.Lugar+"&fecha="+clase.Fecha,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // grabamos el registro
                    clase.grabaActividad();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa actividad ya está declarada");

                }

            }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación y luego
     * recarga la grilla
     */
    grabaActividad(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosActividad = new FormData();
        let clase = this;

        // agregamos los valores
        datosActividad.append("Id", this.Id);
        datosActividad.append("Paciente", this.Paciente);
        datosActividad.append("Actividad", this.Actividad);
        datosActividad.append("Lugar", this.Lugar);
        datosActividad.append("Fecha", this.Fecha);
        datosActividad.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "actividades/grabar.php",
            type: "POST",
            data: datosActividad,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro Grabado ...");

                    // recargamos la grilla de actividades
                    $('#grilla-actividades').datagrid('reload');

                    // reiniciamos las variables
                    clase.initActividades();

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
     * @param {int} index - clave de la grilla
     * Método llamado antes de eliminar que pide confirmación
     * antes de ejecutar la consulta
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-actividades').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "la actividad " + row.Actividad + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                           mensaje,
                           function(r){
                               if (r){
                                   clase.borraActividad(row.Id);
                               }
                           });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación
     */
    borraActividad(id){

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "actividades/borrar.php?id="+id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si está correcto
                if (data.Resultado){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro eliminado ...");

                    // nos aseguramos de reiniciar
                    clase.initActividades();

                    // recargamos la grilla
                    $('#grilla-actividades').datagrid('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

            }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con la ayuda del
     * sistema
     */
    ayudaActividades(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-actividades'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-actividades").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-actividades').window({
            title: "Adyuda de Actividades del Paciente",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'actividades/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-actividades').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-actividades').window('center');

    }

}
