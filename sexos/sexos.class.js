/*

    Nombre: sexos.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 13/11/2021
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Diagnóstico
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 sexos de pacientes

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
 *        de sexos
 */
class Sexos {

    // constructor de la clase
    constructor(){

        // declaramos la matriz
        this.nominaSexos = "";

        // cargamos la matriz
        this.cargaSexos();

        // inicializamos las variables
        this.initSexos();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa las variables de clase
     */
    initSexos(){

        // inicializamos las variables
        this.Id = 0;                    // clave del registro
        this.Sexo = "";                 // nombre del sexo
        this.Usuario = "";              // nombre del usuario
        this.Fecha = "";                // fecha de alta
        this.ClaveGrilla = "";          // clave de la grilla

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que carga la matriz de sexos en la variable
     * de clase, con ello está disponible tanto para la
     * clase como para el resto del sistema
     */
    cargaSexos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // cargamos la matriz
        $.ajax({
            url: "sexos/nominasexos.php",
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.length != 0){

                    // cargamos la matriz
                    clase.nominaSexos = data.slice();

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú que carga la definición
     * de la grilla
     */
     verGrillaSexos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos el formulario
        $("#form_administracion").load("sexos/grillasexos.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición de la
     * grilla que inicializa los componentes y carga el
     * diccionario de sexos declarados
     */
     initGrillaSexos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase y asignamos el usuario
        let clase = this;

        // definimos la tabla
        $('#grilla-sexos').datagrid({
            title: "Pulse sobre una entrada para editarla",
            toolbar: [{
                iconCls: 'icon-edit',
                handler: function(){clase.formSexos();}
            },'-',{
                iconCls: 'icon-help',
                handler: function(){clase.ayudaSexos();}
            }],
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaSexos(index, field);
            },
            remoteSort: false,
            pagination: true,
            data: clase.nominaSexos,
            columns:[[
                {field:'idsexo',title:'Id',width:50,align:'center'},
                {field:'sexo',title:'Sexo',width:120,sortable:true},
                {field:'usuario',title:'Usuario',width:100,align:'center'},
                {field:'fecha',title:'Fecha',width:100,align:'center'},
                {field:'editar',width:50,align:'center'},
                {field:'borrar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo
     * Método llamado al pulsar sobre la grilla que recibe
     * la clave del registro y el nombre del campo pulsado
     * según este último valor, llama el método de
     * edición o de eliminación
     */
     eventoGrillaSexos(index, field){

        // verificamos el nivel de acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-sexos').datagrid('getRows')[index];

        // si pulsó en editar
        if (field == "editar"){

            // asignamos la clave
            this.ClaveGrilla = index;

            // presentamos el registro
            this.getDatosSexo(row);

        // si pulsó sobre borrar
        } else if (field == "borrar"){

            // eliminamos
            this.puedeBorrar(row, index);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} row - vector con el registro
     * Método que recibe como parámetro la clave de la
     * grilla y obtiene los valores del registro
     */
     getDatosSexo(row){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en las variables de clase
        this.Id = row.idsexo;
        this.Sexo = row.sexo;
        this.Fecha = row.fecha;
        this.Usuario = row.usuario;

        // cargamos el formulario
        this.formSexos();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el formulario emergente de los
     * sexos declarados
     */
     formSexos(){

        // verificamos el acceso
        if (!seguridad.verificaAcceso()){
            return;
        }

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar en el formulario
        let formulario = "<div id='win-sexos'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-sexos').window({
            width:450,
            height:190,
            modal:true,
            title: "Sexos Declarados",
            minimizable: false,
            closable: true,
            href: 'sexos/formsexos.html',
            onClose:function(){clase.cerrarEmergente();},
            border: 'thin'
        });

        // centramos el formulario
        $('#win-sexos').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa los componentes del
     * formulario de sexos declarados
     */
     initFormSexos(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los componentes
        $('#idsexo').textbox();
        $('#nombresexo').textbox();
        $('#usuariosexo').textbox();
        $('#fechasexo').textbox();
        $('#btnGrabarSexo').linkbutton();
        $('#btnCancelarSexo').linkbutton();

        // si está editando
        if (this.Id != 0){

            // cargamos los valores
            $('#idsexo').textbox('setValue', this.Id);
            $('#nombresexo').textbox('setValue', this.Sexo);
            $('#usuariosexo').textbox('setValue', this.Usuario);
            $('#fechasexo').textbox('setValue', this.Fecha);

        // si está insertando
        } else {

            // configuramos la fecha y el usuario
            $('#usuariosexo').textbox('setValue', sessionStorage.getItem("Usuario"));
            $('#fechasexo').textbox('setValue', fechaActual());

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que verifica el formulario antes de
     * enviar los datos al servidor
     */
     verificaSexo(){

        // si está editando
        if ($('#idsexo').textbox('getValue') != ""){
            this.Id = $('#idsexo').textbox('getValue');
        } else {
            this.Id = 0;
        }

        // verifica el nombre del sexo
        if ($('#nombresexo').textbox('getValue') != ""){
            this.Sexo = $('#nombresexo').textbox('getValue');
        } else {

            // presenta el mensaje
            Mensaje("Error", "Atención", "Ingrese la descripción");
            return;

        }

        // si está insertando
        if (this.Id == 0){
            this.validaSexo();
        } else {
            this.grabaSexo();
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado en el caso de un alta que verifica
     * que el sexo no esté repetido
     */
     validaSexo(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que la compañia no esté repetida
        $.ajax({
            url: "sexos/validasexo.php?sexo="+clase.Sexo,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Registros){

                    // grabamos el registro
                    clase.grabaSexo();

                // si está repetida
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Sexo ya declarado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
     grabaSexo(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos el formulario
        let datosSexo = new FormData();

        // declaramos la clase
        let clase = this;

        // agregamos los elementos
        datosSexo.append("Id", this.Id);
        datosSexo.append("Sexo", this.Sexo);
        datosSexo.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "sexos/grabasexo.php",
            type: "POST",
            data: datosSexo,
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
                        $('#grilla-sexos').datagrid('appendRow',{
                            idsexo: data.Id,
                            sexo: clase.Sexo,
                            usuario: sessionStorage.getItem("Usuario"),
                            fecha: fechaActual(),
                            editar: "<img src='imagenes/meditar.png'>",
                            borrar: "<img src='imagenes/borrar.png'>"
                        });

                    // si está editando
                    } else {

                        // actualizamos la grilla
                        $('#grilla-sexos').datagrid('updateRow', {
                            index: clase.ClaveGrilla,
                            row: {idsexo:clase.Id,
                                  sexo:clase.Sexo,
                                  usuario: sessionStorage.getItem("Usuario"),
                                  fecha: fechaActual(),
                                  editar: "<img src='imagenes/meditar.png'>",
                                  borrar: "<img src='imagenes/borrar.png'>"
                                }
                            });

                    }

                    // cerramos el layer
                    clase.cerrarEmergente();

                    // recargamos la grilla
                    clase.cargaSexos();

                    // actualizamos el select de pacientes
                    $('#sexopaciente').combobox('reload');

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
     * Método que verifica que el registro no tenga
     * hijos
     */
     puedeBorrar(fila, index){

        // reiniciamos la sesion
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos que no esté repetido
        $.ajax({
            url: "sexos/puedeborrar.php?id="+fila.idsexo,
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
                    Mensaje("Error", "Atención", "Sexo con registros asociados");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que pide confirmación antes de eliminar el
     * registro
     */
     confirmaEliminar(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // declaramos las variables
        let mensaje = 'Está seguro que desea eliminar el ';
        mensaje += 'sexo ' + fila.sexo + '?';

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                            mensaje,
                            function(r){
                                if (r){
                                    clase.borraSexo(fila, index);
                                }
                            });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} fila - vector con el registro
     * @param {int} index - clave de la grilla
     * Método que ejecuta la consulta de eliminación
     */
    borraSexo(fila, index){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // eliminamos el registro
        $.ajax({
            url: "sexos/borrar.php?id="+fila.idsexo,
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
                    $('#grilla-sexos').datagrid('deleteRow', index);

                    // recargamos la matriz
                    clase.cargaSexos();

                    // recargamos el select de filiación
                    $('#sexopaciente').combobox('reload');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método genérico que cierra el layer emergente de
     * búsquedas
     */
     cerrarEmergente(){

        // reiniciamos las variables
        this.initSexos();

        // cerramos el layer
        $('#win-sexos').window('destroy');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta la ayuda para el abm de órganos
     */
    ayudaSexos(){

        // reiniciamos
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // definimos el contenido a agregar en el formulario
        let formulario = "<div id='win-sexos'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_administracion").append(formulario);

        // definimos el diálogo y lo mostramos
        $('#win-sexos').window({
            width:750,
            height:650,
            modal:true,
            title: "Ayuda Sexos",
            minimizable: false,
            closable: true,
            onClose:function(){clase.cerrarEmergente();},
            href: 'sexos/ayuda.html',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-sexos').window('center');

    }

}
