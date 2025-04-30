<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../config.php';
include_once '../../Controller/avisContoller.php';
include_once '../../Model/Avis.php';

$avisController = new AvisController();
$avis = null;
$message = "";
$errors = [];

// Récupération des données de l'avis à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $avis = $avisController->getAvisById($id);

    if (!$avis) {
        die("Avis introuvable !");
    }
}

// Traitement de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Assure that ID is taken from POST
    $event_id = $_POST['event_id'] ?? null;
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $reported_at = date('Y-m-d H:i:s');

    // Validation
    if (empty($name) || !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/u", $name)) {
        $errors[] = "Nom invalide (lettres et espaces uniquement).";
    }

    if (empty($description)|| strlen($description) < 3) {
        $errors[] = "Description ne peut pas être vide.";
    }

    if (empty($event_id) || !is_numeric($event_id)) {
        $errors[] = "Événement invalide.";
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        $avisObj = new Avis();
        $avisObj->setId($id);
        $avisObj->setIdEvent($event_id);
        $avisObj->setName($name);
        $avisObj->setDescription($description);
        $avisObj->setReportedAt($reported_at);

        $avisController->updateAvis($avisObj);
        echo "<script>alert('Avis modifié avec succès !'); window.location.href='afficheavis.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Modifier Avis - Urbanisme</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
</head>
<body>
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
            <li class="nav-item active"><a class="nav-link" href="afficheavis.php">Avis</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <!-- Form Section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2 class="text-center">Modifier un Avis</h2>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $error): ?>
            <div><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ($avis): ?>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <form method="POST">
              <input type="hidden" name="id" value="<?= htmlspecialchars($avis['id']) ?>">
              <input type="hidden" name="event_id" value="<?= htmlspecialchars($avis['id_event']) ?>">

              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($avis['name']) ?>" required>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4" required><?= htmlspecialchars($avis['description']) ?></textarea>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary">Modifier l'avis</button>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
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
