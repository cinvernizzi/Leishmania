/*

    Nombre: peridomicilio.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 03/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 elementos del peridomicilio del paciente

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
 *        de elementos del peridomicilio del paciente
 */
class Peridomicilio {

    // constructor de la clase
    constructor(){

        // inicializamos las variables
        this.initPeridomicilio();

        // cargamos en el contenedor la grilla
        $("#form-peridomicilio").load("peridomicilio/grillaperidomicilio.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initPeridomicilio(){

        // definimos las variables
        this.Id = 0;                  // clave del registro
        this.Animal = 0;              // clave del animal u objeto
        this.Distancia = 0;           // distancia en metros de la vivienda
        this.Cantidad = 0;            // cantidad de animales u objetos

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
     *
     * Los eventos beginedit y endedit de la grilla permiten que
     * al seleccionar el valor de un select, la grilla muestre
     * el texto del mismo y que mas tarde, al obtener el valor
     * del registro, retorne la clave correspondiente al select
     *
     */
    initGrillaPeridomicilio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-peridomicilio').datagrid({
            title: "Objetos y Animales del Peridomicilio",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevoPeridomicilio();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaPeridomicilio();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaPeridomicilio(index, field);
            },
            remoteSort: false,
            pagination: false,
            url:'peridomicilio/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Animal',title:'Animal',width:250,
                    formatter:function(value,row){
                        return row.nombreAnimal || value;
                    },
                    editor:{type:'combobox',
                            options: {data: animales.NominaAnimales,
                                      valueField: 'Id',
                                      textField: 'Animal',
                                      panelHeight: 'auto'
                            }
                    }
                },
                {field:'Distancia',title:'Distancia',width:100, align:'center',
                    editor:{type:'numberspinner'}
                },
                {field:'Cantidad',title:'Cantidad',width:100, align:'center',
                    editor:{type:'numberspinner'}
                },
                {field:'Alta',title:'Alta',width:100,align:'center'},
                {field:'Usuario',title:'Usuario',width:100,align:'center'},
                {field:'Editar',width:50,align:'center'},
                {field:'Borrar',width:50,align:'center'}
            ]],
            onEndEdit:function(index,row){
                var ed = $(this).datagrid('getEditor', {
                    index: index,
                    field: 'Animal'
                });
                row.nombreAnimal = $(ed.target).combobox('getText');
            },
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
     * @param {int} idpaciente - clave del paciente
     * Método llamado desde el formulario de pacientes al
     * cargar un registro que recibe como parámetro la clave
     * del paciente y recarga la grilla
     */
    cargaPeridomicilio(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // asignamos en la clase
        this.Paciente = idpaciente;

        // recargamos la grilla
        $('#grilla-peridomicilio').datagrid('load',{
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
        this.initPeridomicilio();

        // limpiamos el datagrid
        $('#grilla-peridomicilio').datagrid('loadData',[]);

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
    eventoGrillaPeridomicilio(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-peridomicilio').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-peridomicilio').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaPeridomicilio(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-peridomicilio').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción nueva actividad
     * que agrega un registro en blanco al inicio de la grilla
     */
    nuevoPeridomicilio(){

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
        $('#grilla-peridomicilio').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Animal: "",
                Distancia: "",
                Cantidad: "",
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
    verificaPeridomicilio(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición
        $('#grilla-peridomicilio').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-peridomicilio').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Animal = row.Animal;
        this.Distancia = row.Distancia;
        this.Cantidad = row.Cantidad;

        // si no indicó el tipo
        if (this.Animal == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Seleccione el animal u objeto");
            return;

        }

        // si no declaró
        if (this.Distancia == "" || this.Distancia == 0){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la distancia en metros");
            return;

        }

        // si no ingresó la cantidad
        if (this.Cantidad == "" || this.Cantidad == 0){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la cantidad");
            return;

        }

        // grabamos el registro
        this.grabaPeridomicilio();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación y luego
     * recarga la grilla
     */
    grabaPeridomicilio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosPeridomicilio = new FormData();
        let clase = this;

        // agregamos los valores
        datosPeridomicilio.append("Id", this.Id);
        datosPeridomicilio.append("Paciente", this.Paciente);
        datosPeridomicilio.append("Animal", this.Animal);
        datosPeridomicilio.append("Distancia", this.Distancia);
        datosPeridomicilio.append("Cantidad", this.Cantidad);
        datosPeridomicilio.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "peridomicilio/grabar.php",
            type: "POST",
            data: datosPeridomicilio,
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
                    $('#grilla-peridomicilio').datagrid('reload');

                    // reiniciamos las variables
                    clase.initPeridomicilio();

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
        let row = $('#grilla-peridomicilio').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "el registro de " + row.Animal + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                           mensaje,
                           function(r){
                               if (r){
                                   clase.borraPeridomicilio(row.Id);
                               }
                           });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación
     */
    borraPeridomicilio(id){

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "peridomicilio/borrar.php?id="+id,
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
                    clase.initPeridomicilio();

                    // recargamos la grilla
                    $('#grilla-peridomicilio').datagrid('reload');

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
    ayudaPeridomicilio(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-peridomicilio'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-mascotas").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-peridomicilio').window({
            title: "Adyuda de Peridomicilio",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'peridomicilio/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-peridomicilio').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-peridomicilio').window('center');

    }

}
