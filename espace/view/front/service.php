
<?php
require_once 'C:\xampp\htdocs\espace\controller\espaceController.php';


$Pc = new espaceController();

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

  <title>Hostit</title>


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

<body class="sub_page">

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
              <li class="nav-item ">
                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html"> About</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="service.php">espaces</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="price.html">Pricing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li>
            </ul>
            <div class="quote_btn-container">
              <form class="form-inline">
                <button class="btn   nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call : +216 25 125 669
                </span>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- service section -->

  <section class="service_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Espaces
        </h2>
      </div>
    </div>
  <!-- Liste des espaces -->
<div class="container">
  <div class="row">
    <?php if (!empty($Pc->listEspace())): ?>
      <?php foreach ($Pc->listEspace() as $espace): ?>
        <div class="col-md-6 col-lg-4">
          <div class="box">

          <div class="box-img-hover">
    <!-- Affichage de l'image -->
    <?php
    // Définir le chemin de l'image
    $imagePath = '../back/img/' . htmlspecialchars($espace['image']);
    // Définir une image par défaut si l'image n'existe pas
    $defaultImage = '../back/img/';    ?>
    <!-- Vérifier si le fichier existe, sinon afficher l'image par défaut -->
    <img src="<?= (file_exists($imagePath) && !empty($espace['image'])) ? $imagePath : $defaultImage; ?>" 
         class="img-fluid">
</div>


            <div class="detail-box">
              <h4><?= htmlspecialchars($espace['nom']); ?></h4>
              <p><?= htmlspecialchars($espace['description']); ?></p>
              <ul class="list-unstyled">
                <li><strong>Adresse :</strong> <?= htmlspecialchars($espace['adresse']); ?></li>
                <li><strong>Ville :</strong> <?= htmlspecialchars($espace['ville']); ?></li>
                <li><strong>Superficie :</strong> <?= $espace['superficie']; ?> m²</li>
                <li>
                  <strong>Statut :</strong>
                  <span class="badge 
                    <?php 
                      $statut = strtolower($espace['statut']);
                      echo ($statut === 'disponible') ? 'bg-success' :
                          (($statut === 'occupé') ? 'bg-danger' :
                          (($statut === 'en maintenance') ? 'bg-warning text-dark' : 'bg-secondary'));
                    ?>">
                    <?= ucfirst($espace['statut']); ?>
                  </span>
                </li>
              </ul>
              <form method="GET" action="acheterespaces.php">
                <input type="hidden" name="id" value="<?= $espace['id']; ?>">
                <input type="submit" class="btn btn-secondary w-100 mt-2" value="Reserver">
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">Aucun espace disponible pour le moment.</p>
    <?php endif; ?>
  </div>
</div>


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
                  Call +216 22585841
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
              <a class="" href="index.html">
                <img src="images/nav-bullet.png" alt="">
                Home
              </a>
              <a class="" href="about.html">
                <img src="images/nav-bullet.png" alt="">
                About
              </a>
              <a class="active" href="service.html">
                <img src="images/nav-bullet.png" alt="">
                Espace
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
          <form action="#">
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