/*

    Nombre: animales.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 31/07/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 animales y objetos del peridomicilio

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
 *        de animales y objetos del diccionario del peridomicilio
 */
class Animales {

    // constructor de la clase
    constructor(){

        // inicializamos
        this.initAnimales();

        // cargamos la nómina
        this.cargaNominaAnimales();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que inicializa las
     * variables
     */
    initAnimales(){

        // declaramos las variables
        this.Id = 0;                // clave del registro
        this.Animal = "";           // descripción del animal y objetos
        this.Usuario = "";          // nombre del usuario
        this.Alta = "";             // fecha de alta del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que define el
     * vector con el listado completo de animales del
     * peridomicilio quedando disponible para el resto
     * de la aplicación
     */
    cargaNominaAnimales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el vector
        $.ajax({
            url: "animales/nomina.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // asignamos en la clase
                clase.NominaAnimales = data.slice();

            }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú principal que carga en el
     * contenedor la grilla con el diccionario de animales
     */
    verGrillaAnimales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos en el contenedor la definición
        $("#form_administracion").load("animales/grillaanimales.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la definición de la grilla que
     * la inicializa
     */
    initGrillaAnimales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-animales').datagrid({
            title: "Diccionario del Peridomicilio",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevoAnimal();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaAnimal();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaAnimales(index, field);
            },
            remoteSort: false,
            pagination: true,
            url:'animales/nomina.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Animal',title:'Animal',width:150,
                    editor:{type:'textbox'}
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
     * Método llamado al pulsar sobre el botón nuevo que
     * agrega un registro en blanco a la grilla
     */
    nuevoAnimal(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // agregamos un registro al inicio de la grilla
        $('#grilla-animales').datagrid('insertRow',{
            index: 0,
            row: {
                Id: 0,
                Animal: "",
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
     * @param [string] field - nombre del campo
     * Método llamado al pulsar sobre la grilla que recibe
     * como parámetros la clave de la grilla y el nombre
     * del campo pulsado, desencadena la grabación, edición
     * o eliminación según el valor de este último
     */
    eventoGrillaAnimales(index, field){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-animales').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-animales').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaAnimal(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // verificamos si puede eliminar
            this.puedeBorrar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-animales').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método llamado al pulsar el botón grabar que verifica
     * los datos de la grilla antes de enviarlos al servidor
     */
    verificaAnimal(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-animales').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Animal = row.Animal;

        // si no declaró
        if (this.Animal == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique la descripción");
            return;
        }

        // verificamos que no esté repetido
        this.validaAnimal();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de verificar los datos de la grilla
     * que valida que no esté repetido el registro
     */
    validaAnimal(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "animales/validar.php?id="+clase.Id+"&animal="+clase.Animal,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // grabamos el registro
                    clase.grabaAnimal();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa elemento ya está declarado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
    grabaAnimal(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosAnimal = new FormData();
        let clase = this;

        // agregamos los valores
        datosAnimal.append("Id", this.Id);
        datosAnimal.append("Animal", this.Animal);
        datosAnimal.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "animales/grabar.php",
            type: "POST",
            data: datosAnimal,
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
                    $('#grilla-animales').datagrid('reload');

                    // reiniciamos las variables
                    clase.cargaNominaAnimales();

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
     * Método llamado al pulsar el botón borrar que verifica
     * que el registro no tenga hijos
     */
    puedeBorrar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-animales').datagrid('getRows')[index];

        // verificamos que no esté repetido
        $.ajax({
            url: "animales/puedeborrar.php?id="+row.Id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si puede borrar
                if (data.Resultado){

                    // pedimos confirmación
                    clase.confirmaEliminar(index);

                // si encontró registros
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa elemento tiene pacientes asociados");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método que pide confirmación antes de eliminar el
     * registro
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-animales').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar ';
        mensaje += row.Animal + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraAnimal(row.Id);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que ejecuta la consulta de eliminación y luego
     * recarga la grilla
     */
    borraAnimal(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "animales/borrar.php?id="+id,
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
                    clase.initAnimales();

                    // recargamos la grilla
                    $('#grilla-animales').datagrid('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón ayuda que abre el
     * layer emergente con la ayuda del sistema
     */
    ayudaAnimal(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-animales'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-animales').window({
            title: "Diccionario de Peridomicilio",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'animales/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-animales').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-animales').window('center');

    }

}
