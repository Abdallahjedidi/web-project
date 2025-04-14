<?php
include_once '../../Controller/signalementctrl.php';
include_once '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $signalement = new Signalement();

    if (isset($_POST['id_signalement'])) {
        $signalement->setIdSignalement($_POST['id_signalement']);
    }
    if (isset($_POST['titre'])) {
        $signalement->setTitre($_POST['titre']);
    }
    if (isset($_POST['description'])) {
        $signalement->setDescription($_POST['description']);
    }
    if (isset($_POST['emplacement'])) {
        $signalement->setEmplacement($_POST['emplacement']);
    }
    if (isset($_POST['date_signalement'])) {
        $signalement->setDateSignalement($_POST['date_signalement']);
    }
    if (isset($_POST['statut'])) {
        $signalement->setStatut($_POST['statut']);
    }

    $controller = new SignalementC();
    $controller->updateSignalement($signalement);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Signalements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestion:</h6>
                        <a class="collapse-item" href="addsignalement.php">Ajouter signalement</a>
                        <a class="collapse-item" href="affichesignalement.php">Afficher signalements</a>
                        <a class="collapse-item" href="modifiersignalement.php">Modifier signalement</a>
                    </div>
                </div>
            </li>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
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
                                            placeholder="Rechercher..." aria-label="Search"
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

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Paramètres
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="text-center">Modifier un Signalement</h1>
                    
                    <?php
                    include_once '../../Controller/signalementctrl.php';

                    $titre = $description = $emplacement = $date_signalement = $statut = "";
                    $id_signalement = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
                        $id_signalement = $_POST['search'];
                        $controller = new SignalementC();
                        $signalements = $controller->rechercher($id_signalement);

                        if ($signalements) {
                            $signalement = $signalements[0];
                            $titre = $signalement['titre'];
                            $description = $signalement['description'];
                            $emplacement = $signalement['emplacement'];
                            $date_signalement = $signalement['date_signalement'];
                            $statut = $signalement['statut'];
                        }
                    }
                    ?>

                    <form class="user mx-auto" action="" method="POST" style="max-width: 400px;">
                        <div class="form-group">
                            <label for="search">ID Signalement:</label>
                            <input type="number" class="form-control form-control-user" id="search" name="search"
                                value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">Rechercher</button>
                    </form>

                    <form class="user mx-auto" method="POST" style="max-width: 400px; margin-top: 20px;">
                        <input type="hidden" name="id_signalement" value="<?= htmlspecialchars($id_signalement ?? '') ?>">

                        <div class="form-group">
                            <label for="titre">Titre:</label>
                            <input type="text" class="form-control form-control-user" id="titre" name="titre" 
                                value="<?= htmlspecialchars($titre) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control form-control-user" id="description" name="description" 
                                required><?= htmlspecialchars($description) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="emplacement">Emplacement:</label>
                            <input type="text" class="form-control form-control-user" id="emplacement" name="emplacement" 
                                value="<?= htmlspecialchars($emplacement) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="date_signalement">Date du signalement:</label>
                            <input type="date" class="form-control form-control-user" id="date_signalement" name="date_signalement" 
                                value="<?= htmlspecialchars($date_signalement) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="statut">Statut:</label>
                            <select class="form-control form-control-user" id="statut" name="statut" required>
                                <option value="En attente" <?= $statut == 'En attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="En cours" <?= $statut == 'En cours' ? 'selected' : '' ?>>En cours</option>
                                <option value="Résolu" <?= $statut == 'Résolu' ? 'selected' : '' ?>>Résolu</option>
                                <option value="Rejeté" <?= $statut == 'Rejeté' ? 'selected' : '' ?>>Rejeté</option>
                            </select>
                        </div>

                        <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Mettre à jour</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href='affichersignalement.php' class="btn btn-secondary">Retour à la liste</a>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2023</span>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="login.html">Déconnexion</a>
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

</body>

</html>