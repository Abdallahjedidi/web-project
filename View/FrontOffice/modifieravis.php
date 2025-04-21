<?php
include_once '../../config.php';
include_once '../../Controller/avisContoller.php';
include_once '../../Model/Avis.php';

$avisController = new AvisController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $avis = $avisController->getAvisById($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $reported_at = $_POST['reported_at'];

    $errors = [];

    if (empty($event_id) || !is_numeric($event_id)) {
        $errors[] = "ID événement invalide.";
    }

    if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Nom invalide (lettres et espaces uniquement).";
    }

    if (empty($description)) {
        $errors[] = "Description ne peut pas être vide.";
    }

    if (empty($reported_at) || strtotime($reported_at) === false) {
        $errors[] = "Date invalide.";
    }

    if (empty($errors)) {
        $avisObj = new Avis();
        $avisObj->setId($id);
        $avisObj->setIdEvent($event_id);
        $avisObj->setName($name);
        $avisObj->setDescription($description);
        $avisObj->setReportedAt($reported_at);
        $avisController->updateAvis($avisObj);
        echo "<script>alert('Avis modifié avec succès !'); window.location.href='afficheavis.php';</script>";
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier Avis - Urbanisme</title>

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

  <!-- Form Section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2 class="text-center">Modifier un Avis</h2>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($avis['id']) ?>">

            <div class="form-group">
              <label for="event_id">ID Événement</label>
              <input type="text" class="form-control" name="event_id" id="event_id" value="<?= htmlspecialchars($avis['event_id']) ?>" >
            </div>

            <div class="form-group">
              <label for="name">Nom</label>
              <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($avis['name']) ?>" >
            </div>

            <div class="form-group">
  <label for="description">Description</label>
  <textarea class="form-control" name="description" id="description" rows="4"><?= htmlspecialchars($avis['description']) ?></textarea>
</div>

            <div class="form-group">
              <label for="reported_at">Date de signalement</label>
              <input type="datetime-local" class="form-control" name="reported_at" id="reported_at" value="<?= htmlspecialchars($avis['reported_at']) ?>" >
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Modifier l'avis</button>
            </div>
          </form>
        </div>
      </div>
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
