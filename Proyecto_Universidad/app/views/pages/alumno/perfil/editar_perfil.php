<?php require RUTA_APP . '/views/layout/alumno/header.php'; ?>


<div class="container mt-5">
    <h2 class="text-center mb-4">Formulario Alumno</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($data['exito_editar_perfil'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($data['exito_editar_perfil']) ?>
        </div>
    <?php elseif (!empty($data['error_editar_perfil'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($data['error_editar_perfil']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form action="<?php echo RUTA_URL; ?>/alumnoController/editarPerfilAction" class="row g-3" method="POST">
        <!-- Nombre -->
        <div class="col-md-6">
            <label for="nombreAlumno" class="form-label">Nombre</label>
            <input type="text" class="form-control"
                name="nombre-alumno"
                value="<?= htmlspecialchars($_POST['nombre-alumno'] ?? $data['alumno']->nombre_alumno) ?>"
                id="nombreAlumno" placeholder="Ingrese el nombre" required>
        </div>
        <!-- Apellido -->
        <div class="col-md-6">
            <label for="apellidoAlumno" class="form-label">Apellido</label>
            <input type="text"
                name="apellido-alumno"
                value="<?= htmlspecialchars($_POST['apellido-alumno'] ?? $data['alumno']->apellido_alumno ?? '') ?>"
                class="form-control" id="apellidoAlumno" placeholder="Ingrese el apellido" required>
        </div>
        <!-- Email -->
        <div class="col-md-12">
            <label for="emailAlumno" class="form-label">Email</label>
            <input type="email"
                name="email-alumno"
                value="<?= htmlspecialchars($_POST['email-alumno'] ?? $data['alumno']->email_alumno ?? '') ?>"
                class="form-control" id="emailAlumno" placeholder="Ingrese el correo electrónico" required>
        </div>
        <!-- Fecha de Nacimiento -->
        <div class="col-md-12">
            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control w-25" id="fechaNacimiento" name="fecha-nacimiento-alumno"
                value="<?= htmlspecialchars($_POST['fecha-nacimiento-alumno'] ?? $data['alumno']->fecha_nacimiento ?? '') ?>">
        </div>
        <!-- Botón de envío -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>

<?php require RUTA_APP . '/views/layout/alumno/footer.php'; ?>