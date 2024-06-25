<?php
require __DIR__ . '/vendor/autoload.php';
if(!isset($_SESSION['usuario'])){
    session_destroy();
    header('Location: app/View/LoginView.php');
}
if(isset($_SESSION['usuario'])){
    if($_SESSION['usuario'][2] == "colaborador"){
        header('Location: app/View/ViewTreinamentos');
    }
    if($_SESSION['usuario'][2] == "administrador"){
        header('Location: app/View/IndexAdministrador');
    }
}
exit;