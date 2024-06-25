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
if (isset($_SESSION['usuario'])) {
    if ($banco->getUsuario()[2] == "colaborador") {
        ?>
        <script>
            document.getElementById("wrapper").style.display = 'none';
            window.onload = function () {
                Swal.fire({
                    title: "Acesso Não Permitido!",
                    text: "Apenas administradores podem acessar está pagina, encerrando sessão.",
                    icon: "error",
                    //timer: 2000,
                    showConfirmButton: true
                }).then(function () {
                    <?php $banco->destroy_sessoes(); ?>
                    window.location = '<?php echo dirname($_SERVER["PHP_SELF"]) ?>/LoginView.php';
                })
            };
        </script>
        <?php
    }
} else {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}
/* 
$colaboradorIdTeste = 10;
$teste = (new ColaboradoresController)->getTreinamentosByColaboradorId($colaboradorIdTeste);
echo "<pre>";
print_r($teste);
echo "</pre>"; */


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

    $var = (new ColaboradoresController)->inserirVerificador(
        $pesNome,
        $pesCPF,
        $pesCEP,
        $pesCidade,
        $pesBairro,
        $pesNumero,
        $pesTelefone,
        $usuEmail,
        $usuSenha
    );
    $_SESSION['varInserCol'] = $var;
    header('Location:' . basename(__FILE__));
    goto b;
}


if (isset($_POST['salvarColaborador'])) {
    $colID = $_POST['editColaboradorId'];
    $usuEmail = $_POST['editusuEmail'];
    $pesNome = $_POST['editpesNome'];
    $pesCPF = $_POST['editpesCPF'];
    $pesCEP = $_POST['editpesCEP'];
    $pesCidade = $_POST['editpesCidade'];
    $pesBairro = $_POST['editpesBairro'];
    $pesNumero = $_POST['editpesNumero'];
    $pesTelefone = $_POST['editpesTelefone'];


    $var = (new ColaboradoresController)->editarColaborador(
        $colID,
        $usuEmail,
        $pesNome,
        $pesCPF,
        $pesCEP,
        $pesCidade,
        $pesBairro,
        $pesNumero,
        $pesTelefone
    );
    echo $var;
    header('Location:' . basename(__FILE__));
    goto b;
}

