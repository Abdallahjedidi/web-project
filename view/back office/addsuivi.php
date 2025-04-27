<?php
include_once '../../Controller/SuiviC.php';
include_once '../../Controller/signalementctrl.php';
include_once '../../Model/Suivi.php';
include_once '../../config.php';

$signalementC = new SignalementC();
$listeSignalements = $signalementC->afficherSignalements();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['id_signalement'])) {
        $errors['id_signalement'] = "Veuillez sélectionner un signalement.";
    } else {
        $idsExistants = array_column($listeSignalements, 'id_signalement');
        if (!in_array($_POST['id_signalement'], $idsExistants)) {
            $errors['id_signalement'] = "Signalement invalide.";
        }
    }

    if (empty($_POST['date_suivi'])) {
        $errors['date_suivi'] = "Veuillez saisir une date.";
    }

    if (empty($_POST['service_responsable'])) {
        $errors['service_responsable'] = "Veuillez choisir un service.";
    }

    if (empty($_POST['statut'])) {
        $errors['statut'] = "Veuillez choisir un statut.";
    }

    if (empty($_POST['description'])) {
        $errors['description'] = "Veuillez saisir une description.";
    } else {
        $description = trim($_POST['description']);
        if (strlen($description) < 10) {
            $errors['description'] = "La description doit contenir au moins 10 caractères.";
        } elseif (str_word_count($description) < 2) {
            $errors['description'] = "La description doit contenir au moins deux mots.";
        }
    }

    if (empty($errors)) {
        $suivi = new Suivi();
        $suivi->setIdSignalement($_POST['id_signalement']);
        $suivi->setDateSuivi($_POST['date_suivi']);
        $suivi->setServiceResponsable($_POST['service_responsable']);
        $suivi->setStatut($_POST['statut']);
        $suivi->setDescription($_POST['description']);

        $suivic = new SuiviC();
        $suivic->ajouterSuivi($suivi);
        header("Location: affichesuivi.php?success=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter un Suivi</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
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

        <li class="nav-item active">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSignalement" aria-expanded="true" aria-controls="collapseSignalement">
                <i class="fas fa-fw fa-cog"></i>
                <span>Signalements</span>
            </a>
            <div id="collapseSignalement" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="addsignalement.php">Ajouter Signalement</a>
                    <a class="collapse-item" href="affichesignalement.php">Afficher Signalements</a>
                    <a class="collapse-item" href="modifiersignalement.php">Modifier Signalement</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuivi" aria-expanded="true" aria-controls="collapseSuivi">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Suivis</span>
            </a>
            <div id="collapseSuivi" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="addsuivi.php">Ajouter Suivi</a>
                    <a class="collapse-item" href="affichesuivi.php">Afficher Suivis</a>
                    <a class="collapse-item" href="rapport_signalement_suivi.php">Rapport Suivi</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
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

            <div class="container-fluid">

                <h1 class="text-center">Ajouter un Suivi</h1>

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <form class="user" method="POST">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user <?php echo isset($errors['id_signalement']) ? 'is-invalid' : ''; ?>" name="id_signalement" id="id_signalement" placeholder="ID Signalement" value="<?php echo isset($_POST['id_signalement']) ? htmlspecialchars($_POST['id_signalement']) : ''; ?>">
                                            <?php if (isset($errors['id_signalement'])): ?><div class="invalid-feedback" style="display:block;"><?php echo $errors['id_signalement']; ?></div><?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control form-control-user <?php echo isset($errors['date_suivi']) ? 'is-invalid' : ''; ?>" name="date_suivi" value="<?php echo isset($_POST['date_suivi']) ? htmlspecialchars($_POST['date_suivi']) : ''; ?>">
                                            <?php if (isset($errors['date_suivi'])): ?><div class="invalid-feedback" style="display:block;"><?php echo $errors['date_suivi']; ?></div><?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control <?php echo isset($errors['service_responsable']) ? 'is-invalid' : ''; ?>" name="service_responsable">
                                                <option value="" disabled selected hidden>-- Choisir un service --</option>
                                                <option value="Municipalité" <?php if(isset($_POST['service_responsable']) && $_POST['service_responsable']=="Municipalité") echo "selected"; ?>>Municipalité</option>
                                                <option value="Police" <?php if(isset($_POST['service_responsable']) && $_POST['service_responsable']=="Police") echo "selected"; ?>>Police</option>
                                                <option value="STEG" <?php if(isset($_POST['service_responsable']) && $_POST['service_responsable']=="STEG") echo "selected"; ?>>STEG</option>
                                                <option value="SONEDE" <?php if(isset($_POST['service_responsable']) && $_POST['service_responsable']=="SONEDE") echo "selected"; ?>>SONEDE</option>
                                                <option value="Autre" <?php if(isset($_POST['service_responsable']) && $_POST['service_responsable']=="Autre") echo "selected"; ?>>Autre</option>
                                            </select>
                                            <?php if (isset($errors['service_responsable'])): ?><div class="invalid-feedback" style="display:block;"><?php echo $errors['service_responsable']; ?></div><?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control <?php echo isset($errors['statut']) ? 'is-invalid' : ''; ?>" name="statut">
                                                <option value="" disabled selected hidden>-- Choisir un statut --</option>
                                                <option value="En attente" <?php if(isset($_POST['statut']) && $_POST['statut']=="En attente") echo "selected"; ?>>En attente</option>
                                                <option value="En cours" <?php if(isset($_POST['statut']) && $_POST['statut']=="En cours") echo "selected"; ?>>En cours</option>
                                                <option value="Résolu" <?php if(isset($_POST['statut']) && $_POST['statut']=="Résolu") echo "selected"; ?>>Résolu</option>
                                            </select>
                                            <?php if (isset($errors['statut'])): ?><div class="invalid-feedback" style="display:block;"><?php echo $errors['statut']; ?></div><?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control form-control-user <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" name="description" placeholder="Description..." rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                                            <?php if (isset($errors['description'])): ?><div class="invalid-feedback" style="display:block;"><?php echo $errors['description']; ?></div><?php endif; ?>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Ajouter Suivi
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des Signalements -->
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
                                        <td><?= $signalement['id_signalement'] ?></td>
                                        <td><?= htmlspecialchars($signalement['titre']) ?></td>
                                        <td><?= htmlspecialchars($signalement['description']) ?></td>
                                        <td><?= htmlspecialchars($signalement['emplacement']) ?></td>
                                        <td><?= htmlspecialchars($signalement['date_signalement']) ?></td>
                                        <td><?= htmlspecialchars($signalement['statut']) ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="remplirIdSignalement('<?= $signalement['id_signalement'] ?>')">
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
