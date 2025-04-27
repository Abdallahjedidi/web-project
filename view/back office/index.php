<?php
session_start();
include_once '../../Controller/signalementctrl.php';

$signalementCtrl = new SignalementC();
$newSignalements = $signalementCtrl->getTodaySignalements(); // Notifications
$allSignalements = $signalementCtrl->getAllSignalements();   // Tous signalements pour graphe

// Compter les statuts
$statutCounts = [
    'En attente' => 0,
    'En cours' => 0,
    'Résolu' => 0,
];

foreach ($allSignalements as $sig) {
    if (isset($statutCounts[$sig['statut']])) {
        $statutCounts[$sig['statut']]++;
    }
}

// Sécurité : si base vide
if (array_sum($statutCounts) === 0) {
    $statutCounts['En attente'] = 1;
    $statutCounts['En cours'] = 1;
    $statutCounts['Résolu'] = 1;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
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
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSignalement">
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

        <!-- Menu Suivi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuivi">
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
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-bell fa-fw"></i>
                            <?php
                            $newCount = 0;
                            foreach ($newSignalements as $sig) {
                                if (!isset($_SESSION['closed_notifications'][$sig['id_signalement']])) {
                                    $newCount++;
                                }
                            }
                            ?>
                            <?php if ($newCount > 0): ?>
                                <span class="badge badge-danger badge-counter" id="notifCount"><?= $newCount ?></span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" id="notifList">
                            <h6 class="dropdown-header">Nouveaux signalements</h6>
                            <?php foreach ($newSignalements as $sig): ?>
                                <?php if (!isset($_SESSION['closed_notifications'][$sig['id_signalement']])): ?>
                                    <div class="dropdown-item d-flex align-items-center" id="notif-<?= $sig['id_signalement'] ?>">
                                        <div onclick="showDetails('<?= htmlspecialchars(json_encode($sig)) ?>')" style="flex:1; cursor:pointer;">
                                            <div class="small text-gray-500"><?= htmlspecialchars($sig['date_signalement']) ?></div>
                                            <span class="font-weight-bold"><?= htmlspecialchars($sig['titre']) ?></span>
                                        </div>
                                        <button class="close-btn" onclick="removeNotification('notif-<?= $sig['id_signalement'] ?>', <?= $sig['id_signalement'] ?>, event)">X</button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </li>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Détail signalement caché au début -->
                <div id="signalementDetails" style="display:none;" class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Détails du Signalement</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Titre :</strong> <span id="detailTitre"></span></p>
                        <p><strong>Description :</strong> <span id="detailDescription"></span></p>
                        <p><strong>Emplacement :</strong> <span id="detailEmplacement"></span></p>
                        <p><strong>Date :</strong> <span id="detailDate"></span></p>
                        <p><strong>Statut :</strong> <span id="detailStatut"></span></p>
                    </div>
                </div>

                <!-- Graphe -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Répartition des Signalements</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4">
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2025</span>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- Scripts -->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

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

function removeNotification(idHtml, idSignalement, event) {
    event.stopPropagation();
    const notif = document.getElementById(idHtml);
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
        fetch('close_notification.php?id=' + idSignalement);
    }, 500);
}

// Graphe
var ctx = document.getElementById("myPieChart").getContext('2d');
var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["En attente", "En cours", "Résolu"],
        datasets: [{
            data: [
                <?= $statutCounts['En attente'] ?>,
                <?= $statutCounts['En cours'] ?>,
                <?= $statutCounts['Résolu'] ?>
            ],
            backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a'],
            hoverBackgroundColor: ['#f4b619', '#2c9faf', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        legend: { display: true },
        cutoutPercentage: 60
    },
});
</script>

</body>
</html>
