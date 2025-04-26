<?php
include_once '../../Controller/SuiviC.php';
include_once '../../Controller/signalementctrl.php';
include_once '../../Model/Suivi.php';
include_once '../../config.php';

$signalementC = new SignalementC();
$listeSignalements = $signalementC->afficherSignalements();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suivi = new Suivi();
    $suivi->setIdSignalement($_POST['id_signalement']);
    $suivi->setDateSuivi($_POST['date_suivi']);
    $suivi->setServiceResponsable($_POST['service_responsable']);
    $suivi->setStatut($_POST['statut']);
    $suivi->setDescription($_POST['description']);

    $suivic = new SuiviC();
    $suivic->ajouterSuivi($suivi);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajouter un Suivi</title>

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
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Formulaire -->
            <div class="container-fluid">
                <h1 class="text-center">Ajouter un Suivi</h1>

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Formulaire de Suivi</h1>
                                    </div>
                                    <form class="user mx-auto" action="addsuivi.php" method="POST" style="max-width: 400px;">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="id_signalement" id="id_signalement" placeholder="ID Signalement" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="date" class="form-control form-control-user" name="date_suivi" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-user" name="service_responsable" required>
                                                <option value="" disabled selected hidden>Choisir un service...</option>
                                                <option value="Municipalité">Municipalité</option>
                                                <option value="Police">Police</option>
                                                <option value="STEG">STEG</option>
                                                <option value="SONEDE">SONEDE</option>
                                                <option value="Autre">Autre</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-user" name="statut" required>
                                                <option value="" disabled selected hidden>Choisir un statut...</option>
                                                <option value="En attente">En attente</option>
                                                <option value="En cours">En cours</option>
                                                <option value="Résolu">Résolu</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control form-control-user" name="description" placeholder="Description..." rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Ajouter Suivi
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau Signalements -->
                <div class="container-fluid mt-5">
                    <h2 class="text-center">Liste des Signalements</h2>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Emplacement</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listeSignalements as $signalement): ?>
                                    <tr>
                                        <td><?php echo $signalement['id_signalement']; ?></td>
                                        <td><?php echo htmlspecialchars($signalement['titre']); ?></td>
                                        <td><?php echo htmlspecialchars($signalement['description']); ?></td>
                                        <td><?php echo htmlspecialchars($signalement['emplacement']); ?></td>
                                        <td><?php echo htmlspecialchars($signalement['date_signalement']); ?></td>
                                        <td><?php echo htmlspecialchars($signalement['statut']); ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="remplirIdSignalement('<?php echo $signalement['id_signalement']; ?>')">
                                                Ajouter Suivi
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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

<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

<script>
function remplirIdSignalement(id) {
    document.getElementById('id_signalement').value = id;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

</body>
</html>
