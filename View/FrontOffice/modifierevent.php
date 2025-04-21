<?php
include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $event = new Event();

    if (isset($_POST['id'])) {
        $event->setId($_POST['id']);
    }
    if (isset($_POST['title'])) {
        $event->setTitle($_POST['title']);
    }
    if (isset($_POST['description'])) {
        $event->setDescription($_POST['description']);
    }
    if (isset($_POST['date'])) {
        $event->setDate($_POST['date']);
    }
    if (isset($_POST['location'])) {
        $event->setLocation($_POST['location']);
    }
    
    $eventController = new eventcontroller();
    $eventController->updateevents($event);
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
  

  <h1 class="text-center">Modifier un event</h1> 
                </div>
                <?php
include_once '../../Controller/eventscontroller.php';

$title = $description = $date = $location =  "";
$id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $id = $_POST['search'];
    $eventController = new eventcontroller();
    $event = $eventController->rechercher($id);

    if ($event) {
        $event = $event[0];
        $title = $event['title'];
        $description = $event['description'];
        $date = $event['date'];
        $location = $event['location'];
        $organizer_id = $event['organizer_id'];
    }
}
?>
 <form class="user mx-auto" action="" method="POST" style="max-width: 400px;">
    <div class="form-group">
        <label for="search">ID EVENT:</label>
        <input type="number" class="form-control form-control-user" id="search" name="search"
               value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" >
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">Rechercher</button>
</form>

<form class="user mx-auto" method="POST" onsubmit="return validateForm();" style="max-width: 400px; margin-top: 20px;">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control form-control-user" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control form-control-user" id="description" name="description" value="<?= htmlspecialchars($description) ?>">
    </div>

    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control form-control-user" id="date" name="date" value="<?= htmlspecialchars($date) ?>">
    </div>

    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" class="form-control form-control-user" id="location" name="location" value="<?= htmlspecialchars($location) ?>">
    </div>

    <button type="submit" name="update" class="btn btn-primary btn-user btn-block">Mettre à jour</button>
</form>

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
        alert("Veuillez saisir location.");
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
