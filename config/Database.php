<?php
// config/database.php

class Database {
    
    private static $host = 'localhost';
    private static $db   = 'tareas_database';
    private static $user = 'root';
    private static $pass = 'root';          
    private static $charset = 'utf8mb4';

     /**
     * Crea y retorna una nueva conexión a la base de datos.
     *
     * @return PDO Objeto PDO para la conexión a la base de datos.
     */
    public static function conectar() {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;

        // Opciones adicionales para el manejo de la conexión PDO
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
            PDO::ATTR_EMULATE_PREPARES   => false,                  
        ];

        try {
            $pdo = new PDO($dsn, self::$user, self::$pass, $options);
            return $pdo;
        } catch (PDOException $e) {
            die('Error en la conexión: ' . $e->getMessage());
        }
    }
}
?>
