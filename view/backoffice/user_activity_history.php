<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/usercontroller.php';

$conn = Config::getConnection();
$error_message = '';

// Récupérer tous les utilisateurs avec leur login_count
$sqlUsers = "SELECT id, nom, prenom, email, login_count FROM users";
$stmtUsers = $conn->prepare($sqlUsers);
$stmtUsers->execute();
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les dernières activités de chaque utilisateur
$sqlActivities = "
    SELECT u.id AS user_id, u.nom, u.email, a.activity_type, a.activity_description, a.ip_address, a.created_at
    FROM user_activity a
    JOIN users u ON a.user_id = u.id
    ORDER BY a.created_at DESC";

$stmtActivities = $conn->prepare($sqlActivities);
$stmtActivities->execute();
$activities = $stmtActivities->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        /* Style pour la recherche */
        #searchInput {
            transition: all 0.3s ease;
            width: 200px;
        }

        #searchInput:focus {
            width: 250px;
        }

        .no-results {
            display: none;
            text-align: center;
            padding: 10px;
            color: #dc3545;
            font-style: italic;
        }

        @media (max-width: 768px) {
            #searchInput {
                width: 150px;
            }
            #searchInput:focus {
                width: 180px;
            }
        }
        
        /* Style pour le tableau */
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            position: sticky;
            top: 0;
            background-color: #f8f9fc;
            z-index: 10;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin</div>
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
                    <span>Users</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">edits:</h6>
                        <a class="collapse-item" href="Users.php">List Users</a>
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
                            <input type="text" id="searchInput" class="form-control bg-light border-0 small" placeholder="Rechercher par nom..." aria-label="Search" aria-describedby="basic-addon2" onkeyup="searchTable()">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../backoffice/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../frontoffice/profile.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
                </div>
                <!-- /.container-fluid -->

                <div class="container mt-5">
                    <h1 class="text-center mb-4">Historique des Activités des Utilisateurs</h1>
                    
                    <?php if (!empty($activities)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="activitiesTable">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Activité</th>
                                        <th>Description</th>
                                        <th>IP de connexion</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activities as $activity): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($activity['nom']) ?></td>
                                            <td><?= htmlspecialchars($activity['email']) ?></td>
                                            <td><?= htmlspecialchars($activity['activity_type']) ?></td>
                                            <td><?= htmlspecialchars($activity['activity_description']) ?></td>
                                            <td>
                                                <?= ($activity['ip_address'] == '::1') ? 'admin' : 'user' ?>
                                            </td>
                                            <td><?= htmlspecialchars($activity['created_at']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="noResults" class="no-results">Aucune activité trouvée</div>
                    <?php else: ?>
                        <p class="text-center">Aucune activité trouvée pour les utilisateurs.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/projet/view/frontoffice/login.php">Logout</a>
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

    <script>
    // Fonction de recherche
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("activitiesTable");
        const tr = table.getElementsByTagName("tr");
        const noResults = document.getElementById("noResults");
        let found = false;

        // Parcours toutes les lignes du tableau (sauf l'en-tête)
        for (let i = 1; i < tr.length; i++) {
            const tdNom = tr[i].getElementsByTagName("td")[0]; // Colonne Nom
            const tdEmail = tr[i].getElementsByTagName("td")[1]; // Colonne Email
            const tdActivite = tr[i].getElementsByTagName("td")[2]; // Colonne Activité
            
            let showRow = false;
            
            if (tdNom && (tdNom.textContent || tdNom.innerText).toUpperCase().includes(filter)) {
                showRow = true;
            }
            
            if (!showRow && tdEmail && (tdEmail.textContent || tdEmail.innerText).toUpperCase().includes(filter)) {
                showRow = true;
            }
            
            if (!showRow && tdActivite && (tdActivite.textContent || tdActivite.innerText).toUpperCase().includes(filter)) {
                showRow = true;
            }

            if (showRow) {
                tr[i].style.display = "";
                found = true;
            } else {
                tr[i].style.display = "none";
            }
        }

        // Affiche le message si aucun résultat n'est trouvé
        noResults.style.display = found ? "none" : "block";
    }

    // Recherche avec délai de 300ms
    let searchTimer;
    document.getElementById("searchInput").addEventListener('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(searchTable, 300);
    });

    // Vérification de l'authentification
    document.addEventListener("DOMContentLoaded", function () {
        const user = JSON.parse(localStorage.getItem('user'));

        if (!user) {
            window.location.href = '../frontoffice/login.php';
            return;
        }

        if (user.role !== 'admin') {
            window.location.href = 'unauthorized.php';
            return;
        }
    });
    </script>
</body>
</html>