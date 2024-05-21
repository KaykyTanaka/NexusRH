<?php
namespace App\Controller;

use App\Model\LoginModel;
use \PDO;
use \PDOException;

ob_start();

class LoginController extends LoginModel
{
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
    public function BDLogin($email, $senha, $login)
    {
        $banco = self::BDConnection();
        $chamada = $banco->query("SELECT usu_id, usu_email, usu_senha FROM usu_usuarios;");
        $modelLogin = self::VerificarLogin($chamada, $email, $senha, $login);
        if ($modelLogin == true) {
            $tipo = self::VerificarTipo($email);
            parent::setTipo($tipo);
            parent::setUsuario($email, $senha, $tipo);
            if ($tipo == "colaborador") {
                header("Location: IndexColaborador.php");
            } else if ($tipo == "administrador") {
                header("Location: IndexAdministrador.php");
            }
            return true;
        } else {
            return parent::getErro();
            ;
        }
    }
    public function VerificarLogin($chamada, $email, $senha, $login)
    {
        if (isset($login)) {
            while ($linha = $chamada->fetch(PDO::FETCH_ASSOC)) {
                if ($email == $linha['usu_email']) {
                    return self::VerificarCriptografia($senha, hash('sha512', $senha), $linha['usu_senha'], $linha['usu_id']);
                }
            }
        }
    }
    public function VerificarCriptografia($senha, $senCriptografada, $senhaDB, $idDB)
    {
        if (isset($senha)) {
            if ($senha == $senhaDB) {
                self::CriptografarSenha($senhaDB, $idDB);
                parent::setID($idDB);
                return true;
            }
            if ($senCriptografada == $senhaDB) {
                parent::setID($idDB);
                return true;
            }
            return false;
        }
    }
    public function CriptografarSenha($senha, $idDB)
    {
        $senhaCriptografada = hash('sha512', $senha);
        $stmt = self::BDConnection()->prepare('UPDATE usu_usuarios SET usu_senha = :criptografada 
            WHERE usu_id = :id');
        $stmt->bindParam(':criptografada', $senhaCriptografada);
        $stmt->bindParam(':id', $idDB);
        return $stmt->execute();
    }
    public function VerificarTipo($email)
    {
        $banco = self::BDConnection();
        $chamada = $banco->
            query("SELECT usu_email, 'administrador' as tipo from usu_usuarios u 
            inner join adm_administradorRH a on u.usu_id = a.usu_id where '$email' = usu_email
            union
            select usu_email, 'colaborador' as tipo from usu_usuarios u 
            inner join col_colaborador c on u.usu_id = c.usu_id where '$email' = usu_email;");
        $linha = $chamada->fetchAll(PDO::FETCH_ASSOC);
        $linhaLength = count($linha);
        for ($i = 0; $i <= $linhaLength; $i++) {
            if ($email == $linha[$i]['usu_email']) {
                return $linha[$i]['tipo'];
            }
        }
    }

    static function getUsuario()
    {
        $userInfo = new LoginModel;
        return $userInfo::getUsuario();
    }
    static function getID()
    {
        return parent::getID();
    }
    static function destroy_sessoes()
    {
        $sessoes = new LoginModel;
        $sessoes->destroy_sessoes();
    }
    static function chamarTipo()
    {
        $LMode = new LoginModel;
        return $LMode->getTipo();
    }
}