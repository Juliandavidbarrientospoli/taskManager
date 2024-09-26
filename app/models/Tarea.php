<?php
// app/models/Tarea.php
require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo para gestionar las tareas en la base de datos.
 */
class Tarea {
    private $db;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     * @throws PDOException Si ocurre un error de conexión.
     */
    public function __construct() {
        $this->db = $this->conectar();
    }

    /**
     * Método privado para conectar a la base de datos y manejar errores de conexión.
     * @return PDO Objeto PDO para interactuar con la base de datos.
     */
    private function conectar() {
        try {
            return Database::conectar();
        } catch (PDOException $e) {
            error_log('Error de conexión en la base de datos: ' . $e->getMessage());
            throw $e; // Re-lanzar la excepción para manejarla en un nivel más alto si es necesario.
        }
    }

    /**
     * Ejecuta una consulta SQL y maneja errores.
     * @param string $sql La consulta SQL a ejecutar.
     * @param array $params Parámetros para la consulta preparada.
     * @return mixed Resultado de la consulta o false si ocurre un error.
     */
    private function ejecutarConsulta($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return ($stmt->rowCount() > 0) ? $stmt : false;
        } catch (PDOException $e) {
            error_log('Error ejecutando consulta: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todas las tareas de la base de datos, incluyendo el nombre del usuario responsable.
     * @return array|false Arreglo de todas las tareas o false en caso de error.
     */
    public function obtenerTodas() {
        $sql = "SELECT t.*, u.nombre AS responsable FROM tareas t LEFT JOIN usuarios u ON t.usuario_id = u.id ORDER BY t.fecha_creacion DESC";
        return $this->ejecutarConsulta($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una tarea por su ID.
     * @param int $id El ID de la tarea a obtener.
     * @return array|false Datos de la tarea solicitada o false en caso de error.
     */
    public function obtenerPorId($id) {
        $sql = "SELECT t.*, u.nombre AS responsable FROM tareas t LEFT JOIN usuarios u ON t.usuario_id = u.id WHERE t.id = :id";
        $resultado = $this->ejecutarConsulta($sql, [':id' => $id]);
        return $resultado ? $resultado->fetch(PDO::FETCH_ASSOC) : false;
    }

    /**
     * Crea una nueva tarea en la base de datos.
     * @param array $datos Datos de la nueva tarea a crear.
     * @return bool Retorna true si la operación es exitosa, false de lo contrario.
     */
    public function crear($datos) {
        $sql = "INSERT INTO tareas (titulo, descripcion, prioridad, fecha_vencimiento, usuario_id) VALUES (:titulo, :descripcion, :prioridad, :fecha_vencimiento, :usuario_id)";
        return $this->ejecutarConsulta($sql, $datos);
    }

    /**
     * Actualiza los datos de una tarea existente.
     * @param int $id El ID de la tarea a actualizar.
     * @param array $datos Datos actualizados de la tarea.
     * @return bool Retorna true si la operación es exitosa, false de lo contrario.
     */
    public function actualizar($id, $datos) {
        $datos[':id'] = $id; // Agregar el ID al array de datos para la consulta
        $sql = "UPDATE tareas SET titulo = :titulo, descripcion = :descripcion, prioridad = :prioridad, fecha_vencimiento = :fecha_vencimiento, usuario_id = :usuario_id WHERE id = :id";
        return $this->ejecutarConsulta($sql, $datos);
    }
}
?>
