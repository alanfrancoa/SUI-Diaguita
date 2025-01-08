<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Modificar comisiones</h3>
<a href="<?php echo RUTA_URL; ?>/adminController/abmComisiones" class="btn btn-primary">Volver a listado</a>

<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Modificar Comisión</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($data['mensaje'])): ?>
        <div class="alert alert-info"><?php echo $data['mensaje']; ?></div>
    <?php endif; ?>

    <!-- Verificar si se obtuvo una comisión para modificar -->
    <?php if ($data['comision']): ?>
        <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/modificarComisionAction">
            <div class="mb-3">
                <label for="idComision" class="form-label">ID de comisión (no editable):</label>
                <input type="text" class="form-control" id="idComision" name="id-comision"
                    value="<?php echo $data['comision']->id_comision; ?>" readonly>

                <label for="diasComision">Seleccione los días:</label>
                <select class="form-control" id="diasComisionSelect" name="dias-comision">
                    <option value="Lunes, Miércoles y Viernes" <?php echo $data['comision']->dia_comision == "Lunes, Miércoles y Viernes" ? 'selected' : ''; ?>>Lunes, Miércoles y Viernes</option>
                    <option value="Martes, Jueves y Sábado" <?php echo $data['comision']->dia_comision == "Martes, Jueves y Sábado" ? 'selected' : ''; ?>>Martes, Jueves y Sábado</option>
                </select>

                <label for="turnoComision">Seleccione el turno:</label>
                <select class="form-control" id="turnoComisionSelect" name="turno-comision">
                    <option value="Mañana" <?php echo $data['comision']->horario_comision == "Mañana" ? 'selected' : ''; ?>>Mañana</option>
                    <option value="Tarde" <?php echo $data['comision']->horario_comision == "Tarde" ? 'selected' : ''; ?>>Tarde</option>
                    <option value="Noche" <?php echo $data['comision']->horario_comision == "Noche" ? 'selected' : ''; ?>>Noche</option>
                </select>
            </div>

            <!-- Mensaje de error en caso de que falle la modificación -->
            <?php if (!empty($data['error_modificar_comision'])): ?>
                <div class="alert alert-danger"><?php echo $data['error_modificar_comision']; ?></div>
            <?php endif; ?>

            <button type="submit" class="estilo-botones w-100 my-2">Modificar</button>
        </form>
    <?php else: ?>
        <p>No se encontró la comisión para modificar.</p>
    <?php endif; ?>
</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>