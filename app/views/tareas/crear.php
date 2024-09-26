<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!--
    Vista para crear nuevas tareas.
    Esta página muestra un formulario para ingresar los detalles de una nueva tarea.
-->

<h1>Agregar Tarea</h1>

<!-- Muestra los errores de validación -->
<?php if (!empty($errores)): ?>
    <div class="errores">
        <?php foreach ($errores as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="index.php?action=crear">
    <label for="titulo">Título:</label><br>
    <input type="text" name="titulo" id="titulo" required><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" id="descripcion" required></textarea><br>

    <label for="prioridad">Prioridad:</label><br>
    <select name="prioridad" id="prioridad" required>
        <option value="Alta">Alta</option>
        <option value="Media" selected>Media</option>
        <option value="Baja">Baja</option>
    </select><br>

    <label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" required><br>

    <!-- Lista desplegable de usuarios disponibles como responsables -->
    <div class="mb-3">
        <label for="usuario_id" class="form-label">Responsable:</label>
        <select name="usuario_id" id="usuario_id" class="form-select" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= intval($usuario['id']) ?>">
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Guardar</button>
</form>
