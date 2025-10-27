/*

    Nombre: diagnostico.sql
    Fecha: 20/03/2017
    Autor: Lic. Claudio Invernizzi
    E-Mail: cinvernizzi@dsgestion.site
    Licencia: GPL
    Producido en: DsGestion
    Buenos Aires - Argentina
    Comentarios: definicion de la estructura de base de datos del sistema
                 de pacientes de leishmania

    En la base de datos CCE
    1. La tabla de Laboratorios
    2. La tabla de Usuarios Autorizados de CCE

    De la base de datos de diagnóstico
    1. La tabla de Instituciones Asistenciales
    2. Los permisos de acceso de los usuarios

   En la base de Diccionarios tendremos (comunes a las dos plataformas)
   1. La tabla de países
   2. La tabla de jurisdicciones
   3. La tabla de localidades
   4. El diccionario de tipos de documento
   5. El diccionario de dependencias

   Las tablas específicas de leishmania son
   1. Actividades las actividades realizadas por el paciente
   2. Clínica datos de la historia clínica y antecedentes
   3. Control de control y seguimiento del paciente
   4. Dicmaterial diccionario de tipos de muestras recibidos
   5. Dicanimales diccionario de animales y objetos del peridomicilio
   6. Dictecnicas diccionario de técnicas diagnósticas utilizadas
   7. Evolución datos de la evolución del paciente
   8. Mascotas los animales del paciente
   9. Muestras las muestras recibidas del paciente que incluye la
      técnica aplicada y el tipo de material de cada muestra
   10. Ocupaciones diccionario de ocupaciones del paciente
   11. Pacientes datos de filiación del paciente
   12. Peridomicilio datos de objetos y animales del peridomicilio
   13. Sintmascotas síntomas de las mascotas
   14. Viajes realizados por el paciente
   15. Muestras tomadas a las mascotas
*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- eliminamos la base si existe
DROP DATABASE IF EXISTS leishmania;

-- la creamos
CREATE DATABASE IF NOT EXISTS leishmania
DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
