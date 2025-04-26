<?php
include_once '../../config.php';
include_once '../../Model/signalement.php';

class SignalementC {
    private function showMessage($type, $message, $index = 0) {
        $top = 20 + ($index * 60);
        echo <<<HTML
        <div class="alert alert-{$type} position-fixed" 
             style="top:{$top}px; right:20px; z-index:1050; width:300px; transition: all 0.3s ease;">
            {$message}
        </div>
        HTML;
    }

    public function afficherSignalement() {
        $sql = "SELECT * FROM signalement";
        $db = config::getConnection();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll();
        } catch (Exception $e) {
            $this->showMessage('danger', '❌ Error: '.$e->getMessage());
            return [];
        }
    }

    public function addSignalement($signalement) {
        $db = config::getConnection();
        $errors = [];

        if (empty($signalement->getTitre()) || !preg_match('/[a-zA-ZÀ-ÿ]/u', $signalement->getTitre())) {
            $errors[] = "Le titre est obligatoire et doit contenir des lettres.";
        }

        if (empty($signalement->getDescription()) || !preg_match('/[a-zA-ZÀ-ÿ]/u', $signalement->getDescription())) {
            $errors[] = "La description est obligatoire et doit contenir des lettres.";
        }

        if (empty($signalement->getEmplacement())) {
            $errors[] = "L'emplacement est obligatoire.";
        }

        if (empty($signalement->getDateSignalement())) {
            $errors[] = "La date est obligatoire.";
        }

        if (empty($signalement->getStatut())) {
            $errors[] = "Le statut est obligatoire.";
        }

        if (!empty($errors)) {
            foreach ($errors as $i => $error) {
                $this->showMessage('danger', '❌ '.htmlspecialchars($error), $i);
            }
            return false;
        }

        try {
            $query = $db->prepare("
                INSERT INTO signalement 
                (titre, description, emplacement, date_signalement, statut)
                VALUES 
                (:titre, :description, :emplacement, :date_signalement, :statut)
            ");

            $success = $query->execute([
                ':titre' => $signalement->getTitre(),
                ':description' => $signalement->getDescription(),
                ':emplacement' => $signalement->getEmplacement(),
                ':date_signalement' => $signalement->getDateSignalement(),
                ':statut' => $signalement->getStatut()
            ]);

            if ($success) {
                $this->showMessage('success', '✅ Signalement ajouté avec succès !');
                return true;
            }

            $this->showMessage('danger', '❌ Erreur lors de l\'ajout');
            return false;

        } catch (PDOException $e) {
            $this->showMessage('danger', '❌ Erreur: '.htmlspecialchars($e->getMessage()));
            return false;
        }
    }

    public function deleteSignalement($id_signalement) {
        $db = config::getConnection();
        try {
            $query = $db->prepare("DELETE FROM signalement WHERE id_signalement = :id_signalement");
            $query->execute([':id_signalement' => $id_signalement]);
            $this->showMessage('success', '✅ Signalement supprimé !');
            return true;
        } catch (PDOException $e) {
            $this->showMessage('danger', '❌ Erreur: '.htmlspecialchars($e->getMessage()));
            return false;
        }
    }

    public function updateSignalement($signalement) {
        $db = config::getConnection();
        $errors = [];

        if (empty($signalement->getIdSignalement()) || !ctype_digit((string)$signalement->getIdSignalement())) {
            $errors[] = "ID invalide ou manquant pour la mise à jour.";
        }

        if (empty($signalement->getTitre()) || !preg_match('/[a-zA-ZÀ-ÿ]/u', $signalement->getTitre())) {
            $errors[] = "Le titre est obligatoire et doit contenir des lettres.";
        }

        if (empty($signalement->getDescription()) || !preg_match('/[a-zA-ZÀ-ÿ]/u', $signalement->getDescription())) {
            $errors[] = "La description est obligatoire et doit contenir des lettres.";
        }

        if (empty($signalement->getEmplacement())) {
            $errors[] = "L'emplacement est obligatoire.";
        }

        if (empty($signalement->getDateSignalement())) {
            $errors[] = "La date est obligatoire.";
        }

        if (empty($signalement->getStatut())) {
            $errors[] = "Le statut est obligatoire.";
        }

        if (!empty($errors)) {
            foreach ($errors as $i => $error) {
                $this->showMessage('danger', '❌ '.htmlspecialchars($error), $i);
            }
            return false;
        }

        try {
            $query = $db->prepare("
                UPDATE signalement SET
                    titre = :titre,
                    description = :description,
                    emplacement = :emplacement,
                    date_signalement = :date_signalement,
                    statut = :statut
                WHERE id_signalement = :id_signalement
            ");

            $success = $query->execute([
                ':titre' => $signalement->getTitre(),
                ':description' => $signalement->getDescription(),
                ':emplacement' => $signalement->getEmplacement(),
                ':date_signalement' => $signalement->getDateSignalement(),
                ':statut' => $signalement->getStatut(),
                ':id_signalement' => $signalement->getIdSignalement()
            ]);

            if ($success) {
                $this->showMessage('success', '✅ Signalement modifié avec succès !');
                return true;
            }

            $this->showMessage('danger', '❌ Erreur lors de la modification');
            return false;

        } catch (PDOException $e) {
            $this->showMessage('danger', '❌ Erreur: '.htmlspecialchars($e->getMessage()));
            return false;
        }
    }

    public function rechercher($id) {
        $db = config::getConnection();
        try {
            $query = $db->prepare("SELECT * FROM signalement WHERE id_signalement = :id");
            $query->execute(['id' => $id]);
            return $query->fetchAll();
        } catch (Exception $e) {
            $this->showMessage('danger', '❌ Erreur: '.htmlspecialchars($e->getMessage()));
            return [];
        }
    }
    public function getTodaySignalements()
    {
        $db = config::getConnection();
        $query = $db->query("SELECT id_signalement, titre, description, emplacement, date_signalement, statut FROM signalement WHERE DATE(date_signalement) = CURDATE()");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    


    public function recupererSignalement($id_signalement) {
        $db = config::getConnection();  // ajoute ça ici
        $sql = "SELECT * FROM signalement WHERE id_signalement = :id_signalement";
        $req = $db->prepare($sql);
        $req->bindValue(':id_signalement', $id_signalement);
        $req->execute();
        return $req->fetch();
    }

    public function afficherSignalements() {
        $db = config::getConnection();
        try {
            $query = $db->query("SELECT * FROM signalement");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->showMessage('danger', '❌ Erreur: '.htmlspecialchars($e->getMessage()));
            return [];
        }
    }
}
?>
