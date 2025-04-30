<?php
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';
$eventcontroller = new eventcontroller();  
$liste = $eventcontroller->afficherevent();  

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Urbanisme - event</title>

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
  <!-- Event Cards -->
                      <div class="row">
                        <?php foreach ($liste as $event): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <?php if (!empty($event['image'])): ?>
                                        <img src="<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="Event Image">
                                    <?php else: ?>
                                        <img src="images/default-event.jpg" class="card-img-top" alt="Default Event Image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                                        <p class="card-text"><small class="text-muted"><?= htmlspecialchars($event['date']) ?></small></p>
                                        <!-- Latitude and Longitude -->
                                        <p class="card-text">
                                        <strong>Latitude:</strong> <?= htmlspecialchars($event['latitude']) ?><br>
                                        <strong>Longitude:</strong> <?= htmlspecialchars($event['longitude']) ?>
                                        </p>
                                        <a href="eventdetails.php?id=<?= $event['id'] ?>" class="btn btn-primary">See Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
