  <script>
  function validateForm() {
    // Retrieve form field values
    var idRapport = document.forms["rapportForm"]["id_rapport"].value.trim();
    var idVehiculeLie = document.forms["rapportForm"]["id_vehicule_lie"].value.trim();
    var utilisateurNom = document.forms["rapportForm"]["utilisateur_nom"].value.trim();
    var dateSignalement = document.forms["rapportForm"]["date_signalement"].value.trim();
    var typeProbleme = document.forms["rapportForm"]["type_probleme"].value.trim();
    var description = document.forms["rapportForm"]["description"].value.trim();

    // Check if any field is empty
    if (idRapport === "" || idVehiculeLie === "" || utilisateurNom === "" || dateSignalement === "" || typeProbleme === "" || description === "" ) {
      alert("Veuillez remplir tous les champs obligatoires.");
      return false; // Prevent form submission
    }

    return true; // Allow form submission
  }
  </script>

<?php
include_once '../../Controller/vehiculectrl.php';
include_once '../../config.php';
$vehiculec = new Vehiculec();
$liste = $vehiculec->afficherVehicule();



include_once '../../Controller/rapportctrl.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rapport = new Rapport();

    $rapport->setIdRapport($_POST['id_rapport']);
    $rapport->setIdVehiculeLie($_POST['id_vehicule_lie']);
    $rapport->setUtilisateurNom($_POST['utilisateur_nom']);
    $rapport->setDateSignalement($_POST['date_signalement']);
    $rapport->setTypeProbleme($_POST['type_probleme']);
    $rapport->setDescription($_POST['description']);
    $rapport->setStatut($_POST['statut']);

    // Gestion de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $imageData = file_get_contents($_FILES['photo']['tmp_name']);
        $rapport->setPhoto($imageData);
    } else {
        $rapport->setPhoto(null);
    }

    $rapportc = new Rapportc();
    $rapportc->addRapport($rapport);
}
$rapportObj = new Rapportc();

$rapports = $rapportObj->afficherRAPPORT();

$acceptedRapports = array_filter($rapports, function($rapport) {
    return strtolower($rapport['statut']) === 'accepted';
});

?>


<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="images/fevicon.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>URBANISME</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  

</head>
<style>
  .hoverbrasomek{background-color:white;
  border-radius:20px;}
  .hoverbrasomek {
  background-color: #00008B; /* Dark Blue */
  color: white;
  transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
}

.hoverbrasomek:hover {
  background-color:rgb(244, 244, 244); /* Navy Blue */
  transform: scale(1.05);
  color:black;
}

