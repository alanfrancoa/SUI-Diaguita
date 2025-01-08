# Proyecto Universidad para Aplicaciones Web - Sistema de Gestión Académica SIU Diaguita

Este proyecto es un sistema de gestión académica desarrollado en PHP. Permite gestionar carreras, comisiones,  profesores y usuarios. El sistema incluye funcionalidades de autenticación, ABMs (Altas, Bajas, Modificaciones) y vistas diferenciadas para administración y usuarios.

# Indice 
- [Funcionalidades y roles principales]
- [Requisitos]
- [Instalación]
- [Credenciales]
- [Desarrolladores]

---

# Funcionalidades y roles principales

Administrador:
- **Gestión de Carreras**: Alta, baja, modificación, asociación de materias y visualización de materias activas e inactivas.
- **Gestión de Comisiones**: Alta, baja, modificación y visualización de comisiones activas e inactivas.
- **Gestión de Materia**: Alta, baja, modificación, asociación de profesores y visualización de materias activas e inactivas.
- **Gestión de Profesores**: Alta, baja, modificación, asociación de profesores y visualización de materias activas e inactivas.
- **Sistema de Autenticación**: Alta, baja, reactivación, detalle y visualización de listado de usuarios activos e inactivos.


Alumno: 
- **Materias**: visualiza materias de su carrera.
- **Perfil**: visualiza detalles de su cuenta y permite el cambio de contraseña.

---

# Requisitos
Para ejecutar este proyecto, necesitarás:
- **Servidor Web**: Apache - Xampp.
- **PHP**: Versión 7.4 o superior.
- **Base de Datos**: PhpMyAdmin - MySQL.

---

# Instalación

1. **Clonar el Repositorio**:
  git clone https://github.com/juanPabloCesarini/appweb_caba_2c_2024.git
  

2. Configurar la Base de Datos:

Crea una base de datos en MySQL llamada appweb_caba_universidad.
Importa el archivo SQL ubicado en C:\xampp\htdocs\appweb_caba_2c_2024\A-Grupo1\Proyecto_Universidad\database.

3.Configurar Variables de Entorno: Renombra el archivo config/config.example.php a config/config.php y edítalo:


 // configuracion acceso a la BD
   define('DB_HOST','localhost:3306');
   define('DB_USER','root');
   define('DB_PASSWORD','');
   define('DB_NAME','appweb_caba_universidad');

   // Ruta de la aplicación
   define('RUTA_APP', dirname(dirname(__FILE__)));
   // Ruta url

   define('RUTA_URL','http://localhost/appweb_caba_2c_2024/A-Grupo1/Proyecto_Universidad');

   
   define('NOMBRESITIO','Administrador de tareas');


4 Configurar Archivos .ini para Envío de Correos:

Copia los archivos php.ini y sendmail.ini que vienen en la carpeta config/.
Pégalos en el directorio de configuración de tu servidor PHP:
Para XAMPP, esto suele estar en C:\xampp\php\ (php.ini) y C:\xampp\sendmail\ (sendmail.ini).


5. Configurar el Servidor:

6. Asegúrate de que el servidor web apunte al directorio public/ como raíz del proyecto.
Iniciar el Proyecto: Abre tu navegador y navega a:

http://localhost/appweb_caba_2c_2024/A-Grupo1/Proyecto_Universidad/landingController/index

---

# Credenciales

Para acceder a las funciones de administración, utiliza las siguientes credenciales:

Usuario: univ2024
Contraseña: Univ897ersidad

