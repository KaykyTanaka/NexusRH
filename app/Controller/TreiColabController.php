<?php
namespace App\Controller;

use \App\Model\ColaboradoresModel;
use \App\Controller\LoginController;
use \PDO;
use \PDOException;

class TreiColabController extends ColaboradoresModel
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

    public function getAllTreiColab()
    {
        $teste = self::BDConnection();
        $stmt = 
        $teste->query('SELECT p.pes_nome, t.tre_titulo, t.tre_responsavel FROM treinamentos_do_colaborador
        INNER JOIN tre_treinamento t USING (tre_id)
        INNER JOIN col_colaborador c USING (col_id)
        INNER JOIN usu_usuarios USING (usu_id)
        INNER JOIN pes_pessoas p USING (pes_id);');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getColaboradores(){
        $sql = 'SELECT c.col_id, p.pes_nome
        FROM col_colaborador c INNER JOIN usu_usuarios u USING (usu_id) INNER JOIN pes_pessoas p USING (pes_id)
        WHERE col_status = true';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTreinamentos(){
        $sql = 'SELECT tre_id, tre_titulo
        FROM tre_treinamento';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function linkarTreinoColab($colID, $treID)
    {
        try {
            $sql = "INSERT INTO treinamentos_do_colaborador (tre_id, col_id) VALUES (:treID, :colID)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':colID', $colID);
            $stmt->bindParam(':treID', $treID);
            $stmt->execute();

            return "Colaborador inserido com sucesso.";
        } catch (PDOException $e) {
            return "Erro ao inserir o treinamento: " . $e->getMessage();
        }
    }
}