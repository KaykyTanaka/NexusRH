<?php
namespace App\Controller;

use App\Model\PerfilModel;
use \PDO;
use \PDOException;

ob_start();

class PerfilController extends PerfilModel
{
    private $db;
    public function __construct()
    {
        $this->db = $this->BDConnection();
    }

    private function BDConnection()
    {
        try {
            return new PDO('mysql:host=localhost;dbname=NexusRH;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
            exit;
        }
    }
    
    public function getAllColaboradores($email)
    {
        $stmt =
            $this->db->prepare('SELECT c.col_id, u.usu_email, d.dep_nome, p.pes_nome, p.pes_cpf, p.pes_cep, p.pes_cidade, p.pes_bairro, p.pes_numero, p.pes_telefone
            FROM  col_colaborador c inner join  usu_usuarios u on c.usu_id = u.usu_id inner join pes_pessoas p using (pes_id) inner join dep_departamento d on 
            c.dep_id = d.dep_id where u.usu_email = :email 
            order by c.col_id asc');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getPerfil()
    {
        return parent::getPerfil();
    }
    static function getID()
    {
        return parent::getID();
    }
    static function destroy_sessoes()
    {
        parent::destroy_sessoes();
    }
}