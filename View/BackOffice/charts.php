<?php
// Include your configuration file and other necessary files
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';
include_once '../../Controller/avisContoller.php'; 
// Fetch data for the number of events and feedback for each event
try {
    // Get PDO connection
    $pdo = Config::getConnection();

    // Query to get the count of events created
    $eventsQuery = "SELECT COUNT(*) as total_events FROM events";
    $eventsStmt = $pdo->query($eventsQuery);
    $eventsData = $eventsStmt->fetch(PDO::FETCH_ASSOC);
    $totalEvents = $eventsData['total_events'];

    // Query to get the number of feedback/avis for each event
    $feedbackQuery = "SELECT id_event, COUNT(*) as feedback_count FROM avis GROUP BY id_event";
    $feedbackStmt = $pdo->query($feedbackQuery);
    $feedbackData = $feedbackStmt->fetchAll(PDO::FETCH_ASSOC);
    
    $eventIds = [];
    $feedbackCounts = [];
    
    foreach ($feedbackData as $data) {
        $eventIds[] = $data['id_event'];
        $feedbackCounts[] = $data['feedback_count'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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

    <title>URBANISME - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">URBANISME</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Nav Item - Avis -->
            <li class="nav-item">
                <a class="nav-link" href="addAvis.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Avis</span>
                </a>
            </li>

            <!-- Nav Item - Events -->
            <li class="nav-item">
                <a class="nav-link" href="addevent.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="charts.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>charts</span>
                </a>
            </li>
        
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Event and Feedback Statistics</h1>
                    <p class="mb-4">This chart displays the number of events and feedback for each event.</p>

                    <!-- Chart Row -->
                    <div class="row">

                        <!-- Number of Events Created -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Number of Events Created</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="eventChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Number of Feedback per Event -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Feedback for Each Event</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="feedbackChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End of Chart Row -->
                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script>
        // Chart.js for Number of Events Created
        var ctx1 = document.getElementById('eventChart').getContext('2d');
        var eventChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Total Events'],
                datasets: [{
                    label: 'Number of Events',
                    data: [<?php echo $totalEvents; ?>],
                    backgroundColor: ['#4e73df'],
                }]
            }
        });

        // Chart.js for Feedback Count for Each Event
        var ctx2 = document.getElementById('feedbackChart').getContext('2d');
        var feedbackChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($eventIds); ?>, // Event IDs
                datasets: [{
                    label: 'Feedback Count',
                    data: <?php echo json_encode($feedbackCounts); ?>, // Feedback count per event
                    backgroundColor: '#36b9cc',
                    borderColor: '#2c3e50',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin 2 JS -->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