$desativarColaborador = new ColaboradoresController();
if (isset($_POST['desColaborador'])) {
    $colID = $_POST['desColaborador'];
    $varErro = $desativarColaborador->disableColaborador($colID);
    header('Location:' . basename(__FILE__));
    goto b;
}
$_POST = array();
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
    <link rel="stylesheet" href="css/estiloNexus.css">
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
                <?php Renders::renderNavbar($banco->getUsuario()[0], $banco->chamarTipo()); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0 text-dark">Colaboradores</h3>
                        <button class="d-none d-sm-inline-block btn btn-sm azul-claro shadow-sm text-light"
                            data-toggle="modal" data-target="#novoColaborador">
                            <i class="fas fa-plus fa-sm text-light"></i>
                            Colaborador
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="novoColaborador" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header azul-nexus">
                                    <h5 class="modal-title text-light font-weight-bold" id="exampleModalLabel">Novo
                                        Colaborador</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="fechar">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formNovoColaborador" method="POST" class="font-weight-bold text-dark">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="pesNome">Nome:</label>
                                                    <input type="text" class="form-control" id="pesNome" name="pesNome"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="pesCPF">CPF:</label>
                                                    <input type="text" class="form-control" id="pesCPF" name="pesCPF"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="pesTelefone">Telefone:</label>
                                                    <input type="text" class="form-control" id="pesTelefone"
                                                        name="pesTelefone" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="pesCEP">CEP:</label>
                                                    <input type="number" class="form-control" id="pesCEP" name="pesCEP"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="pesCidade">Cidade:</label>
                                                    <input type="text" class="form-control" id="pesCidade"
                                                        name="pesCidade" required>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="pesBairro">Bairro:</label>
                                                    <input type="text" class="form-control" id="pesBairro"
                                                        name="pesBairro" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="pesNumero">Número da residência:</label>
                                                    <input type="number" class="form-control" id="pesNumero"
                                                        name="pesNumero" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr class="border border-primary border-2 opacity-50">
                                            </div>
                                            <div class="col-12">
                                                <p><span class="font-weight-bold">Usuário:</span></p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usuEmail">Email:</label>
                                                    <input type="email" class="form-control" id="usuEmail"
                                                        name="usuEmail" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="usuSenha">Senha:</label>
                                                    <input type="password" class="form-control" id="usuSenha"
                                                        name="usuSenha" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <input type="submit" class="btn btn-primary" value="Enviar"
                                                    name="enviar"></i>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- DataTales Example -->
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
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($colaboradores as $colaborador): ?>

                                            <tr>
                                                <!-- </?php echo array_search($colaborador['col_id'], $colaborador); ?> -->
                                                <td><?php echo $colaborador['col_id']; ?></td>
                                                <td><?php echo $colaborador['usu_email']; ?></td>
                                                <td><?php echo $colaborador['pes_nome']; ?></td>
                                                <td><?php echo $colaborador['pes_cpf']; ?></td>
                                                <td>
                                                    <div class="container text-center">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <button class="btn btn-info btn-visualizar"
                                                                    data-toggle="modal" data-target="#visualizarColaborador"
                                                                    data-id="<?php echo $colaborador['col_id']; ?>"
                                                                    data-email="<?php echo $colaborador['usu_email']; ?>"
                                                                    data-nome="<?php echo $colaborador['pes_nome']; ?>"
                                                                    data-cpf="<?php echo $colaborador['pes_cpf']; ?>"
                                                                    data-cep="<?php echo $colaborador['pes_cep']; ?>"
                                                                    data-cidade="<?php echo $colaborador['pes_cidade']; ?>"
                                                                    data-bairro="<?php echo $colaborador['pes_bairro']; ?>"
                                                                    data-numero="<?php echo $colaborador['pes_numero']; ?>"
                                                                    data-telefone="<?php echo $colaborador['pes_telefone']; ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </div>

                                                            <div class="col-4">
                                                                <button class="btn btn-warning btn-editar"
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

                                                            <div class="col-4">
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

    <!-- Modal de Visualização do Colaborador -->
    <div class="modal" id="visualizarColaborador" tabindex="-1" role="dialog"
        aria-labelledby="visualizarColaboradorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarColaboradorLabel">Visualizar Colaborador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="viewColaboradorId" name="viewColaboradorId">
                    <div class="form-group">
                        <label for="viewusuEmail">Email:</label>
                        <input type="text" class="form-control" id="viewusuEmail" name="viewusuEmail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesNome">Nome:</label>
                        <input type="text" class="form-control" id="viewpesNome" name="viewpesNome" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesCPF">CPF:</label>
                        <input type="text" class="form-control" id="viewpesCPF" name="viewpesCPF" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesCEP">CEP:</label>
                        <input type="text" class="form-control" id="viewpesCEP" name="viewpesCEP" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesCidade">Cidade:</label>
                        <input type="text" class="form-control" id="viewpesCidade" name="viewpesCidade" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesBairro">Bairro:</label>
                        <input type="text" class="form-control" id="viewpesBairro" name="viewpesBairro" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesNumero">Número residencial:</label>
                        <input type="text" class="form-control" id="viewpesNumero" name="viewpesNumero" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesTelefone">Telefone:</label>
                        <input type="text" class="form-control" id="viewpesTelefone" name="viewpesTelefone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewpesTreinamentos">Treinamentos:</label>
                        <ul id="listaTreinamentos"></ul>
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



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
                            <input type="text" class="form-control" id="editusuEmail" name="editusuEmail" required>
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
                            <input type="text" class="form-control" id="editpesTelefone" name="editpesTelefone"
                                required>
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
        $(document).ready(function () {
            //var </?php echo 'z'?> = $(this).data('titulo');
            //$('#editTreTitulo').val(z);
            // Evento de clique no botão de edição

            $('.btn-visualizar').click(function () {
                var idCol = $(this).data('id');
                var usuEmail = $(this).data('email');
                var pesNome = $(this).data('nome');
                var pesCPF = $(this).data('cpf');
                var pesCEP = $(this).data('cep');
                var pesCidade = $(this).data('cidade');
                var pesBairro = $(this).data('bairro');
                var pesNumero = $(this).data('numero');
                var pesTelefone = $(this).data('telefone');

                $('#viewColaboradorId').val(idCol);
                $('#viewusuEmail').val(usuEmail);
                $('#viewpesNome').val(pesNome);
                $('#viewpesCPF').val(pesCPF);
                $('#viewpesCEP').val(pesCEP);
                $('#viewpesCidade').val(pesCidade);
                $('#viewpesBairro').val(pesBairro);
                $('#viewpesNumero').val(pesNumero);
                $('#viewpesTelefone').val(pesTelefone);

                // Chamada Ajax para recuperar os treinamentos do colaborador
                $.ajax({
                    url: '../Controller/ColaboradoresController.php', // Substitua pelo caminho do seu arquivo PHP
                    type: 'POST',
                    data: { "colaboradorId": idCol },
                    success: function (response) {
                        console.log(response); // Imprime a resposta no console para depuração
                        $('#listaTreinamentos').empty();
                        // Verifica se a resposta é um array
                        if (Array.isArray(response)) {
                            
                            response.forEach(function (treinamento) {
                                console.log(treinamento);
                                $('#listaTreinamentos').append('<li>' + treinamento + '</li>');
                            });
                        }
                    },
                    error: function () {
                        $('#listaTreinamentos').empty();
                        //alert('Erro ao carregar os treinamentos do colaborador.');
                        $('#listaTreinamentos').append('<li>Nenhum treinamento encontrado.</li>');
                    }
                });
            });


            $('.btn-editar').click(function () {
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

            $('.btn-desativar').click(function () {
                // Recupera o ID do treinamento do botão clicado
                var colID = $(this).data('id');
                Swal.fire({
                    title: "Tem certeza?",
                    text: "Você não conseguirá reverter isto!",
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
                        }).then(function () {
                            document.getElementById("desColaborador").value = colID;
                            document.forms["formdesativarColaborador"].submit();
                        });
                        //document.formdesativarTreinamento.desTreinamento.value = treId;
                    }
                });

            });
        });
    </script>
    <?php 
    if(isset($_SESSION['varInserCol']) && $_SESSION['varInserCol'] instanceof \PDOException){
        echo
        '<script>
            Swal.fire({
                title: "Erro!",
                text: "'.$_SESSION['varInserCol']->getMessage().'",
                icon: "error"
                //showConfirmButton: false
            })
        </script>';
        //echo "Erro ao atualizar o treinamento: " . $_SESSION['varInserCol']->getMessage();
        unset($_SESSION['varInserCol']);
    }
    b:;
    ?>
</body>
</html>