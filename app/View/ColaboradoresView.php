<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\ColaboradoresController;
use \App\Controller\LoginController;
use \App\Controller\Renders;

$banco = new LoginController;
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

$colaboradores = (new ColaboradoresController)->getAllColaboradores();
if (isset($_POST['enviar'])) { 
    $pesNome = $_POST['pesNome'];
    $pesCPF = $_POST['pesCPF'];
    $pesCEP = $_POST['pesCEP'];
    $pesCidade = $_POST['pesCidade'];
    $pesBairro = $_POST['pesBairro'];
    $pesNumero = $_POST['pesNumero'];
    $pesTelefone = $_POST['pesTelefone'];
    $usuEmail = $_POST['usuEmail'];
    $usuSenha = $_POST['usuSenha'];

    $var = (new ColaboradoresController)->inserirColaborador($pesNome, $pesCPF, $pesCEP, $pesCidade, 
    $pesBairro, $pesNumero, $pesTelefone, $usuEmail, $usuSenha);
    header('Location:' .basename(__FILE__));
}
if(isset($_POST['salvarColaborador'])){
    $colID = $_POST['editColaboradorId'];
    $usuEmail = $_POST['editusuEmail'];
    $pesNome = $_POST['editpesNome'];
    $pesCPF = $_POST['editpesCPF'];
    $pesCEP = $_POST['editpesCEP'];
    $pesCidade = $_POST['editpesCidade'];
    $pesBairro = $_POST['editpesBairro'];
    $pesNumero = $_POST['editpesNumero'];
    $pesTelefone = $_POST['editpesTelefone'];


    $var = (new ColaboradoresController)->editarColaborador($colID, $usuEmail, $pesNome, $pesCPF, $pesCEP, 
    $pesCidade, $pesBairro, $pesNumero, $pesTelefone);
    echo $var;
    header('Location:' .basename(__FILE__));
}

