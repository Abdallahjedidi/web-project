<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>URBANISME</title>

  <!-- Bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
</head>

<body>
  <div class="hero_area">
    <!-- Header -->
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
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signalement_ajout.php">Ajouter</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signalement_view.php">Voir les signalements</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
              </li>
            </ul>
            <div class="quote_btn-container">
              <form class="form-inline">
                <button class="btn nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <!-- Slider section -->
    <section class="slider_section">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>Améliorons notre ville</h1>
                    <p>Participez activement en signalant les problèmes urbains autour de vous.</p>
                    <div class="btn-box">
                      <a href="signalement_ajout.php" class="btn-1">Signaler</a>
                      <a href="signalement_view.php" class="btn-2">Voir les signalements</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="img-box">
                    <img src="images/slider-img.png" alt="Illustration urbaine">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel_btn-box">
          <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Précédent</span>
          </a>
          <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Suivant</span>
          </a>
        </div>
      </div>
    </section>
  </div>

  <!-- Contact rapide section -->
  <section class="contact_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Un problème à signaler ?</h2>
      </div>
      <div class="row">
        <div class="col-md-8 col-lg-6 mx-auto">
          <div class="form_container">
            <form action="signalement_ajout.php" method="GET">
              <div><input type="text" name="titre" placeholder="Titre du problème" /></div>
              <div><input type="text" name="emplacement" placeholder="Emplacement" /></div>
              <div><input type="text" name="description" class="message-box" placeholder="Description" /></div>
              <div class="btn_box">
                <button type="submit">Signaler</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="info_contact">
            <h4>Contact</h4>
            <a href="#"><i class="fa fa-map-marker"></i> Ariana Soghra</a><br>
            <a href="#"><i class="fa fa-phone"></i> 29494994</a><br>
            <a href="#"><i class="fa fa-envelope"></i> mehdi@gmail.com</a>
          </div>
        </div>
        <div class="col-md-4">
          <h4>Liens rapides</h4>
          <ul class="list-unstyled">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="signalement_ajout.php">Ajouter</a></li>
            <li><a href="signalement_view.php">Voir les signalements</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4>Newsletter</h4>
          <form action="#">
            <input type="text" placeholder="Entrez votre email">
            <button type="submit">S'inscrire</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer_section">
    <div class="container">
      <p>&copy; <span id="displayYear"></span> URBANISME. Tous droits réservés.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>
