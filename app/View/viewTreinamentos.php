<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\controllerTreinamentos;
use \App\Controller\LoginController;

$banco = new LoginController;
//var_dump($banco->getUsuario());
//var_dump($banco->getUsuario()[0]);
if (isset($_SESSION['usuario'])) {

}
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

$controllerTreinamentos = new controllerTreinamentos;
$treinamentos = $controllerTreinamentos->getAllTreinamentos();

$novoTreinamento = new controllerTreinamentos;
if (isset($_POST['enviar'])) {
    $treTitulo = $_POST['treTitulo'];
    $treDescricao = $_POST['treDescricao'];
    $treResponsavel = $_POST['treResponsavel'];

    $varErro = $novoTreinamento->inserirTreinamento($treTitulo, $treDescricao, $treResponsavel);
    header('Location:' .basename(__FILE__));
}

$editTreinamento = new controllerTreinamentos;
if (isset($_POST['editarTreinamento'])) {
    $treId = $_POST['editTreinamentoId'];
    $treTitulo = $_POST['editTreTitulo'];
    $treDescricao = $_POST['editTreDescricao'];
    $treResponsavel = $_POST['editTreResponsavel'];

    $varErro = $editTreinamento->editarTreinamento($treId, $treTitulo, $treDescricao, $treResponsavel);
    header('Location:' .basename(__FILE__));
}

$desativarTreinamento = new controllerTreinamentos;
if (isset($_POST['desativarTreinamento'])) {
    $treId = $_POST['desTreinamento'];

    $varErro = $desativarTreinamento->disableTreinamento($treId);
    
    //header('Location:' .basename(__FILE__));
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

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" 
            <?php if($banco->chamarTipo() == "colaborador") : ?>href="IndexColaborador.php"
            <?php elseif($banco->chamarTipo() == "administrador") : ?>href="IndexAdministrador.php"
            <?php endif; ?> >
                <div class="sidebar-brand-icon">
                    <img src="img/logo.svg" style="width: 45px;" alt="logo">
                </div>
                <div class="sidebar-brand-text mx-3">NexusSync</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link"
                <?php if($banco->chamarTipo() == "colaborador") : ?>href="IndexColaborador.php"
                <?php elseif($banco->chamarTipo() == "administrador") : ?>href="IndexAdministrador.php"
                <?php endif; ?> >
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="viewTreinamentos.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Treinamentos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
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
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
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
                                <a class="dropdown-item" href="#">
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
                                </a>
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
                                                                <button type="submit" class="btn btn-danger btn-desativar mr-2"
                                                                data-toggle="modal" data-target="#desativarTreinamento" 
                                                                data-id="<?php echo $treinamento['tre_id']; ?>" name="desativar">
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


    <div class="modal" id="desativarTreinamento" tabindex="-1" role="dialog" aria-labelledby="desativarTreinamentoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="desativarTreinamentoLabel">Editar Treinamento</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formdesativarTreinamento" method="POST">
                    <div class="form-group">
                        <!-- <label for="desTreinamento">ID:</label> -->
                        <input type="hidden" class="form-control" id="desTreinamento" name="desTreinamento" required>
                    </div>
                    <div class="modal-body">

                    <p>Desativar treinamento?</p>
                    <button type="submit" class="btn btn-primary" name="desativarTreinamento">Sim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                </form>
                </div>
            </div>
        </div>
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
    <link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/natural.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function () {
            // Evento de clique no botão de edição
            $('.btn-editar').click(function () {
                // Recupera o ID do treinamento do botão clicado
                var treId = $(this).data('id');
                var treTitulo = $(this).data('titulo');
                var treDescricao = $(this).data('descricao');
                var treResponsavel = $(this).data('responsavel');

                // Define os valores nos campos do formulário de edição
                $('#editTreinamentoId').val(treId);
                $('#editTreTitulo').val(treTitulo);
                $('#editTreDescricao').val(treDescricao);
                $('#editTreResponsavel').val(treResponsavel);
            });
            $('.btn-desativar').click(function () {
                // Recupera o ID do treinamento do botão clicado
                var treId = $(this).data('id');

                $('#desTreinamento').val(treId);
               
            });
        });
    </script>


</body>

</html>