$desativarColaborador = new ColaboradoresController();
if (isset($_POST['desColaborador'])) {
    $colID = $_POST['desColaborador'];
    $varErro = $desativarColaborador->disableColaborador($colID);
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
                        <h1 class="h3 mb-0 text-gray-800">Colaboradores</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                            data-target="#novoTreinamento">
                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Colaborador
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal" id="novoTreinamento" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Novo colaborador</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formNovoColaborador" method="POST">
                                        <div class="form-group">
                                            <p><span class="font-weight-bold">Pessoa:</span></p>
                                            <label for="pesNome">Nome:</label>
                                            <input type="text" class="form-control" id="pesNome" name="pesNome"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesCPF">CPF:</label>
                                            <input type="text" class="form-control" id="pesCPF" name="pesCPF" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesCEP">CEP:</label>
                                            <input type="number" class="form-control" id="pesCEP" name="pesCEP"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesCidade">Cidade:</label>
                                            <input type="text" class="form-control" id="pesCidade" name="pesCidade"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesBairro">Bairro:</label>
                                            <input type="text" class="form-control" id="pesBairro" name="pesBairro"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesNumero">Número da residência:</label>
                                            <input type="number" class="form-control" id="pesNumero" name="pesNumero"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pesTelefone">Telefone:</label>
                                            <input type="text" class="form-control" id="pesTelefone" name="pesTelefone"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <p><span class="font-weight-bold">Usuário:</span></p>
                                            <label for="usuEmail">Email:</label>
                                            <input type="email" class="form-control" id="usuEmail" name="usuEmail"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usuSenha">Senha:</label>
                                            <input type="password" class="form-control" id="usuSenha" name="usuSenha"
                                                required>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Enviar" name="enviar"></i>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Begin DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Colaboradores Cadastrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>CEP</th>
                                            <th>Cidade</th>
                                            <th>Bairro</th>
                                            <th>Número Residencial</th>
                                            <th>Telefone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($colaboradores as $colaborador): ?>

                                        <tr>
                                            <!-- </?php echo array_search($colaborador['col_id'], $colaborador); ?> -->
                                            <td><?php echo $colaborador['col_id']; ?></td>
                                            <td><?php echo $colaborador['usu_email']; ?></td>
                                            <td><?php echo $colaborador['pes_nome']; ?></td>
                                            <td><?php echo $colaborador['pes_cpf']; ?></td>
                                            <td><?php echo $colaborador['pes_cep']; ?></td>
                                            <td><?php echo $colaborador['pes_cidade']; ?></td>
                                            <td><?php echo $colaborador['pes_bairro']; ?></td>
                                            <td><?php echo $colaborador['pes_numero']; ?></td>
                                            <td><?php echo $colaborador['pes_telefone']; ?></td>
                                            <td>
                                                <div class="container text-center">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button class="btn btn-primary btn-editar"
                                                                data-toggle="modal" data-target="#editarColaborador"
                                                                data-id="<?php echo $colaborador['col_id']; ?>"
                                                                data-email="<?php echo $colaborador['usu_email']; ?>"
                                                                data-nome="<?php echo $colaborador['pes_nome']; ?>"
                                                                data-cpf="<?php echo $colaborador['pes_cpf']; ?>"
                                                                data-cep="<?php echo $colaborador['pes_cep']; ?>"
                                                                data-cidade="<?php echo $colaborador['pes_cidade']; ?>"
                                                                data-bairro="<?php echo $colaborador['pes_bairro']; ?>"
                                                                data-numero="<?php echo $colaborador['pes_numero']; ?>"
                                                                data-telefone="<?php echo $colaborador['pes_telefone']; ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-desativar ml-2 mr-5"
                                                                data-toggle="modal" data-target="#desativarColaborador"
                                                                data-id="<?php echo $colaborador['col_id']; ?>"
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
                    <!-- DataTable End -->

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
    <div class="modal" id="editarColaborador" tabindex="-1" role="dialog" aria-labelledby="editarColaboradorLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarColaboradorLabel">Editar Colaborador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarColaborador" method="POST">
                        <input type="hidden" id="editColaboradorId" name="editColaboradorId">
                        <div class="form-group">
                            <label for="editusuEmail">Email:</label>
                            <input type="text" class="form-control" id="editusuEmail" name="editusuEmail"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="editpesNome">Nome:</label>
                            <input type="text" class="form-control" id="editpesNome" name="editpesNome" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesCPF">CPF:</label>
                            <input type="text" class="form-control" id="editpesCPF" name="editpesCPF" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesCEP">CEP:</label>
                            <input type="text" class="form-control" id="editpesCEP" name="editpesCEP" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesCidade">Cidade:</label>
                            <input type="text" class="form-control" id="editpesCidade" name="editpesCidade" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesBairro">Bairro:</label>
                            <input type="text" class="form-control" id="editpesBairro" name="editpesBairro" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesNumero">Número residencial:</label>
                            <input type="text" class="form-control" id="editpesNumero" name="editpesNumero" required>
                        </div>
                        <div class="form-group">
                            <label for="editpesTelefone">Telefone:</label>
                            <input type="text" class="form-control" id="editpesTelefone" name="editpesTelefone" required>
                        </div>
                        <!-- Deixarei o campo de senha de lado por enquanto
                        <div class="form-group">
                            <label for="editusuSenha">Senha:</label>
                            <input type="text" class="form-control" id="editusuSenha" name="editusuSenha" required>
                        </div> -->
                        <button type="submit" class="btn btn-primary" name="salvarColaborador">Salvar
                            Alterações</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" name="desativarColaborador" id="desativarColaborador" tabindex="-1" role="dialog"
        aria-labelledby="desativarColaboradorLabel" aria-hidden="true">
        <form name="formdesativarColaborador" id="formdesativarColaborador" method="POST">
            <input type="hidden" class="form-control" id="desColaborador" name="desColaborador" required>
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
    <script src="vendor/SweetAlert2/sweetalert2.all.min.js"></script>
    <script src="vendor/datatables/natural.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

    <script>
    $(document).ready(function() {
        //var </?php echo 'z'?> = $(this).data('titulo');
        //$('#editTreTitulo').val(z);
        // Evento de clique no botão de edição
        $('.btn-editar').click(function() {
            // Recupera o ID do treinamento do botão clicado
            var idCol = $(this).data('id');
            var usuEmail = $(this).data('email');
            var pesNome = $(this).data('nome')
            var pesCPF = $(this).data('cpf');
            var pesCEP = $(this).data('cep');
            var pesCidade = $(this).data('cidade');
            var pesBairro = $(this).data('bairro');
            var pesNumero = $(this).data('numero');
            var pesTelefone = $(this).data('telefone');
            console.log(usuEmail);

            // Define os valores nos campos do formulário de edição
            $('#editColaboradorId').val(idCol);
            $('#editusuEmail').val(usuEmail);
            $('#editpesNome').val(pesNome);
            $('#editpesCPF').val(pesCPF);
            $('#editpesCEP').val(pesCEP);
            $('#editpesCidade').val(pesCidade);
            $('#editpesBairro').val(pesBairro);
            $('#editpesNumero').val(pesNumero);
            $('#editpesTelefone').val(pesTelefone);
        });
        $('.btn-desativar').click(function() {
            // Recupera o ID do treinamento do botão clicado
            var colID = $(this).data('id');
            Swal.fire({
                title: "Tem certeza?",
                text: "Você não conseguira reverter isto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Deletar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deletado!",
                        text: "O usuário foi deletado com sucesso, redirecionando em 2 segundos.",
                        icon: "success",
                        timer: 2000
                        //showConfirmButton: false
                    }).then(function() {
                        document.getElementById("desColaborador").value = colID;
                        document.forms["formdesativarColaborador"].submit();
                    });
                    //document.formdesativarTreinamento.desTreinamento.value = treId;
                }
            });

        });
    });
    </script>

</body>

</html>

<?php $_POST = array(); ?>