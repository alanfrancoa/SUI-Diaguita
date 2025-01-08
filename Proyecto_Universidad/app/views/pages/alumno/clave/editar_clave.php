<?php require RUTA_APP . '/views/layout/alumno/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Cambiar Contraseña</h1>

            <!-- Mensajes de error o éxito -->
            <?php if (!empty($data['error_cambio_clave'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $data['error_cambio_clave']; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['exito_cambio_clave'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $data['exito_cambio_clave']; ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de cambio de contraseña -->
            <form action="<?php echo RUTA_URL; ?>/alumnoController/editarClaveAction" method="POST">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Contraseña Antigua:</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
            </form>
        </div>
    </div>
</div>

<?php require RUTA_APP . '/views/layout/alumno/footer.php'; ?>