<?php
include_once '../../Controller/signalementctrl.php';
include_once '../../Controller/suivic.php';
include_once '../../config.php';

$signalementCtrl = new SignalementC();
$suiviCtrl = new SuiviC();

$id_signalement = $_GET['id_signalement'] ?? null;

if (!$id_signalement || !is_numeric($id_signalement)) {
    echo "ID de signalement invalide.";
    exit;
}

$signalement = $signalementCtrl->getSignalementById($id_signalement);
$suivis = $suiviCtrl->getSuivisBySignalement($id_signalement);

if (!$signalement) {
    echo "Aucun signalement trouvé.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suivi du Signalement</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <style>
    .signalement-box, .suivi-box {
      background-color: #fff;
      padding: 25px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .timeline {
      list-style: none;
      padding-left: 0;
      position: relative;
    }
    .timeline::before {
      content: '';
      position: absolute;
      left: 20px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #ff4b5c;
    }
    .timeline-item {
      position: relative;
      margin-left: 40px;
      margin-bottom: 30px;
    }
    .timeline-item::before {
      content: '';
      position: absolute;
      left: -28px;
      top: 5px;
      width: 14px;
      height: 14px;
      background: #ff4b5c;
      border-radius: 50%;
      border: 2px solid white;
      box-shadow: 0 0 0 3px #ff4b5c33;
    }
    .timeline-date {
      font-weight: bold;
      color: #555;
      margin-bottom: 5px;
      display: block;
    }
    .timeline-content {
      background: #ffffff;
      padding: 15px;
      border-radius: 6px;
      box-shadow: 0 0 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="hero_area">
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.php"><span>URBANISME</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class=""></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="signalement_ajout.php">Ajouter</a></li>
            <li class="nav-item"><a class="nav-link" href="signalement_view.php">Voir les signalements</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Suivi</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <section class="contact_section layout_padding-bottom py-5" style="background-color: #f1f2f6;">
    <div class="container">
      <div class="heading_container heading_center mb-4">
        <h2 class="text-dark">Suivi du Signalement</h2>
      </div>

      <div class="signalement-box">
        <h4><?= htmlspecialchars($signalement['titre']) ?></h4>
        <p><strong>Description :</strong> <?= htmlspecialchars($signalement['description']) ?></p>
        <p><strong>Emplacement :</strong> <?= htmlspecialchars($signalement['emplacement']) ?></p>
        <p><strong>Date :</strong> <?= htmlspecialchars($signalement['date_signalement']) ?></p>
        <p><strong>Statut global :</strong> <?= htmlspecialchars($signalement['statut']) ?></p>
      </div>
      

      <div class="suivi-box">
        <h5 class="mb-3 text-secondary">Étapes de suivi :</h5>
        <?php if (!empty($suivis)): ?>
          <ul class="timeline">
            <?php foreach ($suivis as $suivi): ?>
              <li class="timeline-item">
                <span class="timeline-date"><?= htmlspecialchars($suivi['date_suivi']) ?></span>
                <div class="timeline-content">
                  <span class="badge badge-<?= strtolower($suivi['statut']) == 'résolu' ? 'success' : (strtolower($suivi['statut']) == 'en cours' ? 'warning' : 'secondary') ?>">
                    <?= htmlspecialchars($suivi['statut']) ?>
                  </span>
                  <p><strong>Service :</strong> <?= htmlspecialchars($suivi['service_responsable']) ?></p>
                  <p><?= htmlspecialchars($suivi['description']) ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="text-muted">Aucune mise à jour disponible.</p>
        <?php endif; ?>
      </div>
      <div class="text-right mb-4">
  <a href="signalement_view.php" class="btn btn-outline-primary">
    ← Retour à la liste
  </a>
</div>

    </div>
  </section>
</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
