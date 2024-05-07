<?php
namespace App\Model;

session_start();
//use NexusRH\Controller\LoginController;
class LoginModel
{
    public $erro = 'Perfil não encontrado!';
    private $email;
    private $senha;

    public function getErro()
    {
        return $this->erro;
    }
    public function setErro($erro)
    {
        $this->erro = $erro;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getSenha()
    {
        return $this->email;
    }
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
    static function setUsuario($email, $senha)
    {
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        //echo $_SESSION['email'] . " " . $_SESSION['senha'];
    }
    static function getUsuario()
    {
        return [$_SESSION['email'], $_SESSION['senha']];
    }
    static function destroy_sessoes()
    {
        session_destroy();
    }

}


