# /bin/bash

# author Claudio Invernizzi <cinvernizzi@dsgestion.site>
# date 04/08/2025
# Licencia: GPL
# copyright DsGestion

# definimos las constantes de usuario y contraseña
USUARIO="root"
PASSWORD='gamaeco'

# la base no la regeneramos mas ya que los scripts incluyen la sentencia drop table
# primero cargamos la definición de la base
echo "Generando base de datos"
mariadb -u $USUARIO -p$PASSWORD < leishmania.sql

# primero vamos a generar los diccionarios

echo "Generando diccionario de ocupaciones"
mariadb -u $USUARIO -p$PASSWORD < ocupaciones.sql

# creamos el diccionario de tipos de material recibido
echo "Generando tablas del diccionario de materiales recibidos"
mariadb -u $USUARIO -p$PASSWORD < dicmaterial.sql

# creamos el diccionario del objetos del peridomicilio
echo "Generando tablas de animales y objetos del peridomicilio"
mariadb -u $USUARIO -p$PASSWORD < dicanimales.sql

# creamos el diccionario de técnicas utilizadas
echo "Generando tablas de técnicas utilizadas"
mariadb -u $USUARIO -p$PASSWORD < dictecnicas.sql

# creamos la tabla de actividades
echo "Generando tablas de actividades de los pacientes"
mariadb -u $USUARIO -p$PASSWORD < actividades.sql

# creamos la tabla de control y seguimiento del paciente
echo "Generando tablas de control y seguimiento"
mariadb -u $USUARIO -p$PASSWORD < control.sql

# creamos la tabla de evolución del paciente
echo "Generando tablas de la evolución del paciente"
mariadb -u $USUARIO -p$PASSWORD < evolucion.sql

# creamos la tabla de mascotas del paciente
echo "Generando diccionario de mascotas"
mariadb -u $USUARIO -p$PASSWORD < mascotas.sql

# creamos la tabla de muestras recibidas
echo "Generando tablas de muestras recibidas"
mariadb -u $USUARIO -p$PASSWORD < muestras.sql

# la tabla del peridomicilio
echo "Generando tablas del peridomicilio"
mariadb -u $USUARIO -p$PASSWORD < peridomicilio.sql

# la tabla de síntomas de las mascotas
echo "Generando tablas de síntomas de las mascotas"
mariadb -u $USUARIO -p$PASSWORD < mascotas.sql

# los viajes realizados por el paciente
echo "Generando tablas de viajes realizados"
mariadb -u $USUARIO -p$PASSWORD < viajes.sql

# creamos la tabla de síntomas de las mascotas
echo "Generando tablas de síntomas de las mascotas"
mariadb -u $USUARIO -p$PASSWORD < sintmascotas.sql

# creamos la tabla de muestras tomadas a las mascotas
echo "Generando tablas de muestras de las mascotas"
mariadb -u $USUARIO -p$PASSWORD < muestrasmasc.sql

# creamos la tabla de pacientes
echo "Generando tablas de pacientes"
mariadb -u $USUARIO -p$PASSWORD < pacientes.sql

# creamos la tabla de datos clínicos
echo "Generando tablas de datos clínicos"
mariadb -u $USUARIO -p$PASSWORD < clinica.sql

# creamos las claves foráneas
echo "Generando claves foráneas"
mariadb -u $USUARIO -p$PASSWORD < claves.sql

# presentamos el mensaje
echo "Generación de tablas realizada"
