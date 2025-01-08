<?php require RUTA_APP . '/views/layout/landing/header.php'; ?>

<div class="bg-image" style="
    background-image: url('<?php echo RUTA_URL; ?>/public/img/diaguita-paisaje.jpg'); 
    background-size: cover;
    background-position: center;
    height: 100vh; /* Altura completa de la ventana */
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
                <h1 class="display-5 fw-bold lh-1 mb-1 titulo text-left">¡Bienvenidx a SIU Diaguita!</h1>
                <p class="lead text-left my-2">Accede a tus materias y anótate fácilmente. ¡Simplifica tu vida académica!</p>
            </div>
            <!-- Sección inicio sesion-formulario -->
            <div class="col-10 col-sm-8 col-lg-6">
                <div class="card p-4 shadow-lg " style="width: 33rem; background-color: rgba(255, 255, 255, 0.7); min-height: 400px; ">
                    <h2 class="text-center mb-4">Inicia sesión</h2>
                    <form method="POST" action="<?php echo RUTA_URL; ?>/authController/loginUsuario">
                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="username" placeholder="Ingresa tu usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <?php if (!empty($data['error_login'])): ?>
                            <div class="alert alert-danger"><?php echo $data['error_login']; ?></div>
                        <?php endif; ?>
                        <button type="submit" class="estilo-botones w-100 my-2">Iniciar sesión</button>
                    </form>
                    <a href="<?php echo RUTA_URL; ?>/authController/reset">Olvidé mi contraseña</a>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <div class="container d-flex justify-content-center align-items-start vh-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/landing/footer.php'; ?>