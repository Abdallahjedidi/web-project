<?php
// signalement_ajout.php (version finale avec adresse au lieu de coordonnées)
include_once '../../Controller/signalementctrl.php';
include_once '../../config.php';

$signalementCtrl = new SignalementC();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titre = trim($_POST['titre'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $emplacement = trim($_POST['emplacement'] ?? '');
  $date_signalement = $_POST['date_signalement'] ?? '';
  $statut = $_POST['statut'] ?? null;
  
    if (empty($titre)) {
        $errors[] = "Le titre est requis.";
    } else {
        if (strlen($titre) < 5) {
            $errors[] = "Le titre doit contenir au moins 5 caractères.";
        }
        if (str_word_count($titre) < 1) {
            $errors[] = "Le titre doit contenir au moins un mot.";
        }
        if (!preg_match('/[a-zA-Z\xc0-\xff]/u', $titre)) {
            $errors[] = "Le titre doit contenir des lettres.";
        }
    }

    if (empty($description)) {
        $errors[] = "La description est requise.";
    } else {
        if (strlen($description) < 10) {
            $errors[] = "La description doit contenir au moins 10 caractères.";
        }
        if (str_word_count($description) < 2) {
            $errors[] = "La description doit contenir au moins deux mots.";
        }
        if (!preg_match('/[a-zA-Z\xc0-\xff]/u', $description)) {
            $errors[] = "La description doit contenir des lettres.";
        }
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
        $signalement->setTitre($titre);
        $signalement->setDescription($description);
        $signalement->setEmplacement($emplacement);
        $signalement->setDateSignalement($date_signalement);
        $signalement->setStatut($statut);

        $result = $signalementCtrl->addSignalement($signalement);

        if ($result) {
            echo '<script>alert("✅ Signalement ajouté avec succès !"); window.location.href = "signalement_ajout.php";</script>';
            exit;
        } else {
            $errors[] = "❌ Une erreur s'est produite lors de l'enregistrement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Ajouter un signalement</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    input[type="text"], input[type="date"], textarea, select {
      background-color: #ffffff;
      border: 1px solid #ced4da;
      color: #495057;
      padding: 10px;
    }
    input[readonly] {
      background-color: #ffffff !important;
    }
    button[type="submit"] {
      background-color: #ff4b5c;
      color: white;
      font-weight: bold;
      padding: 10px 30px;
      border: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    button[type="submit"]:hover {
      background-color: #e03e4e;
    }
  </style>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
            <li class="nav-item"><a class="nav-link active" href="signalement_ajout.php">Ajouter</a></li>
            <li class="nav-item"><a class="nav-link" href="signalement_view.php">Voir les signalements</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  
  <section class="contact_section layout_padding-bottom py-5" style="background-color: #f1f2f6;">
    <div class="container">
      <div class="heading_container heading_center mb-4">
        <h2 class="text-dark">Ajouter un signalement</h2>
        <p class="text-secondary">Remplissez le formulaire ci-dessous pour signaler un problème</p>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
          <div class="form_container">
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <form action="signalement_ajout.php" method="POST">
              <input type="text" name="titre" class="form-control" placeholder="Titre du signalement*" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>">
              <textarea name="description" class="form-control" placeholder="Description*" rows="4" ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
              <div class="input-group mb-2">
                <input type="text" id="emplacement" name="emplacement" class="form-control" placeholder="Emplacement exact*" value="<?= htmlspecialchars($_POST['emplacement'] ?? '') ?>" readonly>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="btnMap"><i class="fa fa-map-marker"></i></button>
                </div>
              </div>
              <div id="selectedAddress" class="text-muted small mb-3"></div>
              <input type="date" name="date_signalement" class="form-control" value="<?= htmlspecialchars($_POST['date_signalement'] ?? date('Y-m-d')) ?>">
              <select name="statut" class="form-control">
                <option disabled selected>Statut du signalement*</option>
                <option value="En attente" <?= (($_POST['statut'] ?? '') == 'En attente') ? 'selected' : '' ?>>En attente</option>
                <option value="En cours" <?= (($_POST['statut'] ?? '') == 'En cours') ? 'selected' : '' ?>>En cours</option>
                <option value="Résolu" <?= (($_POST['statut'] ?? '') == 'Résolu') ? 'selected' : '' ?>>Résolu</option>
              </select>
              <div class="text-center mt-4">
                <button type="submit">ENVOYER</button>
              </div>
              <p class="text-center text-muted mt-3">* Champs obligatoires</p>
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
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
      }).addTo(map);

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