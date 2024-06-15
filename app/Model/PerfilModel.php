<?php
namespace App\Model;

class PerfilModel
{
    private $email;

    public function getEmail()
    {
        return $_SESSION['email'];
    }
    public function setEmail($email)
    {
        $_SESSION['email'] = $email;
    }
    static function setPerfil($email, $senha, $tipo)
    {
        // $_SESSION['email'] = $email;
        // $_SESSION['senha'] = $senha;
        $_SESSION['perfil'] = array($email, $senha, $tipo);
    }
    static function getPerfil()
    {
        return $_SESSION['perfil'];
    }
    static function getID()
    {
        return $_SESSION['id'];
    }
    static function setID($id)
    {
        $_SESSION['id'] = $id;
    }
    static function destroy_sessoes()
    {
        session_destroy();
    }

}


