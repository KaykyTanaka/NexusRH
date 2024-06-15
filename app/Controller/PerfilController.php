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
            return new PDO('mysql:host=localhost;dbname=NexusRH;charset=utf8', 'root', '1234');
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
            exit;
        }
    }
    
    public function getAllColaboradores($email)
    {
        $stmt =
            $this->db->prepare('SELECT u.usu_id, u.usu_email, p.pes_nome, p.pes_cpf, p.pes_cep, 
        p.pes_cidade, p.pes_bairro, p.pes_numero, p.pes_telefone
        FROM usu_usuarios u INNER JOIN pes_pessoas p USING (pes_id)
        WHERE u.usu_email = :email');
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