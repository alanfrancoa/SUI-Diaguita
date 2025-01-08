<?php require RUTA_APP . '/views/layout/admin/header.php'; ?>
<div class="container my-5">
    <h2>Detalle del Usuario</h2>
    <?php if ($data['usuario']) : ?>
        <p><strong>ID Usuario:</strong> <?= htmlspecialchars($data['usuario']->id_usuario) ?></p>
        <p><strong>Nombre de Usuario:</strong> <?= htmlspecialchars($data['usuario']->nombre_usuario) ?></p>
        <p><strong>Fecha de Alta:</strong> <?= htmlspecialchars($data['usuario']->createdAt) ?></p>
        <?php if (is_null($data['usuario']->deletedAt)) : ?>
            <div class="alert alert-success d-inline-block">
                El usuario está activo
            </div>
        <?php else : ?>
            <div class="alert alert-danger d-inline-block">
                Inactivo desde: <?= htmlspecialchars($data['usuario']->deletedAt) ?>
            </div>
        <?php endif; ?>
        <h3>Datos del Alumno</h3>
        <?php if (!empty($data['usuario']->dni_alumno)) : ?>
            <p><strong>DNI Alumno:</strong> <?= htmlspecialchars($data['usuario']->dni_alumno) ?></p>
            <p><strong>Nombre Alumno:</strong> <?= htmlspecialchars($data['usuario']->nombre_alumno) ?></p>
            <p><strong>Apellido Alumno:</strong> <?= htmlspecialchars($data['usuario']->apellido_alumno) ?></p>
            <p><strong>Email Alumno:</strong> <?= htmlspecialchars($data['usuario']->email_alumno) ?></p>
            <p><strong>Carrera Alumno:</strong> <?= htmlspecialchars($data['usuario']->nombre_carrera) ?></p>
        <?php else : ?>
            <p>No hay un alumno relacionado con este usuario.</p>
        <?php endif; ?>
    <?php else : ?>
        <p><?= htmlspecialchars($data['mensaje']) ?></p>
    <?php endif; ?>
</div>
<?php require RUTA_APP . '/views/layout/admin/footer.php'; ?>