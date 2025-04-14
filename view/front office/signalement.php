<?php
include_once '../../Controller/signalementctrl.php';
include_once '../../config.php';

$signalementCtrl = new SignalementC();

function generateSignalementId() {
    return rand(100000, 999999);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $emplacement = trim($_POST['emplacement']);
    $date_signalement = $_POST['date_signalement'];
    $statut = $_POST['statut'];

    // Validation PHP
    if (empty($titre) || !preg_match('/[a-zA-Z]/', $titre)) {
        $errors[] = "Le titre est requis et doit contenir au moins une lettre.";
    }

    if (empty($description) || !preg_match('/[a-zA-Z]/', $description)) {
        $errors[] = "La description est requise et doit contenir au moins une lettre.";
    }

    if (empty($emplacement)) {
        $errors[] = "L'emplacement est requis.";
    }

    if (empty($date_signalement)) {
        $errors[] = "La date du signalement est requise.";
    }

    if (empty($statut)) {
        $errors[] = "Le statut est requis.";
    }

    if (empty($errors)) {
        $signalement = new Signalement();
        $generatedId = generateSignalementId();
        $signalement->setIdSignalement($generatedId);
        $signalement->setTitre($titre);
        $signalement->setDescription($description);
        $signalement->setEmplacement($emplacement);
        $signalement->setDateSignalement($date_signalement);
        $signalement->setStatut($statut);

        $result = $signalementCtrl->addSignalement($signalement);

        if ($result) {
            echo '<script>
                    alert("Votre signalement a été envoyé avec succès !\\n\\nID: ' . $generatedId . '");
                    window.location.href = "signalement.php#liste-signalements";
                  </script>';
            exit;
        } else {
            $errors[] = "Une erreur s'est produite lors de l'enregistrement.";
        }
    }
}

$signalements = $signalementCtrl->afficherSignalements();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>URBANISME - Signalements</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
  <style>
    /* ... (CSS inchangé, comme dans ton code d’origine) ... */
    .signalement-container {
      background-color: #1E90FF;
      color: white;
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .signalement-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      background-color: #4169E1;
    }

    .signalement-id {
      font-weight: bold;
      color: #FFD700;
      background-color: rgba(0,0,0,0.2);
      padding: 5px 10px;
      border-radius: 5px;
      display: inline-block;
      margin-bottom: 10px;
    }

    .form-signalement {
      background-color: #E6F2FF;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-bottom: 50px;
    }

    .statut-en-attente {
      color: #FFA500;
      font-weight: bold;
    }

    .statut-traite {
      color: #32CD32;
      font-weight: bold;
    }

    .btn-submit {
      background-color: #FF8C00;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: bold;
      transition: all 0.3s;
    }

    .btn-submit:hover {
      background-color: #FF6347;
      transform: scale(1.05);
    }

    .section-title {
      color: #1E90FF;
      position: relative;
      padding-bottom: 15px;
      margin-bottom: 30px;
      text-align: center;
    }

    .section-title:after {
      content: '';
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      bottom: 0;
      width: 50px;
      height: 3px;
      background-color: #1E90FF;
    }

    .layout_padding {
      padding-top: 90px;
      padding-bottom: 90px;
    }

    .layout_padding-bottom {
      padding-bottom: 90px;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">URBANISME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link active" href="signalement.php">Signalements</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<section class="contact_section layout_padding-bottom pt-5" id="ajout-signalement">
  <div class="container">
    <div class="heading_container heading_center">
      <h2 class="section-title heading_center">Nouveau Signalement</h2>
      <p>Signalez un problème dans votre quartier pour que nous puissions le résoudre</p>
    </div>
    <div class="row">
      <div class="col-md-8 col-lg-6 mx-auto">
        <div class="form_container form-signalement">

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="signalement.php" method="POST">
            <div class="form-group mb-3">
              <label for="titre">Titre du signalement*</label>
              <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" />
            </div>
            <div class="form-group mb-3">
              <label for="description">Description*</label>
              <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>
            <div class="form-group mb-3">
              <label for="emplacement">Emplacement exact*</label>
              <input type="text" class="form-control" id="emplacement" name="emplacement" value="<?= htmlspecialchars($_POST['emplacement'] ?? '') ?>" />
            </div>
            <div class="form-group mb-3">
              <label for="date_signalement">Date du signalement*</label>
              <input type="date" class="form-control" id="date_signalement" name="date_signalement" value="<?= htmlspecialchars($_POST['date_signalement'] ?? '') ?>" />
            </div>
            <div class="mb-3">
              <label for="statut" class="form-label">Statut du signalement*</label>
              <select class="form-select" id="statut" name="statut">
                <option value="En attente" <?= (($_POST['statut'] ?? '') == 'En attente') ? 'selected' : '' ?>>En attente</option>
                <option value="Résolu" <?= (($_POST['statut'] ?? '') == 'Résolu') ? 'selected' : '' ?>>Résolu</option>
                <option value="En cours" <?= (($_POST['statut'] ?? '') == 'En cours') ? 'selected' : '' ?>>En cours</option>
              </select>
            </div>
            <div class="btn_box text-center">
              <button type="submit" class="btn btn-submit">Envoyer le signalement</button>
            </div>
            <p class="mt-3 text-muted text-center">* Champs obligatoires</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="price_section layout_padding bg-light" id="liste-signalements">
  <div class="container">
    <div class="heading_container heading_center">
      <h2 class="section-title heading_center">Signalements Récents</h2>
      <p>Voici les derniers signalements effectués par les citoyens</p>
    </div>
    <div class="row">
      <?php if (!empty($signalements)): ?>
        <?php foreach ($signalements as $signalement): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="signalement-container">
              <div class="signalement-id"><?= htmlspecialchars($signalement['id_signalement']) ?></div>
              <h4><?= htmlspecialchars($signalement['titre']) ?></h4>
              <p><strong>Lieu:</strong> <?= htmlspecialchars($signalement['emplacement']) ?></p>
              <p><strong>Date:</strong> <?= date('d/m/Y', strtotime($signalement['date_signalement'])) ?></p>
              <p><strong>Statut:</strong>
                <span class="<?= $signalement['statut'] == 'En attente' ? 'statut-en-attente' : 'statut-traite' ?>">
                  <?= htmlspecialchars($signalement['statut']) ?>
                </span>
              </p>
              <p><?= nl2br(htmlspecialchars($signalement['description'])) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Aucun signalement n'a été trouvé.
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<footer class="bg-dark text-white py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5>URBANISME</h5>
        <p>Plateforme citoyenne de signalement des problèmes urbains.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Liens utiles</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white text-decoration-none">Accueil</a></li>
          <li><a href="signalement.php" class="text-white text-decoration-none">Signalements</a></li>
          <li><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Contact</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt me-2"></i> Hôtel de Ville</li>
          <li><i class="fas fa-phone me-2"></i> 04 00 00 00 00</li>
          <li><i class="fas fa-envelope me-2"></i> contact@ville-urbanisme.fr</li>
        </ul>
      </div>
    </div>
    <hr class="my-4">
    <div class="text-center">
      <p class="mb-0">&copy; <?= date('Y') ?> URBANISME. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('date_signalement');
    if (dateInput && !dateInput.value) {
      dateInput.value = today;
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetElement = document.querySelector(this.getAttribute('href'));
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });
  });
</script>

</body>
</html>
