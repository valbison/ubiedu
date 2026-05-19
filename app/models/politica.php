<?php

class Politica {
    private $conn;
    private $table = "privacy_policies";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔥 Buscar versão ativa
    public function getVersaoAtiva() {
        $query = "SELECT * FROM {$this->table} 
                  WHERE ativo = 1 
                  ORDER BY topico ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodasVersoes() {
        $query = "SELECT DISTINCT versao, data_publicacao 
                FROM {$this->table}
                ORDER BY versao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 🔥 Buscar por data (versão)
    public function getPorVersao($versao) {
        $query = "SELECT * FROM {$this->table} 
                WHERE versao = :versao
                ORDER BY topico ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":versao", $versao);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}