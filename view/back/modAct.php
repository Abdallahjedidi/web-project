<?php
require_once '../../controller/activiteC.php';
require_once '../../controller/espaceController.php';

$activiteC = new activiteController();
$espaceC = new espaceController();
$espaces = $espaceC->listEspace();

if (isset($_GET['id'])) {
    $activite = $activiteC->getActiviteById($_GET['id']);
}

if (
    isset($_POST['titre'], $_POST['description'], $_POST['date_activite'], $_POST['heure'], $_POST['type_activite'])
) {
    if (!empty($_POST['titre']) && !empty($_POST['type_activite'])) {
        $activiteObj = new Activite(
            $_POST['titre'],
            $_POST['description'],
            $_POST['date_activite'],
            $_POST['heure'],
            $_POST['type_activite'],
            !empty($_POST['espace_id']) ? intval($_POST['espace_id']) : null
        );

        $activiteC->updateActivite($activiteObj, $_GET['id']);
        header('Location: tables.php');
        exit;
    } else {
        echo "<p style='color:red'>Veuillez remplir tous les champs obligatoires.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de l'Espace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Mise à Jour de l'Espace</h1>
                    </div>
                    <div class="card-body">
                    <form method="POST">
                            <div class="form-group">
                                <label for="titre">Titre :</label>
                                <input type="text" id="titre" name="titre" class="form-control" value="<?= $activite['titre'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea id="description" name="description" class="form-control"><?= $activite['description'] ?? '' ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="date_activite">Date :</label>
                                <input type="date" id="date_activite" name="date_activite" class="form-control" value="<?= $activite['date_activite'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="heure">Heure :</label>
                                <input type="time" id="heure" name="heure" class="form-control" value="<?= $activite['heure'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="type_activite">Type d'activité :</label>
                                <select id="type_activite" name="type_activite" class="form-control">
                                    <option value="écologie" <?= ($activite['type_activite'] == 'écologie') ? 'selected' : '' ?>>Écologie</option>
                                    <option value="sport" <?= ($activite['type_activite'] == 'sport') ? 'selected' : '' ?>>Sport</option>
                                    <option value="culture" <?= ($activite['type_activite'] == 'culture') ? 'selected' : '' ?>>Culture</option>
                                    <option value="autre" <?= ($activite['type_activite'] == 'autre') ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="espace_id">Espace associé :</label>
                                <select name="espace_id" id="espace_id" class="form-control">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($espaces as $espace): ?>
                                        <option value="<?= $espace['id']; ?>" <?= ($activite['espace_id'] == $espace['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($espace['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/controleactivité.js"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
