<?php
namespace App\View;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\TreiColabController;
use \App\Controller\LoginController;
use \App\Controller\Renders;

$banco = new LoginController;
if (isset($_POST['sair'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}
if(isset($_SESSION['usuario'])){
    if($banco->getUsuario()[2] == "colaborador"){
        ?>
<script>
window.onload = function() {
    document.getElementById("wrapper").style.display = 'none';
    Swal.fire({
        title: "Acesso Não Permitido!",
        text: "Apenas administradores podem acessar está pagina, encerrando sessão.",
        icon: "error",
        //timer: 2000,
        showConfirmButton: true
    }).then(function() {
        <?php $banco->destroy_sessoes(); ?>
        window.location = '<?php echo dirname($_SERVER["PHP_SELF"])?>/LoginView.php';
    })
};
</script>
<?php
    }
}else{
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

$TreinoColaboradores = (new TreiColabController())->getAllTreiColab();
$colaboradores = (new TreiColabController())->getColaboradores();
$treinamentos = (new TreiColabController())->getTreinamentos();
if (isset($_POST['linkar'])) {
    $colID = $_POST['colaborador'];
    $treID = $_POST['treinamento'];

    $var = (new TreiColabController())->linkarTreinoColab($colID,$treID);
    header('Location:' . basename(__FILE__));
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
    <link href="css/estiloNexus.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Treinamento X Colaboradores</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                            data-target="#novoTreinoColab">
                            <i class="fas fa-link fa-sm text-white-50"></i>
                            Treino/Colab
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal" id="novoTreinoColab" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Linkar Treino/Colaborador</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formNovoColaborador" method="POST">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select class="form-control mt-2" name="colaborador" id="colaborador">
                                                        <option value="" selected>Selecione um colaborador</option>
                                                        <?php foreach ($colaboradores as $colaborador) { ?>
                                                        <option value="<?php echo $colaborador['col_id'] ?>">
                                                            <?php echo $colaborador['pes_nome']; ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select class="form-control mt-2" name="treinamento" id="treinamento">
                                                        <option value="" selected>Selecione um treinamento</option>
                                                        <?php foreach ($treinamentos as $treinamento) { ?>
                                                        <option value="<?php echo $treinamento['tre_id']?>">
                                                            <?php echo $treinamento['tre_titulo']; ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Linkar" name="linkar"></i>
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
                            <h6 class="m-0 font-weight-bold text-primary">Treinamento/Colaboradores Cadastrados</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nome do Colaborador</th>
                                            <th>Treinamento</th>
                                            <th>Responsável pelo Treinamento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($TreinoColaboradores as $TreinoColaborador): ?>

                                        <tr>
                                            <!-- </?php echo array_search($colaborador['col_id'], $colaborador); ?> -->
                                            <td><?php echo $TreinoColaborador['pes_nome']; ?></td>
                                            <td><?php echo $TreinoColaborador['tre_titulo']; ?></td>
                                            <td><?php echo $TreinoColaborador['tre_responsavel']; ?></td>
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

    });
    </script>

</body>

</html>

<?php $_POST = array(); ?>