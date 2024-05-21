<?php
namespace App\Controller;

use \App\Model\TreinamentosModel;
use \PDO;
use \PDOException;

class TreinamentosController extends TreinamentosModel
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

    public function getAllTreinamentos()
    {
        $teste = self::BDConnection();
        $stmt = $teste->query('SELECT * FROM tre_treinamento WHERE tre_ativo = true;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getColabTreinamentos($colID)
    {
        $stmt = 
        $this->db->query("SELECT t.*  FROM tre_treinamento t, col_colaborador c, treinamentos_do_colaborador tc where
        t.tre_id = tc.tre_id and c.col_id in (
        SELECT c.col_id FROM col_colaborador c 
        INNER JOIN usu_usuarios u USING (usu_id) 
        INNER JOIN pes_pessoas p USING (pes_id)
        WHERE col_status = true and c.col_id = '$colID' and c.col_id = tc.col_id);");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function disableTreinamento($treinamentoId)
    {
        $stmt = $this->db->prepare('UPDATE tre_treinamento SET tre_ativo = false WHERE tre_id = :id');
        $stmt->bindParam(':id', $treinamentoId);
        echo "teste";
        return $stmt->execute();
    }

    public function inserirTreinamento($treTitulo, $treDescricao, $treResponsavel)
    {
        try {
            $sql = "INSERT INTO tre_treinamento (tre_titulo, tre_descricao, tre_responsavel, tre_ativo) 
            VALUES (:titulo, :descricao, :responsavel, true)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':titulo', $treTitulo);
            $stmt->bindParam(':descricao', $treDescricao);
            $stmt->bindParam(':responsavel', $treResponsavel);

            $stmt->execute();

            return "Treinamento inserido com sucesso.";
        } catch (PDOException $e) {
            return "Erro ao inserir o treinamento: " . $e->getMessage();
        }
    }

    public function editarTreinamento($treId, $treTitulo, $treDescricao, $treResponsavel)
    {
        try {
            $sql = "UPDATE tre_treinamento SET tre_titulo = :titulo, tre_descricao = :descricao, tre_responsavel = :responsavel 
            WHERE tre_id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $treId);
            $stmt->bindParam(':titulo', $treTitulo);
            $stmt->bindParam(':descricao', $treDescricao);
            $stmt->bindParam(':responsavel', $treResponsavel);

            $stmt->execute();

            return "Treinamento atualizado com sucesso.";
        } catch (PDOException $e) {
            return "Erro ao atualizar o treinamento: " . $e->getMessage();
        }
    }
}
