<?php
include_once '../../config.php';
include_once '../../Controller/avisContoller.php';
include_once '../../Model/Avis.php';

$errors = [];
$success = "";

// Get id_event from URL if present
$id_event = $_GET['id_event'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id_event = trim($_POST['id_event']); // pulled from hidden input
  $name = trim($_POST['name']);
  $description = trim($_POST['description']);
  $reported_at = date('Y-m-d H:i:s'); // Automatically set current timestamp

  $errors = [];

  if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
      $errors[] = "Invalid name (letters and spaces only).";
  }

  if (empty($description)|| strlen($description) < 3) {
      $errors[] = "Description cannot be empty.";
  }

  if (empty($errors)) {
      $avis = new Avis();

      $avis->setIdEvent($id_event);
      $avis->setName($name);
      $avis->setDescription($description);
      $avis->setReportedAt($reported_at);

      $avisc = new AvisController();
      $avisc->addAvis($avis);

      $success = "Thank you! Your feedback has been submitted.";
      //Redirect to event list page after successful update
      header("Location: afficheevent.php");
      exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Donner un avis - Urbanisme</title>

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
          <a class="navbar-brand" href="index.php">
            <span>Urbanisme</span>
          </a>
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

   
  <!-- Form Section -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php elseif (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" class="bg-light p-4 rounded shadow">        
               
        <div class="form-group">
            <label for="id_event">ID Event</label>
            <input type="hidden" name="id_event" value="<?= htmlspecialchars($id_event) ?>">
        </div>

         <div class="form-group">
            <label for="name">Votre nom :</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label for="description">Avis :</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
          </div>

          <!-- reported_at field removed from form -->

          <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
      </div>
    </div>
  </div>

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
