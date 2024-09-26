<?php
// app/controllers/TareaController.php
require_once __DIR__ . '/../models/Tarea.php';
require_once __DIR__ . '/../models/Usuario.php';

class TareaController
{
    private $model;
    private $usuarioModel;

    /**
     * Constructor de la clase TareaController.
     * Inicializa los modelos de tarea y usuario.
     */
    public function __construct()
    {
        $this->model = new Tarea();
        $this->usuarioModel = new Usuario();
    }

    /**
     * Muestra la página de inicio con todas las tareas.
     */
    public function index()
    {
        $tareas = $this->model->obtenerTodas();
        require_once __DIR__ . '/../views/tareas/index.php';
    }

    /**
     * Maneja la creación de una nueva tarea.
     * Recoge datos del formulario, valida y almacena la tarea.
     */
    public function crear()
    {
        $errores = [];
        $usuarios = $this->usuarioModel->obtenerTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $this->obtenerDatosTarea($_POST);
            $errores = $this->validarDatosTarea($datos);

            if (empty($errores)) {
                $this->model->crear($datos);
                header('Location: index.php?action=index');
                exit;
            }
        }
        require_once __DIR__ . '/../views/tareas/crear.php';
    }

    /**
     * Maneja la edición de una tarea existente.
     * Carga datos de la tarea a editar, valida y actualiza los cambios.
     *
     * @param int $id Identificador de la tarea a editar.
     */
    public function editar($id)
    {
        $tarea = $this->model->obtenerPorId($id);
        if (!$tarea) {
            header('Location: index.php?action=index');
            exit;
        }

        $usuarios = $this->usuarioModel->obtenerTodos();

        if ($tarea['fecha_vencimiento']) {
            $fecha = new DateTime($tarea['fecha_vencimiento']);
            $tarea['fecha_vencimiento'] = $fecha->format('Y-m-d');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $this->obtenerDatosTarea($_POST, $tarea);
            $errores = $this->validarDatosTarea($datos);

            if (empty($errores)) {
                $this->model->actualizar($id, $datos);
                header('Location: index.php?action=index');
                exit;
            }
        }

        require_once __DIR__ . '/../views/tareas/editar.php';
    }

    /**
     * Recoge y sanitiza los datos de entrada del formulario.
     * 
     * @param array $input Datos del formulario.
     * @param array|null $tareaExistente Datos de la tarea existente para preservar valores.
     * @return array Datos sanitizados.
     */
    private function obtenerDatosTarea($input, $tareaExistente = null)
    {
        return [
            'titulo' => $this->sanitizeInput($input['titulo']),
            'descripcion' => $this->sanitizeInput($input['descripcion']),
            'prioridad' => $this->sanitizeInput($input['prioridad']),
            'fecha_vencimiento' => isset($input['fecha_vencimiento']) && !empty($input['fecha_vencimiento'])
                ? $this->sanitizeInput($input['fecha_vencimiento'])
                : ($tareaExistente ? $tareaExistente['fecha_vencimiento'] : null),
            'usuario_id' => isset($input['usuario_id']) ? (int) $input['usuario_id'] : ($tareaExistente ? $tareaExistente['usuario_id'] : null)
        ];
    }

    /**
     * Valida los datos de la tarea.
     *
     * @param array $datos Datos de la tarea a validar.
     * @return array Lista de errores.
     */
    private function validarDatosTarea($datos)
    {
        $errores = [];

        if (empty($datos['titulo'])) {
            $errores[] = 'El título de la tarea es obligatorio.';
        }

        if (empty($datos['descripcion'])) {
            $errores[] = 'Debe proporcionar una descripción para la tarea.';
        }

        if (empty($datos['prioridad']) || !in_array($datos['prioridad'], ['Alta', 'Media', 'Baja'])) {
            $errores[] = 'Debe seleccionar una prioridad válida: Alta, Media, o Baja.';
        }

        if (!empty($datos['fecha_vencimiento']) && !$this->validateDate($datos['fecha_vencimiento'])) {
            $errores[] = 'La fecha de vencimiento proporcionada no es válida. Asegúrese de usar el formato correcto (AAAA-MM-DD).';
        }

        if (empty($datos['usuario_id']) || !$this->usuarioModel->existe($datos['usuario_id'])) {
            $errores[] = 'Debe seleccionar un usuario responsable válido.';
        }

        return $errores;
    }

    /**
     * Sanitiza una cadena de entrada.
     *
     * @param string $data Cadena a sanitizar.
     * @return string Cadena sanitizada.
     */
    private function sanitizeInput($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    /**
     * Valida si una fecha tiene el formato correcto.
     *
     * @param string $date Fecha a validar.
     * @param string $format Formato esperado de la fecha.
     * @return bool Verdadero si la fecha es válida.
     */
    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
