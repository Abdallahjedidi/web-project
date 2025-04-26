<?php
include_once '../../Controller/SuiviC.php';
include_once '../../Model/Suivi.php';
include_once '../../config.php';

$suivic = new SuiviC();

// Récupérer le suivi
if (isset($_GET['id_suivi'])) {
    $id_suivi = $_GET['id_suivi'];
    $suiviData = $suivic->recupererSuivi($id_suivi);

    if (!$suiviData) {
        die('Suivi introuvable.');
    }
} else {
    die('ID non spécifié.');
}

// Modifier suivi si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suivi = new Suivi();
    $suivi->setIdSuivi($_POST['id_suivi']);
    $suivi->setIdSignalement($_POST['id_signalement']);
    $suivi->setDateSuivi($_POST['date_suivi']);
    $suivi->setServiceResponsable($_POST['service_responsable']);
    $suivi->setStatut($_POST['statut']);
    $suivi->setDescription($_POST['description']);

    $suivic->modifierSuivi($suivi);

    header("Location: affichesuivi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modifier Suivi</title>

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
                    <a class="collapse-item" href="rapport_signalement_suivi.php">Modifier Signalement</a>
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
                    <a class="collapse-item" href="modifiersuivi.php">Modifier Suivi</a>
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

            <!-- Content -->
            <div class="container-fluid">

                <h1 class="text-center mb-4">Modifier un Suivi</h1>

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="p-5">

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Formulaire de Modification</h1>
                                    </div>

                                    <form class="user" method="POST">
                                        <input type="hidden" name="id_suivi" value="<?php echo $suiviData['id_suivi']; ?>">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="id_signalement" value="<?php echo $suiviData['id_signalement']; ?>" required placeholder="ID Signalement">
                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control form-control-user" name="date_suivi" value="<?php echo $suiviData['date_suivi']; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control form-control-user" name="service_responsable" required>
                                                <option value="" disabled>Choisir un service...</option>
                                                <option value="Municipalité" <?php if($suiviData['service_responsable']=='Municipalité') echo 'selected'; ?>>Municipalité</option>
                                                <option value="Police" <?php if($suiviData['service_responsable']=='Police') echo 'selected'; ?>>Police</option>
                                                <option value="STEG" <?php if($suiviData['service_responsable']=='STEG') echo 'selected'; ?>>STEG</option>
                                                <option value="SONEDE" <?php if($suiviData['service_responsable']=='SONEDE') echo 'selected'; ?>>SONEDE</option>
                                                <option value="Autre" <?php if($suiviData['service_responsable']=='Autre') echo 'selected'; ?>>Autre</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control form-control-user" name="statut" required>
                                                <option value="" disabled>Choisir un statut...</option>
                                                <option value="En attente" <?php if($suiviData['statut']=='En attente') echo 'selected'; ?>>En attente</option>
                                                <option value="En cours" <?php if($suiviData['statut']=='En cours') echo 'selected'; ?>>En cours</option>
                                                <option value="Résolu" <?php if($suiviData['statut']=='Résolu') echo 'selected'; ?>>Résolu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control form-control-user" name="description" placeholder="Description..." rows="3" required><?php echo htmlspecialchars($suiviData['description']); ?></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Modifier Suivi
                                        </button>
                                        <a href="affichesuivi.php" class="btn btn-secondary btn-user btn-block">
                                            Retour à la liste
                                        </a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
