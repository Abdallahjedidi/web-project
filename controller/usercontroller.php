<?php
// Importation de PHPMailer au début du fichier
require '../../PHPMailer/src/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../../config.php';
include_once '../../model/User.php';

class UserController
{
    public function register(User $user)
    {
        // Vérification des champs non vides
        if (empty($user->getNom()) || empty($user->getPrenom()) || empty($user->getEmail()) || empty($user->getPassword())) {
            echo "Tous les champs doivent être remplis.";
            return;
        }

        if ($this->isEmailTaken($user->getEmail())) {
            echo "L'email est déjà utilisé.";
            return;
        }

        $db = config::getConnection();

        if (!$user->getRole()) {
            $user->setRole('user'); 
        }

        $sql = "INSERT INTO users (nom, prenom, email, password, role)
                VALUES (:nom, :prenom, :email, :password, :role)";
        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([
                ':nom' => $user->getNom(),
                ':prenom' => $user->getPrenom(),
                ':email' => $user->getEmail(),
                ':password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
                ':role' => $user->getRole(),
            ]);
            echo "Utilisateur enregistré avec succès !";
        } catch (PDOException $e) {
            die("Erreur inscription : " . $e->getMessage());
        }
    }

    public function isEmailTaken($email)
    {
        $db = config::getConnection();
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email);
        try {
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            die("Erreur vérification email : " . $e->getMessage());
        }
    }

    public function getAllRegularUsers()
    {
        $db = config::getConnection();
        $sql = "SELECT * FROM users WHERE role = 'user'";
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur récupération des utilisateurs : " . $e->getMessage());
        }
    }

    public function getOneUser($id)
    {
        $db = config::getConnection();
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur récupération de l'utilisateur : " . $e->getMessage());
        }
    }

    public function getOneUserByEmail($email)
    {
        $db = config::getConnection();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email);
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur récupération de l'utilisateur par email : " . $e->getMessage());
        }
    }

    public function updateUserp(User $user) {
        $db = config::getConnection(); 
        $query = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':id' => $user->getId(),
            ':nom' => $user->getNom(),
            ':prenom' => $user->getPrenom(),
            ':email' => $user->getEmail()
        ]);
    }

    public function updateUser($data) {
        $db = config::getConnection(); 
        $query = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':id' => $data['id'],
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email']
        ]);
    }
    
    public function deleteUser($id)
    {
        $db = config::getConnection();
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);

        try {
            $stmt->execute();
            echo "Utilisateur supprimé avec succès !";
        } catch (PDOException $e) {
            die("Erreur suppression : " . $e->getMessage());
        }
    }

    // Ajout de la méthode de réinitialisation de mot de passe
    public function resetPassword($email)
    {
        // Vérifier si l'email existe dans la base de données
        $user = $this->getOneUserByEmail($email);
        if ($user) {
            // Générer un mot de passe aléatoire
            $newPassword = $this->generateRandomPassword(8); // Tu peux ajuster la longueur ici
    
            // Mettre à jour le mot de passe dans la base de données
            $this->updateUserPassword($email, $newPassword);
    
            return "Votre mot de passe a été réinitialisé avec succès. Nouveau mot de passe : " . $newPassword;
        } else {
            return "Cet email n'existe pas dans nos enregistrements.";
        }
    }
    
    // Fonction pour mettre à jour le mot de passe
    public function updateUserPassword($email, $newPassword)
    {
        $db = config::getConnection();
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_DEFAULT), // Hashage du mot de passe pour la sécurité
            ':email' => $email
        ]);
    }

    // Fonction pour générer un mot de passe aléatoire
    public function generateRandomPassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }
}

?>