</style>
<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <span>Hostit</span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="transports.php"> TRANSPORTS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="service.html">***</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="price.html">***</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">***</a>
              </li>
            </ul>
            <div class="quote_btn-container">
              <form class="form-inline">
                <button class="btn   nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->

    <section class="price_section layout_padding">
  <div class="container">
    <div class="row">
        <?php foreach ($liste as $vehicule): ?>
            <div class="col-md-4 mb-4">
              <div class="hoverbrasomek">
                    <div class="card-body">
                        <h5 class="card-title">Véhicule ID: <?= htmlspecialchars($vehicule['id_vehicule']) ?></h5>
                        <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($vehicule['type']) ?></p>
                        <p class="card-text"><strong>Compagnie:</strong> <?= htmlspecialchars($vehicule['compagnie']) ?></p>
                        <p class="card-text"><strong>Accessibilité:</strong> <?= htmlspecialchars($vehicule['accessibilte']) ?></p>
                        <p class="card-text"><strong>État:</strong> <?= htmlspecialchars($vehicule['etat']) ?></p>
                        <p class="card-text"><strong>Niveau de confort:</strong> <?= htmlspecialchars($vehicule['niveau_confort']) ?></p>
                    </div>
        </div>
            </div>
        <?php endforeach; ?>
      </div>
    </div>  <!-- end slider section -->
    <!-- slider section -->       </section>>    </div>


    <section class="contact_section layout_padding-bottom">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Ajouter un Rapport</h2>
    </div>
    <div class="row">
      <div class="col-md-8 col-lg-6 mx-auto">
        <div class="form_container">
        <form name="rapportForm" action="transports.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div>
              <input type="number" name="id_rapport" placeholder="ID Rapport"  />
            </div>
            <div>
              <input type="text" name="id_vehicule_lie" placeholder="Matricule du Véhicule"  />
            </div>
            <div>
              <input type="text" name="utilisateur_nom" placeholder="Nom de l'utilisateur"  />
            </div>
            <div>
              <input type="date" name="date_signalement"  />
            </div>
            <div>
              <input type="text" name="type_probleme" placeholder="Type de problème"  />
            </div>
            <div>
              <textarea name="description" placeholder="Description du problème" ></textarea>
            </div>
            <div>
              <label for="photo">Photo (facultatif)</label>
              <input type="file" name="photo" accept="image/*" />
            </div>
            <input type="hidden" name="statut" value="En attente" />
            <div class="btn_box">
              <button type="submit">Ajouter Rapport</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- end contact section -->

  <section>
    <?php
  if (!empty($acceptedRapports)) {
    echo '<div class="container mt-4"><div class="row">';
    foreach ($acceptedRapports as $rapport) {
        echo '<div class="col-md-4 mb-4">
                <div class="card hoverbrasomek">
                    <div class="card-body">
                        <h5 class="card-title">ID: ' . htmlspecialchars($rapport['id_rapport']) . '</h5>
                        <p class="card-text"><strong>Matricule du Véhicule:</strong> ' . htmlspecialchars($rapport['id_vehicule_lie']) . '</p>
                        <p class="card-text"><strong>Nom de l\'Utilisateur:</strong> ' . htmlspecialchars($rapport['utilisateur_nom']) . '</p>
                        <p class="card-text"><strong>Date de Signalement:</strong> ' . htmlspecialchars($rapport['date_signalement']) . '</p>
                        <p class="card-text"><strong>Type de Problème:</strong> ' . htmlspecialchars($rapport['type_probleme']) . '</p>
                        <p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($rapport['description']) . '</p>
                        <p class="card-text"><strong>Statut:</strong> ' . htmlspecialchars($rapport['statut']) . '</p>';
        if (!empty($rapport['photo'])) {
            echo '<p><img src="data:image/jpeg;base64,' . base64_encode($rapport['photo']) . '" width="100" alt="Photo du rapport" /></p>';
        }
        echo '</div>
              </div>
            </div>';
    }
    echo '</div></div>';
} else {
    echo '<div class="alert alert-warning" role="alert">Aucun rapport accepté trouvé.</div>';
}
?>

        </section>



  <!-- info section -->

  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>
              Address
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Location
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call +01 1234567890
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  demo@gmail.com
                </span>
              </a>
            </div>
          </div>
          <div class="info_social">
            <a href="">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_link_box">
            <h4>
              Links
            </h4>
            <div class="info_links">
              <a class="active" href="index.php">
                <img src="images/nav-bullet.png" alt="">
                Home
              </a>
              <a class="" href="transports.php">
                <img src="images/nav-bullet.png" alt="">
                About
              </a>
              <a class="" href="service.html">
                <img src="images/nav-bullet.png" alt="">
                Services
              </a>
              <a class="" href="price.html">
                <img src="images/nav-bullet.png" alt="">
                Pricing
              </a>
              <a class="" href="contact.html">
                <img src="images/nav-bullet.png" alt="">
                Contact Us
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_detail">
            <h4>
              Info
            </h4>
            <p>
              necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful
            </p>
          </div>
        </div>
        <div class="col-md-3 mb-0">
          <h4>
            Subscribe
          </h4>
          <form action="../../View/BackOffice/index.php">
            <input type="text" placeholder="Enter email" />
            <button type="submit">
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- end info section -->


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>


</body>

</html>