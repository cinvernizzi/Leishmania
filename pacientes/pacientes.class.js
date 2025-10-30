/*

    Nombre: pacientes.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 26/05/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido: Claudio Invernizzi <cinvernizzi@dsgestion.site>
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del formulario
                 de pacientes

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// declaración de la clase
class Pacientes {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, llama la inicialización
     * de las variables y carga la definición del formulario
     * en el contenedor
     */
    constructor(){

        // inicializamos
        this.initPacientes();

        // cargamos en el contenedor el formulario
        $("#form-filiacion").load("pacientes/formpacientes.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o cuando se ejecuta
     * una consulta de eliminación o inserción que limpia
     * las variables de clase
     */
    initPacientes(){

        // inicializamos las variables
        this.Id = 0;                     // clave del registro
        this.Fecha = "";                 // fecha de la visita
        this.Nombre = "";                // nombre del paciente
        this.Documento = "";             // número de documento
        this.TipoDoc = 0;                // clave del tipo de documento
        this.Sexo = 0;                   // clave del sexo
        this.Edad = 0;                   // edad en años
        this.Nacimiento = "";            // fecha de nacimiento
        this.CodLoc = "";                // clave indec de la localidad
        this.Coordenadas = "";           // coordenadas gps
        this.Domicilio = "";             // domicilio postal
        this.Urbano = "";                // tipo de domicilio
        this.TelPaciente = "";           // teléfono del paciente
        this.IdOcupacion = 0;            // clave de la ocupación
        this.IdInstitucion = 0;          // clave de la institución
        this.Enviado = "";               // quien envió la muestra
        this.Mail = "";                  // mail de quien envía la muestra
        this.Telefono = "";              // teléfono de quien envía la muestra
        this.Antecedentes = "";          // antecedentes clínicos del paciente
        this.Notificado = "";            // fecha notificación sisa
        this.Sisa = "";                  // clave de la notificación sisa
        this.Usuario = "";               // nombre del usuario
        this.Alta = "";                  // fecha de alta del registro
        this.Modificado = "";            // fecha de modificación del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar el formulario de datos
     * que lo configura
     */
    initFormPacientes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // configuramos los controles
        $('#idpaciente').textbox();
        $('#ingresopaciente').datebox({
            required:true,
            width: "120px"
        });
        $('#nombrepaciente').textbox();
        $('#tipodocumento').combobox({
            url: "documentos/nominadocumentos.php",
            valueField: 'iddocumento',
            textField: 'descripcion',
            panelHeight: 'auto'
        });
        $('#documentopaciente').numberbox();
        $('#sexopaciente').combobox({
            url: "sexos/nominasexos.php",
            valueField: 'idsexo',
            textField: 'sexo',
            panelHeight: 'auto'
        });
        $('#nacimientopaciente').datebox({
            width: "120px"
        });
        $('#edadpaciente').numberspinner({
            min: 1
        });
        $('#paispaciente').combobox({
            url: 'paises/nominapaises.php',
            valueField: 'idpais',
            textField: 'pais',
            panelHeigh: 'auto',
            onSelect: function(rec){
                let url="jurisdicciones/nominajurisdicciones.php?idpais="+rec.idpais;
                $('#provinciapaciente').combobox('reload', url);
            }
        });
        $('#provinciapaciente').combobox({
            valueField: 'idprovincia',
            textField: 'provincia',
            panelHeigh: 'auto',
            onSelect: function(rec){
                let url="localidades/nominalocalidades.php?codprov="+rec.idprovincia;
                $('#localidadpaciente').combobox('reload', url);
            }
        });
        $('#localidadpaciente').combobox({
            valueField: 'idlocalidad',
            textField: 'localidad',
            panelHeigh: 'auto'
        });
        $('#domiciliopaciente').textbox({
            onChange: function(){
                clase.getCoordenadas();
            }
        });
        $('#telpaciente').textbox();
        $('#tipodomicilio').combobox({
            panelHeight: 'auto'
        });
        $('#ocupacionpaciente').combobox({
            url: "ocupaciones/nominaocupaciones.php",
            valueField:'id',
            textField:'ocupacion',
            panelHeight: 'auto'
        });
        $('#provinciainstitucion').combobox({
            valueField: 'idprovincia',
            textField: 'provincia',
            url: 'jurisdicciones/nominajurisdicciones.php?idpais=1',
            panelHeigh: 'auto',
            onSelect: function(rec){
                let url="localidades/nominalocalidades.php?codprov="+rec.idprovincia;
                $('#localidadinstitucion').combobox('reload', url);
            }
        });
        $('#localidadinstitucion').combobox({
            valueField: 'idlocalidad',
            textField: 'localidad',
            panelHeigh: 'auto',
            onSelect: function(rec){
                let url="instituciones/institucioneslocalidad.php?codloc="+rec.idlocalidad;
                $('#institucionpaciente').combobox('reload', url);
            }
        });
        $('#institucionpaciente').combobox({
            valueField: 'Id',
            textField: 'Institucion',
            panelHeigh: 'auto'
        });
        $('#profesionalpaciente').textbox();
        $('#mailpaciente').textbox();
        $('#telefonoprofesional').textbox();
        $('#notificacionpaciente').datebox({
            width: "120px"
        });
        $('#sisapaciente').textbox();
        $('#antecedentespaciente').texteditor();
        $('#usuariopaciente').textbox();
        $('#altapaciente').textbox();
        $('#modificadopaciente').textbox();
        $('#btnGrabarPaciente').linkbutton();
        $('#btnCancelarPaciente').linkbutton();

        // fijamos los valores por defecto
        $('#usuariopaciente').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altapaciente').textbox('setValue', fechaActual());
        $('#modificadopaciente').textbox('setValue', fechaActual());

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar la opción buscar del menú
     * que abre el cuadro de diálogo solicitando el texto
     * a buscar
     */
    buscaPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // pedimos el texto
        $.messager.prompt({
            title: 'Buscar Paciente',
            msg: 'Ingrese el documento o parte del nombre del paciente:',
            fn: function(r){
                if (r){
                    clase.encuentraPaciente(r);
                }
            }
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} texto - cadena a buscar
     * Método que recibe como parámetro el texto a buscar
     * y ejecuta la consulta en el servidor, en caso de
     * no encontrar resultados presenta el alerta y si
     * encontró registros llama la rutina de presentación
     * de la grilla pasándole el vector con los registros
     */
    encuentraPaciente(texto){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        this.Texto = texto;

        // definimos el contenido a agregar
        let formulario = "<div id='win-pacientes'>" +
                         "</div>";

        // agregamos la definición de la grilla al dom
        $("#form-filiacion").append(formulario);

        // abrimos el layer presentando el protocolo
        $('#win-pacientes').window({
            width:850,
            height:500,
            modal:true,
            title: "Búsqueda de Pacientes",
            minimizable: false,
            closable: true,
            href:'pacientes/grilla-pacientes.html',
            onClose:function(){$('#win-pacientes').window('destroy');},
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-pacientes').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición del
     * layer emergente, que configura la grilla y carga
     * los registros coincidentes
     */
    initGrillaPacientes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // configuramos la grilla
        $('#grilla-pacientes').datagrid({
            title: "Pacientes encontrados",
            loadMsg: 'Cargando ...',
            singleSelect: true,
            onClickCell: function(index,field){
                clase.eventoGrillaPacientes(index, field);
            },
            remoteSort: false,
            pagination: true,
            url: 'pacientes/buscapaciente.php?texto='+clase.Texto,
            columns:[[
                {field:'Id',title:'Id',width:100,align:'center'},
                {field:'Nombre',title:'Nombre',width:250,sortable:true},
                {field:'Documento',title:'Documento',width:100,sortable:true},
                {field:'Institucion',title:'Institucion',width:150,sortable:true},
                {field:'Enviado',title:'Envió',width:150,sortable:false},
                {field:'Editar',width:50,align:'center'}
            ]]
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} index - clave de la grilla
     * @param {string} field - nombre del campo
     * Método llamado al pulsar sobre la grilla de pacientes
     * encontrados que recibe como parámetro la clave de la
     * grilla y el nombre del campo pulsado, en función de
     * esto desencadena la presentación del registro
     */
    eventoGrillaPacientes(index, field){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la fila seleccionada
        let row = $('#grilla-pacientes').datagrid('getRows')[index];

        // si se pulsó sobre editar
        if (field == "Editar"){

            // mostramos el registro
            this.getDatosPaciente(row.Id);

            // destruimos el layer
            $('#win-pacientes').window('destroy');

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método llamado al pulsar sobre el botón editar en
     * la grilla que obtiene los datos del registro y
     * luego presenta los datos
     */
    getDatosPaciente(id){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "pacientes/getpaciente.php?id="+id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Id != 0){

                    // mostramos el registro
                    clase.verDatosPaciente(data);

                // de otra forma
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos vector con los datos del registro
     * Método llamado luego de obtener los datos del
     * paciente, que recibe como parámetro el registro y
     * lo presenta en el formulario
     */
    verDatosPaciente(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        /*
         *
         * El usar el evento on loadsuccess en los combos nos
         * garantiza que al actualizar que solo seleccionará
         * el valor correspondiente luego de haber cargado la
         * nómina
         *
        */

        // cargamos en el formulario
        $('#idpaciente').textbox('setValue', datos.Id);
        $('#ingresopaciente').datebox('setValue', datos.Fecha);
        $('#nombrepaciente').textbox('setValue', datos.Nombre);
        $('#tipodocumento').combobox('setValue', datos.IdTipoDoc);
        $('#sexopaciente').combobox('setValue', datos.IdSexo);
        $('#documentopaciente').numberbox('setValue', datos.Documento);
        $('#edadpaciente').numberspinner('setValue', datos.Edad);
        $('#paispaciente').combobox('setValue', datos.IdNacionalidad);
        $('#provinciapaciente').combobox({
            onLoadSuccess: function(){
                $('#provinciapaciente').combobox('setValue', datos.IdProvincia);
            }});
        $('#localidadpaciente').combobox({
            onLoadSuccess: function(){
                $('#localidadpaciente').combobox('setValue', datos.LocNacimiento);
            }});
        document.getElementById("coordenadaspaciente").value = datos.Coordenadas;
        this.Coordenadas = datos.Coordenadas;
        $('#domiciliopaciente').textbox('setValue', datos.Domicilio);
        $('#tipodomicilio').combobox('setValue', datos.Urbano);
        $('#ocupacionpaciente').combobox('setValue', datos.IdOcupacion);
        $('#telpaciente').textbox('setValue', datos.TelPaciente);
        $('#provinciainstitucion').combobox({
            onLoadSuccess: function(){
                $('#provinciainstitucion').combobox('setValue', datos.CodProvInstitucion);
            }});
        $('#localidadinstitucion').combobox({
            onLoadSuccess: function(){
                $('#localidadinstitucion').combobox('setValue', datos.CodLocInstitucion);
            }});
        $('#institucionpaciente').combobox({
            onLoadSuccess: function(){
                $('#institucionpaciente').combobox('setValue', datos.IdInstitucion);
            }});
        $('#profesionalpaciente').textbox('setValue', datos.Enviado);
        $('#mailpaciente').textbox('setValue', datos.Mail);
        $('#telefonoprofesional').textbox('setValue', datos.Telefono);
        $('#notificacionpaciente').datebox('setValue', datos.Notificado);
        $('#sisapaciente').textbox('setValue', datos.Sisa);
        $('#antecedentespaciente').texteditor('setValue', datos.Antecedentes);
        $('#usuariopaciente').textbox('setValue', datos.Usuario);
        $('#altapaciente').textbox('setValue', datos.Alta);
        $('#modificadopaciente').textbox('setValue', datos.Modificado);

        // cargamos los formularios hijos
        this.cargaFormHijos(datos.Id);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} id - clave del registro
     * Método llamado al cargar un registro o luego de insertar
     * un paciente, que carga en los formularios hijos los
     * datos existentes del paciente, si no hay datos, inicializa
     * la clave del paciente en las clases heredadas
     */
    cargaFormHijos(id){

        // asignamos en las clases hijas
        muestras.cargaMuestras(id);
        clinica.getDatosClinica(id);
        actividades.cargaActividades(id);
        viajes.cargaViajes(id);
        evolucion.getDatosEvolucion(id);
        control.getDatosControl(id);
        mascotas.cargaMascotas(id);
        peridomicilio.cargaPeridomicilio(id);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón grabar que verifica
     * los datos del formulario antes de enviarlo al servidor
     */
    verificaPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // obtenemos la clave
        if ($('#idpaciente').textbox('getValue') == ""){
            this.Id = 0;
        } else {
            this.Id = $('#idpaciente').textbox('getValue');
        }

        // verifica la fecha de ingreso
        this.Fecha = $('#ingresopaciente').datebox('getValue');
        if (this.Fecha == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique la fecha de ingreso de la muestra");
            return;

        }

        // verifica el nombre
        this.Nombre = $('#nombrepaciente').textbox('getValue');
        if (this.Nombre == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Indique el nombre del paciente");
            return;

        }

        // el documento lo permite en blanco
        this.Documento = $('#documentopaciente').textbox('getValue');

        // el tipo de documento lo permite en blanco
        this.IdTipoDoc = $('#tipodocumento').combobox('getValue');

        // el sexo del paciente
        this.IdSexo = $('#sexopaciente').combobox('getValue');
        if (this.IdSexo == "" || this.IdSexo == 0){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Seleccione el sexo del paciente");
            return;

        }

        // la fecha de nacimiento la permite en blanco
        this.Nacimiento = $('#nacimientopaciente').datebox('getValue');

        // la edad la permite en blanco
        this.Edad = $('#edadpaciente').numberspinner('getValue');

        // si no seleccionó la localidad
        this.CodLoc = $('#localidadpaciente').combobox('getValue');
        if (this.CodLoc == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Seleccione la localidad");
            return;

        }

        // asigna las coordenadas
        this.Coordenadas = document.getElementById("coordenadaspaciente").value;

        // verifica el domicilio
        this.Domicilio = $('#domiciliopaciente').textbox('getValue');
        if (this.Domicilio == ""){

            // presenta el mensaje
            Mensaje("Error", "Atención", "Indique el domicilio");
            return;

        }

        /**
         *
         * Hasta aquí definimos los datos que pueden ser tanto del
         * paciente como del tutor de una mascota, si completa
         * los datos de la institución, consideramos que se trata
         * de un paciente
         *
         */
        // el tipo de domicilio lo permite en blanco
        this.Urbano = $('#tipodomicilio').combobox('getValue');

        // verifica el teléfono
        this.TelPaciente = $('#telpaciente').textbox('getValue');

        // la ocupación la permite en blanco
        this.IdOcupacion = $('#ocupacionpaciente').combobox('getValue');

        // si seleccionó la institución asumimos que se trata de un paciente
        this.IdInstitucion = $('#institucionpaciente').combobox('getValue');

        // si es paciente
        if (this.IdInstitucion != "" || this.IdInstitucion != 0){

            // si no indicó el profesional que envío la muestra
            this.Enviado = $('#profesionalpaciente').textbox('getValue');
            if (this.Enviado == ""){

                // presenta el mensaje y retorna
                Mensaje("Error", "Atención", "Indique el profesional que envió la muestra");
                return;

            }

            // si ingresó el mail verifica el formato
            this.Mail = $('#mailpaciente').textbox('getValue');
            if (this.Mail.length !== 0){
                if (!echeck(this.Mail)){

                    // presenta el mensaje y retorna
                    Mensaje("Error", "Atención", "El mail parece incorrecto");
                    return;

                }

            }

            // el teléfono lo permite en blanco
            this.Telefono = $('#telefonoprofesional').textbox('getValue');

            // si no ingresó ni mail ni teléfono
            if (this.Telefono.length === 0 && this.Mail.length === 0){

                // presenta el mensaje y retorna
                Mensaje("Error", "Atención", "Debe indicar una forma de contacto");
                return;

            }

        }

        // notificación al sisa la permite en blanco
        this.Notificado = $('#notificacionpaciente').datebox('getValue');

        // la clave sisa la permite en blanco
        this.Sisa = $('#sisapaciente').textbox('getValue');

        // antecedentes clínicos los permite en blanco
        this.Antecedentes = $('#antecedentespaciente').texteditor('getValue');

        // si declaró el documento
        if (this.Documento != ""){

            // validamos al paciente
            this.validaPaciente();

        // si no declaró
        } else {

            // grabamos directamente
            this.grabaPaciente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de verificar el formularrio que
     * valida que el paciente no se encuentre repetido
     * (ojo, como el documento es optativo esta validación
     * nunca es completamente segura)
     */
    validaPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // verificamos si ya existe
        $.ajax({
            url: "pacientes/validapaciente.php?documento="+this.Documento+'&id='+this.Id,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // mostramos el registro
                    clase.grabaPaciente();

                // de otra forma
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ese paciente ya está declarado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en
     * el servidor
     */
    grabaPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos las variables
        let datosPaciente = new FormData();

        // declaramos la clase
        let clase = this;

        // asignamos en el formulario
        datosPaciente.append("Id", this.Id);
        datosPaciente.append("Fecha", this.Fecha);
        datosPaciente.append("Nombre", this.Nombre);
        datosPaciente.append("Documento", this.Documento);
        datosPaciente.append("IdTipoDoc", this.IdTipoDoc);
        datosPaciente.append("IdSexo", this.IdSexo);
        datosPaciente.append("Edad", this.Edad);
        datosPaciente.append("Nacimiento", this.Nacimiento);
        datosPaciente.append("LocNacimiento", this.CodLoc);
        datosPaciente.append("Coordenadas", this.Coordenadas);
        datosPaciente.append("Domicilio", this.Domicilio);
        datosPaciente.append("Urbano", this.Urbano);
        datosPaciente.append("TelPaciente", this.TelPaciente);
        datosPaciente.append("IdOcupacion", this.IdOcupacion);
        datosPaciente.append("IdInstitucion", this.IdInstitucion);
        datosPaciente.append("Enviado", this.Enviado);
        datosPaciente.append("Mail", this.Mail);
        datosPaciente.append("Telefono", this.Telefono);
        datosPaciente.append("Antecedentes", this.Antecedentes);
        datosPaciente.append("Notificado", this.Notificado);
        datosPaciente.append("Sisa", this.Sisa);
        datosPaciente.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "pacientes/grabapaciente.php",
            type: "POST",
            data: datosPaciente,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // si está insertando
                    if ($('#idpaciente').textbox('getValue') == ""){

                        // actualizamos en el formulario
                        $('#idpaciente').textbox('setValue', data.Resultado);

                        // asignamos en los formularios hijos
                        clase.cargaFormHijos(data.Resultado);

                    }

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Registro grabado ...");

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
     * Método llamado al pulsar el botón nuevo que limpia
     * el formulario de datos y verifica las credenciales
     * del usuario (que tenga autorización para nuevos
     * pacientes)
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos los campos
        $('#idpaciente').textbox('setValue', "");
        $('#ingresopaciente').datebox('setValue', fechaActual());
        $('#nombrepaciente').textbox('setValue', "");
        $('#tipodocumento').combobox('setValue', "");
        $('#documentopaciente').textbox('setValue', "");
        $('#edadpaciente').numberspinner('setValue', "");
        $('#sexopaciente').combobox('setValue', "");
        $('#paispaciente').combobox('setValue', "");
        $('#provinciapaciente').combobox('setValue', "");
        $('#localidadpaciente').combobox('setValue', "");
        document.getElementById("coordenadaspaciente").value = "";
        $('#domiciliopaciente').textbox('setValue', "");
        $('#tipodomicilio').combobox('setValue', "");
        $('#telpaciente').textbox('setValue', "");
        $('#ocupacionpaciente').combobox('setValue', "");
        $('#provinciainstitucion').combobox('setValue', "");
        $('#localidadinstitucion').combobox('setValue', "");
        $('#institucionpaciente').combobox('setValue', "");
        $('#profesionalpaciente').textbox('setValue', "");
        $('#mailpaciente').textbox('setValue', "");
        $('#telefonoprofesional').textbox('setValue', "");
        $('#notificacionpaciente').datebox('setValue', "");
        $('#sisapaciente').textbox('setValue', "");
        $('#antecedentespaciente').texteditor('setValue', "");
        $('#usuariopaciente').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altapaciente').textbox('setValue', fechaActual());
        $('#modificadopaciente').textbox('setValue', fechaActual());

        // reiniciamos las variables por las dudas
        this.initPacientes();

        // reiniciamos las clases hijas
        clinica.nuevoPaciente();
        actividades.nuevoPaciente();
        viajes.nuevoPaciente();
        evolucion.nuevoPaciente();
        control.nuevoPaciente();
        mascotas.nuevoPaciente();
        peridomicilio.nuevoPaciente();
        muestras.nuevoPaciente();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de verificar que puede ser
     * eliminado el registro que pide confirmación al
     * usuario
     */
    confirmaEliminar(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos que halla un registro activo
        let id = $('#idpaciente').textbox('getValue');
        if (id == "" || id == 0){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe haber un registro activo");
            return;

        }

        // declaramos las variables
        let mensaje = 'Está seguro que desea<br>eliminar el registro ' +
                      'del paciente ' +
                      $('#nombrepaciente').textbox('getValue') + '?';
        let clase = this;

        // pedimos confirmación
        $.messager.confirm('Eliminar',
                        mensaje,
                        function(r){
                            if (r){
                                clase.borraPaciente(id);
                            }
                        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idpaciente - clave del registro
     * Método que recibe como parámetro la clave de un registro
     * y ejecuta la consulta de eliminación
     */
    borraPaciente(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // ejecutamos la consulta
        $.ajax({
            url: "pacientes/borrapaciente.php?id="+idpaciente,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si dió correcto
                if (data.Resultado){

                    // presenta el mensaje y limpia el formulario
                    Mensaje("Info", "Atención", "Registro eliminado ... ");
                    clase.nuevoPaciente();

                // de otra forma
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ha ocurrido un error ...");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón cancelar, que
     * según el caso limpia el formulario o recarga el
     * registro
     */
    cancelaPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if ($('#idpaciente').textbox('getValue') != ""){

            // recargamos el registro
            this.getDatosPaciente($('#idpaciente').textbox('getValue'));

        // si está insertando
        } else {

            // limpiamos el formulario
            this.nuevoPaciente();

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cambiar el contenido de la dirección
     * que intenta obtener las coordenadas gps
     */
    getCoordenadas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos los valores
        let domicilio = $('#domiciliopaciente').textbox('getValue');
        let pais = $('#paispaciente').combobox('getText');
        let provincia = $('#provinciapaciente').combobox('getText');
        let localidad = $('#localidadpaciente').combobox('getText');

        // si no completó todos los campos, aunque domicilio lo
        // permitimos en blanco porque una muestra puede provenir
        // sin todos los datos pero si con localidad y provincia
        if (pais == "" ||
            provincia == "" ||
            localidad == ""){

            // retornamos directamente
            return;

        }

        // instancia el geocoder y componemos el domicilio
        let geocoder = new google.maps.Geocoder();
        let direccion = domicilio + " - " + localidad + " - " + provincia + " - " + pais;

        // busca la dirección
        geocoder.geocode( { 'address': direccion}, function(results, status) {

            // si hubo resultados
            if (status == google.maps.GeocoderStatus.OK) {

                // asignamos las coordenadas en la clase y en el formulario
                clase.Coordenadas = results[0].geometry.location;
                document.getElementById("coordenadaspaciente").value = clase.Coordenadas;

            // si no encontró
            } else {

                // presenta el mensaje
                var mensaje = "No se ha podido detectar una<br>";
                mensaje += "serie de coordenadas válidas, el<br>";
                mensaje += "error fue: " + status;

                // presenta el mensaje y retorna
                Mensaje("Error", "Atención", mensaje);

            }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú que define el layer emergente
     * y presenta el mapa con los datos de georreferenciación
     */
    mostrarMapa(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos si hay un conjunto de coordenadas
        if (this.Coordenadas == ""){

            // presenta el mensaje
            Mensaje("Info", "Atención", "No hay un conjunto de coordenadas válido");
            return;

        }

        // instanciamos el mapa
        let mapa = new Mapas();

        // de otra forma define el layer
        let formulario = "<div id='map'></div>";

        // agregamos la definición de la grilla al dom
        $("#form-filiacion").append(formulario);

        // abrimos el layer presentando el mapa
        $('#map').window({
            width:1100,
            height:650,
            modal:true,
            title: "Ubicación del Paciente",
            minimizable: false,
            closable: true,
            onClose:function(){$('#map').window('destroy');},
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#map').window('center');

        // convertimos a string y obtenemos la posición de la coma
        let coordenadas = this.Coordenadas.toString();
        let posicion = coordenadas.indexOf(',');

        // obtenemos la latitud y longitud
        let latitud = coordenadas.substring(1, posicion);
        let longitud = coordenadas.substring(posicion + 1, coordenadas.length -1);

        // fijamos las propiedades
        mapa.setLatitud(latitud);
        mapa.setLongitud(longitud);
        mapa.setTitulo($('#domiciliopaciente').textbox('getValue'));

        // lo presentamos
        mapa.verMapa();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el menú principal que imprime la 
     * historia clínica completa del paciente y en todo caso 
     * de las mascotas
     */
    imprimePaciente(){

        // reiniciamos la sesión 
        sesion.reiniciar();

        // verificamos que exista un registro activo
        let idpaciente = $('#idpaciente').textbox('getValue');
        if ( idpaciente == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe tener un registro en pantalla");
            return;

        }

        // definimos el contenido a agregar
        let formulario = "<div id='win-pacientes'>" +
                         "</div>";

        // agregamos la definición de la grilla al dom
        $("#form-filiacion").append(formulario);

        // abrimos el layer presentando el documento
        $('#win-pacientes').window({
            width:850,
            height:500,
            modal:true,
            title: "Historia Clínica",
            minimizable: false,
            closable: true,
            onClose:function(){$('#win-pacientes').window('destroy');},
            href: 'informes/historiaclinica.php?id='+idpaciente,
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $(this.Layer).window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente presentando la
     * ayuda del sistema
     */
    ayudaPacientes(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let formulario = "<div id='win-ayuda'></div>";

        // agregamos la definición de la grilla al dom
        $("#form-filiacion").append(formulario);

        // abrimos el layer presentando la ayuda
        $('#win-ayuda').window({
            width:850,
            height:500,
            modal:true,
            title: "Ayuda del Sistema",
            minimizable: false,
            closable: true,
            href: 'pacientes/ayuda.html',
            onClose:function(){$('#win-ayuda').window('destroy');},
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-ayuda').window('center');

    }

}
