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
            width: 1300,
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
            onText: 'Si',
            offText: 'No'
        });
        $('#adinamiasint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#emasiacionsint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#polidipsiasint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#atrofiasint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#paresiasint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#convulsionesint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#blefaritissint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#conjuntivitissint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#queratitissint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#uveitissint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#palidezsint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#epistaxissint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#ulcerassint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#nodulossint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#vomitossint').switchbutton({
            onText: 'Si',
            offText: 'No'
        });
        $('#diarreasint').switchbutton({
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
            $('#usuariosintmasc').textbox('setValue', datos.Usuario);
            $('#altasintmasc').textbox('setValue', datos.Alta);

        // si no hay un registro cargado
        } else {

            // cargamos las claves
            document.getElementById('idmascotasint').value = this.Mascota;
            document.getElementById('idpacientesint').value = this.Paciente;

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

        // el resto de los campos los permitimos en blanco
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