<?php

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = $_ENV['hostdb'] ?? 'localhost';
        $this->db_name = $_ENV['db_name'] ?? '';
        $this->username = $_ENV['username'] ?? 'root';
        $this->password = $_ENV['password'] ?? '';
    }

    public function conectar() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo json_encode(["erro" => "Erro de conexão: " . $e->getMessage()]);
            exit;
        }

        return $this->conn;
    }
}