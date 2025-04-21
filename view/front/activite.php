<?php
require_once '../../controller/activiteC.php';

if (isset($_GET['id_espace'])) {
  $idEspace = $_GET['id_espace'];
  $controller = new activiteController();
  $activites = $controller->listActiviteByEspace($idEspace);
} else {
  echo "Aucun espace sélectionné.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>UrbanNext</title>

  <!-- Stylesheets -->
  <link rel="icon" href="images/fevicon.png" type="image/gif">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">
</head>

<body class="sub_page">

  <!-- Header Section -->
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.html">
            <span>UrbanNext</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
              <li class="nav-item active"><a class="nav-link" href="espaces.php">Espaces</a></li>
              <li class="nav-item"><a class="nav-link" href="price.html">Evenement</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
            </ul>
            <div class="quote_btn-container">
              <form class="form-inline">
                <button class="btn nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Call : +216 25 125 669</span>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
  </div>

  <!-- Service Section -->
  <!-- service section -->
<section class="service_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Nos Activités
            </h2>
            <p class="subheading">Découvrez toutes les activités disponibles dans cet espace</p>
        </div>
        
        <!-- Liste des activités améliorée -->
        <div class="activity-container">
            <?php if (!empty($activites)): ?>
                <div class="row">
                <?php foreach ($activites as $act): ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="activity-card">
            <div class="card-header">
                <h3 class="activity-title"><?= htmlspecialchars($act['titre']) ?></h3>
                <span class="activity-badge"><?= htmlspecialchars($act['type_activite']) ?></span>
            </div>
            <div class="card-body">
                <p class="activity-description"><?= htmlspecialchars($act['description']) ?></p>
                <div class="activity-meta">
                    <div class="meta-item">
                        <i class="fa fa-calendar"></i>
                        <span><?= date('d/m/Y', strtotime($act['date_activite'])) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fa fa-clock-o"></i>
                        <span><?= htmlspecialchars($act['heure']) ?></span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span class="space-info">
                    <i class="fa fa-map-marker"></i> <?= htmlspecialchars($act['cespace_name']) ?>
                </span>
                <form action="reserver.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($act['id']) ?>">
    <input type="submit" class="btn-reserve" value="Réserver">
</form>

            </div>
        </div>
    </div>
<?php endforeach; ?>

                </div>
            <?php else: ?>
                <div class="no-activities">
                    <i class="fa fa-calendar-times-o"></i>
                    <h3>Aucune activité programmée</h3>
                    <p>Revenez plus tard pour découvrir nos prochaines activités</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    /* Styles pour les activités */
    .heading_container .subheading {
        color: #666;
        font-size: 1.1rem;
        margin-top: 10px;
    }
    
    .activity-container {
        margin-top: 40px;
    }
    
    .activity-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .activity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .card-header {
        background: #0c0c0c;
        color: white;
        padding: 15px 20px;
        position: relative;
    }
    
    .activity-title {
        margin: 0;
        font-size: 1.3rem;
    }
    
    .activity-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        color: #0c0c0c;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    
    .card-body {
        padding: 20px;
        flex-grow: 1;
    }
    
    .activity-description {
        color: #555;
        margin-bottom: 20px;
    }
    
    .activity-meta {
        display: flex;
        gap: 15px;
        margin-top: auto;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        color: #666;
    }
    
    .meta-item i {
        margin-right: 5px;
        color: #0c0c0c;
    }
    
    .card-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .space-info {
        color: #555;
        display: flex;
        align-items: center;
    }
    
    .space-info i {
        margin-right: 5px;
        color: #e74c3c;
    }
    
    .btn-reserve {
        background: #2ecc71;
        color: white;
        padding: 5px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .btn-reserve:hover {
        background: #27ae60;
        color: white;
    }
    
    .no-activities {
        text-align: center;
        padding: 50px 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-top: 30px;
    }
    
    .no-activities i {
        font-size: 3rem;
        color: #bdc3c7;
        margin-bottom: 20px;
    }
    
    .no-activities h3 {
        color: #34495e;
        margin-bottom: 10px;
    }
    
    .no-activities p {
        color: #7f8c8d;
    }
</style>

  <!-- Info Section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>Address</h4>
            <div class="contact_link_box">
              <a href=""><i class="fa fa-map-marker" aria-hidden="true"></i><span>Location</span></a>
              <a href=""><i class="fa fa-phone" aria-hidden="true"></i><span>Call +216 22585841</span></a>
              <a href=""><i class="fa fa-envelope" aria-hidden="true"></i><span>demo@gmail.com</span></a>
            </div>
          </div>
          <div class="info_social">
            <a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_link_box">
            <h4>Links</h4>
            <div class="info_links">
              <a href="index.html"><img src="images/nav-bullet.png" alt="">Home</a>
              <a href="about.html"><img src="images/nav-bullet.png" alt="">About</a>
              <a class="active" href="service.html"><img src="images/nav-bullet.png" alt="">Espace</a>
              <a href="price.html"><img src="images/nav-bullet.png" alt="">Evenement</a>
              <a href="contact.html"><img src="images/nav-bullet.png" alt="">Contact Us</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_detail">
            <h4>Info</h4>
          </div>
        </div>
        <div class="col-md-3 mb-0">
          <h4>Subscribe</h4>
          <form action="#">
            <input type="text" placeholder="Enter email">
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer Section -->
  <footer class="footer_section">
    <div class="container">
      <p>&copy; <span id="displayYear"></span> All Rights Reserved By <a href="https://html.design/">Free Html Templates</a></p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>
