<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>
<style>
    /* Ocultar las flechas de incremento */
    .no-spinners::-webkit-inner-spin-button,
    .no-spinners::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Ocultar las flechas de incremento (Firefox) */
    .no-spinners {
        -appearance: textfield;
    }
</style>

<!-- FORM -->
<div class="container p-5">
    <h2 class="text-center mb-4">Alta de Usuario</h2>
    <form method="POST" action="<?php echo RUTA_URL; ?>/adminController/altaUsuarioAction">
        <!-- Parte del Alta del Usuario -->
        <div class="mb-3">
            <label for="nombre-usuario" class="form-label">Nombre de Usuario:</label>
            <input type="number" class="form-control no-spinners" id="nombre-usuario" name="nombre-usuario" placeholder="Ingrese el DNI del Usuario" required>
            <label for="clave-usuario" class="form-label">Clave:</label>
            <input type="password" class="form-control" id="claveUsuario" name="clave-usuario" placeholder="Ingrese la clave del Usuario" required>
        </div>
        <h2 class="text-center mb-4">Alta de Alumno</h2>
        <!-- Parte del Alta del Alumno -->
        <div class="mb-3">
            <label for="nombre-alumno" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre-alumno" name="nombre-alumno" placeholder="Ingrese el Nombre del alumno" required>
        </div>
        <div class="mb-3">
            <label for="apellido-alumno" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="claveUsuario" name="apellido-alumno" placeholder="Ingrese el Apellido del alumno" required>
        </div>
        <div class="mb-3">
            <label for="email-alumno" class="form-label">Email</label>
            <input type="email" class="form-control" id="email-alumno" name="email-alumno" placeholder="Ingrese el Email del alumno" required>
        </div>
        <label for="carrera-alumno" class="form-label">Carrera</label>
        <select class="form-control" id="carrera-alumno" name="carrera-alumno" required>
            <option value="">Seleccionar una carrera...</option>
            <?php foreach ($data['carreras'] as $carrera): ?>
                <option value="<?php echo $carrera->id_carrera; ?>"><?php echo $carrera->nombre_carrera; ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($data['error_crear_usuario'])): ?>
            <div class="alert alert-danger"><?php echo $data['error_crear_usuario']; ?></div>
        <?php endif; ?>

        <button type="submit" class="estilo-botones w-100 my-2">Dar de alta</button>

    </form>

</div>

<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>