/*

    Nombre: sindeterminacion.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 07/11/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que presenta la nómina de determinaciones
                 sin resultados

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
class SinDeterminacion {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que presenta la nómina de muestras pendientes de
     * determinación
     */
    sinDeterminacion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // cargamos en el contenedor el documento pdf
        $("#form_reportes").load("reportes/grillasindeterminacion.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la página con la definición 
     * de la grilla que configura la misma
     */
    initGrillaSinDeterminacion(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // definimos la clase
        let clase = this;

        // configuramos la grilla 
        $('#grilla-sindeterminacion').datagrid({
            toolbar: [{
                iconCls: 'icon-print',
                handler: function(){clase.imprimeSinDeterminacion();}
            }],
            title: "Pacientes sin Determinaciones Cargadas",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            remoteSort: false,
            pagination: true,
            rownumbers: false,
            onClickCell: function(index,field){
                clase.eventoGrillaSinDeterminacion(index, field);
            },
            url: 'reportes/nominasindeterminacion.php',
            columns:[[
                {field:'Id',hidden:true},
                {field:'Fecha',title:'Fecha', width:80, align:'center'},
                {field:'Nombre',title:'Paciente', width:150, align:'left'},
                {field:'Documento',title:'Documento', width:120, align:'center'},
                {field:'FechaMuestra',title:'Muestra', width:100, align:'left'},
                {field:'Usuario',title:'Operador', width:100, align:'left'},
                {field:'Editar',title:'Ver', width:50, align:'center'}
            ]]
        });

        // configuramos la grilla de las mascotas
        $('#grilla-mascotassindet').datagrid({
            title: "Mascotas sin Determinaciones Cargadas",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            remoteSort: false,
            pagination: true,
            rownumbers: false,
            onClickCell: function(index,field){
                clase.eventoGrillaMascotas(index, field);
            },
            url: 'reportes/nominamascotassindet.php',
            columns:[[
                {field:'Id',hidden:true},
                {field:'Fecha',title:'Fecha', width:80, align:'center'},
                {field:'Nombre',title:'Paciente', width:150, align:'left'},
                {field:'Documento',title:'Documento', width:120, align:'center'},                
                {field:'Mascota',title:'Mascota', width:150, align:'left'},                
                {field:'FechaMuestra',title:'Muestra', width:100, align:'left'},                                
                {field:'Usuario',title:'Operador', width:100, align:'left'},                                
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
    eventoGrillaSinDeterminacion(field, index){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // obtenemos la fila
        let row = $('#grilla-sindeterminacion').datagrid('getRows')[index];

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
        let row = $('#grilla-mascotassindet').datagrid('getRows')[index];

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
    imprimeSinDeterminacion(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let winsindeter = "<div id='win-sindeter'></div>";

        // agregamos la definición de la grilla al dom
        $("#form_reportes").append(winsindeter);

        // ahora abrimos el diálogo
        $('#win-sindeter').window({
            title: "Pacientes Sin Determinaciones",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'reportes/sindeterminacion.php',
            method: 'post',
            onClose:function(){$('#win-sindeter').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#win-sindeter').window('center');

    }

}
