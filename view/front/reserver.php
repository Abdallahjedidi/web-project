<?php
require_once '../../controller/activiteC.php';
require_once '../../controller/reserverC.php';

// Vérifier si l'ID de l'activité est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: espaces.php');
    exit;
}

$activite_id = $_GET['id'];
$activiteController = new activiteController();
$reservationController = new reserverController();

// Récupérer les détails de l'activité
$activite = $activiteController->getActiviteById($activite_id);

// Si l'activité n'existe pas
if (!$activite) {
    header('Location: espaces.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'activite_id' => $activite_id,
        'email' => $_POST['email'],
        'numtlf' => $_POST['numtlf'],
        'date_inscription' => date('Y-m-d H:i:s')
    ];

    $result = $reservationController->addReserver($data);

    if ($result) {
        header('Location: service.php');
        exit;
    } else {
        $error = "Une erreur s'est produite lors de la réservation";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation d'activité - UrbanNext</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <style>
        .reservation-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .reservation-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .reservation-header h2 {
            color: #0c0c0c;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding-left: 15px;
        }
        
        .form-control:focus {
            border-color: #0c0c0c;
            box-shadow: none;
        }
        
        textarea.form-control {
            height: auto;
            min-height: 100px;
        }
        
        .btn-reserve {
            background: #0c0c0c;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-reserve:hover {
            background: #2e2e2e;
            transform: translateY(-2px);
        }
        
        .activity-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .activity-info h4 {
            color: #0c0c0c;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
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
                            <li class="nav-item"><a class="nav-link" href="espaces.php">Espaces</a></li>
                            <li class="nav-item"><a class="nav-link" href="price.html">Evenement</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    </div>

    <!-- Reservation Form Section -->
    <section class="service_section layout_padding">
        <div class="container">
            <div class="reservation-container">
                <div class="reservation-header">
                    <h2>Formulaire de Réservation</h2>
                    <p>Remplissez ce formulaire pour réserver votre activité</p>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <!-- Vous pouvez ajouter ici des informations sur l'activité réservée -->
                <div class="activity-info">
    <h4>Vous réservez l'activité : <?= htmlspecialchars($activite['titre']) ?></h4>
    <p><strong>Date de l'activité :</strong> <?= date('d/m/Y', strtotime($activite['date_activite'])) ?></p>
</div>

                
<form method="POST" action="" onsubmit="return validateForm()">
    <div class="form-group">
        <label for="email">Adresse Email *</label>
        <input type="email" class="form-control" id="email" name="email" >
    </div>
    
    <div class="form-group">
        <label for="numtlf">Numéro de Téléphone *</label>
        <input type="tel" class="form-control" id="numtlf" name="numtlf" >
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn-reserve">Confirmer la réservation</button>
    </div>
</form>

<script>
function validateForm() {
    // Vérification de l'email
    var email = document.getElementById('email').value;
    var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        alert('Veuillez entrer une adresse email valide.');
        return false;
    }

    // Vérification du numéro de téléphone
    var numtlf = document.getElementById('numtlf').value;
    var numtlfRegex = /^[0-9]{8}$/; // Exemple de validation pour un numéro de téléphone à 10 chiffres
    if (!numtlfRegex.test(numtlf)) {
        alert('Veuillez entrer un numéro de téléphone valide (8 chiffres).');
        return false;
    }

    return true; // Le formulaire est valide
}
</script>


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