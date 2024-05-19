<?php
namespace App\Controller;

use \App\Model\ColaboradoresModel;
use \PDO;
use \PDOException;

class ColaboradoresController extends ColaboradoresModel
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

    public function getAllColaboradores()
    {
        $teste = self::BDConnection();
        $stmt = 
        $teste->query('SELECT c.col_id, u.usu_email, p.pes_nome, p.pes_cpf, p.pes_cep, 
        p.pes_cidade, p.pes_bairro, p.pes_numero, p.pes_telefone
        FROM col_colaborador c INNER JOIN usu_usuarios u ON c.usu_id = u.usu_id INNER JOIN pes_pessoas p USING (pes_id);');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserirTreinamento($treTitulo, $treDescricao, $treResponsavel)
    {
        try {
            $sql = "INSERT INTO tre_treinamento (tre_titulo, tre_descricao, tre_responsavel, tre_ativo) VALUES (:titulo, :descricao, :responsavel, true)";
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
}