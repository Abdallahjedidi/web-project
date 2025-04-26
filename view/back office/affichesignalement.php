<?php
include_once '../../Controller/signalementCtrl.php';
include_once '../../config.php';

$signalementC = new Signalementc();
$liste = $signalementC->afficherSignalement();

if (isset($_POST['id'])) {
    $signalementC->deleteSignalement($_POST['id']);
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

    <title>Dashboard - Liste des Signalements</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Menu Signalement -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSignalement"
               aria-expanded="true" aria-controls="collapseSignalement">
                <i class="fas fa-fw fa-cog"></i>
                <span>Signalements</span>
            </a>
            <div id="collapseSignalement" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Édition :</h6>
                    <a class="collapse-item" href="addsignalement.php">Ajouter Signalement</a>
                    <a class="collapse-item" href="affichesignalement.php">Afficher Signalements</a>
                    <a class="collapse-item" href="modifiersignalement.php">Modifier Signalement</a>
                </div>
            </div>
        </li>

        <!-- Menu Suivi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuivi"
               aria-expanded="true" aria-controls="collapseSuivi">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Suivis</span>
            </a>
            <div id="collapseSuivi" class="collapse" aria-labelledby="headingSuivi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Édition :</h6>
                    <a class="collapse-item" href="addsuivi.php">Ajouter Suivi</a>
                    <a class="collapse-item" href="affichesuivi.php">Afficher Suivis</a>
                    <a class="collapse-item" href="rapport_signalement_suivi.php">rapport Suivi</a>
                </div>
            </div>
        </li>
    </ul>

        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Liste des signalements</h1>
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="m-0 font-weight-bold text-primary">Liste des signalements</h6>
                                <a href="export_pdf.php" target="_blank" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-file-pdf"></i>
                                    </span>
                                    <span class="text">Exporter en PDF</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Emplacement</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($liste as $signalement): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($signalement['id_signalement']) ?></td>
                                                <td><?= htmlspecialchars($signalement['titre']) ?></td>
                                                <td><?= htmlspecialchars($signalement['description']) ?></td>
                                                <td><?= htmlspecialchars($signalement['emplacement']) ?></td>
                                                <td><?= htmlspecialchars($signalement['date_signalement']) ?></td>
                                                <td><?= htmlspecialchars($signalement['statut']) ?></td>
                                                <td>
                                                    <form action="affichesignalement.php" method="POST">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($signalement['id_signalement']) ?>" />
                                                        <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                                                    </form>
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
                        <span>Copyright &copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- JS Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
