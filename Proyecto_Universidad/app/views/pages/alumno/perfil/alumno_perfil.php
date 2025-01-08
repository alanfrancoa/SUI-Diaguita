<?php require RUTA_APP . '/views/layout/alumno/header.php'; ?>

<div class="container my-5">
    <h2>Detalle del Usuario</h2>
    <?php if ($data['usuario']) : ?>
        <p><strong>Nombre de Usuario:</strong> <?= htmlspecialchars($data['usuario']->nombre_usuario) ?></p>
        <p><strong>Fecha de Alta:</strong> 
            <?php
                echo !empty($data['usuario']->createdAt) ? date('d/m/Y', strtotime($data['usuario']->createdAt)) : 'Sin especificar';
            ?>
        </p>
        <a href="<?php echo RUTA_URL; ?>/alumnoController/editarClaveVista" class="mb-3 btn btn-warning">Cambiar clave</a>
        <h3>Datos del Alumno</h3>

        <?php if (!empty($data['usuario']->dni_alumno)) : ?>
            <p><strong>DNI Alumno:</strong> <?= htmlspecialchars($data['usuario']->dni_alumno) ?></p>
            <p><strong>Fecha de Nacimiento Alumno:</strong>
                <?php
                echo !empty($data['usuario']->fecha_nacimiento) ? date('d/m/Y', strtotime($data['usuario']->fecha_nacimiento)) : 'Sin especificar';
                ?>
            </p>
            <p><strong>Nombre Alumno:</strong> <?= htmlspecialchars($data['usuario']->nombre_alumno) ?></p>
            <p><strong>Apellido Alumno:</strong> <?= htmlspecialchars($data['usuario']->apellido_alumno) ?></p>
            <p><strong>Carrera Alumno:</strong> <?= htmlspecialchars($data['usuario']->nombre_carrera) ?></p>
            <p><strong>Email Alumno:</strong> <?= htmlspecialchars($data['usuario']->email_alumno) ?></p>
            <a href="<?php echo RUTA_URL; ?>/alumnoController/editarPerfilVista" class="mb-3 btn btn-warning">Editar Perfil</a>
        <?php else : ?>
            <p>No hay un alumno relacionado con este usuario.</p>
        <?php endif; ?>
    <?php else : ?>
        <p><?= htmlspecialchars($data['mensaje']) ?></p>
    <?php endif; ?>
</div>

<!-- Footer -->
<?php require RUTA_APP . '/views/layout/alumno/footer.php'; ?>