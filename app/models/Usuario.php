<?php
// app/models/Usuario.php
require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo para gestionar los usuarios en la base de datos.
 */
class Usuario {
    private $db;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     */
    public function __construct() {
        $this->db = Database::conectar();
    }

    /**
     * Obtiene todos los usuarios de la base de datos.
     * @return array|false Arreglo de todos los usuarios o false en caso de error.
     */
    public function obtenerTodos() {
        $sql = "SELECT * FROM usuarios ORDER BY nombre ASC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error en obtenerTodos: ' . $e->getMessage());
            return false;  // Retorna false en caso de error
        }
    }

    /**
     * Verifica si un usuario existe en la base de datos por su ID.
     * @param int $id El ID del usuario a verificar.
     * @return bool Retorna true si el usuario existe, false de lo contrario.
     */
    public function existe($id) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error en existe: ' . $e->getMessage());
            return false; 
        }
    }
}
?>
