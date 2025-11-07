/*

    Nombre: sinnotificar.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 07/11/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que presenta la grilla de los pacientes y 
                 mascotas con resultados cargados que aún no 
                 han sido notificados al sisa

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 */
class SinNotificar {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta la nómina de determinaciones realizadas
     * que aún no han sido notificadas al Sisa
     */
    sinNotificar(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos la grilla
        $("#form_reportes").load("reportes/grillasinnotificar.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la página con la definición 
     * de la grilla que configura la misma
     */
    initGrillaSinNotificar(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // configuramos la grilla 
        $('#grilla-sinnotificar').datagrid({
            toolbar: [{
                iconCls: 'icon-print',
                handler: function(){clase.imprimeSinNotificar();}
            }],
            title: "Pacientes sin Notificar al Sisa",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            remoteSort: false,
            pagination: true,
            rownumbers: false,
            onClickCell: function(index,field){
                clase.eventoGrillaSinNotificar(index, field);
            },
            url: 'reportes/nominasinnotificar.php',
            columns:[[
                {field:'Id',hidden:true},
                {field:'Fecha',title:'Fecha', width:80, align:'center'},
                {field:'Nombre',title:'Paciente', width:150, align:'left'},
                {field:'Documento',title:'Documento', width:120, align:'center'},
                {field:'Material',title:'Material', width:120, align:'left'},
                {field:'Tecnica',title:'Tecnica', width:100, align:'left'},
                {field:'FechaMuestra',title:'Muestra', width:100, align:'left'},
                {field:'Editar',title:'Ver', width:50, align:'center'}
            ]]
        });

        // configuramos la grilla de las mascotas
        $('#grilla-mascotassinnoti').datagrid({
            title: "Mascotas sin Notificar al Sisa",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            remoteSort: false,
            pagination: true,
            rownumbers: false,
            onClickCell: function(index,field){
                clase.eventoGrillaMascotas(index, field);
            },
            url: 'reportes/nominamascotassinnoti.php',
            columns:[[
                {field:'Id',hidden:true},
                {field:'Fecha',title:'Fecha', width:80, align:'center'},
                {field:'Nombre',title:'Paciente', width:150, align:'left'},
                {field:'Documento',title:'Documento', width:120, align:'center'},                
                {field:'Mascota',title:'Mascota', width:150, align:'left'},                
                {field:'Material',title:'Material', width:120, align:'left'},
                {field:'Tecnica',title:'Tecnica', width:100, align:'left'},
                {field:'FechaMuestra',title:'Muestra', width:100, align:'left'},
                {field:'Editar',title:'Ver', width:50, align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla que recibe 
     * como parámetro la clave de la fila y el nombre del 
     * campo pulsado
     */
    eventoGrillaSinNotificar(field, index){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-sinnotificar').datagrid('getRows')[index];

        // si se pulsó en editar
        if (field == "Editar"){

            // cargamos el registro del paciente
            pacientes.getDatosPaciente(row.Id);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo pulsado
     * Método llamado al pulsar sobre la grilla que recibe 
     * como parámetro la clave de la fila y el nombre del 
     * campo pulsado
     */
    eventoGrillaMascotas(field, index){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-mascotassinnoti').datagrid('getRows')[index];

        // si se pulsó en editar
        if (field == "Editar"){

            // cargamos el registro del paciente
            pacientes.getDatosPaciente(row.Id);

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón imprimir que abre el 
     * layer emergente y presenta el documento pdf
     */
    imprimeSinNotificar(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let winsinnoti = "<div id='win-sinnotificar'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_reportes").append(winsinnoti);

        // ahora abrimos el diálogo
        $('#win-sinnotificar').window({
            title: "Pacientes Sin Notificar",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'reportes/sinnotificar.php',
            method: 'post',
            onClose:function(){$('#win-sinnotificar').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-sinnotificar').window('center');

    }

}