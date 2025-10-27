/*

    Nombre: dictecnicas.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 24/04/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido: Claudio Invernizzi <cinvernizzi@dsgestion.site>
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del dicccionario
                 de técnicas utilizadas

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// declaración de la clase
class DicTecnicas {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, llamamos la inicialización de
     * las variables
     */
    constructor(){

        // llamamos al constructor
        this.initTecnicas();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o luego de grabar
     * un registro que inicializa las variables de clase
     */
    initTecnicas(){

        // inicializamos las variables
        this.Id = 0;                  // clave del registro
        this.Tecnica = "";            // nombre de la técnica
        this.Alta = "";               // fecha de alta del registro
        this.Modificado = "";         // fecha de modificación
        this.Usuario = "";            // nombre del usuario
        this.NominaTecnicas = "";     // array con la nómina de técnicas

        // cargamos la matriz
        this.cargaNominaTecnicas();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor que define el
     * vector con el listado completo de técnicas quedando
     * disponible para el resto de la aplicación
     */
    cargaNominaTecnicas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el vector
        $.ajax({
            url: "tecnicas/nominadictecnicas.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // asignamos en la clase
                clase.NominaTecnicas = data.slice();

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú que carga en el formulario
     * de administración la grilla de las técnicas
     */
    verFormTecnicas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos en el contenedor la definición
        $("#form_administracion").load("tecnicas/grilladictecnicas.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la definición de la grilla
     * que inicializa los componentes
     */
    initGrillaTecnicas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-tecnicas').datagrid({
            title: "Técnicas Utilizadas",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevaTecnica();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaDicTecnica();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaTecnicas(index, field);
            },
            remoteSort: false,
            pagination: true,
            url:'tecnicas/nominadictecnicas.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Tecnica',title:'Técnica',width:150,
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
     * @param {int} index la clave de la grilla
     * @param {string} field el nombre del campo
     * Método llamado al pulsar sobre la grilla que recibe
     * como parámetro la clave de la fila y el nombre del
     * campo pulsado, a partir de allí desencadena la edición
     * o la eliminación del registro
     */
    eventoGrillaTecnicas(index, field){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-tecnicas').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-tecnicas').datagrid('endEdit', i);

        }

        // si pulsó en grabar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaTecnica(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // verificamos si puede eliminar
            this.puedeBorrar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-tecnicas').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón nueva técnica que
     * agrega un registro en blanco al inicio de la grilla
     */
    nuevaTecnica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // agregamos un registro al inicio de la grilla
        $('#grilla-tecnicas').datagrid('insertRow',{
	        index: 0,
	        row: {
		        Id: 0,
		        Tecnica: "",
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
     * datos del registro
     */
    verificaTecnica(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-tecnicas').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Tecnica = row.Tecnica;

        // si no declaró
        if (this.Material == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el nombre de la técnica");
            return;
        }

        // verificamos que no esté repetido
        this.validaTecnica();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado antes de grabar el registro que verifica
     * que el mismo no se encuentre repetido
     */
    validaTecnica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que el efecto no esté repetido
        $.ajax({
            url: "tecnicas/validadictecnica.php?id="+clase.Id+"&tecnica="+clase.Tecnica,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // grabamos el registro
                    clase.grabaTecnica();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Esa técnica ya está declarada");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación y luego
     * actualiza la grilla
     */
    grabaTecnica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosTecnica = new FormData();
        let clase = this;

        // agregamos los valores
        datosTecnica.append("Id", this.Id);
        datosTecnica.append("Tecnica", this.Tecnica);
        datosTecnica.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "tecnicas/grabadictecnica.php",
            type: "POST",
            data: datosTecnica,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Id != 0){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro Grabado ...");

                    // recargamos la grilla de efectos
                    $('#grilla-tecnicas').datagrid('reload');

                    // reiniciamos las variables
                    clase.initTecnicas();

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
     * Método llamado al pulsar borrar que verifica que la
     * técnica no tenga registros hijos
     */
    puedeBorrar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-tecnicas').datagrid('getRows')[index];

        // verificamos que no esté repetido
        $.ajax({
            url: "tecnicas/puedeborrar.php?id="+row.Id,
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
                    Mensaje("Error", "Atención", "Esa técnica tiene pacientes asociados");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método llamado antes de borrar que pide confirmación
     * al usuario
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-tecnicas').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar la técnica ';
        mensaje += row.Tecnica + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraTecnica(row.Id);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método que ejecuta la consulta de eliminación y luego
     * recarga la grilla
     */
    borraTecnica(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "tecnicas/borradictecnica.php?id="+id,
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
                    clase.initTecnicas();

                    // recargamos la grilla
                    $('#grilla-tecnicas').datagrid('reload');

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
    ayudaDicTecnica(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-tecnicas'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-tecnicas').window({
            title: "Diccionario de Técnicas Utilizadas",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,            
            href: 'tecnicas/ayudadic.html',
            method: 'post',
            onClose:function(){$('#ayuda-tecnicas').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-tecnicas').window('center');
        
    }
    
}
