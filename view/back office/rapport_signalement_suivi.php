<?php
include_once '../../Controller/SuiviC.php';
include_once '../../config.php';

$suivic = new SuiviC();
$listeSuivis = $suivic->afficherSuivis();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liste des Suivis</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">

                <h1 class="text-center mb-4">Liste des Suivis</h1>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID Suivi</th>
                                <th>ID Signalement</th>
                                <th>Date Suivi</th>
                                <th>Service Responsable</th>
                                <th>Statut</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listeSuivis as $suivi): ?>
                                <tr>
                                    <td><?php echo $suivi['id_suivi']; ?></td>
                                    <td><?php echo $suivi['id_signalement']; ?></td>
                                    <td><?php echo htmlspecialchars($suivi['date_suivi']); ?></td>
                                    <td><?php echo htmlspecialchars($suivi['service_responsable']); ?></td>
                                    <td><?php echo htmlspecialchars($suivi['statut']); ?></td>
                                    <td><?php echo htmlspecialchars($suivi['description']); ?></td>
                                    <td class="text-center">
                                        <a href="pdfsuivi.php?id_signalement=<?php echo $suivi['id_signalement']; ?>" 
                                           class="btn btn-success btn-sm" target="_blank" title="Générer PDF">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © TonSite 2025</span>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
