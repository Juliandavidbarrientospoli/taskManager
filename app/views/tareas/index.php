<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!--
    Vista que lista todas las tareas existentes.
    Muestra una tabla con todas las tareas, sus detalles y acciones.
-->

<h1>Lista de Tareas</h1>
<a href="index.php?action=crear" class="btn">Agregar Tarea</a>

<table>
    <tr>
        <th>Título</th>
        <th>Descripción</th>
        <th>Prioridad</th>
        <th>Fecha Vencimiento</th>
        <th>Responsable</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($tareas as $tarea): ?>
        <tr>
            <td><?= htmlspecialchars($tarea['titulo']) ?></td>
            <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
            <td><?= htmlspecialchars($tarea['prioridad']) ?></td>
            <td><?= htmlspecialchars($tarea['fecha_vencimiento']) ?></td>
            <td><?= htmlspecialchars($tarea['responsable']) ?></td>
            <td>
                <a href="index.php?action=editar&id=<?= intval($tarea['id']) ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
