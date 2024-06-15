<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\TreinamentosController;
use \App\Controller\PerfilController;
use \App\Controller\LoginController;
use \App\Controller\Renders;

$banco = new LoginController;
//var_dump($banco->getUsuario());
//var_dump($banco->getUsuario()[0]);
//var_dump($banco->chamarTipo());
if (!isset($_SESSION['usuario'])) {
    //Alterar!!
}
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}
$dados = (new PerfilController())->getAllColaboradores($banco->getUsuario()[0]);
$dados = $dados[0];
//echo $banco->getUsuario()[0] . '<br>';
//var_dump($dados['pes_nome']);
$controllerTreinamentos = new TreinamentosController;
$treinamentos = $controllerTreinamentos->getColabTreinamentos($banco->getID());
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/estiloNexus.css" rel="stylesheet">
</head>

<body id="page-top">
    <form method="post" action="#">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php Renders::renderSidebar($banco->chamarTipo()); ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php Renders::renderNavbar($banco->getUsuario()[0]) ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Perfil</h1>
                        </div>

                        <section style="background-color: #eee;">
                            <div class="container py-5">

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card mb-4">
                                            <div class="card-body text-center">
                                                <img src="img/colaborador.png"
                                                    alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                                <h5 class="my-3"><?php echo $dados['pes_nome'] ?></h5>
                                                <p class="text-muted mb-1">Recursos Humanos</p>
                                                <p class="text-muted mb-4"><?php echo $dados['pes_cidade'] .  ", " 
                                                . $dados['pes_bairro'] . ", " ?>BR</p>                                     
                                            </div>
                                        </div>
                                        <div class="card mb-4 mb-lg-0">
                                            <div class="card-body p-0">
                                                <ul class="list-group list-group-flush rounded-3">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                        <i class="fas fa-globe fa-lg text-warning"></i>
                                                        <p class="mb-0">https://mdbootstrap.com</p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                        <i class="fab fa-github fa-lg text-body"></i>
                                                        <p class="mb-0">mdbootstrap</p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                        <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                                        <p class="mb-0">@mdbootstrap</p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                        <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                                        <p class="mb-0">mdbootstrap</p>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                        <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                                        <p class="mb-0">mdbootstrap</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">Nome</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p class="text-muted mb-0"><?php echo $dados['pes_nome'] ?></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">Email</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p class="text-muted mb-0"><?php echo $dados['usu_email'] ?></p>
                                                    </div>
                                                </div>
                                               <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">Telefone</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p class="text-muted mb-0"><?php echo $dados['pes_telefone'] ?></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">Endereço</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p class="text-muted mb-0"><?php echo $dados['pes_cidade'] .  ", " 
                                                . $dados['pes_bairro'] . ", " ?>BR</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($_SESSION['tipo'] == "colaborador") : ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card mb-4 mb-md-0">
                                                    <div class="card-body">
                                                        <p class="mb-3"><span
                                                                class="text-primary">Treinamentos</span>
                                                        </p>
                                                        <!-- <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                                        <div class="progress rounded" style="height: 5px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 80%" aria-valuenow="80" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div> -->
                                                        <?php foreach ($treinamentos as $treinamento): ?>
                                                        <p class="mb-2" style="font-size: .77rem;">
                                                            <?php echo $treinamento['tre_titulo']; ?>
                                                        </p>
                                                        <?php endforeach; ?>
                                                        <!-- <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup
                                                        </p>
                                                        <div class="progress rounded" style="height: 5px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 72%" aria-valuenow="72" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif;  ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>NexusSync &copy; 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>


        <?php Renders::logoutModal(); ?>


        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>