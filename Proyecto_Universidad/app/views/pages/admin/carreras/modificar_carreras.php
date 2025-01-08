<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Modificar Carrera</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmCarreras" class="btn btn-primary">Volver a listado</a>

<!-- Mostrar mensaje de éxito o error -->
<?php if (!empty($data['mensaje'])): ?>
    <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
<?php endif; ?>

<!-- Verificar si se obtuvo una carrera para modificar -->
<?php if ($data['carrera']): ?>
    <div class="container p-5">
        <h2 class="text-center mb-4">Modificar Carrera</h2>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/modificarCarreraAction">
            <div class="mb-3">
                <!-- Campo ID Carrera (Solo lectura) -->
                <label for="idCarrera" class="form-label">ID de carrera (no editable):</label>
                <input type="text" class="form-control" id="idCarrera" name="id_carrera"
                    value="<?php echo $data['carrera']->id_carrera; ?>" readonly>

                <!-- Campo Nombre Carrera -->
                <label for="nombreCarrera" class="form-label">Nombre de la carrera:</label>
                <input type="text" class="form-control" id="nombreCarrera" name="nombre_carrera"
                    value="<?php echo $data['carrera']->nombre_carrera; ?>" required>
            </div>

            <!-- Mensaje de error en caso de que falle la modificación -->
            <?php if (!empty($data['error_modificar_carrera'])): ?>
                <div class="alert alert-danger"><?php echo $data['error_modificar_carrera']; ?></div>
            <?php endif; ?>

            <button type="submit" class="estilo-botones w-100 my-2">Modificar</button>
        </form>
    </div>
<?php else: ?>
    <p class="alert alert-danger text-center">No se encontró la carrera para modificar.</p>
<?php endif; ?>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>
