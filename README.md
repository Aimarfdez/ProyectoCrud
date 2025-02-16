README - Mejoras en el CRUD de Clientes en PHP

USUARIOS INICIO SESION:

usuario1 , password:usuario 1 ---> Sin permisos
usuario2 , password:usuario2 ---> Con permisos



Descripción del Proyecto

Este proyecto consiste en un sistema CRUD de gestión de clientes desarrollado en PHP, con mejoras enfocadas en la validación de datos, la usabilidad, la seguridad y la visualización de información adicional. Se han implementado diversas optimizaciones y nuevas funcionalidades.

Lista de Mejoras Implementadas

1. Navegación Mejorada en Detalles y Modificar

Se han agregado los botones "Siguiente" y "Anterior" para facilitar la navegación entre clientes desde las vistas de detalles y modificar.

2. Validación de Datos en Nuevo y Modificar

Se verifica que:

El correo electrónico no esté repetido.

La IP ingresada tenga un formato válido.

El número de teléfono cumpla con el formato 999-999-9999.

3. Gestión de Imágenes de Clientes

Se muestra la imagen asociada al cliente almacenada en la carpeta uploads/.

Si no existe una imagen, se usa una imagen por defecto aleatoria generada desde RoboHash.

Las imágenes se guardan con el formato 00000XXX.jpg, donde XXX corresponde al ID del cliente.

4. Subida y Cambio de Imágenes

Se permite subir o cambiar la foto del cliente en las vistas de "Nuevo" y "Modificar".

Se validan las imágenes para que:

Sean de tipo jpg o png.

No superen los 500 Kbps de tamaño.

5. Bandera del País en la Vista de Detalles

Se obtiene la bandera del país correspondiente a la IP del cliente utilizando:

ip-api.com para obtener la geolocalización de la IP.

Flagpedia para mostrar la bandera del país.

6. Listado de Clientes con Diferentes Modos de Ordenación

Se permite ordenar la lista de clientes por:

Nombre

Apellido

Correo Electrónico

Género

IP

Se mantiene la funcionalidad de "Siguiente" y "Anterior" según el criterio de ordenación seleccionado.

7. Generación de PDF con Detalles del Cliente

Se ha añadido un botón de "Imprimir" que genera un archivo PDF con toda la información de un cliente.

8. Implementación de Autenticación de Usuarios

Se ha creado una nueva tabla User con los siguientes campos:

login

password (almacenado de forma encriptada)

rol (0: solo visualización, 1: administración)

Se implementó un sistema de autenticación:

Solo permite el acceso con credenciales válidas.

Tras tres intentos fallidos, se requiere reiniciar el navegador para intentar nuevamente.

9. Control de Acceso Según Rol

Los usuarios con rol 0 solo pueden visualizar datos (lista y detalles de clientes).

Los usuarios con rol 1 pueden realizar todas las acciones: modificar, borrar y administrar usuarios.

10. Mapa de Localización Geográfica del Cliente

Se ha integrado un mapa interactivo que muestra la ubicación geográfica del cliente en función de su IP.

Se utiliza la API de GeoIP junto con OpenLayers para la visualización del mapa.

Requisitos del Proyecto

Tecnologías Utilizadas

Backend: PHP, MySQL

Frontend: HTML, CSS, JavaScript

APIs Externas:

RoboHash → Generación de imágenes aleatorias.

ip-api.com → Obtención de datos de geolocalización por IP.

Flagpedia → Obtención de banderas de países.

OpenLayers → Mapa interactivo de ubicación geográfica.

Librerías y Dependencias

PHP:

mysqli para la gestión de base de datos.

FPDF para la generación de archivos PDF.

JavaScript:

fetch API para consumo de APIs externas.

OpenLayers para la visualización del mapa.

CSS:

Bootstrap (opcional) para mejorar la interfaz de usuario.

Instalación y Configuración

Clonar el repositorio en el servidor.

Importar la base de datos clientes.sql en MySQL.

Configurar el archivo config.php con las credenciales de la base de datos.

Asegurar que la carpeta uploads/ tenga permisos de escritura para almacenar imágenes de clientes.

Instalar las dependencias necesarias (FPDF en PHP si no está instalado).

Ejecutar la aplicación desde el navegador.

Conclusión

Con estas mejoras, el CRUD de clientes en PHP ha sido optimizado en términos de validación de datos, experiencia de usuario, seguridad y presentación visual. Se han integrado APIs y librerías externas para enriquecer la funcionalidad y mejorar la usabilidad del sistema.
