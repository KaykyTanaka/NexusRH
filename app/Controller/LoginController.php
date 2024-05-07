<?php
namespace App\Controller;

use \App\Model\LoginModel;
use \App\View\LoginView;
use \PDO;

ob_start();

class LoginController extends LoginModel
{
    public function BDConnection()
    {
        return new PDO('mysql:host=localhost;dbname=NexusRH', 'root', '1234');
    }
    public function BDLogin($email, $senha, $login)
    {
        $banco = self::BDConnection();
        $chamada = $banco->query("SELECT adm_email, adm_senha FROM adm_administradorRH;");
        $modelLogin = self::VerificarLogin($chamada, $email, $senha, $login);
        $LModel = new LoginModel;
        if ($modelLogin == true) {
            $LModel->setUsuario($email, $senha);
            $tipo = self::VerificarTipo($email);
            if ($tipo == "colaborador") {
                header("Location: IndexColaborador.php");
            } else if ($tipo == "administrador") {
                header("Location: IndexAdministrador.php");
            }
            return true;
            //exit;
            // $_SESSION['login'] = $email;
            // session_unset('erro');
        } else {
            $LModel->getErro();
            return $LModel->erro;
            // $_SESSION['erro'] = "Falha no Login, usuário não identificado"; 
            // return "Falha no Login, usuário não identificado";
            // $_SESSION['login'] = $email;
            // $_SESSION['erro'] = "wdadaw";
            // session_unset('login');
        }
    }
    public function VerificarLogin($chamada, $email, $senha, $login)
    {
        if (isset($login)) {
            while ($linha = $chamada->fetch(PDO::FETCH_ASSOC)) {
                //echo $email . " " . $senha;
                //echo "<br>Email: {$linha['adm_email']} - Senha: {$linha['adm_senha']} <br />";
                if ($email == $linha['adm_email'] && $senha == $linha['adm_senha']) {
                    return true;
                } else {
                    //return false;
                }
            }
        }
    }
    public function VerificarTipo($email)
    {
        $banco = self::BDConnection();
        $chamada = $banco->query("SELECT adm_email, adm_tipo FROM adm_administradorRH WHERE '$email' = adm_email;");
        $linha = $chamada->fetchAll(PDO::FETCH_ASSOC);
        $linhaLength = count($linha);
        for ($i = 0; $i <= $linhaLength; $i++) {
            if ($email == $linha[$i]['adm_email']) {
                return $linha[$i]['adm_tipo'];
            }
        }
    }
    static function getUsuario()
    {
        $userInfo = new LoginModel;
        return $userInfo::getUsuario();
    }
    static function destroy_sessoes()
    {
        $sessoes = new LoginModel;
        $sessoes->destroy_sessoes();
    }
    /*public function getErro(){
        return $this->erro;
    }
    public function setErro(){
        $this->erro = $_SESSION['erro'];
    }
    Passar para o model */
}