<?php
// Start the session if it is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simulate a logged-in user for testing (use the actual user ID you want to test with)
$_SESSION['user_id'] = 2; // Set to the ID of the organizer you want to test

include_once '../../Model/events.php';
include_once '../../config.php';
include_once '../../Controller/eventsController.php';
include_once '../../Controller/avisContoller.php';   // Include AvisController for handling avis deletion

$conn = Config::getconnection();

$event = null; 
$deleted = false;
$deletedAvis = false;

$event_id = $_GET['id'] ?? null;

// Handle event deletion
if (isset($_POST['id'])) {
    $eventController = new eventcontroller();
    $eventController->deleteevent($_POST['id']);
    $deleted = true;
}

// Handle avis (review) deletion
if (isset($_POST['delete_id'])) {
    $avisController = new AvisController();
    $avisController->deleteAvis($_POST['delete_id']);
    $deletedAvis = true;
}

if ($event_id && is_numeric($event_id) && !$deleted) {
    try {
        $query = "SELECT * FROM events WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
}

// Fetch the avis related to the event
$avis = [];
if ($event_id) {
    try {
        $query = "SELECT * FROM avis WHERE id_event = :event_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Détails de l'Événement</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
   <style>
       #eventMap {
            height: 400px !important; /* Make sure map has a height */
            min-height: 400px; /* Fallback if the above doesn't work */
            width: 100%; /* Make it responsive */
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .event-image-container {
            margin: 0 auto;
            max-width: 100%;
            text-align: center;
        }

        .event-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 10px;
        }

        .event-detail-box {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .event-detail-box h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .event-detail-box p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 12px;
        }

        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-container a,
        .btn-container button {
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-container a:hover,
        .btn-container button:hover {
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-outline-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .avis-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .avis {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .avis p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .avis small {
            color: #888;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

    </style>
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
                        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                        <li class="nav-item active"><a class="nav-link" href="afficheevent.php">Événements</a></li>
                        <li class="nav-item"><a class="nav-link" href="afficheavis.php">Avis</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Event Details Section -->
    <section class="slider_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?php if ($deleted): ?>
                        <div class="alert alert-success text-center mt-5">
                            ✅ L'événement a été supprimé avec succès.
                        </div>
                        <div class="text-center">
                            <a href="afficheevent.php" class="btn btn-outline-primary mt-3">
                                ← Retour aux événements
                            </a>
                        </div>
                    <?php elseif ($event): ?>
                        <div class="event-image-container">
                            <?php if (!empty($event['image'])): ?>
                                <img src="<?= htmlspecialchars($event['image']) ?>" class="event-image" alt="Event Image">
                            <?php else: ?>
                                <img src="images/default-event.jpg" class="event-image" alt="Default Event Image">
                            <?php endif; ?>
                        </div>

                        <div class="event-detail-box">
                            <h1><?= htmlspecialchars($event['title']) ?></h1>
                            <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                            <p><strong>Description:</strong><br> <?= nl2br(htmlspecialchars($event['description'])) ?></p>

                            <?php if (!empty($event['location'])): ?>
                                <p><strong>Lieu:</strong> <?= htmlspecialchars($event['location']) ?></p>
                            <?php endif; ?>

                            <?php if (!empty($event['date'])): ?>
                                <p><strong>Heure:</strong> <?= htmlspecialchars($event['date']) ?></p>
                            <?php endif; ?>
                              <!-- Map Display -->
                             <?php if (!empty($event['latitude']) && !empty($event['longitude'])): ?>
                             <h4>Localisation de l'événement</h4>
                                <div id="eventMap"></div>
                             <?php endif; ?>

                            <!-- Check if the logged-in user is the organizer -->
                            <?php if ($_SESSION['user_id'] == $event['organizer_id']): ?>
                                <div class="btn-container">
                                    <a href="afficheevent.php" class="btn btn-outline-secondary">← Retour aux événements</a>
                                    <a href="modifierevent.php?id=<?= $event['id'] ?>" class="btn btn-outline-primary">Modifier</a>
                                    <a href="addavis.php?id_event=<?= $event['id'] ?>" class="btn btn-success">Ajouter un avis</a>
                                    <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="btn-container">
                                    <a href="afficheevent.php" class="btn btn-outline-secondary">← Retour aux événements</a>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger text-center mt-5">
                            Événement introuvable ou déjà supprimé.
                        </div>
                        <div class="text-center">
                            <a href="afficheevent.php" class="btn btn-outline-primary mt-3">
                                ← Retour aux événements
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Display avis section -->
                    <div class="avis-section">
                        <?php if ($avis): ?>
                            <?php foreach ($avis as $review): ?>
                                <div class="avis">
                                    <p><strong><?= htmlspecialchars($review['name']) ?></strong></p>
                                    <p><?= nl2br(htmlspecialchars($review['description'])) ?></p>
                                    <small><em>Posté le <?= $review['reported_at'] ?></em></small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun avis pour cet événement pour le moment.</p>
                        <?php endif; ?>
                    </div>
                    <div class="avis-section">
    <?php if ($avis): ?>
        <?php foreach ($avis as $review): ?>
            <div class="avis">
                <p><strong><?= htmlspecialchars($review['name']) ?></strong></p>
                <p><?= nl2br(htmlspecialchars($review['description'])) ?></p>
                <small><em>Posté le <?= $review['reported_at'] ?></em></small>
                <div class="d-flex justify-content-end mt-2">
                    <!-- Modify Link -->
                    <a href="modifieravis.php?id=<?= $review['id'] ?>" class="btn btn-sm btn-warning mx-1">✏️ Modifier</a>
                    
                    <!-- Delete Form -->
                    <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($review['id']) ?>">
                        <button type="submit" class="btn btn-sm btn-danger">🗑 Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
       
    <?php endif; ?>
</div>
               
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Initialize the map -->
<script>
    <?php if (!empty($event['latitude']) && !empty($event['longitude'])): ?>
        var map = L.map('eventMap').setView([<?= $event['latitude'] ?>, <?= $event['longitude'] ?>], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([<?= $event['latitude'] ?>, <?= $event['longitude'] ?>]).addTo(map)
            .bindPopup("<b><?= htmlspecialchars($event['title']) ?></b><br><?= htmlspecialchars($event['location']) ?>")
            .openPopup();
    <?php endif; ?>
</script>

</body>
</html>
