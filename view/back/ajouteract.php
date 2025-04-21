<?php
require_once '../../controller/activiteC.php';
require_once '../../controller/espaceController.php';

$espaceController = new espaceController();
$espaces = $espaceController->listEspace();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date = $_POST['date_activite'];
    $heure = $_POST['heure'];
    $type = $_POST['type_activite'];
    $espace_id = !empty($_POST['espace_id']) ? intval($_POST['espace_id']) : null;

    $activite = new Activite($titre, $description, $date, $heure, $type, $espace_id);

    $controller = new activiteController();
    $controller->addActivite($activite);

    header('Location: tables.php'); // redirige vers la liste
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Espace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #00796b;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .form-control, .form-control-file, .custom-select {
            border-radius: 10px;
        }
        .btn-success {
            background-color: #00796b;
            border: none;
            border-radius: 10px;
        }
        .btn-success:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0">Ajouter un Espace</h3>
                    </div>
                    <div class="card-body p-4">
                    <form method="POST">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" name="titre" id="titre" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="date_activite" class="form-label">Date</label>
            <input type="date" class="form-control" name="date_activite" id="date_activite">
        </div>

        <div class="mb-3">
            <label for="heure" class="form-label">Heure</label>
            <input type="time" class="form-control" name="heure" id="heure">
        </div>

        <div class="mb-3">
            <label for="type_activite" class="form-label">Type d'activité</label>
            <select class="form-select" name="type_activite" id="type_activite" required>
                <option value="">-- Sélectionnez --</option>
                <option value="écologie">Écologie</option>
                <option value="sport">Sport</option>
                <option value="culture">Culture</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <div class="mb-3">
    <label for="espace_id" class="form-label">Espace associé</label>
    <select class="form-select" name="espace_id" id="espace_id">
        <option value="">-- Aucun --</option>
        <?php foreach ($espaces as $espace): ?>
            <option value="<?= $espace['id']; ?>">
                <?= htmlspecialchars($espace['nom']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="form-text">Sélectionnez un espace lié à l'activité (facultatif).</div>
</div>


        <button type="submit" class="btn btn-success">Ajouter l'activité</button>
        <a href="listeActivite.php" class="btn btn-secondary">Retour à la liste</a>
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
