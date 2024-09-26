<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!--
    Vista para editar una tarea existente.
    Esta página muestra un formulario pre-llenado con los detalles de la tarea que se desea editar.
-->

<h1>Editar Tarea</h1>

<!-- Muestra los errores de validación -->
<?php if (!empty($errores)): ?>
    <div class="errores">
        <?php foreach ($errores as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="index.php?action=editar&id=<?= intval($tarea['id']) ?>">
    <label for="titulo">Título:</label><br>
    <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($tarea['titulo']) ?>" required><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea><br>

    <label for="prioridad">Prioridad:</label><br>
    <select name="prioridad" id="prioridad">
        <option value="Alta" <?= $tarea['prioridad'] == 'Alta' ? 'selected' : '' ?>>Alta</option>
        <option value="Media" <?= $tarea['prioridad'] == 'Media' ? 'selected' : '' ?>>Media</option>
        <option value="Baja" <?= $tarea['prioridad'] == 'Baja' ? 'selected' : '' ?>>Baja</option>
    </select><br>

    <label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="<?= isset($tarea['fecha_vencimiento']) ? htmlspecialchars($tarea['fecha_vencimiento']) : '' ?>"><br>

    <!-- Lista desplegable de usuarios disponibles como responsables -->
    <div class="mb-3">
        <label for="usuario_id" class="form-label">Responsable:</label>
        <select name="usuario_id" id="usuario_id" class="form-select">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?= intval($usuario['id']) ?>" <?= isset($tarea) && $tarea['usuario_id'] == $usuario['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Actualizar</button>
</form>
