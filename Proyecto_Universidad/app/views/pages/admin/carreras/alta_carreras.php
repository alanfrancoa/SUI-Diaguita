<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<h3 class="titulo-fuente text-black">Alta carreras</h3>

<a href="<?php echo RUTA_URL; ?>/adminController/abmCarreras" class="btn btn-primary">Volver a listado</a>


<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Crear Carrera</h2>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/altaCarreraAction">
        <div class="mb-3">
           <!-- <label for="idCarrera" class="form-label">Ingrese ID de la carrera:</label>
            <input type="text" class="form-control" id="idCarrera" name="id_carrera" placeholder="Ingresa el ID de la carrera" required> -->

            <label for="nombreCarrera" class="form-label">Ingrese nombre de la carrera:</label>
            <input type="text" class="form-control" id="nombreCarrera" name="nombre_carrera" placeholder="Ingresa el nombre de la carrera" required>

        </div>
        <?php if (!empty($data['error_crear_carrera'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_crear_carrera']; ?></div>
        <?php endif; ?>


        <button type="submit" class="estilo-botones w-100 my-2">Agregar</button>
    </form>
</div>



<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>