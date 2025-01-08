<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Alta comisiones</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmComisiones" class="btn btn-primary">Volver a listado</a>


<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Crear Comision</h2>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/altaComisionAction">
        <div class="mb-3">
            <label for="idComision" class="form-label">Ingrese ID de comisión:</label>
            <input type="text" class="form-control" id="idComision" name="id-comision" placeholder="Ingresa el ID de la comisión" required>

            <label for="diasComision">Seleccione los días:</label>
            <select class="form-control" id="diasComisionSelect" name="dias-comision">
                <option value="Lunes, Miércoles y Viernes">Lunes, Miércoles y Viernes</option>
                <option value="Martes, Jueves y Sábado">Martes, Jueves y Sábado</option>
            </select>

            <label for="turnoComision">Seleccione el turno:</label>
            <select class="form-control" id="turnoComisionSelect" name="turno-comision">
                <option value="Mañana">Mañana</option>
                <option value="Tarde">Tarde</option>
                <option value="Noche">Noche</option>
            </select>
        </div>
        <?php if (!empty($data['error_crear_comision'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_crear_comision']; ?></div>
        <?php endif; ?>


        <button type="submit" class="estilo-botones w-100 my-2">Agregar</button>
    </form>
</div>



<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>