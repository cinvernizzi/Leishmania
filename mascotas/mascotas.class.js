/*

    Nombre: mascotas.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 03/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 mascotas del paciente

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
 *        de mascotas del paciente
 */
class Mascotas {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initMascotas();

        // cargamos en el contenedor la grilla
        $("#form-mascotas").load("mascotas/grillamascotas.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initMascotas(){

        // definimos las variables
        this.Id = 0;                  // clave del registro
        this.Nombre = "";             // nombre de la mascota
        this.Edad = "";               // edad de la mascota en años
        this.Origen = "";             // origen de la mascota

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
    initGrillaMascotas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-mascotas').datagrid({
            title: "Mascotas declaradas del paciente",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevaMascota();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaMascotas();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaMascotas(index, field);
            },
            remoteSort: false,
            pagination: false,
            url:'mascotas/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Nombre',title:'Nombre',width:250,
                    editor:{type:'textbox'}
                },
                {field:'Edad',title:'Edad',width:80, align:'center',
                    editor:{type:'numberspinner'}
                },
                {field:'Origen',title:'Origen',width:250,
                    editor:{type:'textbox'}
                },
                {field:'Alta',title:'Alta',width:100,align:'center'},
                {field:'Usuario',title:'Usuario',width:100,align:'center'},
                {field:'Editar',width:50,align:'center'},
                {field:'Borrar',width:50,align:'center'},
                {field:'Muestras',width:50, align:'center'}
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
    cargaMascotas(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // asignamos en la clase
        this.Paciente = idpaciente;

        // recargamos la grilla
        $('#grilla-mascotas').datagrid('load',{
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

        // iniciamos las variables
        this.initMascotas();

        // limpiamos el datagrid
        $('#grilla-mascotas').datagrid('loadData',[]);

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
    eventoGrillaMascotas(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-mascotas').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-mascotas').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaMascota(index);

            // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en muestras
        } else if (field == "Muestras"){

            // verificamos que exista una mascota activa
            let row = $('#grilla-mascotas').datagrid('getRows')[index];
            if (row.Id == 0 || row.Id == ""){

                // presenta el mensaje y retorna
                Mensaje("Error", "Atención", "Debe tener una mascota activa");
                return;
            }

            // abrimos el layer emergente
            sintmascotas.verSintomasMascotas(row.Id, this.Paciente);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-mascotas').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción nueva actividad
     * que agrega un registro en blanco al inicio de la grilla
     */
    nuevaMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si hay un paciente activo
        if (this.Paciente == 0){

            // presenta el mensaje
            let mensaje = "Primero debe tener un Paciente en ";
            mensaje += "pantalla para agregar mascotas. ";
            $.messager.alert('Atención',mensaje);
            return;

        }

        // agregamos un registro al inicio de la grilla
        $('#grilla-mascotas').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Nombre: "",
                Edad: "",
                Origen: "",
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
    verificaMascota(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición
        $('#grilla-mascotas').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-mascotas').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Nombre = row.Nombre;
        this.Edad = row.Edad;
        this.Origen = row.Origen;

        // si no indicó el tipo
        if (this.Nombre == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el nombre");
            return;

        }

        // si no declaró
        if (this.Edad == "" || this.Edad == 0){

            // presenta el mensaje
            Mensaje("Error", "Atención", "La edad aproximada en años");
            return;

        }


        // si no ingresó la fecha
        if (this.Origen == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Describa el origen de la mascota");
            return;

        }

        // grabamos el registro
        this.grabaMascota();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación y luego
     * recarga la grilla
     */
    grabaMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosMascota = new FormData();
        let clase = this;

        // agregamos los valores
        datosMascota.append("Id", this.Id);
        datosMascota.append("Paciente", this.Paciente);
        datosMascota.append("Nombre", this.Nombre);
        datosMascota.append("Edad", this.Edad);
        datosMascota.append("Origen", this.Origen);
        datosMascota.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "mascotas/grabar.php",
            type: "POST",
            data: datosMascota,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro Grabado ...");

                    // recargamos la grilla de mascotas
                    $('#grilla-mascotas').datagrid('reload');

                    // reiniciamos las variables
                    clase.initMascotas();

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
        let row = $('#grilla-mascotas').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "la mascota " + row.Nombre + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                           mensaje,
                           function(r){
                               if (r){
                                   clase.borraMascota(row.Id);
                               }
                           });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación
     */
    borraMascota(id){

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "mascotas/borrar.php?id="+id,
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
                    clase.initMascotas();

                    // recargamos la grilla
                    $('#grilla-mascotas').datagrid('reload');

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
    ayudaMascotas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-mascotas'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-mascotas").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-mascotas').window({
            title: "Adyuda de Mascotas del Paciente",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'mascotas/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-mascotas').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-mascotas').window('center');

    }

}
