<?php
namespace App\Controller;

use \PDO;
use \PDOException;

class DepartamentosController
{
    private $db;

    public function __construct()
    {
        $this->db = $this->BDConnection();
    }
    private function BDConnection()
    {
        try {
            return new PDO('mysql:host=localhost;dbname=NexusRH;charset=utf8', 'root', '1234');
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
            exit;
        }
    }

    public function visualizarDepartamentos() {
        $query = "SELECT * FROM dep_departamento WHERE dep_status = 1";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
    
    public function inserirDepartamento($depNome) {
        $query = "INSERT INTO dep_departamento (dep_nome) VALUES (:dep_nome)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':dep_nome', $depNome);
        return $stmt->execute();
    }

    public function editarDepartamento($depId, $depNome) {
        $query = "UPDATE dep_departamento SET dep_nome = :dep_nome WHERE dep_id = :dep_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':dep_nome', $depNome);
        $stmt->bindParam(':dep_id', $depId);
        return $stmt->execute();
    }

    public function desativarDepartamento($depId) {
        $query = "UPDATE dep_departamento SET dep_status = 0 WHERE dep_id = :dep_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':dep_id', $depId);
        return $stmt->execute();
    }

    
}

