<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\LoginController;

$banco = new LoginController;
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $login = $_POST['login'];
    $varErro = $banco->BDLogin($email, $senha, $login);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
            <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>Login</title>
</head>

<body>
    <form method="post" action="#">
        <section class="h-100 w-100 gradient-form" style="background-color: #eee; position: fixed;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4">

                                        <div class="text-center">
                                            <img src="img/logo.svg" style="width: 75px;" alt="logo">
                                            <h4 class="mt-1 mb-5 pb-1">NexusSync</h4>
                                        </div>

                                        <form>
                                            <p>Faça login com sua conta</p>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="text" name="email" id="email" class="form-control"
                                                    placeholder="E-mail" />
                                            </div>

                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="password" name="senha" id="senha" class="form-control"
                                                    placeholder="Senha" />

                                            </div>

                                            <div class="text-center pt-1 mb-5 pb-1">
                                                <input data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                    type="submit" name="login" value="Login">
                                                <br>
                                                <p> <?php if (isset($varErro)) {
                                                    echo $varErro;
                                                } ?>
                                                <p>
                                                    <a class="text-muted" href="#!">Esqueceu a senha?</a>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                        <h4 class="mb-4">MISSÃO: </h4>
                                        <p class="small mb-0">Nossa missão é oferecer soluções de software de alta
                                            qualidade
                                            e alto desempenho, que simplifiquem e otimizem processos de gestão,
                                            promovendo a
                                            eficiência operacional, a transparência e a satisfação dos clientes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

</body>

</html>