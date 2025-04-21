<?php
include_once '../../config.php';
include_once '../../Controller/avisContoller.php';
include_once '../../Model/Avis.php';

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = trim($_POST['id']);
    $id_event = trim($_POST['id_event']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $reported_at = trim($_POST['reported_at']);

    if (empty($id)) {
        $errors[] = "ID is required.";
    } elseif (!ctype_digit($id)) {
        $errors[] = "ID must be a number.";
    }

    if (empty($id_event)) {
        $errors[] = "Event ID is required.";
    } elseif (!ctype_digit($id_event)) {
        $errors[] = "Event ID must be a number.";
    }

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($reported_at)) {
        $errors[] = "Date is required.";
    }

    if (empty($errors)) {
        $avis = new Avis();
        $avis->setId($id);
        $avis->setIdEvent($id_event);
        $avis->setName($name);
        $avis->setDescription($description);
        $avis->setReportedAt($reported_at);

        $avisc = new AvisController();
        $avisc->addAvis($avis);

        $success = "Thank you! Your feedback has been submitted.";
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

    <!-- Page Title -->
    <section class="slider_section">
      <div class="container text-center">
        <h1>Donner votre avis</h1>
        <p>Partagez votre avis sur un événement ou une initiative locale.</p>
      </div>
    </section>
  </div>

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
            <label for="id">ID :</label>
            <input type="text" name="id" id="id" class="form-control" value="<?= htmlspecialchars($_POST['id'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label for="id_event">ID Événement :</label>
            <input type="text" name="id_event" id="id_event" class="form-control" value="<?= htmlspecialchars($_POST['id_event'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label for="name">Votre nom :</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label for="description">Avis :</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
          </div>

          <div class="form-group">
            <label for="reported_at">Date :</label>
            <input type="datetime-local" name="reported_at" id="reported_at" class="form-control" value="<?= htmlspecialchars($_POST['reported_at'] ?? '') ?>">
          </div>

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
