<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Proyecto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos adicionales -->
    <link href="<?php echo RUTA_URL; ?>/public/css/estilos_landing.css" rel="stylesheet">
</head>
<body>
  <!-- Cabecera del sitio -->
  <header class="p-3">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Logo del sitio -->
            <a href="<?php echo RUTA_URL; ?>/adminController/index" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="<?php echo RUTA_URL; ?>/public/img/logo.svg" class="bi me-2" width="40" height="32" alt="Logo">
            </a>
            
            <!-- Menú de navegación centrado -->
            <ul class="nav col-lg-auto mb-2 mb-md-0 me-auto">
                <li><a href="<?php echo RUTA_URL; ?>/adminController/index" class="nav-link px-2 text-white">INICIO</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/adminController/abmCarreras" class="nav-link px-2 text-white">CARRERAS</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/adminController/abmComisiones" class="nav-link px-2 text-white">COMISIONES</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/adminController/abmMaterias" class="nav-link px-2 text-white">MATERIAS</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/adminController/abmProfesores" class="nav-link px-2 text-white">PROFESORES</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/adminController/abmUsuarios" class="nav-link px-2 text-white">CUENTA</a></li>
            </ul>
            <!-- Boton cierre sesion -->
            <div class="d-flex flex-wrap align-items-center"> 
                <a href="<?php echo RUTA_URL; ?>/authController/logout">
                    <button type="button" class="estilo-botones mx-2">Cerrar Sesión</button>
                </a>
            </div> 
            </div> 
        </div>
    </div>
</header>