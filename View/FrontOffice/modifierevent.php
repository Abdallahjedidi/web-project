<?php
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';

$errors = [];
$title = $description = $date = $location = $latitude = $longitude = $organizer_id = "";
$id = "";

// Handle GET: Fetch data for form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $eventController = new eventcontroller();
    $event = $eventController->rechercher($id);

    if ($event) {
        $event = $event[0];
        $title = $event['title'];
        $description = $event['description'];
        $date = $event['date'];
        $location = $event['location'];
        $latitude = $event['latitude'];
        $longitude = $event['longitude'];
        $organizer_id = $event['organizer_id'];
    }
}

// Handle POST: Validate and update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $location = trim($_POST['location']);
    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);
    $organizer_id = trim($_POST['organizer_id']);

    // Validation
    if (empty($title) || strlen($title) < 3) {
        $errors['title'] = "Le titre doit contenir au moins 3 caractères.";
    }

    if (empty($description) || strlen($description) < 10) {
        $errors['description'] = "La description doit contenir au moins 10 caractères.";
    }

    if (empty($date) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errors['date'] = "La date est invalide. Format attendu : AAAA-MM-JJ.";
    }

    if (empty($location)) {
        $errors['location'] = "Le lieu est requis.";
    }

    if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        $errors['latitude'] = "Latitude invalide. Elle doit être comprise entre -90 et 90.";
    }

    if (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        $errors['longitude'] = "Longitude invalide. Elle doit être comprise entre -180 et 180.";
    }

    if (empty($organizer_id) || !is_numeric($organizer_id)) {
        $errors['organizer_id'] = "L'ID de l'organisateur doit être un nombre.";
    }

    // If no errors, update event
    if (empty($errors)) {
        $event = new Event();
        $event->setId($id);
        $event->setTitle($title);
        $event->setDescription($description);
        $event->setDate($date);
        $event->setLocation($location);
        $event->setLatitude($latitude);
        $event->setLongitude($longitude);
        $event->setorganizer_Id($organizer_id);

        $eventController = new eventcontroller();
        $eventController->updateevents($event);

        header("Location: afficheevent.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier Événement</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
  
  <!-- Google Maps API -->
  
  
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

  <h1 class="text-center">Modifier un événement</h1>

  <form class="user mx-auto" method="POST" style="max-width: 400px; margin-top: 20px;">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
    <input type="hidden" name="organizer_id" value="<?= htmlspecialchars($organizer_id ?? '') ?>">

    <!-- Title -->
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control form-control-user" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
        <?php if (!empty($errors['title'])): ?>
            <small class="text-danger"><?= $errors['title'] ?></small>
        <?php endif; ?>
    </div>

    <!-- Description -->
    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control form-control-user" id="description" name="description" value="<?= htmlspecialchars($description) ?>">
        <?php if (!empty($errors['description'])): ?>
            <small class="text-danger"><?= $errors['description'] ?></small>
        <?php endif; ?>
    </div>

    <!-- Date -->
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control form-control-user" id="date" name="date" value="<?= htmlspecialchars($date) ?>">
        <?php if (!empty($errors['date'])): ?>
            <small class="text-danger"><?= $errors['date'] ?></small>
        <?php endif; ?>
    </div>

    <!-- Location -->
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" class="form-control form-control-user" id="location" name="location" value="<?= htmlspecialchars($location) ?>">
        <?php if (!empty($errors['location'])): ?>
            <small class="text-danger"><?= $errors['location'] ?></small>
        <?php endif; ?>
    </div>

    <!-- Latitude -->
    <div class="form-group">
        <label for="latitude">Latitude:</label>
        <input type="text" class="form-control form-control-user" id="latitude" name="latitude" value="<?= htmlspecialchars($latitude) ?>" >
        <?php if (!empty($errors['latitude'])): ?>
            <small class="text-danger"><?= $errors['latitude'] ?></small>
        <?php endif; ?>
    </div>

    <!-- Longitude -->
    <div class="form-group">
        <label for="longitude">Longitude:</label>
        <input type="text" class="form-control form-control-user" id="longitude" name="longitude" value="<?= htmlspecialchars($longitude) ?>" >
        <?php if (!empty($errors['longitude'])): ?>
            <small class="text-danger"><?= $errors['longitude'] ?></small>
        <?php endif; ?>
    </div>

    <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Mettre à jour</button>
</form>


  <!-- Google Maps Script -->
  <script>
    let map;
    let marker;

    function initMap() {
      const defaultLocation = { lat: <?= $latitude ?? '0' ?>, lng: <?= $longitude ?? '0' ?> };
      
      map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 15,
      });

      marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
      });

      /*const input = document.getElementById("location");
      const autocomplete = new google.maps.places.Autocomplete(input);
      
      autocomplete.setFields(["address_components", "geometry"]);

      autocomplete.addListener("place_changed", function () {
        const place = autocomplete.getPlace();

        if (place.geometry) {
          map.setCenter(place.geometry.location);
          marker.setPosition(place.geometry.location);

          // Set latitude and longitude values
          document.getElementById("latitude").value = place.geometry.location.lat();
          document.getElementById("longitude").value = place.geometry.location.lng();
        }
      });*/
    }

    google.maps.event.addDomListener(window, "load", initMap);
  </script>

  <!-- Map div -->
  <div id="map" style="width: 100%; height: 300px;"></div>

<script>
function validateForm() {
    let title = document.getElementById("title").value.trim();
    let description = document.getElementById("description").value.trim();
    let date = document.getElementById("date").value.trim();
    let location = document.getElementById("location").value.trim();

    if (!title) {
        alert("Veuillez saisir le titre.");
        return false;
    }

    if (!description) {
        alert("Veuillez saisir la description.");
        return false;
    }

    if (!date) {
        alert("Veuillez saisir une date valide.");
        return false;
    }

    if (!location) {
        alert("Veuillez saisir le lieu.");
        return false;
    }

    // Optional: More specific checks (e.g., format, min length)
    return true;
}
</script>

<!-- Footer -->
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
