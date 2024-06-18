<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use App\Controller\DepartamentosController;
use \App\Controller\LoginController;
use \App\Controller\Renders;

$banco = new LoginController;

if (!isset($_SESSION['usuario'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
    exit;
}
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
    exit;
}

$NovoDepartamento = new DepartamentosController();
if (isset($_POST['enviar'])) {
    $depNome = $_POST['depNome'];
    $varErro = $NovoDepartamento->inserirDepartamento($depNome);
    header('Location: ' . basename(__FILE__));
    exit;
}

$editDepartamento = new DepartamentosController;
if (isset($_POST['editarDepartamento'])) {
    $depId = $_POST['editDepId'];
    $depNome = $_POST['editDepNome'];
    $varErro = $editDepartamento->editarDepartamento($depId, $depNome);
    header('Location: ' . basename(__FILE__));
    exit;
}

$desativarDepartamento = new DepartamentosController;
if (isset($_POST['desativarDepartamento'])) {
    $depId = $_POST['desativarDepartamento'];
    $varErro = $desativarDepartamento->desativarDepartamento($depId);
    header('Location: ' . basename(__FILE__));
    exit;
}

$departamentos = $NovoDepartamento->visualizarDepartamentos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Treinamentos</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="css/estiloNexus.css">
    <link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/estiloNexus.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
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

                    <!-- Sidebar e Navbar omitidos para brevidade -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <div id="content">
                            <div class="container-fluid">
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h1 class="h3 mb-0 text-gray-800">Departamentos</h1>
                                    <?php if ($banco->getUsuario()[2] == "administrador"): ?>
                                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                            data-toggle="modal" data-target="#novoDepartamento">
                                            <i class="fas fa-plus fa-sm text-white-50"></i> Novo Departamento
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <!-- Modal de Novo Departamento -->
                                <div class="modal fade" id="novoDepartamento" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header azul-nexus">
                                                <h5 class="modal-title text-light font-weight-bold"
                                                    id="exampleModalLabel">Novo
                                                    Departamento</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true" class="fechar">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formNovoDepartamento" method="POST"
                                                    class="font-weight-bold text-dark">
                                                    <div class="form-group">
                                                        <label for="depNome">Nome do Departamento:</label>
                                                        <input type="text" class="form-control" id="depNome"
                                                            name="depNome" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="enviar">Enviar</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabela de Departamentos -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Departamentos Cadastrados</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nome</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($departamentos as $departamento): ?>
                                                        <tr>
                                                            <td><?php echo $departamento['dep_id']; ?></td>
                                                            <td><?php echo $departamento['dep_nome']; ?></td>
                                                            <td>
                                                                <div class="container text-center">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary btn-visualizar"
                                                                                data-toggle="modal"
                                                                                data-target="#visualizarDepartamento"
                                                                                data-id="<?php echo $departamento['dep_id']; ?>"
                                                                                data-nome="<?php echo $departamento['dep_nome']; ?>">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary btn-editar"
                                                                                data-toggle="modal"
                                                                                data-target="#editarDepartamento"
                                                                                data-id="<?php echo $departamento['dep_id']; ?>"
                                                                                data-nome="<?php echo $departamento['dep_nome']; ?>">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-desativar"
                                                                                data-toggle="modal"
                                                                                data-target="#desativarDepartamento"
                                                                                data-id="<?php echo $departamento['dep_id']; ?>">
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
                        </div>

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
            </div>
        </div>





        <!-- Modal de Visualização de Departamento -->
        <div class="modal fade" id="visualizarDepartamento" tabindex="-1" role="dialog"
            aria-labelledby="visualizarDepartamentoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header azul-nexus">
                        <h5 class="modal-title text-light font-weight-bold" id="visualizarDepartamentoLabel">
                            Departamento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fechar">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formVisualizarDepartamento" method="POST" class="font-weight-bold text-dark">
                            <div class="form-group">
                                <label for="viewDepNome">Nome do Departamento:</label>
                                <input type="text" class="form-control" id="viewDepNome" name="viewDepNome" readonly>
                            </div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Edição de Departamento -->
        <div class="modal fade" id="editarDepartamento" tabindex="-1" role="dialog"
            aria-labelledby="editarDepartamentoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header azul-nexus">
                        <h5 class="modal-title text-light font-weight-bold" id="editarDepartamentoLabel">Editar
                            Departamento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fechar">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarDepartamento" method="POST" class="font-weight-bold text-dark">
                            <input type="hidden" id="editDepId" name="editDepId">
                            <div class="form-group">
                                <label for="editDepNome">Nome do Departamento:</label>
                                <input type="text" class="form-control" id="editDepNome" name="editDepNome" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="editarDepartamento">Salvar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Desativação de Departamento -->
        <div class="modal fade" id="desativarDepartamento" tabindex="-1" role="dialog"
            aria-labelledby="desativarDepartamentoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header azul-nexus">
                        <h5 class="modal-title text-light font-weight-bold" id="desativarDepartamentoLabel">
                            Desativar
                            Departamento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fechar">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formDesativarDepartamento" method="POST" class="font-weight-bold text-dark">
                            <p>Você tem certeza de que deseja desativar este departamento?</p>
                            <input type="hidden" id="desativarDepId" name="desativarDepartamento">
                            <button type="submit" class="btn btn-primary">Desativar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="vendor/sweetalert2/sweetalert2.all.min.js"></script>
        <script src="js/demo/datatables-demo.js"></script>

        <script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/natural.js"></script>
        <!-- Page level custom scripts -->

        <!-- Script para preencher os campos dos modais -->
        <script>
            $(document).ready(function () {
                $('#editarDepartamento').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var nome = button.data('nome');
                    var modal = $(this);
                    modal.find('#editDepId').val(id);
                    modal.find('#editDepNome').val(nome);
                });

                $('#visualizarDepartamento').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var nome = button.data('nome');
                    var modal = $(this);
                    modal.find('#viewDepNome').val(nome);
                });

                $('#desativarDepartamento').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var modal = $(this);
                    modal.find('#desativarDepId').val(id);
                });
            });
        </script>
</body>

</html>