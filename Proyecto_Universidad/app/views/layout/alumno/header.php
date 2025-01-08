<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siu Diaguita</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos adicionales -->
    <link href="<?php echo RUTA_URL; ?>/public/css/estilos_landing.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
  <!-- Cabecera del sitio -->
  <header class="p-3">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Logo del sitio -->
            <a href="<?php echo RUTA_URL; ?>/alumnoController/index" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="<?php echo RUTA_URL; ?>/public/img/logo.svg" class="bi me-2" width="40" height="32" alt="Logo">
            </a>
            
            <!-- Menú de navegación centrado -->
            <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0 me-auto">
                <li><a href="<?php echo RUTA_URL; ?>/alumnoController/index" class="nav-link px-2 text-white">INICIO</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/alumnoController/getMateriasAlumno" class="nav-link px-2 text-white">MATERIAS</a></li>
                <li><a href="<?php echo RUTA_URL; ?>/alumnoController/perfilAlumnoVista" class="nav-link px-2 text-white">PERFIL</a></li>
            </ul>

            <!-- Boton -icono estudiante para cierre sesion -->
            <div class="d-flex flex-wrap align-items-center"> 
                <a href="<?php echo RUTA_URL; ?>/authController/logout">
                    <button type="button" class="estilo-botones mx-2">Cerrar Sesión</button> 
                    <i class="fa-solid fa-user-graduate fa-xl" style="color: #f8d082;" margin-left: 5px;"></i>
                </a>
            </div> 
            </div> 
        </div>
    </div>
</header>

