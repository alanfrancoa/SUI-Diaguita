<?php require RUTA_APP . '/views/layout/landing/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 25rem;">
        <h2 class="text-center mb-4">Recuperar Contraseña</h2>
        <p class="text-center">Ingresa tu correo electrónico para reestablecer la contraseña</p>
        <form method="POST" action="<?php echo RUTA_URL; ?>/authController/resetPasswordAction">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu email" required>
            </div>
            <?php if (!empty($data['error_recupero_clave'])): ?>
                <div class="alert alert-danger">
                    <?php echo $data['error_recupero_clave']; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($data['exito_recupero_clave'])): ?>
                <div class="alert alert-success">
                    <?php echo $data['exito_recupero_clave']; ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="estilo-botones w-100">Enviar enlace</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?php echo RUTA_URL; ?>/authController/login">Volver al inicio de sesión</a>
        </div>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/landing/footer.php'; ?>