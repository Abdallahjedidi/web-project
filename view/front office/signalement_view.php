<?php
include_once '../../Controller/signalementctrl.php';

$signalementCtrl = new SignalementC();

// Suppression si requête GET avec suppression
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $signalementCtrl->deleteSignalement($_GET['delete']);
    header("Location: signalement_view.php");
    exit;
}

$signalements = $signalementCtrl->afficherSignalements();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signalements - Vue</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
</head>
<body style="background-color: #f4f4f4;">
  <div class="hero_area">
    <!-- Header identique à signalement_ajout.php -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>URBANISME</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class=""></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">ACCUEIL</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signalement_ajout.php">AJOUTER</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="signalement_view.php">VOIR LES SIGNALEMENTS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">CONTACT</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <!-- Section contenant le tableau centré -->
    <section class="contact_section layout_padding" style="background-color: #ffffff; padding: 60px 0;">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Liste des signalements</h2>
        </div>
        <div class="table-responsive d-flex justify-content-center">
          <table class="table table-bordered table-striped w-75">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Emplacement</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($signalements)) : ?>
                <?php foreach ($signalements as $sig) : ?>
                  <tr>
                    <td><?= htmlspecialchars($sig['id_signalement']) ?></td>
                    <td><?= htmlspecialchars($sig['titre']) ?></td>
                    <td><?= htmlspecialchars($sig['description']) ?></td>
                    <td><?= htmlspecialchars($sig['emplacement']) ?></td>
                    <td><?= htmlspecialchars($sig['date_signalement']) ?></td>
                    <td><?= htmlspecialchars($sig['statut']) ?></td>
                    <td>
                      <a href="signalement_edit.php?id=<?= $sig['id_signalement'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                      <a href="?delete=<?= $sig['id_signalement'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="7" class="text-center">Aucun signalement trouvé.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="text-center mt-4">
          <a href="signalement_ajout.php" class="btn btn-primary">Ajouter un signalement</a>
        </div>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>
