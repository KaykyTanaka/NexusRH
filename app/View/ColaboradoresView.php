<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\TreinamentosController;
use \App\Controller\LoginController;

$banco = new LoginController;
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

$TreinamentosController = new TreinamentosController;
$treinamentos = $TreinamentosController->getAllTreinamentos();

$novoTreinamento = new TreinamentosController;
if (isset($_POST['enviar'])) {
    $treTitulo = $_POST['treTitulo'];
    $treDescricao = $_POST['treDescricao'];
    $treResponsavel = $_POST['treResponsavel'];

    $varErro = $novoTreinamento->inserirTreinamento($treTitulo, $treDescricao, $treResponsavel);
    header('Location:' .basename(__FILE__));
}

$editTreinamento = new TreinamentosController;
if (isset($_POST['editarTreinamento'])) {
    $treId = $_POST['editTreinamentoId'];
    $treTitulo = $_POST['editTreTitulo'];
    $treDescricao = $_POST['editTreDescricao'];
    $treResponsavel = $_POST['editTreResponsavel'];

    $varErro = $editTreinamento->editarTreinamento($treId, $treTitulo, $treDescricao, $treResponsavel);
    header('Location:' .basename(__FILE__));
}

$desativarTreinamento = new TreinamentosController;
if (isset($_POST['desTreinamento'])) {
    $treId = $_POST['desTreinamento'];
    $varErro = $desativarTreinamento->disableTreinamento($treId);
    //echo "teste";

    header('Location:' .basename(__FILE__));
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nexus</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/SweetAlert2/sweetalert2.min.css" rel="stylesheet">
    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                <?php if($banco->chamarTipo() == "colaborador") : ?>
                    href="IndexColaborador.php"
                <?php elseif($banco->chamarTipo() == "administrador") : ?>
                    href="IndexAdministrador.php" 
                    <?php endif; ?>
                    >
                
                    <div class="sidebar-brand-icon">
                    <img src="img/logo.svg" style="width: 45px;" alt="logo">
                </div>
                <div class="sidebar-brand-text mx-3">NexusSync</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->

            <li class="nav-item active">
                <a class="nav-link" href="viewTreinamentos.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Treinamentos</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="ColaboradoresView.php">
                <i class="fas fa-fw fa-users"></i>
                    <span>Colaboradores</span></a>
            </li>
            
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Pesquisar por..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $banco->getUsuario()[0] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
<!--                                 <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Treinamentos</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                            data-target="#novoTreinamento">
                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Treinamento
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal" id="novoTreinamento" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Novo treinamento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formNovoTreinamento" method="POST">
                                        <div class="form-group">
                                            <label for="treTitulo">Título do Treinamento:</label>
                                            <input type="text" class="form-control" id="treTitulo" name="treTitulo"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="treDescricao">Descrição do Treinamento:</label>
                                            <textarea class="form-control" id="treDescricao" name="treDescricao"
                                                rows="3" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="treResponsavel">Responsável pelo Treinamento:</label>
                                            <input type="text" class="form-control" id="treResponsavel"
                                                name="treResponsavel" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="enviar">Enviar</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Treinamentos Cadastrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Descrição</th>
                                            <th>Responsável</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($treinamentos as $treinamento): ?>
                                        <tr>

                                            <td><?php echo $treinamento['tre_id']; ?></td>
                                            <td><?php echo $treinamento['tre_titulo']; ?></td>
                                            <td><?php echo $treinamento['tre_descricao']; ?></td>
                                            <td><?php echo $treinamento['tre_responsavel']; ?></td>
                                            <td>
                                                <div class="container text-center">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button class="btn btn-primary btn-editar"
                                                                data-toggle="modal" data-target="#editarTreinamento"
                                                                data-id="<?php echo $treinamento['tre_id']; ?>"
                                                                data-titulo="<?php echo $treinamento['tre_titulo']; ?>"
                                                                data-descricao="<?php echo $treinamento['tre_descricao']; ?>"
                                                                data-responsavel="<?php echo $treinamento['tre_responsavel']; ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-desativar mr-2"
                                                                data-toggle="modal" data-target="#desativarTreinamento"
                                                                data-id="<?php echo $treinamento['tre_id']; ?>"
                                                                name="desativar">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; NexusRH 2024</span>
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
    <!-- Modal de Edição de Treinamento -->
    <div class="modal" id="editarTreinamento" tabindex="-1" role="dialog" aria-labelledby="editarTreinamentoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTreinamentoLabel">Editar Treinamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarTreinamento" method="POST">
                        <input type="hidden" id="editTreinamentoId" name="editTreinamentoId">
                        <div class="form-group">
                            <label for="editTreTitulo">Título do Treinamento:</label>
                            <input type="text" class="form-control" id="editTreTitulo" name="editTreTitulo" required>
                        </div>
                        <div class="form-group">
                            <label for="editTreDescricao">Descrição do Treinamento:</label>
                            <textarea class="form-control" id="editTreDescricao" name="editTreDescricao" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editTreResponsavel">Responsável pelo Treinamento:</label>
                            <input type="text" class="form-control" id="editTreResponsavel" name="editTreResponsavel"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editarTreinamento">Salvar
                            Alterações</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" name="desativarTreinamento" id="desativarTreinamento" tabindex="-1" role="dialog"
        aria-labelledby="desativarTreinamentoLabel" aria-hidden="true">
        <form name="formdesativarTreinamento" id="formdesativarTreinamento" method="POST">
            <input type="hidden" class="form-control" id="desTreinamento" name="desTreinamento" required>
        </form>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="vendor/SweetAlert2/sweetalert2.all.min.js"></script>
    <script src="vendor/datatables/natural.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    
</body>

</html>