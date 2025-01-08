<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>

<style>

    .no-spinners::-webkit-inner-spin-button,
    .no-spinners::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-spinners {
        -appearance: textfield;
    }
</style>

<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-2">Alta de Profesor</h2>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/altaProfesorAction">

        <div class="mb-3">
            <label for="nombre_profesor" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre_profesor" name="nombre_profesor" placeholder="Ingrese el Nombre del profesor" required>
        </div>
        <div class="mb-3">
            <label for="apellido_profesor" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido_profesor" name="apellido_profesor" placeholder="Ingrese el Apellido del profesor" required>
        </div>
        <div class="mb-3">
            <label for="dni_profesor" class="form-label">DNI</label>
            <input type="number" class="form-control no-spinners" id="dni_profesor" name="dni_profesor" placeholder="Ingrese el DNI del profesor" required>
        </div>
        <div class="mb-3">
            <label for="email_profesor" class="form-label">Email</label>
            <input type="email" class="form-control" id="email_profesor" name="email_profesor" placeholder="Ingrese el Email del profesor" required>
        </div>
        <?php if (!empty($data['error_crear_profesor'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_crear_profesor']; ?></div>
        <?php endif; ?>

        <button type="submit" class="estilo-botones w-100 my-2">Dar de alta</button>

    </form>

</div>



<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>