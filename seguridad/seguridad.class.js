/*

    Nombre: seguridad.class.js
    Autor: Lic. Claudio Invernizzi
    Fecha: 13/02/2025
    E-Mail: cinvernizzi@dsgestion.site
    Proyecto: Leishmania
    Producido: Claudio Invernizzi <cinvernizzi@dsgestion.site>
    Licencia: GPL
    Comentarios: Clase que controla las operaciones de ingreso
                 y trazabilidad de los usuarios

*/

/**
 *
 * Atención, utilizamos el estandard definido en ECMAScript 2015 (ES6)
 *
 */

/*jshint esversion: 6 */

// declaración de la clase
class Seguridad {

    // constructor de la clase
    constructor(){

        // configuramos los elementos del formulario
        $('#usuario').textbox({
            width: 250,
            label: 'Usuario:',
            labelWidth: 100,
            labelPosition:'before',
            labelAlign: 'right'
        });
        $('#password').passwordbox({
            width: 250,
            label: 'Contraseña:',
            labelWidth: 100,
            labelPosition:'before',
            labelAlign: 'right'
        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón ingresar que
     * verifica se halla completado correctamente el
     * formulario
     */
    Ingresar(){

        // verificamos los valores
        let usuario = $('#usuario').textbox('getValue');
        let password = $('#password').passwordbox('getValue');

        // verifica el usuario
        if (usuario == ""){
            Mensaje("Error", "Atención", "Ingrese su Usuario");
            return;
        }

        // verifica la contraseña
        if (password == ""){
            Mensaje("Error", "Atención", "Ingrese su contraseña");
            return;
        }

        // verificamos las credenciales
        this.Validar(usuario, password);

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} usuario - el nombre de usuario
     * @param {string} password - la contraseña del usuario
     * Método llamado luego de verificar el formulario que
     * verifica las credenciales de acceso
     */
    Validar(usuario, password){

        // definimos la clase
        let clase = this;

        // verificamos las credenciales
        $.ajax({
            url: "validar.php?usuario="+usuario+"&password="+password,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si no acreditó
                if (!data.Resultado){

                    // presenta el mensaje
                    Mensaje("Error", "Atencion", "Hay un error en las credenciales");

                // si no está activo
                } else if (data.Activo == "No"){

                    // presenta el mensaje
                    var mensaje = "El usuario no está activo. Comuníquese ";
                    mensaje += "con el Administrador del Sitio.";
                    $.messager.alert('Error', mensaje, 'error');

                // si acreditó
                } else {

                    // configuramos los permisos
                    clase.asignaIngreso(data);

                }

            }

        });

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {array} datos - vector con el registro
     * Método que recibe como parámetro el vector con los
     * datos del usuario y los asigna a las variables
     * de sesión, luego redirige el navegador al
     * escritorio de la aplicación
     */
    asignaIngreso(datos){

        // asignamos en la sesión
        sessionStorage.setItem("IdUsuario", datos.IdUsuario);
        sessionStorage.setItem("Usuario", datos.Usuario);
        sessionStorage.setItem("Area", datos.Area);
        sessionStorage.setItem("IdArea", datos.IdArea);
        sessionStorage.setItem("Administrador", datos.Administrador);
        sessionStorage.setItem("IdSesion", datos.Sesion);

        // redirigimos el navegador
        window.location = "../index.html";

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @return {bool} - si puede editar
     * Método llamado al editar cualquiera de los diccionarios
     * del sistema que verifica el nivel de acceso, si puede
     * editar / insertar / borrar retorna true, caso contrario
     * presenta el mensaje y retorna falso
     */
    verificaAcceso(){

        // verificamos el nivel de acceso
        if (sessionStorage.getItem("Administrador") != "Si"){

            // presenta el mensaje y retorna
            let mensaje = "Usted no tiene permisos para ";
            mensaje += "añadir / editar diccionarios ";
            mensaje += "del sistema.";
            $.messager.alert('Atención',mensaje);
            return false;

        // si puede editar
        } else {

            // simplemente retornamos
            return true;

        }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el enlace de recuperación
     * de contrasña, cierra el layer de ingreso y luego
     * presenta el formulario de ingreso de correo
     */
    recuperaPassword(){

        // creamos el div
        $("#contenedor").append("<div id='win-seguridad'></div>");

        // pedimos ingrese el mail
        $('#win-seguridad').window({
            width:420,
            height:350,
            modal:true,
            title: "Recuperar Contraseña",
            minimizable: false,
            closable: false,
            href: 'recuperar.html',
            onClose:function(){$('#win-seguridad').window('destroy');},
            method: 'post',
            loadingMessage: 'Cargando',
            border: 'thin'
        });

        // centramos el formulario
        $('#win-seguridad').window('center');

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar el botón confirmar del
     * formulario de recuperación de contraseñá que
     * verifica que esté completado correctamente
     */
    verificaRecuperacion(){

      // obtenemos el valor
      var mail = $('#recuperamail').textbox('getValue');

      // si no ingresó el mail
      if (mail == ""){

          // presenta el mensaje
          Mensaje("Error", "Atención", "Debe ingresar un mail válido");

      // verifica el mail
      } else if (!echeck(mail)){

          // presenta el mensaje
          Mensaje("Error", "Atención", "El mail parece incorrecto");

      // si llegó hasta aquí
      } else {

          // enviamos el mail
          this.enviaRecuperacion(mail);

      }

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} mail - dirección de correo
     * Método llamado luego de verificar el formulario de
     * recuperación que envía los datos al servidor, el
     * que reinicia la contraseña y envía el mail en caso
     * que el correo de recuperación sea correcto o
     * retorna falso en caso que el mail no se encuentra
     */
    enviaRecuperacion(mail){

        // definimos la clase
        var clase = this;

        // verificamos que el mail exista
        $.ajax({
            url: "recuperamail.php?mail="+mail,
            type: "GET",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si encontró el usuario
                if (data.Resultado){

                    // enviamos el correo
                    clase.enviaCorreo(data.Usuario, data.Password, mail);

                    // cerramos el diálogo
                    $('#win-seguridad').window('destroy');

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "El correo no está registrado");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * @param {string} usuario - nombre del usuario
     * @param {string} password - password generado
     * @param {string} mail - correo del usuario
     * Método llamado luego de recuperar la contraseña
     * que envía el correo al usuario informando de
     * sus credenciales de acceso
     */
    enviaCorreo(usuario, password, mail){

        // enviamos el correo
        $.ajax({
            url: "enviamail.php?mail="+mail+"&usuario="+usuario+"&password="+password,
            type: "POST",
            cahe: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                // si pudo enviar
                if (data.Resultado == null){

                    // presenta el mensaje
                    Mensaje("Info", "Atención", "Se ha enviado la recuperación a " + mail);

                // si hubo un error
                } else {

                    // presenta el mensaje
                    Mensaje("Error", "Atención", "Ocurrió un error al enviar el correo");

                }

        }});

    }

    /**
     * @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
     * Método llamado al pulsar sobre la opción salir
     * del menú de usuarios, cierra la sesión y
     * recarga la página inicial
     */
    salir(){

        // grabamos el log de usuarios
        $.get('seguridad/salir.php?Sesion='+sessionStorage.getItem("IdSesion"));

        // destruye las variables de sesión javascript
        sessionStorage.removeItem("IdUsuario");

        // redirigimos el navegador
        window.location = "seguridad/login.html";

    }

}
