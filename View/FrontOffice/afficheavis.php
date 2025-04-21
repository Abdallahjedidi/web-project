<?php
include_once '../../Controller/avisContoller.php';  
include_once '../../config.php';
$avisController = new AvisController();  
$liste = $avisController->afficherAvis();  

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Urbanisme - Avis</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
</head>

<body>

  <div class="hero_area">
    <!-- Header -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>Urbanisme</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
            <span class=""></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active"><a class="nav-link" href="index.php">Accueil</a></li>
              <li class="nav-item"><a class="nav-link" href="afficheevent.php">Événements</a></li>
              <li class="nav-item active"><a class="nav-link" href="afficheavis.php">avis</a></li>
             
              <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
  </div>

  <!-- Main Content Section -->
  <div class="container">
    <h1 class="text-center my-5">Avis des Citoyens</h1>  

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Avis</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Événement</th>
                <th>Avis</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($liste as $avis): ?>
                <tr>
                  <td><?= htmlspecialchars($avis['id']) ?></td>
                  <td><?= htmlspecialchars($avis['event_id']) ?></td>
                  <td><?= htmlspecialchars($avis['name']) ?></td>
                  <td><?= htmlspecialchars($avis['description']) ?></td>
                  <td><?= htmlspecialchars($avis['reported_at']) ?></td>
                  <td>
                    <a href="modifieravis.php?id=<?= htmlspecialchars($avis['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional Footer -->
  <footer class="footer_section">
    <div class="container text-center">
      <p>&copy; 2025 Urbanisme. Tous droits réservés.</p>
    </div>
  </footer>

  <!-- JS -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>

</html>
