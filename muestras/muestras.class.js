/*

    Nombre: muestras.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 05/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 muestras tomadas al paciente

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Clase que controla las operaciones de la grilla de
 * muestras tomadas al paciente
 */
class Muestras{


    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase
     */
    constructor(){

        // inicializamos las variables
        this.initMuestras();

        // cargamos la definición de la grilla
        $("#form-muestras").load("muestras/grillamuestras.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initMuestras(){

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

        // inicializamos el resto de las variables
        this.Id = 0;                   // clave del registro
        this.Material = 0;             // clave del material
        this.Tecnica = 0;              // clave de la técnica
        this.Fecha = "";               // fecha de toma de la muestra
        this.Resultado = "";           // resultado de la determinación
        this.Determinacion = "";       // fecha de la determinación
        this.Usuario = "";             // nombre del usuario
        this.Alta = "";                // fecha de alta del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición de la
     * grilla que configura la misma
     *
     * Los eventos onBeginEdit, onEndEdit, etc., permiten que
     * en el caso de las técnicas y los materiales, presentar
     * el select y que al seleccionar el valor el usuario
     * la grilla presente el texto seleccionado, pero que
     * mas tarde, al obtener el valor del registro, este
     * retorne la clave de la técnica o del material
     *
     * Notar que como en este caso tenemos mas de un select 
     * lo que hacemos es lo siguiente:
     * 
     * return row.nombreMaterial || value; 
     * 
     * Al declararlo en la definición de la celda, lo que 
     * hacemos es que la grilla presente el valor nombreMaterial
     * (o nombreTecnica)
     * 
     * luego instanciamos el objeto index será la clave del 
     * registro en la grilla y luego field nos indica en 
     * que campo alojaremos el texto 
     * var ed = $(this).datagrid('getEditor', {
     *              index: index,
     *              field: 'Tecnica'
     *          });
     *           row.nombreTecnica = $(ed.target).combobox('getText');
     *
     * notar que la variable ed es la que alojará el contenido 
     * luego le asignamos a ese objeto el texto del select 
     * 
     */
    initGrillaMuestras(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el array de resultados
        let datosResultado = [{"valor": "Positivo"},
                              {"valor": "Negativo"},
                              {"valor": "Indeterminado"}];

        // definimos la tabla
        $('#grilla-muestras').datagrid({
            title: "Muestras tomadas al paciente",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevaMuestra();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaMuestras();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaMuestras(index, field);
            },
            remoteSort: false,
            pagination: false,
            url:'muestras/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Material',title:'Material',width:250,
                    formatter:function(value,row){
                        return row.nombreMaterial || value;
                    },
                    editor:{type:'combobox',
                            options: {data: dicmaterial.NominaMateriales,
                                      valueField: 'Id',
                                      textField: 'Material',
                                      panelHeight: 'auto'
                            }
                    }
                },
                {field:'Tecnica',title:'Tecnica',width:250,
                    formatter:function(value,row){
                        return row.nombreTecnica || value;
                    },
                    editor:{type:'combobox',
                            options: {data: dictecnicas.NominaTecnicas,
                                      valueField: 'Id',
                                      textField: 'Tecnica',
                                      panelHeight: 'auto'
                            }
                    }
                },
                {field:'Fecha',title:'Fecha',width:120, align:'center',
                    editor:{type:'datebox'}
                },
                {field:'Resultado',title:'Resultado',width:120,
                 editor:{type:'combobox',
                        options:{data: datosResultado,
                                 valueField: 'valor',
                                 textField: 'valor',
                                 panelHeight: 'auto'
                        }}},
                {field:'Determinacion',title:'Determ.',width:120,align:'center',
                    editor:{type:'datebox'}
                },
                {field:'Alta',title:'Alta',width:100,align:'center'},
                {field:'Usuario',title:'Usuario',width:100,align:'center'},
                {field:'Editar',width:50,align:'center'},
                {field:'Borrar',width:50,align:'center'}
            ]],
            onEndEdit:function(index,row){
                var ed = $(this).datagrid('getEditor', {
                    index: index,
                    field: 'Tecnica'
                });
                row.nombreTecnica = $(ed.target).combobox('getText');
                var mat = $(this).datagrid('getEditor', {
                    index: index,
                    field: 'Material'
                });
                row.nombreMaterial = $(mat.target).combobox('getText');
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
     * Método llamado al pulsar la opción nueva muestra que
     * agrega una fila en blanco al inicio de la grilla
     */
    nuevaMuestra(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si hay un paciente activo
        if (this.Paciente == 0){

            // presenta el mensaje
            let mensaje = "Primero debe tener un Paciente en ";
            mensaje += "pantalla para agregar muestras. ";
            $.messager.alert('Atención',mensaje);
            return;

        }

        // agregamos un registro al inicio de la grilla
        $('#grilla-muestras').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Material: "",
                Tecnica: "",
                Fecha: fechaActual(),
                Resultado: "",
                Determinacion: "",
                Alta: fechaActual(),
                Usuario: sessionStorage.getItem("Usuario"),
                Editar: "<img src='imagenes/save.png'>",
                Borrar: "<img src='imagenes/borrar.png'>"
            }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idpaciente - clave del paciente
     * Método llamado desde el formulario de datos de filiación
     * luego de cargar los datos del paciente que recibe como
     * parámetro la clave del paciente
     */
    cargaMuestras(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        this.Paciente = idpaciente;

        // recargamos la grilla
        $('#grilla-muestras').datagrid('load',{
            idpaciente: idpaciente
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index clave de la grilla
     * @param {string} field campo de la grilla
     * Método llamado al pulsar sobre la grilla que recibe
     * como parámetro la clave de la grilla y el nombre del
     * campo pulsado, según el valor de este habilita la
     * edición, la grabación o la eliminación
     */
    eventoGrillaMuestras(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-muestras').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-muestras').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaMuestras(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-muestras').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el formulario de filiación al
     * insertar un nuevo paciente que limpia la grilla de
     * muestras
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos las variables
        this.initMuestras();

        // limpiamos el datagrid
        $('#grilla-muestras').datagrid('loadData',[]);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método llamado al pulsar sobre el botón grabar que
     * verifica los datos ingresados antes de enviarlos
     * al servidor
     */
    verificaMuestras(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verifica por las dudas la clave del paciente
        if (this.Paciente == 0 || this.Paciente == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Debe tener un paciente activo");
            return;

        }

        // cerramos la edición
        $('#grilla-muestras').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-muestras').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Material = row.Material;
        this.Tecnica = row.Tecnica;
        this.Fecha = row.Fecha;
        this.Resultado = row.Resultado;
        this.Determinacion = row.Determinacion;

        // si no indicó el material
        if (this.Material == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el tipo de material utilizado");
            return;

        }

        // si no declaró la técnica
        if (this.Tecnica == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el la técnica utilizada");
            return;
        }


        // si no ingresó la fecha
        if (this.Fecha == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la fecha de recepción de la muestra");
            return;

        }

        // los demás elementos los permitimos en blanco
        this.grabaMuestra();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en la
     * base
     */
    grabaMuestra(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosMuestra = new FormData();

        // declaramos la clase
        let clase = this;

        // agregamos los elementos
        datosMuestra.append("Id", this.Id);
        datosMuestra.append("Paciente", this.Paciente);
        datosMuestra.append("Material", this.Material);
        datosMuestra.append("Tecnica", this.Tecnica);
        datosMuestra.append("Fecha", this.Fecha);
        datosMuestra.append("Resultado", this.Resultado);
        datosMuestra.append("Determinacion", this.Determinacion);
        datosMuestra.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "muestras/grabar.php",
            type: "POST",
            data: datosMuestra,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro Grabado ...");

                    // recargamos la grilla de efectos
                    $('#grilla-muestras').datagrid('reload');

                    // reiniciamos las variables
                    clase.initMuestras();

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
     * Método llamado al pulsar el botón eliminar que pide
     * confirmación antes de ejecutar
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-muestras').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "la determinacion " + row.Tecnica;
        mensaje += "de la muestra " + row.Material + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                           mensaje,
                           function(r){
                               if (r){
                                   clase.borraMuestra(row.Id);
                               }
                           });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idmuestra - clave del registro
     * Método que ejecuta la consulta de eliminación
     */
    borraMuestra(idmuestra){

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "muestras/borrar.php?idmuestra="+idmuestra,
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
                    clase.initMuestras();

                    // recargamos la grilla
                    $('#grilla-muestras').datagrid('reload');

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
    ayudaMuestras(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-muestras'></div>";

        // agregamos la definición de la grilla al dom
        $("#form-muestras").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-muestras').window({
            title: "Ayuda de las Muestras recibidas",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'muestras/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-muestras').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-muestras').window('center');

    }

}
