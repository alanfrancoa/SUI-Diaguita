<?php require RUTA_APP . '/views/layout/alumno/header.php'; ?>

<div style="display: flex; flex-direction: column; min-height: 100vh; margin: 0;">
    <!-- Contenido principal -->
    <div class="bg-image" style="
        background-image: url('<?php echo RUTA_URL; ?>/public/img/diaguita-paisaje.jpg'); 
        background-size: cover;
        background-position: center;
        height: 100vh; /* Asegura que el fondo ocupe toda la pantalla */
        position: relative;
    ">
        <div class="overlay" style="
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semitransparente */
        "></div>

        <div class="container py-5" style="position: relative; z-index: 1; color: white;">
            <!-- Sección de introducción con imagen -->
            <div class="row align-items-stretch g-5 py-5">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-1 titulo text-left">
                        Hola Alumno 
                        <?php echo $_SESSION['nombre_alumno']; ?> !
                    </h1>
                    <p class="lead text-left my-2" style="font-size: 1.5rem;">
                        Explora y accede a tus materias, organiza tu vida académica. ¡Optimiza tu tiempo y mantén todo bajo control en un solo lugar!
                    </p>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Footer -->
    <?php require RUTA_APP . '/views/layout/alumno/footer.php'; ?>

</div>