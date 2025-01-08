<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<div style="display: flex; flex-direction: column; min-height: 100vh;">
    <!-- Contenido principal -->
    <div class="bg-image" style="
        background-image: url('<?php echo RUTA_URL; ?>/public/img/diaguita-paisaje.jpg'); 
        background-size: cover;
        background-position: center;
        flex: 1; /* Permite que este bloque crezca para ocupar el espacio disponible */
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
                        Hola Adminstrador/a !
                    </h1>
                    <p class="lead text-left my-2" style="font-size: 1.5rem;">
                        Administra las materias de forma centralizada y eficiente. Controla usuarios y todo lo relacionado con la gestión académica!
                    </p>
                </div>
            </div>
        </div>
    </div>

  <!-- Footer -->
  <?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>
</div>
