<?php
// public/index.php

require_once __DIR__ . '/../app/controllers/TareaController.php';

// Manejo de rutas simples
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$controller = new TareaController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'crear':
        $controller->crear();
        break;
    case 'editar':
        if ($id) {
            $controller->editar($id);
        } else {
            header('Location: index.php?action=index');
        }
        break;
    default:
        echo "Página no encontrada.";
        break;
}
