<?php
namespace App\Controller;

use \PDO;
use \PDOException;

class Dashboard
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

    // Função para obter o total de colaboradores
    public function getTotalColaboradores()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM col_colaborador WHERE col_status = true";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    // Função para obter colaboradores sem treinamento
    public function getColaboradoresSemTreinamento()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM col_colaborador 
                    WHERE col_id NOT IN (SELECT col_id FROM treinamentos_do_colaborador);";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    // Função para obter o treinamento com mais colaboradores
    public function getTreinamentoMaisColaboradores()
    {
        try {
            $sql = "SELECT tre_titulo, COUNT(ct.col_id) as total 
                    FROM tre_treinamento t 
                    JOIN treinamentos_do_colaborador ct ON t.tre_id = ct.tre_id 
                    GROUP BY t.tre_titulo 
                    ORDER BY total DESC 
                    LIMIT 1";
            $stmt = $this->db->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }


    // Função para obter colaboradores por departamento
    public function getColaboradoresPorDepartamento()
    {
        try {
            $sql = "SELECT d.dep_nome, COUNT(c.col_id) as total 
                    FROM dep_departamento d 
                    JOIN col_colaborador c ON d.dep_id = c.dep_id 
                    WHERE c.col_status = true 
                    GROUP BY d.dep_nome";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
// Função para obter o total de departamentos
    public function getTotalDepartamentos() {
        $sql = "SELECT COUNT(*) AS total FROM dep_departamento";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

  
}
