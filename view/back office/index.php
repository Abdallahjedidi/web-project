<?php
include_once '../../Controller/signalementctrl.php';
$signalementCtrl = new SignalementC();
$newSignalements = $signalementCtrl->getTodaySignalements();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <style>
        .fade-out {
            transition: opacity 0.5s ease-out;
            opacity: 0;
        }
        .close-btn {
            background: none;
            border: none;
            color: red;
            font-size: 18px;
            font-weight: bold;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
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
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSignalement" aria-expanded="true" aria-controls="collapseSignalement">
                <i class="fas fa-fw fa-cog"></i>
                <span>Signalements</span>
            </a>
            <div id="collapseSignalement" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Edition:</h6>
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
            <div id="collapseSuivi" class="collapse" aria-labelledby="headingSuivi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Edition:</h6>
                    <a class="collapse-item" href="addsuivi.php">Ajouter Suivi</a>
                    <a class="collapse-item" href="affichesuivi.php">Afficher Suivis</a>
                    <a class="collapse-item" href="rapport_signalement_suivi.php">Rapport Suivi</a>
                </div>
            </div>
        </li>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <?php if (count($newSignalements) > 0): ?>
                                <span class="badge badge-danger badge-counter" id="notifCount"><?= count($newSignalements) ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">Nouveaux signalements</h6>
                            <?php foreach ($newSignalements as $sig): ?>
                                <div class="dropdown-item d-flex align-items-center" id="notif-<?= $sig['id_signalement'] ?>">
                                    <div onclick="showDetails('<?= htmlspecialchars(json_encode($sig)) ?>')" style="flex:1; cursor:pointer;">
                                        <div class="small text-gray-500"> <?= htmlspecialchars($sig['date_signalement']) ?> </div>
                                        <span class="font-weight-bold"> <?= htmlspecialchars($sig['titre']) ?> </span>
                                    </div>
                                    <button class="close-btn" onclick="removeNotification('notif-<?= $sig['id_signalement'] ?>', event)">X</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid">
                <div id="signalementDetails" style="display:none;" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Détail Signalement</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Titre:</strong> <span id="detailTitre"></span></p>
                        <p><strong>Description:</strong> <span id="detailDescription"></span></p>
                        <p><strong>Emplacement:</strong> <span id="detailEmplacement"></span></p>
                        <p><strong>Date:</strong> <span id="detailDate"></span></p>
                        <p><strong>Statut:</strong> <span id="detailStatut"></span></p>
                    </div>
                </div>
            </div>

        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
function showDetails(data) {
    var signalement = JSON.parse(data);
    document.getElementById('detailTitre').innerText = signalement.titre;
    document.getElementById('detailDescription').innerText = signalement.description;
    document.getElementById('detailEmplacement').innerText = signalement.emplacement;
    document.getElementById('detailDate').innerText = signalement.date_signalement;
    document.getElementById('detailStatut').innerText = signalement.statut;
    document.getElementById('signalementDetails').style.display = 'block';
}

function removeNotification(id, event) {
    event.stopPropagation();
    const notif = document.getElementById(id);
    notif.classList.add('fade-out');
    setTimeout(() => {
        notif.remove();
        let badge = document.getElementById('notifCount');
        if (badge) {
            let count = parseInt(badge.innerText);
            if (count > 1) {
                badge.innerText = count - 1;
            } else {
                badge.remove();
            }
        }
    }, 500);
}
</script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>