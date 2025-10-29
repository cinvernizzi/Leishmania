/*

    Nombre: sintmascotas.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 13/08/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido en: INP
    Licencia: GPL
    Comentarios: Clase que controla las operaciones del abm de
                 síntomas de las mascotas

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
 *        de síntomas de las mascotas
 */
class SintMascotas {

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Constructor de la clase, cargamos la definición del
     * formulario en el layer e inicializamos las variablesç
     */
    constructor(){

        // inicializamos las variables
        this.initSintMascotas();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado desde el constructor o al grabar un
     * registro que inicializa las variables de clase
     */
    initSintMascotas(){

        // inicializamos las variables
        this.Id = 0;                    // clave del registro
        this.Mascota = 0;               // clave de la mascota
        this.Paciente = 0;              // clave del dueño
        this.Anorexia = "No";           // si presenta anorexia
        this.Adinamia = 'No';           // si presenta adinamia
        this.Emaciacion = "No";         // si presenta emaciación
        this.Polidipsia = "No";         // si presenta polidipsia
        this.Atrofia = "No";            // si presenta atrofia muscular
        this.Paresia = "No";            // si presenta paresia
        this.Convulsiones = "No";       // si presenta convulsiones
        this.Adenomegalia = "No";       // si presenta adenomegalia
        this.Blefaritis = "No";         // si presenta blefaritis
        this.Conjuntivitis = "No";      // si presenta conjuntivitis
        this.Queratitis = "No";         // si presenta queratitis
        this.Uveitis = "No";            // si presenta uveitis
        this.Palidez = "No";            // si presenta palidez
        this.Epistaxis = "No";          // si presenta epistaxis
        this.Ulceras = "No";            // si presenta úlceras
        this.Nodulos = "No";            // si presenta nódulos
        this.Vomitos = "No";            // si presenta vómitos
        this.Diarrea = 'No';            // si presenta diarrea
        this.Artritis = "No";           // si presenta artritis
        this.Eritema = "No";            // si presenta eritema
        this.Prurito = "No";            // si presenta prurito
        this.UlceraCutanea = "No";      // si presenta úlcera cutánea
        this.NodulosCutaneos = "No";    // si presenta nódulos cutáneos
        this.AlopeciaLocalizada = "No"; // si presenta pérdida de cabello
        this.AlopeciaGeneralizada = "No"; // si presenta pérdida de pelo
        this.HiperqueratosisN = "No";   // si presenta hiperqueratosis nasal
        this.HiperqueratosisP = 'No';   // si presenta hiperqueratosis plantar
        this.SeborreaGrasa = "No";      // si presenta seborrea
        this.SeborreaEscamosa = "No";   // si presenta seborrea
        this.Onicogrifosis = "No";      // engrosamiento de las uñas
        this.CasoHumano = "No";         // antecedentes de un caso humano
        this.Flebotomos = "No";         // si presenta flebótomos
        this.CasaTrampeada = "No";      // si la casa está trampeada
        this.Fumigacion = "No";         // si se fumiga
        this.MateriaOrganica = "No";    // si hay presencia de materia orgánica
        this.Repelentes = "No";         // si se utilizan repelentes
        this.Periodicidad = "";         // semanal / mensual / semestral
        this.Duerme = "";               // donde duerme (casa / intemperie)
        this.QuedaLibre = "No";         // si queda suelto en la calle
        this.Usuario = "";              // nombre del usuario
        this.Alta = "";                 // fecha de alta del registro

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {int} idmascota - clave de la mascota
     * @param {int} idpaciente - clave del paciente
     * Método llamado desde la grilla de mascotas del paciente
     * al pulsar sobre el botón de síntomas que recibe como
     * parámetros la clave de la mascota y la clave del
     * paciente, entonces abre el layer emergente con la
     * definición del formulario
     */
    verSintomasMascotas(idmascota, idpaciente){

        // reiniciamos la sesión
        sesion.reiniciar();

        // asignamos en la clase
        this.Mascota = idmascota;
        this.Paciente = idpaciente;

        // cargamos el formulario
        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let formsintomas = "<div id='formsintomas'></div>";

        // agregamos la definición de la grilla al dom
        $("#form-mascotas").append(formsintomas);

        // ahora abrimos el diálogo
        $('#formsintomas').window({
            title: "Síntomas de la Mascota",
            modal:true,
            maximizable: true,
            width: 1400,
            height: 600,
            closed: false,
            closable: true,
            href: 'sintmascotas/formsintomas.html',
            method: 'post',
            onClose:function(){$('#formsintomas').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#formsintomas').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al cargar la definición del formulario
     * que lo configura
     */
    initFormSintomas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // configuramos el formulario
        $('#idsintmasc').textbox();
        $('#usuariosintmasc').textbox();
        $('#anorexiasint').switchbutton({
            label: 'Anorexia:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#adinamiasint').switchbutton({
            label: 'Adinamia:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#emasiacionsint').switchbutton({
            label: 'Emaciación:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#polidipsiasint').switchbutton({
            label: 'Polidipsia:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#atrofiasint').switchbutton({
            label: 'Atrofia Musc.:',
            labelWidth: 100,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#paresiasint').switchbutton({
            label: 'Paresia:',
            labelWidth: 100,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#convulsionesint').switchbutton({
            label: 'Convulsiones:',
            labelWidth: 100,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#blefaritissint').switchbutton({
            label: 'Blefaritis:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#conjuntivitissint').switchbutton({
            label: 'Conjuntivitis:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#queratitissint').switchbutton({
            label: 'Queratitis:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#uveitissint').switchbutton({
            label: 'Uveitis:',
            labelWidth: 90,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#palidezsint').switchbutton({
            label: 'Palidez:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#epistaxissint').switchbutton({
            label: 'Epistaxis:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#ulcerassint').switchbutton({
            label: 'Ulceras:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#nodulossint').switchbutton({
            label: 'Nódulos:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#vomitossint').switchbutton({
            label: 'Vómitos:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#diarreasint').switchbutton({
            label: 'Diarrea:',
            labelWidth: 70,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#eritemasint').switchbutton({
            label: 'Eritema:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#pruritosint').switchbutton({
            label: 'Prurito:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#ulceracutsint').switchbutton({
            label: 'Ulcera:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#noduloscutsint').switchbutton({
            label: 'Nódulos:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#alopecialocsint').switchbutton({
            label: 'Alopecía Loc.:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#alopeciagensint').switchbutton({
            label: 'Alopecía Gen.:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#hiperqueratosisnsint').switchbutton({
            label: 'HiperQ. Nasal:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#hiperqueratosispsint').switchbutton({
            label: 'HiperQ. Plantar:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#casohumanosint').switchbutton({
            label: 'Caso Humano:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#flebotomossint').switchbutton({
            label: 'Flebótomos:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#casatrampeadasint').switchbutton({
            label: 'Casa Tramp.:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#materiaorganicasint').switchbutton({
            label: 'Mat. Orgánica:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#fumigacionsint').switchbutton({
            label: 'Fumigación:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#repelentessint').switchbutton({
            label: 'Repelentes:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#frecuenciasint').combobox({
            panelHeight: 'auto',
            label: 'Frecuencia:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            limitToList: true
        });
        $('#dondeduermesint').combobox({
            panelHeight: 'auto',
            label: 'Duerme:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            limitToList: true
        });
        $('#quedasueltosint').switchbutton({
            label: 'Queda Suelto:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#adenomegaliasint').switchbutton({
            label: 'Adenomegalia:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#artritissint').switchbutton({
            label: 'Artritis:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#onicogrifosissint').switchbutton({
            label: 'Onicogrifosis:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#seborreagrasasint').switchbutton({
            label: 'Seborrea Grasa:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#seborreaescsint').switchbutton({
            label: 'Seborrea Esc.:',
            labelWidth: 110,
            labelPosition: 'before',
            labelAlign: 'left',
            onText: 'Si',
            offText: 'No'
        });
        $('#altasintmasc').textbox();
        $('#btnGrabarSintMasc').linkbutton();
        $('#btnCancelarSintMasc').linkbutton();

        // definimos los valores por defecto
        $('#usuariosintmasc').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altasintmasc').textbox('setValue', fechaActual());

        // verificamos si hay datos
        this.getDatosSintomas();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado luego de abrir el layer que obtiene los
     * datos del registro (si es que existe)
     */
    getDatosSintomas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // declaramos la clase
        let clase = this;

        // obtenemos el registro
        $.ajax({
            url: "sintmascotas/getdatos.php?idmascota="+clase.Mascota,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // mostramos el registro
                clase.verDatosSintomas(data);

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con el registro
     * Método llamado luego de obtener el registro que recibe
     * como parámetro los datos del mismo y los presenta en
     * el formulario
     */
    verDatosSintomas(datos){

        // reiniciamos la sesión
        sesion.reiniciar();

        // si obtuvo un registro
        if (datos.Id > 0){

            // cargamos los datos
            $('#idsintmasc').textbox('setValue', datos.Id);
            document.getElementById('idmascotasint').value = datos.Mascota;
            document.getElementById('idpacientesint').value = datos.Paciente;

            // según los valores del registro
            if (datos.Anorexia == "Si"){
                $('#anorexiasint').switchbutton('check');
            } else {
                $('#anorexiasint').switchbutton('uncheck');
            }
            if (datos.Adinamia == "Si"){
                $('#adinamiasint').switchbutton('check');
            } else {
                $('#adinamiasint').switchbutton('uncheck');
            }
            if (datos.Emaciacion == "Si"){
                $('#emasiacionsint').switchbutton('check');
            } else {
                $('#emasiacionsint').switchbutton('uncheck');
            }
            if (datos.Polidipsia == "Si"){
                $('#polidipsiasint').switchbutton('check');
            } else {
                $('#polidipsiasint').switchbutton('uncheck');
            }
            if (datos.Atrofia == "Si"){
                $('#atrofiasint').switchbutton('check');
            } else {
                $('#atrofiasint').switchbutton('uncheck');
            }
            if (datos.Paresia == "Si"){
                $('#paresiasint').switchbutton('check');
            } else {
                $('#paresiasint').switchbutton('uncheck');
            }
            if (datos.Convulsiones == "Si"){
                $('#convulsionesint').switchbutton('check');
            } else {
                $('#convulsionesint').switchbutton('uncheck');
            }
            if (datos.Adenomegalia == "Si"){
                $('#adenomegaliasint').switchbutton('check');
            } else {
                $('#adenomegaliasint').switchbutton('uncheck');
            }
            if (datos.Blefaritis == "Si"){
                $('#blefaritissint').switchbutton('check');
            } else {
                $('#blefaritissint').switchbutton('uncheck');
            }
            if (datos.Conjuntivitis == "Si"){
                $('#conjuntivitissint').switchbutton('check');
            } else {
                $('#conjuntivitissint').switchbutton('uncheck');
            }
            if (datos.Queratitis == "Si"){
                $('#queratitissint').switchbutton('check');
            } else {
                $('#queratitissint').switchbutton('uncheck');
            }
            if (datos.Uveitis == "Si"){
                $('#uveitissint').switchbutton('check');
            } else {
                $('#uveitissint').switchbutton('uncheck');
            }
            if (datos.Palidez == "Si"){
                $('#palidezsint').switchbutton('check');
            } else {
                $('#palidezsint').switchbutton('uncheck');
            }
            if (datos.Epistaxis == "Si"){
                $('#epistaxissint').switchbutton('check');
            } else {
                $('#epistaxissint').switchbutton('uncheck');
            }
            if (datos.Ulceras == "Si"){
                $('#ulcerassint').switchbutton('check');
            } else {
                $('#ulcerassint').switchbutton('uncheck');
            }
            if (datos.Diarrea == "Si"){
                $('#diarreasint').switchbutton('check');
            } else {
                $('#diarreasint').switchbutton('uncheck');
            }
            if (datos.Nodulos == "Si"){
                $('#nodulossint').switchbutton('check');
            } else {
                $('#nodulossint').switchbutton('uncheck');
            }
            if (datos.Vomitos == "Si"){
                $('#vomitossint').switchbutton('check');
            } else {
                $('#vomitossint').switchbutton('uncheck');
            }
            if (datos.Artritis == "Si"){
                $('#artritissint').switchbutton('check');
            } else {
                $('#artritissint').switchbutton('uncheck');
            }
            if (datos.Eritema == "Si"){
                $('#eritemasint').switchbutton('check');
            } else {
                $('#eritemasint').switchbutton('uncheck');
            }
            if (datos.Prurito == "Si"){
                $('#pruritosint').switchbutton('check');
            } else {
                $('#pruritosint').switchbutton('uncheck');
            }
            if (datos.UlceraCutanea == "Si"){
                $('#ulceracutsint').switchbutton('check');
            } else {
                $('#ulceracutsint').switchbutton('uncheck');
            }
            if (datos.NodulosCutaneos == "Si"){
                $('#noduloscutsint').switchbutton('check');
            } else {
                $('#noduloscutsint').switchbutton('uncheck');
            }
            if (datos.AlopeciaLocalizada == "Si"){
                $('#alopecialocsint').switchbutton('check');
            } else {
                $('#alopecialocsint').switchbutton('uncheck');
            }
            if (datos.AlopeciaGeneralizada == "Si"){
                $('#alopeciagensint').switchbutton('check');
            } else {
                $('#alopeciagensint').switchbutton('uncheck');
            }
            if (datos.HiperqueratosisN == "Si"){
                $('#hiperqueratosisnsint').switchbutton('check');
            } else {
                $('#hiperqueratosisnsint').switchbutton('uncheck');
            }
            if (datos.HiperqueratosisP == "Si"){
                $('#hiperqueratosispsint').switchbutton('check');
            } else {
                $('#hiperqueratosispsint').switchbutton('uncheck');
            }
            if (datos.SeborreaGrasa == "Si"){
                $('#seborreagrasasint').switchbutton('check');
            } else {
                $('#seborreagrasasint').switchbutton('uncheck');
            }
            if (datos.SeborreaEscamosa == "Si"){
                $('#seborreaescsint').switchbutton('check');
            } else {
                $('#seborreaescsint').switchbutton('uncheck');
            }
            if (datos.Onicogrifosis == "Si"){
                $('#onicogrifosissint').switchbutton('check');
            } else {
                $('#onicogrifosissint').switchbutton('uncheck');
            }
            if (datos.CasoHumano == "Si"){
                $('#casohumanosint').switchbutton('check');
            } else {
                $('#casohumanosint').switchbutton('uncheck');
            }
            if (datos.Flebotomos == "Si"){
                $('#flebotomossint').switchbutton('check');
            } else {
                $('#flebotomossint').switchbutton('uncheck');
            }
            if (datos.CasaTrampeada == "Si"){
                $('#casatrampeadasint').switchbutton('check');
            } else {
                $('#casatrampeadasint').switchbutton('uncheck');
            }
            if (datos.Fumigacion == "Si"){
                $('#fumigacionsint').switchbutton('check');
            } else {
                $('#fumigacionsint').switchbutton('uncheck');
            }
            if (datos.MateriaOrganica == "Si"){
                $('#materiaorganicasint').switchbutton('check');
            } else {
                $('#materiaorganicasint').switchbutton('uncheck');
            }
            if (datos.Repelentes == "Si"){
                $('#repelentessint').switchbutton('check');
            } else {
                $('#repelentessint').switchbutton('uncheck');
            }
            $('#frecuenciasint').combobox('setValue', datos.Periodicidad);
            $('#dondeduermesint').combobox('setValue', datos.Duerme);
            if (datos.QuedaLibre == "Si"){
                $('#quedasueltosint').switchbutton('check');
            } else {
                $('#quedasueltosint').switchbutton('uncheck');
            }

            $('#usuariosintmasc').textbox('setValue', datos.Usuario);
            $('#altasintmasc').textbox('setValue', datos.Alta);

        // si no hay un registro cargado
        } else {

            // cargamos las claves
            document.getElementById('idmascotasint').value = this.Mascota;
            document.getElementById('idpacientesint').value = this.Paciente;

            // nos aseguramos de inicializar los check
            $('#anorexiasint').switchbutton('uncheck');
            $('#adinamiasint').switchbutton('uncheck');
            $('#emasiacionsint').switchbutton('uncheck');
            $('#polidipsiasint').switchbutton('uncheck');
            $('#atrofiasint').switchbutton('uncheck');
            $('#paresiasint').switchbutton('uncheck');
            $('#convulsionesint').switchbutton('uncheck');
            $('#adenomegaliasint').switchbutton('uncheck');
            $('#blefaritissint').switchbutton('uncheck');
            $('#conjuntivitissint').switchbutton('uncheck');
            $('#queratitissint').switchbutton('uncheck');
            $('#uveitissint').switchbutton('uncheck');
            $('#palidezsint').switchbutton('uncheck');
            $('#epistaxissint').switchbutton('uncheck');
            $('#ulcerassint').switchbutton('uncheck');
            $('#diarreasint').switchbutton('uncheck');
            $('#nodulossint').switchbutton('uncheck');
            $('#vomitossint').switchbutton('uncheck');
            $('#artritissint').switchbutton('uncheck');
            $('#eritemasint').switchbutton('uncheck');
            $('#pruritosint').switchbutton('uncheck');
            $('#ulceracutsint').switchbutton('uncheck');
            $('#noduloscutsint').switchbutton('uncheck');
            $('#alopecialocsint').switchbutton('uncheck');
            $('#alopeciagensint').switchbutton('uncheck');
            $('#hiperqueratosisnsint').switchbutton('uncheck');
            $('#hiperqueratosispsint').switchbutton('uncheck');
            $('#seborreagrasasint').switchbutton('uncheck');
            $('#seborreaescsint').switchbutton('uncheck');
            $('#onicogrifosissint').switchbutton('uncheck');
            $('#casohumanosint').switchbutton('uncheck');
            $('#flebotomossint').switchbutton('uncheck');
            $('#casatrampeadasint').switchbutton('uncheck');
            $('#fumigacionsint').switchbutton('uncheck');
            $('#materiaorganicasint').switchbutton('uncheck');
            $('#repelentessint').switchbutton('uncheck');
            $('#frecuenciasint').combobox('setValue', "");
            $('#dondeduermesint').combobox('setValue', "");
            $('#quedasueltosint').switchbutton('uncheck');

            // cargamos el usuario y la fecha de alta
            $('#usuariosintmasc').textbox('setValue', sessionStorage.getItem("Usuario"));
            $('#altasintmasc').textbox('setValue', fechaActual());

        }

        // ahora cargamos las muestras en la grilla
        muestrasmasc.initGrillaMuestras(this.Mascota, this.Paciente);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón grabar que verifica se
     * hallan completado los datos mínimos
     */
    verificaSintMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // veririficamos si está insertando
        if ($('#idsintmasc').textbox('getValue') == 0 || $('#idsintmasc').textbox('getValue') == ""){
            this.Id = 0;
        } else {
            this.Id = $('#idsintmasc').textbox('getValue');
        }

        // asignamos según el estado de los switchbutton
        if ($('#anorexiasint').switchbutton('options').checked){
            this.Anorexia = "Si";
        } else {
            this.Anorexia = "No";
        }
        if ($('#adinamiasint').switchbutton('options').checked){
            this.Adinamia = "Si";
        } else {
            this.Adinamia = "No";
        }
        if ($('#emasiacionsint').switchbutton('options').checked){
            this.Emaciacion = "Si";
        } else {
            this.Emaciacion = "No";
        }
        if ($('#polidipsiasint').switchbutton('options').checked){
            this.Polidipsia = "Si";
        } else {
            this.Polidipsia = "No";
        }
        if ($('#atrofiasint').switchbutton('options').checked){
            this.Atrofia = "Si";
        } else {
            this.Atrofia = "No";
        }
        if ($('#paresiasint').switchbutton('options').checked){
            this.Paresia = "Si";
        } else {
            this.Paresia = "No";
        }
        if ($('#convulsionesint').switchbutton('options').checked){
            this.Convulsiones = "Si";
        } else {
            this.Convulsiones = "No";
        }
        if ($('#blefaritissint').switchbutton('options').checked){
            this.Blefaritis = "Si";
        } else {
            this.Blefaritis = "No";
        }
        if ($('#conjuntivitissint').switchbutton('options').checked){
            this.Conjuntivitis = "Si";
        } else {
            this.Conjuntivitis = "No";
        }
        if ($('#queratitissint').switchbutton('options').checked){
            this.Queratitis = "Si";
        } else {
            this.Queratitis = "No";
        }
        if ($('#uveitissint').switchbutton('options').checked){
            this.Uveitis = "Si";
        } else {
            this.Uveitis = "No";
        }
        if ($('#palidezsint').switchbutton('options').checked){
            this.Palidez = "Si";
        } else {
            this.Palidez = "No";
        }
        if ($('#epistaxissint').switchbutton('options').checked){
            this.Epistaxis = "Si";
        } else {
            this.Epistaxis = "No";
        }
        if ($('#ulcerassint').switchbutton('options').checked){
            this.Ulceras = "Si";
        } else {
            this.Ulceras = "No";
        }
        if ($('#nodulossint').switchbutton('options').checked){
            this.Nodulos = "Si";
        } else {
            this.Nodulos = "No";
        }
        if ($('#vomitossint').switchbutton('options').checked){
            this.Vomitos = "Si";
        } else {
            this.Vomitos = "No";
        }
        if ($('#diarreasint').switchbutton('options').checked){
            this.Diarrea = "Si";
        } else {
            this.Diarrea = "No";
        }
        if ($('#eritemasint').switchbutton('options').checked){
            this.Eritema = "Si";
        } else {
            this.Eritema = "No";
        }
        if ($('#pruritosint').switchbutton('options').checked){
            this.Prurito = "Si";
        } else {
            this.Prurito = "No";
        }
        if ($('#ulceracutsint').switchbutton('options').checked){
            this.UlceraCutanea = "Si";
        } else {
            this.UlceraCutanea = "No";
        }
        if ($('#noduloscutsint').switchbutton('options').checked){
            this.NodulosCutaneos = "Si";
        } else {
            this.NodulosCutaneos = "No";
        }
        if ($('#alopecialocsint').switchbutton('options').checked){
            this.AlopeciaLocalizada = "Si";
        } else {
            this.AlopeciaLocalizada = "No";
        }
        if ($('#alopeciagensint').switchbutton('options').checked){
            this.AlopeciaGeneralizada = "Si";
        } else {
            this.AlopeciaGeneralizada = "No";
        }
        if ($('#hiperqueratosisnsint').switchbutton('options').checked){
            this.HiperqueratosisN = "Si";
        } else {
            this.HiperqueratosisN = "No";
        }
        if ($('#hiperqueratosispsint').switchbutton('options').checked){
            this.HiperqueratosisP = "Si";
        } else {
            this.HiperqueratosisP = "No";
        }
        if ($('#casohumanosint').switchbutton('options').checked){
            this.CasoHumano = "Si";
        } else {
            this.CasoHumano = "No";
        }
        if ($('#flebotomosssint').switchbutton('options').checked){
            this.Flebotomos = "Si";
        } else {
            this.Flebotomos = "No";
        }
        if ($('#casatrampeadasint').switchbutton('options').checked){
            this.CasaTrampeada = "Si";
        } else {
            this.CasaTrampeada = "No";
        }
        if ($('#materiaorganicasint').switchbutton('options').checked){
            this.MateriaOrganica = "Si";
        } else {
            this.MateriaOrganica = "No";
        }
        if ($('#fumigacionsint').switchbutton('options').checked){
            this.Fumigacion = "Si";
        } else {
            this.Fumigacion = "No";
        }
        if ($('#repelentesint').switchbutton('options').checked){
            this.Repelentes = "Si";
        } else {
            this.Repelentes = "No";
        }
        this.Periodicidad = $('#frecuenciasint').combobox('getValue');
        this.Duerme = $('#dondeduermesint').combobox('getValue');
        if ($('#quedasueltosint').switchbutton('options').checked){
            this.QuedaLibre = "Si";
        } else {
            this.QuedaLibre = "No";
        }
        if ($('#adenomegaliasint').switchbutton('options').checked){
            this.Adenomegalia = "Si";
        } else {
            this.Adenomegalia = "No";
        }
        if ($('#artritissint').switchbutton('options').checked){
            this.Artritis = "Si";
        } else {
            this.Artritis = "No";
        }
        if ($('#onicogrifosissint').switchbutton('options').checked){
            this.Onicogrifosis = "Si";
        } else {
            this.Onicogrifosis = "No";
        }
        if ($('#seborreagrasasint').switchbutton('options').checked){
            this.SeborreaGrasa = "Si";
        } else {
            this.SeborreaGrasa = "No";
        }
        if ($('#seborreaescsint').switchbutton('options').checked){
            this.SeborreaEscamosa = "Si";
        } else {
            this.SeborreaEscamosa = "No";
        }

        // asignamos la clave de la mascota y el paciente
        this.Mascota = document.getElementById('idmascotasint').value;
        this.Paciente = document.getElementById('idpacientesint').value;

        // grabamos el registro
        this.grabaSintMascota();

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que ejecuta la consulta de grabación
     */
    grabaSintMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el formulario
        let datosSintomas = new FormData();

        // asignamos en el formulario
        datosSintomas.append("Id", this.Id);
        datosSintomas.append("Mascota", this.Mascota);
        datosSintomas.append("Paciente", this.Paciente);
        datosSintomas.append("Anorexia", this.Anorexia);
        datosSintomas.append("Adinamia", this.Adinamia);
        datosSintomas.append("Emaciacion", this.Emaciacion);
        datosSintomas.append("Polidipsia", this.Polidipsia);
        datosSintomas.append("Atrofia", this.Atrofia);
        datosSintomas.append("Paresia", this.Paresia);
        datosSintomas.append("Convulsiones", this.Convulsiones);
        datosSintomas.append("Adenomegalia", this.Adenomegalia);
        datosSintomas.append("Blefaritis", this.Blefaritis);
        datosSintomas.append("Conjuntivitis", this.Conjuntivitis);
        datosSintomas.append("Queratitis", this.Queratitis);
        datosSintomas.append("Uveitis", this.Uveitis);
        datosSintomas.append("Palidez", this.Palidez);
        datosSintomas.append("Epistaxis", this.Epistaxis);
        datosSintomas.append("Ulceras", this.Ulceras);
        datosSintomas.append("Diarrea", this.Diarrea);
        datosSintomas.append("Nodulos", this.Nodulos);
        datosSintomas.append("Vomitos", this.Vomitos);
        datosSintomas.append("Artritis", this.Artritis);
        datosSintomas.append("Eritema", this.Eritema);
        datosSintomas.append("Prurito", this.Prurito);
        datosSintomas.append("UlceraCutanea", this.UlceraCutanea);
        datosSintomas.append("NodulosCutaneos", this.NodulosCutaneos);
        datosSintomas.append("AlopeciaLocalidada", this.AlopeciaLocalizada);
        datosSintomas.append("AlopeciaGeneralizada", this.AlopeciaGeneralizada);
        datosSintomas.append("HiperqueratosisN", this.HiperqueratosisN);
        datosSintomas.append("HiperqueratosisP", this.HiperqueratosisP);
        datosSintomas.append("SeborreaGrasa", this.SeborreaGrasa);
        datosSintomas.append("SeborreaEscamosa", this.SeborreaEscamosa);
        datosSintomas.append("Onicogrifosis", this.Onicogrifosis);
        datosSintomas.append("CasoHumano", this.CasoHumano);
        datosSintomas.append("Flebotomos", this.Flebotomos);
        datosSintomas.append("CasaTrampeada", this.CasaTrampeada);
        datosSintomas.append("Fumigacion", this.Fumigacion);
        datosSintomas.append("MateriaOrganica", this.MateriaOrganica);
        datosSintomas.append("Repelentes", this.Repelentes);
        datosSintomas.append("Periodicidad", this.Periodicidad);
        datosSintomas.append("Duerme", this.Duerme);
        datosSintomas.append("QuedaLibre", this.QuedaLibre);
        datosSintomas.append("IdUsuario", sessionStorage.getItem("IdUsuario"));

        // grabamos el registro
        $.ajax({
            url: "sintmascotas/grabar.php",
            type: "POST",
            data: datosSintomas,
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si salío bien
                if (data.Resultado > 0){

                    // actualizamos en el formulario
                    $('#idsintmasc').textbox('setValue', data.Resultado);

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
     * Método llamado al pulsar el botón cancelar que según el
     * estado del formulario lo recarga o lo limpia
     */
    cancelaSintMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // según el valor
        if ($('#idsintmasc').textbox('getValue') == 0 || $('#idsintmasc').textbox('getValue') == ""){
            this.limpiaSintMascota();
        } else {
            this.getDatosSintomas(document.getElemenById('idmascotasint').value);
        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método que limpia el formulario
     */
    limpiaSintMascota(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // reiniciamos el formulario
        $('#idsintmasc').textbox('setValue', "");
        $('#usuariosintmasc').textbox('setValue', sessionStorage.getItem("Usuario"));
        $('#altasintmasc').textbox('setValue', fechaActual());

        // nos aseguramos de inicializar los check
        $('#anorexiasint').switchbutton('uncheck');
        $('#adinamiasint').switchbutton('uncheck');
        $('#emasiacionsint').switchbutton('uncheck');
        $('#polidipsiasint').switchbutton('uncheck');
        $('#atrofiasint').switchbutton('uncheck');
        $('#paresiasint').switchbutton('uncheck');
        $('#convulsionesint').switchbutton('uncheck');
        $('#adenomegaliasint').switchbutton('uncheck');
        $('#blefaritissint').switchbutton('uncheck');
        $('#conjuntivitissint').switchbutton('uncheck');
        $('#queratitissint').switchbutton('uncheck');
        $('#uveitissint').switchbutton('uncheck');
        $('#palidezsint').switchbutton('uncheck');
        $('#epistaxissint').switchbutton('uncheck');
        $('#ulcerassint').switchbutton('uncheck');
        $('#diarreasint').switchbutton('uncheck');
        $('#nodulossint').switchbutton('uncheck');
        $('#vomitossint').switchbutton('uncheck');
        $('#artritissint').switchbutton('uncheck');
        $('#eritemasint').switchbutton('uncheck');
        $('#pruritosint').switchbutton('uncheck');
        $('#ulceracutsint').switchbutton('uncheck');
        $('#noduloscutsint').switchbutton('uncheck');
        $('#alopecialocsint').switchbutton('uncheck');
        $('#alopeciagensint').switchbutton('uncheck');
        $('#hiperqueratosisnsint').switchbutton('uncheck');
        $('#hiperqueratosispsint').switchbutton('uncheck');
        $('#seborreagrasasint').switchbutton('uncheck');
        $('#seborreaescsint').switchbutton('uncheck');
        $('#onicogrifosissint').switchbutton('uncheck');
        $('#casohumanosint').switchbutton('uncheck');
        $('#flebotomossint').switchbutton('uncheck');
        $('#casatrampeadasint').switchbutton('uncheck');
        $('#fumigacionsint').switchbutton('uncheck');
        $('#materiaorganicasint').switchbutton('uncheck');
        $('#repelentessint').switchbutton('uncheck');
        $('#frecuenciasint').combobox('setValue', "");
        $('#dondeduermesint').combobox('setValue', "");
        $('#quedasueltosint').switchbutton('uncheck');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón ayuda que abre el
     * layer emergente con el contenido de la misma
     */
    ayudaSintMascotas(){

        // reiniciamos la sesión
        sesion.reiniciar();

        // definimos el contenido a agregar
        let win_ayuda = "<div id='ayuda-sintomas'></div>";

        // agregamos la definición de la grilla al dom
        $("#form-mascotas").append(win_ayuda);

        // ahora abrimos el diálogo
        $('#ayuda-sintomas').window({
            title: "Ayuda de los Síntomas de la Mascota",
            modal:true,
            maximizable: true,
            width: 900,
            height: 600,
            closed: false,
            closable: true,
            href: 'sintmascotas/ayuda.html',
            method: 'post',
            onClose:function(){$('#ayuda-sintomas').window('destroy');},
            cache: false,
            border: 'thin'
        });

        // centramos el diálogo
        $('#ayuda-sintomas').window('center');

    }

}