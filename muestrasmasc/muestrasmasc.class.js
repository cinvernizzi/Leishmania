/*

    Nombre: muestrasmas.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 14/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones de la
                 tabla de muestras tomadas a las mascotas

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
 *        de muestras tomadas a las mascotas
 */
class MuestrasMasc {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase
     */
    constructor(){

        // inicializamos las variables
        this.initMuestrasMasc();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables de clase
     */
    initMuestrasMasc(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos las variables
        this.Id = 0;                // clave del registro
        this.Mascota = 0;           // clave de la mascota
        this.Paciente = 0;          // clave del paciente
        this.Material = 0;          // clave del material recibido
        this.Tecnica = 0;           // clave de la técnica utilizada
        this.Fecha = "";            // fecha de recepción de la muestra
        this.Resultado = "";        // resultado de la muestra
        this.Determinacion = "";    // fecha de la determinación
        this.Usuario = "";          // nombre del usuario
        this.Alta = "";             // fecha de alta del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idmascota - clave de la mascota
     * @param {int} idpaciente - clave del paciente
     * Método llamado al cargar el formulario con los síntomas
     * de las mascotas que recibe como parámetro la clave
     * de la mascota y configura y carga la grilla
     */
    initGrillaMuestras(idmascota, idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        this.Mascota = idmascota;
        this.Paciente = idpaciente;

        // definimos el array de resultados
        let datosResultado = [{"valor": "Positivo"},
                              {"valor": "Negativo"},
                              {"valor": "Indeterminado"}];

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-muestrasmasc').datagrid({
            title: "Muestras tomadas a la mascota",
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
            url:'muestrasmasc/nomina.php?idmascota='+idmascota,
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Material',title:'Material',width:150,
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
                {field:'Tecnica',title:'Tecnica',width:150,
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
                {field:'Fecha',title:'Fecha',width:110,align:'center',
                    editor:{type:'datebox'}
                },
                {field:'Resultado',title:'Resultado',width:110,
                 editor:{type:'combobox',
                        options:{data: datosResultado,
                                 valueField: 'valor',
                                 textField: 'valor',
                                 panelHeight: 'auto'
                        }}},
                {field:'Determinacion',title:'Determ.',width:110,align:'center',
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
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla de muestras de
     * las mascotas que recibe como parámetro la clave de la
     * grilla y el nombre del campo pulsado, según el caso
     * habilita la edición o confirma la eliminación
     */
    eventoGrillaMuestras(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-muestrasmasc').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-muestrasmasc').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaMuestra(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // pedimos confirmación
            this.confirmaEliminar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-muestrasmasc').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón nuevo que agrega un
     * registro en blanco al inicio de la grilla
     */
    nuevaMuestra(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // agregamos un registro al inicio de la grilla
        $('#grilla-muestrasmasc').datagrid('insertRow',{
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
     * @param {int} index - clave de la grilla
     * Método llamado al pulsar el botón grabar que verifica
     * se hallan declarado los datos mínimos para identificar
     * una muestra
     */
    verificaMuestra(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición
        $('#grilla-muestrasmasc').datagrid('endEdit', index);

        // obtenemos la fila
        let row = $('#grilla-muestrasmasc').datagrid('getRows')[index];

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
     * Método que ejecuta la consulta de grabación y luego
     * recarga la grilla
     */
    grabaMuestra(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosMuestra = new FormData();

        // agregamos los elementos
        datosMuestra.append("Id", this.Id);
        datosMuestra.append("Mascota", this.Mascota);
        datosMuestra.append("Paciente", this.Paciente);
        datosMuestra.append("Material", this.Material);
        datosMuestra.append("Tecnica", this.Tecnica);
        datosMuestra.append("Fecha", this.Fecha);
        datosMuestra.append("Resultado", this.Resultado);
        datosMuestra.append("Determinacion", this.Determinacion);
        datosMuestra.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "muestrasmasc/grabar.php",
            type: "POST",
            data: datosMuestra,
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
                    $('#grilla-muestrasmasc').datagrid('reload');

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
     * @param {int} index - clave del registro
     * Método llamado al pulsar el botón eliminar que pide
     * confirmación antes de borrar el registro
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-muestrasmasc').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += "la determinacion " + row.Tecnica;
        mensaje += " de la muestra " + row.Material + "?";

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
     * @author Claudio Invernizzi <cinvernizzi@gmail.com>
     * @param {int} idmuestra - clave del registro
     * Método que ejecuta la consulta de eliminación
     */
    borraMuestra(idmuestra){

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "muestrasmasc/borrar.php?idmuestra="+idmuestra,
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
                    clase.initMuestrasMasc();

                    // recargamos la grilla
                    $('#grilla-muestrasmasc').datagrid('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

            }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con información del
     * uso del sistema
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
            title: "Ayuda de las Muestras de las Mascotas",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'muestrasmasc/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-muestras').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-muestras').window('center');

    }

}