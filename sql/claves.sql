/**

    @author Claudio Invernizzi <cinvernizzi@dsgestion.site>
    @date 04/11/2025
    Script llamado luego de recrear todas las tablas que 
    verifica las claves foráneas

    La falta de relación con al tabla de usuarios es intencional
    ya que como se encuentra en otra base de datos trae problemas
    al momento de restaurar de un bakcup

*/

-- Establecemos la página de códigos
SET CHARACTER_SET_CLIENT=utf8;
SET CHARACTER_SET_RESULTS=utf8;
SET COLLATION_CONNECTION=utf8_spanish_ci;

-- seleccionamos la base
USE leishmania;

-- eliminamos si existe
ALTER TABLE actividades
DROP CONSTRAINT IF EXISTS actividadespaciente;

-- la tabla de actividades
ALTER TABLE actividades 
ADD CONSTRAINT actividadespaciente 
FOREIGN KEY (paciente) REFERENCES pacientes(id);

-- eliminamos si existe
ALTER TABLE clinica
DROP CONSTRAINT IF EXISTS clinicapaciente;

-- la tabla de clínica
ALTER TABLE clinica
ADD CONSTRAINT clinicapaciente
FOREIGN KEY (paciente) REFERENCES pacientes(id);

-- eliminamos si existe
ALTER TABLE control
DROP CONSTRAINT IF EXISTS controlpacientes;

-- la tabla de control
ALTER TABLE control
ADD CONSTRAINT controlpacientes
FOREIGN KEY (paciente) REFERENCES pacientes(id);

-- eliminamos si existe
ALTER TABLE evolucion
DROP CONSTRAINT IF EXISTS evolucionpaciente;

-- la tabla de evolución
ALTER TABLE evolucion
ADD CONSTRAINT evolucionpaciente 
FOREIGN KEY (paciente) REFERENCES pacientes(id);

-- eliminamos si existe
ALTER TABLE mascotas
DROP CONSTRAINT IF EXISTS mascotaspaciente;

-- la tabla de mascotas
ALTER TABLE mascotas
ADD CONSTRAINT mascotaspaciente
FOREIGN KEY(paciente) REFERENCES pacientes(id);

-- la tabla de muestras (que tiene varias relaciones)
ALTER TABLE muestras
DROP CONSTRAINT IF EXISTS muestraspaciente;
ALTER TABLE muestras
DROP CONSTRAINT IF EXISTS muestrasmaterial;
ALTER TABLE muestras
DROP CONSTRAINT IF EXISTS muestrastecnica;

-- recreamos los índices
ALTER TABLE muestras
ADD CONSTRAINT muestraspaciente
FOREIGN KEY (paciente) REFERENCES pacientes(id);
ALTER TABLE muestras
ADD CONSTRAINT muestrasmaterial
FOREIGN KEY(material) REFERENCES dicmaterial(id);
ALTER TABLE muestras
ADD CONSTRAINT muestrastecnica
FOREIGN KEY(tecnica) REFERENCES dictecnicas(id);

-- las muestras de las mascotas que también 
-- se relaciona con varias tablas
ALTER TABLE muestrasmasc
DROP CONSTRAINT IF EXISTS muestrasmascpaciente;
ALTER TABLE muestrasmasc
DROP CONSTRAINT IF EXISTS muestrasmascmascota;
ALTER TABLE muestrasmasc
DROP CONSTRAINT IF EXISTS muestrasmascmaterial;
ALTER TABLE muestrasmasc 
DROP CONSTRAINT IF EXISTS muestrasmasctecnica;

-- ahora las recreamos
ALTER TABLE muestrasmasc
ADD CONSTRAINT muestrasmascpaciente
FOREIGN KEY(paciente) REFERENCES pacientes(id);
ALTER TABLE muestrasmasc
ADD CONSTRAINT muestrasmascmascota
FOREIGN KEY(mascota) REFERENCES mascotas(id);
ALTER TABLE muestrasmasc
ADD CONSTRAINT muestrasmascmaterial
FOREIGN KEY(material) REFERENCES dicmaterial(id);
ALTER TABLE muestrasmasc
ADD CONSTRAINT muestrasmasctecnica
FOREIGN KEY(tecnica) REFERENCES dictecnicas(id);

-- la tabla de pacientes
ALTER TABLE pacientes
DROP CONSTRAINT IF EXISTS pacientesocupacion;

-- la recreamos
ALTER TABLE pacientes
ADD CONSTRAINT pacientesocupacion
FOREIGN KEY(ocupacion) REFERENCES ocupaciones(id);

-- la tabla de peridomicilio
ALTER TABLE peridomicilio
DROP CONSTRAINT IF EXISTS peridomiciliopaciente;
ALTER TABLE peridomicilio
DROP CONSTRAINT IF EXISTS peridomicilioanimal;

-- la recreamos
ALTER TABLE peridomicilio
ADD CONSTRAINT peridomiciliopaciente
FOREIGN KEY(paciente) REFERENCES pacientes(id);
ALTER TABLE peridomicilio
ADD CONSTRAINT peridomicilioanimal
FOREIGN KEY(animal) REFERENCES dicanimales(id);

-- la tabla de síntomas de las mascotas
ALTER TABLE sintmascotas
DROP CONSTRAINT IF EXISTS sintmascotasmascota;
ALTER TABLE sintmascotas
DROP CONSTRAINT IF EXISTS sintmascotaspaciente;

-- la recreamos
ALTER TABLE sintmascotas
ADD CONSTRAINT sintmascotaspaciente 
FOREIGN KEY(paciente) REFERENCES pacientes(id);
ALTER TABLE sintmascotas
ADD CONSTRAINT sintmascotasmascota
FOREIGN KEY(mascota) REFERENCES mascotas(id);

-- la tabla de viajes
ALTER TABLE viajes
DROP CONSTRAINT IF EXISTS viajespaciente;

-- la recreamos
ALTER TABLE viajes
ADD CONSTRAINT viajespaciente
FOREIGN KEY(paciente) REFERENCES pacientes(id);
