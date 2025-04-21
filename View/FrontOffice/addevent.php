<?php
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $location = trim($_POST['location']);

    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($date)) {
        $errors[] = "Date is required.";
    }

    if (empty($location)) {
        $errors[] = "Location is required.";
    }

    if (empty($errors)) {
        $event = new event();
        $event->settitle($title);
        $event->setdescription($description);
        $event->setdate($date);
        $event->setlocation($location);

        $eventController = new eventcontroller();
        $eventController->addevent($event);

        $success = "Thank you! Your feedback has been submitted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ajouter un événement - Urbanisme</title>

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
          <a class="navbar-brand" href="index.php"><span>Urbanisme</span></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
            <span class=""></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
              <li class="nav-item"><a class="nav-link" href="afficheevent.php">Événements</a></li>
              <li class="nav-item active"><a class="nav-link" href="afficheavis.php">avis</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <!-- Main Content Section -->
    <section class="contact_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Ajouter un événement</h2>
        </div>

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php elseif (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="form-group">
            <label for="title">Titre de l'événement</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
          </div>
          <div class="form-group">
            <label for="date">Date & Heure</label>
            <input type="datetime-local" class="form-control" name="date" id="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="location">Lieu</label>
            <input type="text" class="form-control" name="location" id="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
          </div>
          <div class="btn-box text-center">
            <input type="submit" class="btn btn-primary" value="Ajouter l'événement">
          </div>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer_section">
      <div class="container text-center">
        <p>&copy; 2025 Urbanisme. Tous droits réservés.</p>
      </div>
    </footer>
  </div>

  <!-- JS -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>
</html>