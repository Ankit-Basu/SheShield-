<?php
class Database {
    // Parse database URL if available (for Render.com)
    private function getDbConfig() {
        if (getenv('DATABASE_URL')) {
            $db = parse_url(getenv('DATABASE_URL'));
            return [
                'host' => $db['host'],
                'db'   => ltrim($db['path'], '/'),
                'user' => $db['user'],
                'pass' => $db['pass'],
                'port' => $db['port']
            ];
        }
        return [
            'host' => 'localhost',
            'db'   => 'sheshield',
            'user' => 'root',
            'pass' => '',
            'port' => 5432
        ];
    }
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // First try to connect to MySQL server
            $dbConfig = $this->getDbConfig();
            $dsn = "pgsql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['db']};";
            $this->conn = new PDO(
                $dsn,
                $dbConfig['user'],
                $dbConfig['pass'],
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                )
            );

            // Create database if it doesn't exist
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // Select the database
            $this->conn->exec("USE `" . $this->db_name . "`");

            // Create users table if it doesn't exist
            $this->conn->exec("CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                phone VARCHAR(20),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Create incidents table if it doesn't exist (without dropping)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS incidents (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NULL,
                incident_type VARCHAR(100) NOT NULL,
                description TEXT NOT NULL,
                location VARCHAR(255) NOT NULL,
                date_time DATETIME NOT NULL,
                status VARCHAR(20) DEFAULT 'pending',
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                phone VARCHAR(20),
                email VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            return $this->conn;
        } catch(PDOException $e) {
            error_log("Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
}
?>
