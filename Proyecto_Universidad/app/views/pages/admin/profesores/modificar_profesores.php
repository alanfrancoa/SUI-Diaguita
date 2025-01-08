<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Modificar profesores</h3>
<a href="<?php echo RUTA_URL; ?>/adminController/abmProfesores" class="btn btn-primary">Volver a listado</a>

<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Modificar Profesor</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($data['mensaje'])): ?>
        <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
    <?php endif; ?>

    <!-- Verificar si se obtuvo algpun profesor para modificar -->
    <?php if ($data['profesor']): ?>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/modificarProfesorAction">
            <div class="mb-3">
                <label for="dni_profesor" class="form-label">DNI:</label>
                <input type="text" class="form-control" id="dni_profesor" name="dni_profesor"
                    value="<?php echo $data['profesor']->dni_profesor; ?>" readonly>

                <label for="nombre_profesor">Nombre:</label>
                <input type="text" class="form-control" id="nombre_profesor" name="nombre_profesor"
                    value="<?php echo $data['profesor']->nombre_profesor; ?>">

                <label for="apellido_profesor">Apellido:</label>
                <input type="text" class="form-control" id="apellido_profesor" name="apellido_profesor"
                    value="<?php echo $data['profesor']->apellido_profesor; ?>">

                <label for="email_profesor">Email:</label>
                <input type="text" class="form-control" id="email_profesor" name="email_profesor"
                    value="<?php echo $data['profesor']->email_profesor; ?>">

                
            </div>

            <!-- Mensaje de error en caso de que falle la modificación -->
            <?php if (!empty($data['error_modificar_profesor'])): ?>
                <div class="alert alert-danger"><?php echo $data['error_modificar_profesor']; ?></div>
            <?php endif; ?>

            <button type="submit" class="estilo-botones w-100 my-2">Modificar</button>
        </form>
    <?php else: ?>
        <p>No se encontró el profesor para modificar.</p>
    <?php endif; ?>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>