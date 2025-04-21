<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Urbanisme</title>

  <!-- CSS -->
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
              <li class="nav-item active"><a class="nav-link" href="index.php">Accueil</a></li>
              <li class="nav-item"><a class="nav-link" href="afficheevent.php">Événements</a></li>
              <li class="nav-item active"><a class="nav-link" href="afficheavis.php">avis</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <!-- Hero / Intro Section -->
    <section class="slider_section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="detail-box">
              <h1>Améliorons nos villes ensemble</h1>
              <p>
                Participez à l'amélioration urbaine en signalant des problèmes, en proposant des idées et en explorant les initiatives locales.
              </p>
              <div class="btn-box">
                <a href="addavis.php" class="btn-1">Donner un avis</a>

                <a href="addevent.php" class="btn-1">ajouter un event </a>
                
              </div>
            </div>
          </div>
          <div class="col-md-6">
           
          </div>
        </div>
      </div>
    </section>
  </div>
    <!-- Main Content Section -->
    

  <!-- Optional Footer -->
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
