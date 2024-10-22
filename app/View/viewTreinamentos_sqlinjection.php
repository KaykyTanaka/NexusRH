<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\TreinamentosController;
use \App\Controller\LoginController;
use \App\Controller\Renders;

$banco = new LoginController;
//var_dump($banco->getUsuario());
//var_dump($banco->getUsuario()[0]);
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView_sqlinjection.php');
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

</head>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php Renders::renderSidebar("administrador"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php Renders::renderNavbar("teste") ?>
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
                <div class="modal fade" id="novoTreinamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header azul-nexus">
                                <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel">Novo treinamento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="fechar">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formNovoTreinamento" method="POST" class ="font-weight-bold text-dark">
                                    <div class="form-group">
                                        <label for="treTitulo">Título do Treinamento:</label>
                                        <input type="text" class="form-control" id="treTitulo" name="treTitulo"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="treDescricao">Descrição do Treinamento:</label>
                                        <textarea class="form-control" id="treDescricao" name="treDescricao" rows="3"
                                            required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="treResponsavel">Responsável pelo Treinamento:</label>
                                        <input type="text" class="form-control" id="treResponsavel"
                                            name="treResponsavel" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="enviar">Enviar</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
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
                                        <tr>
                                            <td>teste</td>
                                            <td>teste</td>
                                            <td>teste</td>
                                            <td>teste</td>
                                            <td>
                                                <div class="container text-center">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button class="btn btn-primary btn-editar" data-toggle="modal"
                                                                data-target="#editarTreinamento"
                                                                data-id="teste"
                                                                data-titulo="teste"
                                                                data-descricao="teste"
                                                                data-responsavel="teste">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="submit" class="btn btn-danger btn-desativar mr-2"
                                                                data-toggle="modal" data-target="#desativarTreinamento"
                                                                data-id="teste"
                                                                name="desativar">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
<div class="modal fade" id="editarTreinamento" tabindex="-1" role="dialog" aria-labelledby="editarTreinamentoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header azul-nexus">
                <h5 class="modal-title  text-light font-weight-bold" id="editarTreinamentoLabel">Editar Treinamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class ="fechar">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarTreinamento" method="POST" class="font-weight-bold text-dark">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
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
<script>
    $(document).ready(function () {
        // Evento de clique no botão de edição
        $('.btn-editar').click(function () {
            // Recupera o ID do treinamento do botão clicado
            var treId = $(this).data('id');
            var treTitulo = $(this).data('titulo');
            //var <?php echo 'z' ?> = $(this).data('titulo');
            var treDescricao = $(this).data('descricao');
            var treResponsavel = $(this).data('responsavel');

            // Define os valores nos campos do formulário de edição
            $('#editTreinamentoId').val(treId);
            $('#editTreTitulo').val(treTitulo);
            //$('#editTreTitulo').val(z);
            $('#editTreDescricao').val(treDescricao);
            $('#editTreResponsavel').val(treResponsavel);
        });
        $('.btn-desativar').click(function () {
            // Recupera o ID do treinamento do botão clicado
            var treId = $(this).data('id');

            //$('#desTreinamento').val(treId);
            Swal.fire({
                title: "Tem certeza?",
                text: "Você não conseguira reverter isto!",
                icon: "warning",
                showDenyButton: true,
                confirmButtonColor: "#3085d6",
                denyButtonColor: "#d33",
                confirmButtonText: "Deletar",
                denyButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deletado!",
                        text: "O usuário foi deletado com sucesso, redirecionando em 2 segundos.",
                        icon: "success",
                        timer: 2000
                        //showConfirmButton: false
                    }).then(function () {
                        document.getElementById("desTreinamento").value = treId;
                        document.forms["formdesativarTreinamento"].submit();
                    });
                    //document.formdesativarTreinamento.desTreinamento.value = treId;
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Cancelado.', 
                        text: 'As mudanças não foram feitas', 
                        icon: 'info',
                        timer: 3000
                    }).then(function () {
                        location.reload()
                    });
                }
            });

        });
    });
</script>


</body>

</html>