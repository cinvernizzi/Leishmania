/*

    Nombre: clinica.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 26/05/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones de la tabla
                 de datos clínicos del paciente

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

/**
 * @author Lic. Claudio Invernizzi <cinvernizzi@dsgestion.site>
 * @class Clase que controla las operaciones de los
 *        datos clínicos del paciente
 */
class Clinica {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, se encarga de inicializar
     * las variables
     */
    constructor(){

        // inicializamos las variables
        this.initClinica();

        // cargamos la definición del formulario
        $("#form_clinica").load("clinica/formclinica.html");

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o luego de grabar
     * un registro que inicializa las variables de clase
     */
    initClinica(){

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

        // inicializamos las variables
        this.Id = 0;                   // clave del registro
        this.CutaneaUnica = "";        // si presenta lesión cutánea única
        this.CutaneaMultiple = ""      // si presenta lesión cutánea múltiple
        this.MucosaNasal = "";         // si hay lesión mucosa nasal
        this.Bucofaringea = "";        // si presenta lesión bucofaringea
        this.Laringea = "";            // si presenta lesión laríngea
        this.Visceral = "";            // si hay lesión visceral
        this.Fiebre = "";              // si presenta fiebre
        this.Inicio = "";              // fecha de inicio de la fiebre
        this.Características = "";     // características de la fiebre (diurna / nocturna)
        this.Fatiga = "";              // si presenta fatiga
        this.Debilidad = "";           // si presenta debilidad
        this.Vomitos = "";             // si presenta vómitos
        this.Diarrea = "";             // si presenta diarrea
        this.TosSeca = "";             // si presenta tos seca
        this.PielGris = "";            // si presenta piel gris
        this.Edema = "";               // si presenta edema
        this.Escamosa = "";            // si la piel es escamosa
        this.Cabello = ""              // si hay pérdida de cabello
        this.Petequias = "";           // si presenta petequias
        this.Adenomegalia = "";        // si presenta adenomegalia
        this.Hepato = "";              // si presenta hepatoesplenomegalia
        this.Linfa = "";               // si presenta linfadenopatia
        this.PerdidaPeso = "";         // si hay pérdida de peso
        this.Nodulo = "";              // si presenta nódulos
        this.Ulcera = "";              // si presenta úlcera
        this.Cicatriz = "";            // si hay cicatriz
        this.LesionMucosa = "";        // si hay lesión mucosa
        this.Alta = "";                // fecha de alta del registro
        this.Usuario = "";             // nombre del usuario
        this.Modificado = "";          // fecha de modificación del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de cargar la definición del
     * formulario que lo configura
     */
    initFormClinica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los elementos
        $('#idclinica').textbox();
        $('#cutaneaunica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#cutaneamultiple').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#lesionmucosanasal').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#lesionbucofaringea').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#lesionlaringea').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#lesionvisceral').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentafiebre').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#fechafiebre').datebox({
            width: "120px"
        });
        $('#caracteristicasfiebre').combobox({
            panelHeight: 'auto'
        });
        $('#presentafatiga').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentadebilidad').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentavomitos').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentadiarrea').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentatosseca').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#presentapielgris').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#edemaclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#pielescamosa').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#petequiasclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#perdidacabello').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#adenomegaliaclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#hepatoesplenomegalia').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#linfadenopatia').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#perdidapeso').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#nodulosclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#ulcerasclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#cicatrizclinica').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#lesionmucosa').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#usuarioclinica').textbox();
        $('#altaclinica').textbox();
        $('#btnGrabarClinica').linkbutton();
        $('#btnCancelarClinica').linkbutton();
        $('#btnAyudaClinica').linkbutton();

        // configuramos los valores por defecto
        $('#usuarioclinica').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altaclinica').textbox('setValue', fechaActual());

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con el registro
     * Método llamado desde la interfaz de pacientes que carga
     * en el contenedor el formulario de los datos de clínica
     */
    cargaDatosClinica(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en el formulario
        $('#idclinica').textbox('setValue', datos.Id);
        if (datos.CutaneaUnica == "Si"){
            $('#cutaneaunica').switchbutton('check');
        } else {
            $('#cutaneaunica').switchbutton('uncheck');
        }
        if (datos.CutaneaMultiple == "Si"){
            $('#cutaneamultiple').switchbutton('check');
        } else {
            $('#cutaneamultiple').switchbutton('uncheck');
        }
        if (datos.MucosaNasal == "Si"){
            $('#lesionmucosanasal').switchbutton('check');
        } else {
            $('#lesionmucosanasal').switchbutton('uncheck');
        }
        if (datos.Bucofaringea == "Si"){
            $('#lesionbucofaringea').switchbutton('check');
        } else {
            $('#lesionbucofaringea').switchbutton('uncheck');
        }
        if(datos.Laringea == "Si") {
            $('#lesionlaringea').switchbutton('check');
        } else {
            $('#lesionlaringea').switchbutton('uncheck');
        }
        if (datos.Visceral == "Si"){
            $('#lesionvisceral').switchbutton('check');
        } else {
            $('#lesionvisceral').switchbutton('uncheck');
        }
        if (datos.Fiebre == "Si"){
            $('#presentafiebre').switchbutton('check');
        } else {
            $('#presentafiebre').switchbutton('uncheck');
        }
        $('#fechafiebre').datebox('setValue', datos.Inicio);
        $('#caracteristicasfiebre').combobox('setValue', datos.Inicio);
        if (datos.Fatiga == "Si"){
            $('#presentafatiga').switchbutton('check');
        } else {
            $('#presentafatiga').switchbutton('uncheck');
        }
        if (datos.Debilidad == "Si"){
            $('#presentadebilidad').switchbutton('check');
        } else {
            $('#presentadebilidad').switchbutton('uncheck');
        }
        if (datos.Vomitos == "Si"){
            $('#presentavomitos').switchbutton('check');
        } else {
            $('#presentavomitos').switchbutton('uncheck');
        }
        if (datos.Diarrea == "Si"){
            $('#presentadiarrea').switchbutton('check');
        } else {
            $('#presentadiarrea').switchbutton('uncheck');
        }
        if (datos.TosSeca == "Si"){
            $('#presentatosseca').switchbutton('check');
        } else {
            $('#presentatosseca').switchbutton('uncheck');
        }
        if (datos.PielGris == "Si"){
            $('#presentapielgris').switchbutton('check');
        } else {
            $('#presentapielgris').switchbutton('uncheck');
        }
        if (datos.Edema == "Si"){
            $('#edemaclinica').switchbutton('check');
        } else {
            $('#edemaclinica').switchbutton('uncheck');
        }
        if (datos.Escamosa == "Si"){
            $('#pielescamosa').switchbutton('check');
        } else {
            $('#pielescamosa').switchbutton('uncheck');
        }
        if (datos.Petequias == "Si"){
            $('#petequiasclinica').switchbutton('check');
        } else {
            $('#petequiasclinica').switchbutton('uncheck');
        }
        if (datos.Cabello == "Si"){
            $('#perdidacabello').switchbutton('check');
        } else {
            $('#perdidacabello').switchbutton('uncheck');
        }
        if (datos.Adenomegalia == "Si"){
            $('#adenomegaliaclinica').switchbutton('check');
        } else {
            $('#adenomegaliaclinica').switchbutton('uncheck');
        }
        if (datos.HepatoEspleno == "Si"){
            $('#hepatoesplenomegalia').switchbutton('check');
        } else {
            $('#hepatoesplenomegalia').switchbutton('uncheck');
        }
        if (datos.Linfadenopatia == "Si"){
            $('#linfadenopatia').switchbutton('check');
        } else {
            $('#linfadenopatia').switchbutton('uncheck');
        }
        if (datos.PerdidaPeso == "Si"){
            $('#perdidapeso').switchbutton('check');
        } else {
            $('#perdidapeso').switchbutton('uncheck');
        }
        if (datos.Nodulo == "Si"){
            $('#nodulosclinica').switchbutton('check');
        } else {
            $('#nodulosclinica').switchbutton('uncheck');
        }
        if (datos.Ulcera == "Si"){
            $('#ulcerasclinica').switchbutton('check');
        } else {
            $('#ulcerasclinica').switchbutton('uncheck');
        }
        if (datos.Cicatriz == "Si"){
            $('#cicatrizclinica').switchbutton('check');
        } else {
            $('#cicatrizclinica').switchbutton('uncheck');
        }
        if (datos.LesionMucosa == "Si"){
            $('#lesionmucosa').switchbutton('check');
        } else {
            $('#lesionmucosa').switchbutton('uncheck');
        }
        $('#altaclinica').textbox('setValue', datos.Alta);

        // si existe un usuario
        if (datos.Usuario != ""){
            $('#usuarioclinica').textbox('setValue', datos.Usuario);
        } else {
            $('#usuarioclinica').textbox('setValue', sessionStorage.getItem("Usuario"));
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idpaciente - clave del paciente
     * Método que recibe como parámetro la clave de un paciente
     * y obtiene el registro del mismo
     */
    getDatosClinica(idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        this.Paciente = idpaciente;

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "clinica/getdatos.php?id="+idpaciente,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro ya que si es
                // un paciente nuevo está en blanco con
                // los valores por defecto
                clase.cargaDatosClinica(data);

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return {bool} resultado de la verificación
     * Método llamado al grabar el registro que verifica los
     * datos del formulario, como es llamado desde la verificación
     * de datos del paciente, retorna el resultado de la verificación
     */
    verificaClinica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // verificamos que exista un paciente activo
        if (this.Paciente == 0 || this.Paciente == ""){

            // presenta el mensaje y retorna
            Mensaje("Error", "Atención", "Debe tener un paciente activo");
            return;

        }

        // asignamos en las variables de clase
        this.Id = $('#idclinica').textbox('getValue');
        if (this.Id == ""){
            this.Id = 0;
        }

        // asignamos según el estado de los switchbutton
        if ($('#cutaneaunica').switchbutton('options').checked){
            this.CutaneaUnica = "Si";
        } else {
            this.CutaneaUnica = "No";
        }
        if ($('#cutaneamultiple').switchbutton('options').checked){
            this.CutaneaMultiple = "Si";
        } else {
            this.CutaneaMultiple = "No";
        }
        if ($('#lesionmucosanasal').switchbutton('options').checked){
            this.MucosaNasal = "Si";
        } else {
            this.MucosaNasal = "No";
        }
        if ($('#lesionbucofaringea').switchbutton('options').checked){
            this.Bucofaringea = "Si";
        } else {
            this.Bucofaringea = "No";
        }
        if ($('#lesionlaringea').switchbutton('options').checked){
            this.Laringea = "Si";
        } else {
            this.Laringea = "No";
        }
        if ($('#lesionvisceral').switchbutton('options').checked){
            this.Visceral = "Si";
        } else {
            this.Visceral = "No";
        }
        if ($('#presentafiebre').switchbutton('options').checked){
            this.Fiebre = "Si";
        } else {
            this.Fiebre = "No";
        }
        this.Inicio = $('#fechafiebre').datebox('getValue');
        this.Características = $('#caracteristicasfiebre').combobox('getText');
        if ($('#presentafatiga').switchbutton('options').checked){
            this.Fatiga = "Si";
        } else {
            this.Fatiga = "No";
        }
        if ($('#presentadebilidad').switchbutton('options').checked){
            this.Debilidad = "Si";
        } else {
            this.Debilidad = "No";
        }
        if ($('#presentavomitos').switchbutton('options').checked){
            this.Vomitos = "Si";
        } else {
            this.Vomitos = "No";
        }
        if ($('#presentadiarrea').switchbutton('options').checked){
            this.Diarrea = "Si";
        } else {
            this.Diarrea = "No";
        }
        if ($('#presentatosseca').switchbutton('options').checked){
            this.TosSeca = "Si";
        } else {
            this.TosSeca= "No";
        }
        if ($('#presentapielgris').switchbutton('options').checked){
            this.PielGris = "Si";
        } else {
            this.PielGris = "No";
        }
        if ($('#edemaclinica').switchbutton('options').checked){
            this.Edema = "Si";
        } else {
            this.Edema = "No";
        }
        if ($('#pielescamosa').switchbutton('options').checked){
            this.Escamosa = "Si";
        } else {
            this.Escamosa = "No";
        }
        if ($('#petequiasclinica').switchbutton('options').checked){
            this.Petequias = "Si";
        } else {
            this.Petequias = "No";
        }
        if ($('#perdidacabello').switchbutton('options').checked){
            this.Cabello = "Si";
        } else {
            this.Cabello = "No";
        }
        if ($('#adenomegaliaclinica').switchbutton('options').checked){
            this.Adenomegalia = "Si";
        } else {
            this.Adenomegalia = "No";
        }
        if ($('#hepatoesplenomegalia').switchbutton('options').checked){
            this.Hepato = "Si";
        } else {
            this.Hepato = "No";
        }
        if ($('#linfadenopatia').switchbutton('options').checked){
            this.Linfa = "Si";
        } else {
            this.Linfa = "No";
        }
        if ($('#perdidapeso').switchbutton('options').checked){
            this.PerdidaPeso = "Si";
        } else {
            this.PerdidaPeso = "No";
        }
        if ($('#nodulosclinica').switchbutton('options').checked){
            this.Nodulos = "Si";
        } else {
            this.Nodulos = "No";
        }
        if ($('#ulcerasclinica').switchbutton('options').checked){
            this.Ulcera = "Si";
        } else {
            this.Ulcera = "No";
        }
        if ($('#cicatrizclinica').switchbutton('options').checked){
            this.Cicatriz = "Si";
        } else {
            this.Cicatriz = "No";
        }
        if ($('#lesionmucosa').switchbutton('options').checked){
            this.LesionMucosa = "Si";
        } else {
            this.LesionMucosa = "No";
        }

        // grabamos el registro
        this.grabaClinica();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación en la
     * base de datos
     */
    grabaClinica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos las variables
        let datosClinica = new FormData();

        // asignamos en el formulario
        datosClinica.append("Id", this.Id);
        datosClinica.append("IdPaciente", this.Paciente);
        datosClinica.append("CutaneaUnica", this.CutaneaUnica);
        datosClinica.append("CutaneaMultiple", this.CutaneaMultiple);
        datosClinica.append("MucosaNasal", this.MucosaNasal);
        datosClinica.append("BucoFaringea", this.Bucofaringea);
        datosClinica.append("Laringea", this.Laringea);
        datosClinica.append("Visceral", this.Visceral);
        datosClinica.append("Fiebre", this.Fiebre);
        datosClinica.append("Inicio", this.Inicio);
        datosClinica.append("Caracteristicas", this.Características);
        datosClinica.append("Fatiga", this.Fatiga);
        datosClinica.append("Debilidad", this.Debilidad);
        datosClinica.append("Vomitos", this.Vomitos);
        datosClinica.append("Diarrea", this.Diarrea);
        datosClinica.append("TosSeca", this.TosSeca);
        datosClinica.append("PielGris", this.PielGris);
        datosClinica.append("Edema", this.Edema);
        datosClinica.append("Escamosa", this.Escamosa);
        datosClinica.append("Petequias", this.Petequias);
        datosClinica.append("Cabello", this.Cabello);
        datosClinica.append("Adenomegalia", this.Adenomegalia);
        datosClinica.append("HepatoEspleno", this.Hepato);
        datosClinica.append("Linfadenopatia", this.Linfa);
        datosClinica.append("PerdidaPeso", this.PerdidaPeso);
        datosClinica.append("Nodulo", this.Nodulo);
        datosClinica.append("Ulcera", this.Ulcera);
        datosClinica.append("Cicatriz", this.Cicatriz);
        datosClinica.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "clinica/grabar.php",
            type: "POST",
            data: datosClinica,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado != 0){

                    // actualizamos en el formulario
                    $('#idclinica').textbox('setValue', data.Resultado);

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
     * Método llamado al pulsar el botón cancelar que
     * según el estado de las variables recarga o limpia
     * el formulario
     */
    cancelaClinica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si está editando
        if (this.Paciente != 0){
            this.getDatosClinica(this.Paciente);
        } else {
            this.nuevoPaciente();
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el formulario de datos de filiación
     * al insertar un nuevo paciente o al cancelar que limpia
     * los datos del formulario
     */
    nuevoPaciente(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos los elementos
        $('#idclinica').textbox('setValue', "");
        $('#cutaneaunica').switchbutton('uncheck');
        $('#cutaneamultiple').switchbutton('uncheck');
        $('#lesionmucosanasal').switchbutton('uncheck');
        $('#lesionbucofaringea').switchbutton('uncheck');
        $('#lesionlaringea').switchbutton('uncheck');
        $('#lesionvisceral').switchbutton('uncheck');
        $('#presentafiebre').switchbutton('uncheck');
        $('#fechafiebre').datebox('setValue', "");
        $('#caracteristicasfiebre').combobox('uncheck');
        $('#presentafatiga').switchbutton('uncheck');
        $('#presentadebilidad').switchbutton('uncheck');
        $('#presentavomitos').switchbutton('uncheck');
        $('#presentadiarrea').switchbutton('uncheck');
        $('#presentatosseca').switchbutton('uncheck');
        $('#presentapielgris').switchbutton('uncheck');
        $('#edemaclinica').switchbutton('uncheck');
        $('#pielescamosa').switchbutton('uncheck');
        $('#petequiasclinica').switchbutton('uncheck');
        $('#perdidacabello').switchbutton('uncheck');
        $('#adenomegaliaclinica').switchbutton('uncheck');
        $('#hepatoesplenomegalia').switchbutton('uncheck');
        $('#linfadenopatia').switchbutton('uncheck');
        $('#perdidapeso').switchbutton('uncheck');
        $('#nodulosclinica').switchbutton('uncheck');
        $('#ulcerasclinica').switchbutton('uncheck');
        $('#cicatrizclinica').switchbutton('uncheck');
        $('#lesionmucosa').switchbutton('uncheck');
        $('#usuarioclinica').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altaclinica').textbox('setValue', fechaActual());

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que abre el layer emergente con la ayuda del
     * sistema
     */
    ayudaClinica(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-clinica'></div>";

        // agregamos la definición de la grilla al dom
        $("#datos-clinica").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-clinica').window({
            title: "Ayuda en los Datos Clínicos",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'clinica/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-clinica').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-clinica').window('center');

    }

}
