/*

    Nombre: viajes.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 01/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 viajes realizados por el paciente

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
 *        de viajes realizados por el paciente
 */
class Viajes {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initViajes();

        // cargamos en el contenedor la grilla
        $("#form-viajes").load("viajes/grillaviajes.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initViajes(){

        // definimos las variables
        this.Id = 0;                  // clave del registro
        this.Lugar = "";              // lugar del viaje
        this.Fecha = "";              // fecha del viaje

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

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición de la grilla
     * que la configura
     */
    initGrillaViajes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-viajes').datagrid({
            title: "Viajes realizados por el paciente",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevoViaje();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaViajes();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaViajes(index, field);
            },
            remoteSort: false,
            pagination: false,
            url:'viajes/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Lugar',title:'Lugar',width:250,
                    editor:{type:'textbox'}
                },
                {field:'Fecha',title:'Fecha',width:120,align:'center',
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
     * cargar un registro, que recibe como parámetro la
     * clave del paciente y recarga la grilla
     */
    cargaViajes(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // asignamos en la clase
        this.Paciente = idpaciente;

        // recargamos la grilla
        $('#grilla-viajes').datagrid('load',{
            idpaciente: clase.Paciente
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el formulario de pacientes al
     * insertar un nuevo registro que se asegura de limpiar
     * la grilla e iniciarlizar las variables
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos las variables
        this.initViajes();

        // limpiamos el datagrid
        $('#grilla-viajes').datagrid('loadData',[]);

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
    eventoGrillaViajes(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-viajes').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-viajes').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaViaje(index);

            // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-viajes').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción nueva actividad
     * que agrega un registro en blanco al inicio de la grilla
     */
    nuevoViaje(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si hay un paciente activo
        if (this.Paciente == 0){

            // presenta el mensaje
            let mensaje = "Primero debe tener un Paciente en ";
            mensaje += "pantalla para agregar viajes. ";
            $.messager.alert('Atención',mensaje);
            return;

        }

        // agregamos un registro al inicio de la grilla
        $('#grilla-viajes').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Lugar: "",
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
    verificaViaje(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición
        $('#grilla-viajes').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-viajes').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Lugar = row.Lugar;
        this.Fecha = row.Fecha;

        // si no declaró
        if (this.Lugar == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el destino del viaje");
            return;

        }

        // si no ingresó la fecha
        if (this.Fecha == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la fecha del viaje");
            return;

        }

        // verificamos que no esté repetido
        this.validaViaje();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado antes de grabar el registro que verifica
     * que este no se encuentre repetido
     */
    validaViaje(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "viajes/validar.php?destino="+clase.Lugar+"&fecha="+clase.Fecha,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // grabamos el registro
                    clase.grabaViaje();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa viaje ya está declarado");

                }

            }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación y luego
     * recarga la grilla
     */
    grabaViaje(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosViaje = new FormData();
        let clase = this;

        // agregamos los valores
        datosViaje.append("Id", this.Id);
        datosViaje.append("Paciente", this.Paciente);
        datosViaje.append("Lugar", this.Lugar);
        datosViaje.append("Fecha", this.Fecha);
        datosViaje.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "viajes/grabar.php",
            type: "POST",
            data: datosViaje,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado > 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro Grabado ...");

                    // recargamos la grilla de efectos
                    $('#grilla-viajes').datagrid('reload');

                    // reiniciamos las variables
                    clase.initViajes();

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
        let row = $('#grilla-viajes').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "el viaje a " + row.Lugar + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                           mensaje,
                           function(r){
                               if (r){
                                   clase.borraViaje(row.Id);
                               }
                           });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación
     */
    borraViaje(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "viajes/borrar.php?id="+id,
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
                    clase.initViajes();

                    // recargamos la grilla
                    $('#grilla-viajes').datagrid('reload');

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
    ayudaViajes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-viajes'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-actividades").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-viajes').window({
            title: "Ayuda de Viajes del Paciente",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'viajes/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-viajes').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-viajes').window('center');

    }

}
