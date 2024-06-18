<?php
namespace App\Controller;

ob_start();
class Renders
{
    static function renderNavbar($usuario)
    {
        ?>
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <form class="form-inline">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </form>

            <!-- Topbar Search -->
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Pesquisar por..."
                        aria-label="Search" aria-describedby="basic-addon2">
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
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>


                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $usuario ?></span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="PerfilColaboradorView.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Sair
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <?php
    }
    static function renderSidebar($tipo)
    {
        ?>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" <?php if ($tipo == "colaborador"): ?>
                href="IndexColaborador.php" 
                <?php elseif ($tipo == "administrador"): ?>href="IndexAdministrador.php" <?php endif; ?>>
                <div class="sidebar-brand-icon">
                    <img src="img/logo.svg" style="width: 45px;" alt="logo">
                </div>
                <div class="sidebar-brand-text mx-3">NexusSync</div>
            </a>
            <p style="padding-top:10%; padding-left:6%; color: white;">
                <?php if ($tipo == "colaborador"): ?>Perfil: Colaborador
                <?php elseif ($tipo == "administrador"): ?>Perfil: Administrador do RH
                <?php endif; ?>
            </p>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" <?php if($tipo == "colaborador") : ?>href="IndexColaborador.php"
                    <?php elseif($tipo == "administrador") : ?>href="IndexAdministrador.php" <?php endif; ?>>
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</s></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="viewTreinamentos.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Treinamentos</span></a>
            </li>
            <?php if ($tipo == "administrador"): ?>
            <li class="nav-item">
                    <a class="nav-link" href="ColaboradoresView.php">
                        <i class="fas fa-fw fa-user"></i><span>Usuários</span>
                    </a>
            </li>
            <?php endif; ?>
            <?php if ($tipo == "administrador"): ?>
            <li class="nav-item">
                <a class="nav-link" href="DepartamentosView.php">
                    <i class="fas fa-fw fa-users"></i><span>Departamentos</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($tipo == "administrador"): ?>
            <li class="nav-item">
                <a class="nav-link" href="TreinoColaboradores.php">
                    <i class="fas fa-fw fa-user"></i><span>Treinamento/Colaboradores</span>
                </a>
            </li>
            <?php endif; ?>



            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <?php
    }
    static function logoutModal()
    {
        ?>
        <form method="post" action="">
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Selecione "Sair" abaixo se estiver pronto para encerrar sua sessão atual.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" name="sair">Sair</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
}