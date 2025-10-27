/*

    Nombre: dicmaterial.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 22/02/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido: Claudio Invernizzi <cinvernizzi@dsgestion.site>
    Licencia: GPL
    Comentarios: Clase que control la presentación de datos
                 del diccionario de materiales recibidos

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// declaración de la clase
class DicMaterial {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, definimos e inicializamos las
     * variables
     */
    constructor(){

        // inicializamos las variables
        this.initDicMaterial();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o luego de grabar
     * un registro que inicializa las variables de clase
     */
    initDicMaterial(){

        // declaramos las variables
        this.Id = 0;                // clave del registro
        this.Material = "";         // descripción del material
        this.Alta = "";             // fecha de alta del registro
        this.Modificado = "";       // fecha de modificación del registro
        this.Usuario = "";          // usuario que ingresó el registro
        this.NominaMateriales = ""; // vector con el diccionario de materiales

        // cargamos el diccionario de materiales para
        // disponibilizarlo en el resto de la aplicación
        this.cargaDicMateriales();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o luego de
     * editar, actualizar o eliminar un registro que
     * carga en la variable pública el vector con el
     * diccionario de materiales
     */
    cargaDicMateriales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos los registros
        $.ajax({
            url: "material/nominadicmaterial.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.length != 0){

                    // cargamos en la variable pública
                    clase.NominaMateriales = data.slice();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú que presenta en el
     * contenedor la grilla con la nómina de materiales
     */
    verFormMateriales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos en el contenedor la definición
        $("#form_administracion").load("material/grilladicmaterial.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la grilla de materiales que
     * carga el diccionario
     */
    initGrillaMateriales(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos la tabla
        $('#grilla-materiales').datagrid({
            title: "Materiales remitidos",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.nuevoMaterial();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaMaterial();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaMateriales(index, field);
            },
            remoteSort: false,
            pagination: true,
            url:'material/nominadicmaterial.php',
            columns:[[
                {field:'Id',title:'Id',width:50,align:'center'},
                {field:'Material',title:'Material',width:150,
                        editor:{type:'textbox'}
                },
                {field:'Alta',title:'Alta',width:100,align:'center'},
                {field:'Modificado',title:'Modificado',width:100,align:'center'},
                {field:'Usuario',title:'Usuario',width:100,align:'center'},
                {field:'Editar',width:50,align:'center'},
                {field:'Borrar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index clave de la fila de la grilla
     * @param {string} field nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla que
     * recibe como parámetro la clave del registro y
     * el nombre del campo pulsado
     */
    eventoGrillaMateriales(index, field){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // cerramos la edición en todas las filas
        let filas = $('#grilla-materiales').datagrid('getRows').length;

        // iniciamos un bucle
        for (let i = 0; i < filas; i++){

            // cerramos la edición por las dudas
            $('#grilla-materiales').datagrid('endEdit', i);

        }

        // si pulsó en editar
        if (field == "Editar"){

            // verificamos el registro
            this.verificaMaterial(index);

        // si pulsó sobre borrar
        } else if (field == "Borrar"){

            // verificamos si puede eliminar
            this.puedeBorrar(index);

        // si pulsó en cualquier otro campo
        } else {

            // activamos la edición
            $('#grilla-materiales').datagrid('beginEdit', index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar sobre el ícono nuevo de la
     * grilla que agrega un elemento en blanco y activa la
     * edición
     */
    nuevoMaterial(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // agregamos un registro al inicio de la grilla
        $('#grilla-materiales').datagrid('insertRow',{
	        index: 0,
	        row: {
		        Id: 0,
		        Material: "",
		        Alta: fechaActual(),
                Modificado: fechaActual(),
                Usuario: sessionStorage.getItem("Usuario"),
                Editar: "<img src='imagenes/save.png'>",
                Borrar: "<img src='imagenes/borrar.png'>"
	        }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método llamado al pulsar sobre el ícono grabar que
     * desactiva la edición y verifica los datos del registro
     * antes de enviarlo al servidor
     */
    verificaMaterial(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-materiales').datagrid('getRows')[index];

        // asignamos la clave
        this.Id = row.Id;
        this.Material = row.Material;

        // si no declaró
        if (this.Material == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el nombre del material");
            return;

        }

        // verificamos que no esté repetido
        this.validaMaterial();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que a partir de las variables de clase verifica
     * que el registro no se encuentre repetido
     */
    validaMaterial(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que el efecto no esté repetido
        $.ajax({
            url: "material/validadicmaterial.php?id="+clase.Id+"&material="+clase.Material,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // grabamos el registro
                    clase.grabaMaterial();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese material ya está declarado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en la base
     */
    grabaMaterial(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos las variables
        let datosMaterial = new FormData();
        let clase = this;

        // agregamos los valores
        datosMaterial.append("Id", this.Id);
        datosMaterial.append("Material", this.Material);
        datosMaterial.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos
        $.ajax({
            url: "material/grabadicmaterial.php",
            type: "POST",
            data: datosMaterial,
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
                    $('#grilla-materiales').datagrid('reload');

                    // reiniciamos las variables y recargamos 
                    // el diccionario
                    clase.initDicMaterial();

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
     * Método que recibe como parámetro la clave de la grilla
     * y verifica que el registro pueda ser eliminado
     */
    puedeBorrar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-materiales').datagrid('getRows')[index];

        // verificamos que no esté repetido
        $.ajax({
            url: "material/puedeborrardic.php?id="+row.Id,
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
                    Mensaje("Error", "Atención", "Ese material tiene muestras asociadas");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * Método que recibe como parámetro la clave de la grilla
     * y pide confirmación antes de eliminar el registro
     */
    confirmaEliminar(index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos la fila
        let row = $('#grilla-materiales').datagrid('getRows')[index];

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar el material ';
        mensaje += row.Material + "?";

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraMaterial(row.Id);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id clave del registro
     * Método llamado luego de confirmar que recibe como
     * parámetro la clave del registro y ejecuta la consulta
     * de eliminación
     */
    borraMaterial(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "material/borradicmaterial.php?id="+id,
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
                    clase.initDicMaterial();

                    // recargamos la grilla
                    $('#grilla-materiales').datagrid('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente presentando la ayuda
     * del sistema
     */
    ayudaMaterial(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-materiales'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-materiales').window({
            title: "Diccionario de Materiales Recibidos",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'material/ayudadic.html',
            method: 'post',
            onClose:function(){$('#ayuda-materiales').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-materiales').window('center');

    }

}
