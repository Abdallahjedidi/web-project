<?php

require_once '../../controller/espaceController.php';
require_once '../../controller/activiteC.php';
require_once '../../controller/reserverC.php';
$activiteC= new activiteController();
$reservationC = new reserverController();
$reservationC = $reservationC->listReserver();
$activiteC = $activiteC->listActivite();
$controller = new espaceController();
$Pc = $controller->listEspace();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Stylesheets -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Espace</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="container mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>Liste des Espaces</h3>
                            <a href="ajouterEspace.php" class="btn btn-primary">+ Ajouter un Espace</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Adresse</th>
                                        <th>Ville</th>
                                        <th>Superficie</th>
                                        <th>Image</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Pc as $espace): ?>
                                        <tr>
                                            <td><?= $espace['id']; ?></td>
                                            <td><?= htmlspecialchars($espace['nom']); ?></td>
                                            <td><?= htmlspecialchars($espace['description']); ?></td>
                                            <td><?= htmlspecialchars($espace['adresse']); ?></td>
                                            <td><?= htmlspecialchars($espace['ville']); ?></td>
                                            <td><?= $espace['superficie']; ?> m²</td>
                                            <td>
                                                <?php if (!empty($espace['image'])): ?>
                                                    <img src="<?= $espace['image']; ?>" alt="Image actuelle" width="100">
                                                <?php else: ?>
                                                    <span class="text-muted">Aucune image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $statut = strtolower($espace['statut']);
                                                    $badgeClass = 'secondary';
                                                    if ($statut === 'disponible') $badgeClass = 'success';
                                                    elseif ($statut === 'occupé') $badgeClass = 'danger';
                                                    elseif ($statut === 'en maintenance') $badgeClass = 'warning';
                                                ?>
                                                <span class="badge badge-<?= $badgeClass; ?>">
                                                    <?= ucfirst($espace['statut']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="modifierEspace.php" method="get" style="margin-right: 5px;">
                                                        <input type="hidden" value="<?= $espace['id']; ?>" name="id">
                                                        <button type="submit" class="btn btn-sm btn-warning">Modifier</button>
                                                    </form>
                                                    <a href="supprimer.php?idP=<?= $espace['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet espace ?')">Supprimer</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <!-- table activite  -->
                 <div class="container-fluid">




            <div class="container mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Liste des Activités</h3>
                        <a href="ajouteract.php" class="btn btn-primary">+ Ajouter une Activité</a>
                    </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Type</th>
                                <th>Espace ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activiteC as $activite): ?>
                                <tr>
                                    <td><?= $activite['id']; ?></td>
                                    <td><?= htmlspecialchars($activite['titre']); ?></td>
                                    <td><?= htmlspecialchars($activite['description']); ?></td>
                                    <td><?= htmlspecialchars($activite['date_activite']); ?></td>
                                    <td><?= htmlspecialchars($activite['heure']); ?></td>
                                    <td>
                                        <?php
                                            $type = strtolower($activite['type_activite']);
                                            $badgeClass = 'secondary';
                                            if ($type === 'écologie') $badgeClass = 'success';
                                            elseif ($type === 'sport') $badgeClass = 'primary';
                                            elseif ($type === 'culture') $badgeClass = 'info';
                                            elseif ($type === 'autre') $badgeClass = 'dark';
                                        ?>
                                        <span class="badge bg-<?= $badgeClass; ?>">
                                            <?= ucfirst($activite['type_activite']); ?>
                                        </span>
                                    </td>
                                    <td><?= $activite['espace_id'] ?? '<span class="text-muted">Aucun</span>'; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="modAct.php" method="get" style="margin-right: 5px;">
                                                <input type="hidden" value="<?= $activite['id']; ?>" name="id">
                                                <button type="submit" class="btn btn-sm btn-warning">Modifier</button>
                                            </form>
                                            <a href="suppact.php?id=<?= $activite['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?')">Supprimer</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>



            </div>
            <div class="container-fluid">



                    <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
        <h3>Liste des reservations</h3>

            <tr>
                <th>ID</th>
                <th>Activité ID</th>
                <th>Utilisateur ID</th>
                <th>Email</th>
                <th>Numéro de téléphone</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservationC as $reservation): ?>
                <tr>
                    <td><?= $reservation['id']; ?></td>
                    <td><?= htmlspecialchars($reservation['activite_id']); ?></td>
                    <td><?= htmlspecialchars($reservation['utilisateur_id']); ?></td>
                    <td><?= htmlspecialchars($reservation['email']); ?></td>
                    <td><?= htmlspecialchars($reservation['numtlf']); ?></td>
                    <td><?= htmlspecialchars($reservation['date_inscription']); ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            <a href="suppreservation.php?id=<?= $reservation['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



            </div>



                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
