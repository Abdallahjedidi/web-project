<?php
include_once '../../Controller/signalementctrl.php';
include_once '../../Model/signalement.php';

$signalementCtrl = new SignalementC();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de signalement invalide.</div>";
    exit;
}

$id = $_GET['id'];

$db = config::getConnection();
$query = $db->prepare("SELECT * FROM signalement WHERE id_signalement = :id");
$query->execute(['id' => $id]);
$signalementData = $query->fetch(PDO::FETCH_ASSOC);

if (empty($signalementData)) {
    echo "<div class='alert alert-warning'>Signalement introuvable.</div>";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $emplacement = trim($_POST['emplacement'] ?? '');
    $date_signalement = trim($_POST['date_signalement'] ?? '');
    $statut = trim($_POST['statut'] ?? '');
    $id_signalement = $_POST['id_signalement'] ?? null;

    if ($titre && $description && $emplacement && $date_signalement && $statut && $id_signalement) {

        $errors = [];

        if (strlen($titre) < 5) {
            $errors[] = "Le titre doit contenir au moins 5 caractères.";
        }
        if (str_word_count($titre) < 1) {
            $errors[] = "Le titre doit contenir au moins un mot.";
        }
        if (!preg_match('/[a-zA-ZÀ-ÿ]/u', $titre)) {
            $errors[] = "Le titre doit contenir des lettres.";
        }

        if (strlen($description) < 10) {
            $errors[] = "La description doit contenir au moins 10 caractères.";
        }
        if (str_word_count($description) < 2) {
            $errors[] = "La description doit contenir au moins deux mots.";
        }
        if (!preg_match('/[a-zA-ZÀ-ÿ]/u', $description)) {
            $errors[] = "La description doit contenir des lettres.";
        }

        if (!empty($errors)) {
            $message = implode("<br>", array_map('htmlspecialchars', $errors));
        } else {
            $signalement = new Signalement();
            $signalement->setIdSignalement($id_signalement);
            $signalement->setTitre($titre);
            $signalement->setDescription($description);
            $signalement->setEmplacement($emplacement);
            $signalement->setDateSignalement($date_signalement);
            $signalement->setStatut($statut);

            if ($signalementCtrl->updateSignalement($signalement)) {
                echo "<script>alert('✅ Le signalement a été modifié avec succès !'); window.location.href='signalement_view.php';</script>";
                exit;
            } else {
                $message = "❌ Échec de la modification.";
            }
        }
    } else {
        $message = "❌ Tous les champs doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier un signalement</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body { background-color: #f4f4f4; }
    .navbar { background-color: #04042e !important; }
    .form_container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
    .input-group .form-control { flex: 1 1 auto; }
  </style>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
<div class="hero_area">
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand text-white" href="index.php"><span>URBANISME</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"><span class=""></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link text-white" href="index.php">ACCUEIL</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="signalement_ajout.php">AJOUTER</a></li>
            <li class="nav-item active"><a class="nav-link text-white" href="signalement_view.php">VOIR LES SIGNALEMENTS</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="contact.php">CONTACT</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <section class="contact_section layout_padding" style="padding: 60px 0; background-color: #f4f4f4;">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Modifier le signalement</h2>
      </div>

      <?php if ($message): ?>
        <div class="alert alert-danger text-center"> <?= $message ?> </div>
      <?php endif; ?>

      <div class="alert alert-info text-center mb-4">Vous pouvez modifier un ou plusieurs champs. Tous les champs doivent rester remplis.</div>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="form_container">
            <form method="POST">
              <input type="hidden" name="id_signalement" value="<?= htmlspecialchars($signalementData['id_signalement']) ?>">

              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Titre du signalement*" name="titre" value="<?= htmlspecialchars($signalementData['titre']) ?>" required>
              </div>
              <div class="mb-3">
                <textarea class="form-control" placeholder="Description*" name="description" required><?= htmlspecialchars($signalementData['description']) ?></textarea>
              </div>
              <div class="mb-3 input-group">
                <input type="text" class="form-control" id="emplacement" placeholder="Emplacement exact*" name="emplacement" value="<?= htmlspecialchars($signalementData['emplacement']) ?>" required readonly>
                <button class="btn btn-outline-secondary" type="button" id="btnMap"><i class="fa fa-map-marker"></i></button>
              </div>
              <div id="selectedAddress" class="text-muted small mb-3"></div>
              <div class="mb-3">
                <input type="date" class="form-control" name="date_signalement" value="<?= htmlspecialchars($signalementData['date_signalement']) ?>" required>
              </div>
              <div class="mb-3">
                <select class="form-select form-control" name="statut" required>
                  <option value="En attente" <?= ($signalementData['statut'] === 'En attente') ? 'selected' : '' ?>>En attente</option>
                  <option value="En cours" <?= ($signalementData['statut'] === 'En cours') ? 'selected' : '' ?>>En cours</option>
                  <option value="Résolu" <?= ($signalementData['statut'] === 'Résolu') ? 'selected' : '' ?>>Résolu</option>
                </select>
              </div>
              <div class="btn_box text-center">
                <button type="submit" class="btn btn-danger" style="background-color:#f7444e; border:none;">Modifier</button>
                <a href="signalement_view.php" class="btn btn-secondary">Annuler</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapModalLabel">Choisissez un emplacement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 500px;">
        <div id="map" style="height: 100%;"></div>
      </div>
    </div>
  </div>
</div>

<script>
let mapInitialized = false;
document.getElementById('btnMap').addEventListener('click', function() {
  $('#mapModal').modal('show');

  if (!mapInitialized) {
    setTimeout(() => {
      var map = L.map('map').setView([36.8065, 10.1815], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

      let marker;
      map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        if (marker) {
          marker.setLatLng(e.latlng);
        } else {
          marker = L.marker(e.latlng).addTo(map);
        }

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
          .then(response => response.json())
          .then(data => {
            let address = data.display_name || `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            document.getElementById('emplacement').value = address;
            document.getElementById('selectedAddress').innerHTML = '📍 Adresse choisie : ' + address;
            $('#mapModal').modal('hide');
          })
          .catch(() => {
            document.getElementById('emplacement').value = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            document.getElementById('selectedAddress').innerHTML = '📍 Adresse choisie : Coordonnées sélectionnées';
            $('#mapModal').modal('hide');
          });
      });

      mapInitialized = true;
    }, 500);
  }
});
</script>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>
</body>
</html>