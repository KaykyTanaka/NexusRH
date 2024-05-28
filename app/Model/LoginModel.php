<?php
namespace App\Model;

session_start();
class LoginModel
{
    private $erro = 'Perfil não encontrado!';
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
    static function getTipo()
    {
        return $_SESSION['tipo'];
    }
    static function setTipo($tipo)
    {
        $_SESSION['tipo'] = $tipo;
    }
    static function setUsuario($email, $senha, $tipo)
    {
        // $_SESSION['email'] = $email;
        // $_SESSION['senha'] = $senha;
        $_SESSION['usuario'] = array($email, $senha, $tipo);
    }
    static function getID()
    {
        return $_SESSION['id'];
    }
    static function setID($id)
    {
        $_SESSION['id'] = $id;
    }
    static function getUsuario()
    {
        return $_SESSION['usuario'];
    }
    static function destroy_sessoes()
    {
        session_destroy();
    }

}


