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
  <title>Signalements - Vue</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #map {
      height: 500px;
      border-radius: 10px;
      margin-bottom: 40px;
    }
  </style>
</head>
<body style="background-color: #f4f4f4;">
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
            <li class="nav-item"><a class="nav-link" href="index.php">ACCUEIL</a></li>
            <li class="nav-item"><a class="nav-link" href="signalement_ajout.php">AJOUTER</a></li>
            <li class="nav-item active"><a class="nav-link" href="signalement_view.php">VOIR LES SIGNALEMENTS</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <section class="contact_section layout_padding" style="background-color: #ffffff; padding: 60px 0;">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Liste des signalements</h2>
      </div>

      <div id="map"></div>

      <div class="table-responsive d-flex justify-content-center">
        <table class="table table-bordered table-striped" style="width: 100%;">
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
                    <a href="signalement_suivi.php?id_signalement=<?= $sig['id_signalement'] ?>" class="btn btn-sm btn-info">Suivi</a>
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
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([34.0, 9.0], 6);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap',
    maxZoom: 19,
  }).addTo(map);

  const iconRouge = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  });

  const iconJaune = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  });

  const iconVert = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  });

  const signalements = <?= json_encode($signalements) ?>;

  signalements.forEach(sig => {
    const adresse = sig.emplacement;

    fetch("https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(adresse))
      .then(response => response.json())
      .then(data => {
        if (data && data.length > 0) {
          const lat = parseFloat(data[0].lat);
          const lon = parseFloat(data[0].lon);

          let icon = iconRouge;
          const statut = sig.statut.toLowerCase();

          if (statut.includes("résolu")) {
            icon = iconVert;
          } else if (statut.includes("en cours")) {
            icon = iconJaune;
          }

          const marker = L.marker([lat, lon], { icon: icon }).addTo(map);
          marker.bindPopup(`
            <strong>${sig.titre}</strong><br>${sig.emplacement}<br>
            <a href="signalement_suivi.php?id_signalement=${sig.id_signalement}"
               style="display:inline-block;margin-top:8px;padding:6px 10px;background:#007bff;color:#fff;border-radius:5px;text-decoration:none;font-size:13px;">
               Voir Suivi
            </a>
          `);
        }
      })
      .catch(error => console.error("Erreur de géocodage :", error));
  });
</script>
</body>
</html>