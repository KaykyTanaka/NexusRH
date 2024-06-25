<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\LoginController;
use \App\Controller\Dashboard;
use \App\Controller\Renders;

date_default_timezone_set('America/Sao_Paulo');


$banco = new LoginController;
//var_dump($banco->getUsuario());
//var_dump($banco->chamarTipo());

if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

$dashboard = new Dashboard();

// Dados para o painel
$totalColaboradores = $dashboard->getTotalColaboradores();
$colaboradoresSemTreinamento = $dashboard->getColaboradoresSemTreinamento();
$treinamentoMaisColaboradores = $dashboard->getTreinamentoMaisColaboradores();
$colaboradoresPorDepartamento = $dashboard->getColaboradoresPorDepartamento();
$totalDepartamentos = $dashboard->getTotalDepartamentos();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NS - Painel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/indexAdmin.css">

</head>

<body id="page-top">
    <form method="post" action="#">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php Renders::renderSidebar($banco->chamarTipo()) ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php Renders::renderNavbar($banco->getUsuario()[0], $banco->chamarTipo()); ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Painel</h1>
                            <p class="text-muted">Última atualização: <span
                                    id="lastUpdate"><?php echo date('d/m/Y H:i:s'); ?></span></p>
                        </div>







                        <!-- Visão Geral dos Colaboradores -->
                        <div class="panel-section">
                            <div class="row">
                                <div class="col-md-4 panel-card mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Total de Colaboradores</h5>

                                            <p class="card-text" id="totalColaboradores">
                                                <?php echo $totalColaboradores; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 panel-card mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Colaboradores sem Treinamento</h5>
                                            <p class="card-text" id="colaboradoresSemTreinamento">
                                                <?php echo $colaboradoresSemTreinamento; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 panel-card mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Total de Departamentos</h5>
                                            <p class="card-text" id="totalDepartamentos">
                                                <?php echo $totalDepartamentos; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 panel-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Colaboradores por Departamento</h5>
                                            <ul id="colaboradoresPorDepartamento">
                                                <?php foreach ($colaboradoresPorDepartamento as $departamento): ?>
                                                    <li><?php echo $departamento['dep_nome'] . ': ' . $departamento['total']; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 panel-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Treinamento com Mais Colaboradores</h5>
                                            <p class="card-text" id="treinamentoMaisColaboradores">
                                                <?php echo $treinamentoMaisColaboradores['tre_titulo'] . ': ' . $treinamentoMaisColaboradores['total']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Status de Treinamento e Certificação -->

                        </div>







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

        <!-- Logout Modal-->
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