<?php
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize and get form data
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $date = trim($_POST['date']);
  $location = trim($_POST['location']);
  $organizer_id = trim($_POST['organizer_id']);
  $latitude = trim($_POST['latitude']);
  $longitude = trim($_POST['longitude']);
  $image = $_FILES['image'];

  // Validate each field
  if (empty($title) || strlen($title) < 3 || !preg_match("/^[a-zA-Z0-9\s\-.,!?]+$/", $title)) {
    $errors['title'] = "Le titre doit contenir au moins 3 caractères et être valide (lettres, chiffres et ponctuation autorisés).";
  }

  if (empty($description) || strlen($description) < 10) {
    $errors['description'] = "La description doit contenir au moins 10 caractères.";
  }

  if (empty($date) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
    $errors['date'] = "La date est invalide. Format attendu : AAAA-MM-JJ.";
  }

  if (empty($location) || strlen($location) < 3) {
    $errors['location'] = "Le lieu est requis et doit être valide.";
  }

  if (empty($organizer_id) || !is_numeric($organizer_id)) {
    $errors['organizer_id'] = "L'ID de l'organisateur doit être un nombre.";
  }

  if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
    $errors['latitude'] = "La latitude est invalide.";
  }

  if (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
    $errors['longitude'] = "La longitude est invalide.";
  }

  if (!isset($image) || $image['error'] != 0) {
    $errors['image'] = "Une image valide est requise.";
  }

  // If no errors, proceed
  if (empty($errors)) {
    $event = new Event();
    $event->setTitle($title);
    $event->setDescription($description);
    $event->setDate($date);
    $event->setLocation($location);
    $event->setorganizer_id($organizer_id);
    $event->setLatitude($latitude);
    $event->setLongitude($longitude);

    $eventController = new eventcontroller();
    $eventController->addevent($event, $image);

    $success = "Événement ajouté avec succès.";
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
<style>
    /* Change the color of the page heading */
.heading_container h2 {
    color: #007bff; /* Blue text for the heading */
}

/* Change the color of the labels */
.form-group label {
    color: #555; /* Dark grey color for labels */
}

/* Change the color of the input field text */
.form-control {
    color: #333; /* Dark grey text for inputs */
}

/* Change the color of error messages */
.text-danger {
    color: #dc3545; /* Red color for error messages */
}

/* Change the color of success messages */
.alert-success {
    color: #fff; /* White text for success message */
}

/* Change the color of the submit button text */
.btn-primary {
    color: #fff; /* White text for the submit button */
}

/* Change the color of the navbar links */
.navbar-nav .nav-item .nav-link {
    color: #fff !important; /* White text for navbar links */
}
  </style>
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
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($title ?? '') ?>">
                <?php if (isset($errors['title'])): ?>
                    <div class="text-danger"><?= $errors['title'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($description ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?>
                    <div class="text-danger"><?= $errors['description'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" name="date" id="date" class="form-control" value="<?= htmlspecialchars($date ?? '') ?>">
                <?php if (isset($errors['date'])): ?>
                    <div class="text-danger"><?= $errors['date'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="location">Lieu</label>
                <input type="text" name="location" id="location" class="form-control" value="<?= htmlspecialchars($location ?? '') ?>">
                <?php if (isset($errors['location'])): ?>
                    <div class="text-danger"><?= $errors['location'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="organizer_id">ID Organisateur</label>
                <input type="text" name="organizer_id" id="organizer_id" class="form-control" value="<?= htmlspecialchars($organizer_id ?? '') ?>">
                <?php if (isset($errors['organizer_id'])): ?>
                    <div class="text-danger"><?= $errors['organizer_id'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" value="<?= htmlspecialchars($latitude ?? '') ?>">
                <?php if (isset($errors['latitude'])): ?>
                    <div class="text-danger"><?= $errors['latitude'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" value="<?= htmlspecialchars($longitude ?? '') ?>">
                <?php if (isset($errors['longitude'])): ?>
                    <div class="text-danger"><?= $errors['longitude'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                <?php if (isset($errors['image'])): ?>
                    <div class="text-danger"><?= $errors['image'] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter l'événement</button>
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