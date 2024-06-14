<?php
namespace App\Controller;

use \PDO;
use \PDOException;

if(isset($_POST["colaboradorId"])){
    header("Content-type: application/json; charset=utf-8");
    $retornocoltreinos = (new ColaboradoresController())->getTreinamentosByColaboradorId($_POST["colaboradorId"]);
    $i=0;
    $tre_nomes = array();
    foreach($retornocoltreinos as $retorno){
        foreach($retorno as $tre_nome){
            if($retorno["tre_titulo"] == $tre_nome){
                $tre_nomes[$i] = $tre_nome;
                //echo $tre_nomes[$i];
                $i++;
            }
            
        }
    } 
    if(sizeof($tre_nomes) > 0) {
        echo json_encode($tre_nomes);
    }
}



class ColaboradoresController
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
        $stmt =
            $this->db->query('SELECT c.col_id, u.usu_email, p.pes_nome, p.pes_cpf, p.pes_cep, 
        p.pes_cidade, p.pes_bairro, p.pes_numero, p.pes_telefone
        FROM col_colaborador c INNER JOIN usu_usuarios u ON c.usu_id = u.usu_id INNER JOIN pes_pessoas p USING (pes_id)
        WHERE col_status = true');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function disableColaborador($colID)
    {
        $stmt = $this->db->prepare('UPDATE col_colaborador SET col_status = false WHERE col_id = :id');
        $stmt->bindParam(':id', $colID);
        return $stmt->execute();
    }

    public function inserirVerificador($pesNome, $pesCPF, $pesCEP, $pesCidade, $pesBairro, $pesNumero, $pesTelefone, $usuEmail, $usuSenha){
        $sql = "INSERT INTO usu_usuarios (usu_email, usu_senha, pes_id) VALUES (:email, :senha, 1)";
        $stmt = $this->db->prepare($sql);
        $senhaCriptografada = hash('sha512', $usuSenha);
        //$stmt->bindParam(':email', $usuEmail);
        //$stmt->bindParam(':senha', $senhaCriptografada);
        try{        
            $retorn = $stmt->execute(array('email' => $usuEmail, 'senha' => $senhaCriptografada));
            if($retorn == false){
                throw new PDOException("Exceção PDO, Valor único", 1062);
            }
            self::inserirColaborador($pesNome, $pesCPF, $pesCEP, $pesCidade, $pesBairro, $pesNumero, $pesTelefone, $usuEmail, $usuSenha);
            
            return "test";
        }catch  (PDOException $e) {
            //echo "Erro ao inserir o treinamento: " . $e->getMessage();
            if($e->getCode() == 1062){
                //return "Erro ao atualizar o treinamento: " . $e->getMessage();
                return $e;
            }
        }
    }

    public function inserirColaborador($pesNome, $pesCPF, $pesCEP, $pesCidade, $pesBairro, $pesNumero, $pesTelefone, $usuEmail, $usuSenha)
    {

        try {
            $sql = "INSERT INTO pes_pessoas
            (pes_nome, pes_cpf, pes_cep, pes_cidade, pes_bairro, pes_numero, pes_telefone) 
            VALUES (:nome, :cpf, :cep, :cidade, :bairro, :numero, :telefone)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nome', $pesNome);
            $stmt->bindParam(':cpf', $pesCPF);
            $stmt->bindParam(':cep', $pesCEP);
            $stmt->bindParam(':cidade', $pesCidade);
            $stmt->bindParam(':bairro', $pesBairro);
            $stmt->bindParam(':numero', $pesNumero);
            $stmt->bindParam(':telefone', $pesTelefone);
            $stmt->execute();

            $sql = "SELECT pes_id FROM pes_pessoas WHERE pes_nome = '$pesNome'";
            $stmt = $this->db->query($sql);
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $linha['pes_id'];
            }


            $sql = "INSERT INTO usu_usuarios (usu_email, usu_senha, pes_id) VALUES (:email, :senha, :pes_id)";
            $stmt = $this->db->prepare($sql);
            $senhaCriptografada = hash('sha512', $usuSenha);
            $stmt->bindParam(':email', $usuEmail);
            $stmt->bindParam(':senha', $senhaCriptografada);
            $stmt->bindParam(':pes_id', $id);
            $stmt->execute();

            $sql = "SELECT usu_id FROM usu_usuarios WHERE usu_email = '$usuEmail'";
            $stmt = $this->db->query($sql);
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $linha['usu_id'];
            }

            $sql = "INSERT INTO col_colaborador (col_status, usu_id, dep_id) VALUES (true, :usuid, 1)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuid', $id);
            $stmt->execute();


            return "Colaborador inserido com sucesso.";
        } catch (PDOException $e) {
            return "Erro ao inserir o treinamento: " . $e->getMessage();
        }
    }
    public function editarColaborador($colID, $usuEmail, $pesNome, $pesCPF, $pesCEP, $pesCidade, $pesBairro, $pesNumero, $pesTelefone)
    {
        try {
            $sql = "SELECT u.usu_id, p.pes_id from col_colaborador c inner join usu_usuarios u using (usu_id)
            inner join pes_pessoas p using (pes_id) where c.col_id = '$colID'";
            $stmt = $this->db->query($sql);
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            $vars = ['i' => 'ida'];
            $ida = 0;
            $ids = array();
            foreach ($linha as $id) {
                $ids[${$vars['i']}] = $id;
                $ida++;
            }

            $sql = "UPDATE usu_usuarios u, pes_pessoas p 
            SET u.usu_email = :email, p.pes_nome = :nome, p.pes_cpf = :cpf, p.pes_cep = :cep, p.pes_cidade = :cidade,
            p.pes_bairro = :bairro, p.pes_numero = :numero, p.pes_telefone = :telefone 
            WHERE u.usu_id = :usu_id and p.pes_id = :pes_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $usuEmail);
            $stmt->bindParam(':nome', $pesNome);
            $stmt->bindParam(':cpf', $pesCPF);
            $stmt->bindParam(':cep', $pesCEP);
            $stmt->bindParam(':cidade', $pesCidade);
            $stmt->bindParam(':bairro', $pesBairro);
            $stmt->bindParam(':numero', $pesNumero);
            $stmt->bindParam(':telefone', $pesTelefone);
            $stmt->bindParam(':usu_id', $ids[0]);
            $stmt->bindParam(':pes_id', $ids[1]);

            $stmt->execute();

            return "Treinamento atualizado com sucesso.";
        } catch (PDOException $e) {
            return "Erro ao atualizar o treinamento: " . $e->getMessage();
        }
    }

    public function getTreinamentosByColaboradorId($colaboradorId)
    {
        $stmt = $this->db->prepare('SELECT t.tre_id, t.tre_titulo FROM tre_treinamento t INNER JOIN treinamentos_do_colaborador tc ON t.tre_id = tc.tre_id WHERE tc.col_id = :colaboradorId');
        $stmt->bindParam(':colaboradorId', $colaboradorId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





}