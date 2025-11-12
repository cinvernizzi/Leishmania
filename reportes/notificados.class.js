/*

    Nombre: notificados.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 06/11/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que implementa la grilla y los eventos 
                 de los pacientes notificados al sisa

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
class Notificados {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente solicitando el año
     * a reportar de las muestras informadas al Sisa
     */
    anioNotificados(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos en el contenedor el formulario
        $("#form_reportes").load("reportes/notificados.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que inicializa la grilla con el reporte de los 
     * pacientes notificados al sisa
     */
    initGrillaNotificados(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos la clase
        let clase = this;
        
        // configuramos los controles
        $('#anionotificado').combobox({
            url: "reportes/anionotificados.php",
            valueField: 'Anio',
            textField: 'Anio',
            limitToList: true,
            panelHeigh: 100
        });
        $('#btnFiltraNotificados').linkbutton();
        $('#btnImprimeNotificados').linkbutton();

        // configuramos la grilla 
        $('#grilla-notificados').datagrid({
            title: "Pacientes notificados en el Sisa",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            remoteSort: false,
            pagination: true,
            rownumbers: false,
            emptyMsg: 'No hay pacientes notificados',
            onClickCell: function(index,field){
                clase.eventoGrillaNotificados(index, field);
            },
            url: 'reportes/nominanotificados.php',
            columns:[[
                {field:'Id',hidden:true},
                {field:'Fecha',title:'Fecha', width:80, align:'center'},
                {field:'Nombre',title:'Paciente', width:150, align:'left'},
                {field:'Documento',title:'Documento', width:120, align:'center'},
                {field:'Notificado',title:'Notificado', width:120, align:'center'},                
                {field:'Usuario',title:'Operador', width:120, align:'center'},                
                {field:'Editar',title:'Ver', width:50, align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index la clave de la grilla
     * @param {string} field el nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla que recibe como 
     * parámetros la clave de la grilla y el nombre del campo 
     * pulsado
     */
    eventoGrillaNotificados(index, field){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-notificados').datagrid('getRows')[index];

        // si se pulsó en editar
        if (field == "Editar"){

            // cargamos el registro del paciente
            pacientes.getDatosPaciente(row.Id);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón filtrar que verifica
     * se halla seleccionado un año y luego recarga la grilla
     */
    filtraRegistros(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fecha 
        let anio = $('#anionotificado').combobox('getValue');
        if (anio == ""){

            // presenta el mensaje 
            Mensaje ("Error", "Atención", "Debe indicar un año");

        // si seleccionó
        } else {

            // recargamos la grilla
            $('#grilla-notificados').datagrid('load', {
                anio: anio
            });

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que verifica se halla seleccionado el año a reportar y
     * genera el informe de las muestras y pacientes reportados
     * al Sisa
     */
    imprimeNotificados(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fecha 
        let anio = $('#anionotificado').combobox('getValue');
        if (anio == ""){

            // presenta el mensaje 
            Mensaje ("Error", "Atención", "Debe indicar un año");

        // si seleccionó
        } else {

            // definimos el contenido a agregar
            let winnotificados = "<div id='win-notificados'></div>";

            // agregamos la definición de la grilla al dom
            $("#form_reportes").append(winnotificados);

            // ahora abrimos el diálogo
            $('#win-notificados').window({
                title: "Pacientes Notificados en Sisa",
                modal:true,
                maximizable: true,
                width: 900,
                height: 600,
                closed: false,
                closable: true,
                href: 'reportes/notificados.php?anio='+anio,
                method: 'post',
                onClose:function(){$('#win-notificados').window('destroy');},
                cache: false,
                border: 'thin'
            });

            // centramos el diálogo
            $('#win-notificados').window('center');
        
        }

    }

}
