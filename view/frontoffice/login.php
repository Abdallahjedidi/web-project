<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/usercontroller.php';
 // chat zomara
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat_message'])) {
    header('Content-Type: application/json');

    $message = trim($_POST['chat_message']);
    if (empty($message)) {
        echo json_encode(['error' => 'Message vide']);
        exit;
    }

    // Appel API Gemini
    $api_key = 'AIzaSyA3t5e4a6wl3VjZatdnDLBWfDi6xzPU-yo';
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $api_key;

    $request_data = [
        'contents' => [
            ['parts' => [['text' => $message]]]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Erreur de réponse';

    echo json_encode(['response' => $reply]);
    exit;
}



//chat zomara



















$conn = Config::getConnection();
$error_message = '';
$success_message = '';

$UserController = new UserController();

if (isset($_POST['login'])) {
    $email = trim($_POST['email_login']);
    $password = $_POST['password_login'];

    if (empty($email) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs de connexion.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Veuillez entrer une adresse email valide.";
    } elseif (strlen($password) < 8) {
        $error_message = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $user = $UserController->getOneUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Démarrage session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_nom'] = $user['nom'];

            // Génération d'un token simple avec expiration dans 5 minutes
            $expiration = time() + 300; // 5 minutes
            $token = base64_encode($user['id'] . '|' . $expiration . '|' . bin2hex(random_bytes(10)));

            // Préparer les données utilisateur à stocker dans localStorage
            $userData = [
                'id'         => $user['id'],
                'nom'        => $user['nom'],
                'prenom'     => $user['prenom'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'token'      => $token,
                'expires_at' => $expiration
            ];

            $userJson = json_encode($userData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

            // Mise à jour du login_count à chaque connexion réussie
    $updateLoginCountSql = "UPDATE users SET login_count = login_count + 1 WHERE id = :id";
    $stmtUpdate = $conn->prepare($updateLoginCountSql);
    $stmtUpdate->bindValue(':id', $user['id'], PDO::PARAM_INT);
    $stmtUpdate->execute();

            // Enregistrement de l'activité dans l'historique
            $ip_address = $_SERVER['REMOTE_ADDR'];  // Adresse IP de l'utilisateur
            $activity_type = 'Connexion';
            $activity_description = "Utilisateur connecté avec succès.";
            
            // Enregistrer l'historique dans la base de données
            $sql = "INSERT INTO user_activity (user_id, activity_type, activity_description, ip_address) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $activity_type, PDO::PARAM_STR);
            $stmt->bindValue(3, $activity_description, PDO::PARAM_STR);
            $stmt->bindValue(4, $ip_address, PDO::PARAM_STR);
            $stmt->execute();

            // Redirection en fonction du rôle de l'utilisateur
            if ($user['role'] === 'admin') {
                echo "<script>
                        localStorage.setItem('user', '" . $userJson . "');
                        window.location.href = '../../view/backoffice/index.php';
                      </script>";
            } else {
                echo "<script>
                        localStorage.setItem('user', '" . $userJson . "');
                        window.location.href = 'home.html';
                      </script>";
            }
            exit;
        } else {
            // Si le mot de passe est incorrect ou l'utilisateur n'existe pas
            $error_message = "Email ou mot de passe incorrect.";

            // Enregistrer l'historique d'une tentative de connexion échouée
            $ip_address = $_SERVER['REMOTE_ADDR'];  // Adresse IP de l'utilisateur
            $activity_type = 'Échec de connexion';
            $activity_description = "Tentative de connexion échouée.";

            $sql = "INSERT INTO user_activity (user_id, activity_type, activity_description, ip_address) 
            VALUES (?, ?, ?, ?)";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $activity_type, PDO::PARAM_STR);
            $stmt->bindValue(3, $activity_description, PDO::PARAM_STR);
            $stmt->bindValue(4, $ip_address, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    
</head>
<body>
<style>
  #chat-icon {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background-color: #007bff;
  color: white;
  font-size: 28px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  transition: background-color 0.3s ease;
}
#chat-icon:hover {
  background-color: #0056b3;
}

/* Fenêtre du chatbot */
#chat-window {
  position: fixed;
  bottom: 100px;
  right: 25px;
  width: 320px;
  max-height: 450px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
  display: none;
  flex-direction: column;
  overflow: hidden;
  z-index: 1000;
}

/* Zone des messages */
#chat-messages {
  flex: 1;
  padding: 12px;
  overflow-y: auto;
  font-size: 14px;
  line-height: 1.4;
  max-height: 300px;
  border-bottom: 1px solid #ccc;
}

/* Zone de saisie */
#chat-input {
  display: flex;
  border-top: 1px solid #ccc;
}

#chat-input input {
  flex: 1;
  padding: 10px;
  border: none;
  outline: none;
  font-size: 14px;
}

#chat-input button {
  padding: 10px 15px;
  border: none;
  background-color: #007bff;
  color: white;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}
#chat-input button:hover {
  background-color: #0056b3;
}

/* Messages personnalisés */
#chat-messages div {
  margin-bottom: 10px;
}
#chat-messages strong {
  color: #007bff;
}
 #chatbtn {
    width: 30%;
 }
</style>
    <div class="form-container">
        <h2>Connexion</h2>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email_login">Email</label>
                <input type="email" name="email_login" id="email_login" placeholder="ex: nom@domaine.com">
            </div>

            <div class="form-group">
                <label for="password_login">Mot de passe</label>
                <input type="password" name="password_login" id="password_login" placeholder="••••••••">
            </div>

            <button type="submit" name="login">Se connecter</button>
            <a href="forgot_password.php">Mot de passe oublié ?</a>

        </form>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>

        <div class="link-register">
            Pas encore inscrit ? <a href="register.php">Créer un compte</a>
        </div>
    </div>
    <!-- el chatzomara -->
    <div id="chat-icon" onclick="toggleChat()">💬</div>

<div id="chat-window">
  <div id="chat-messages"></div>
  <form id="chat-form" onsubmit="return sendChatMessage();">
    <div id="chat-input">
      <input type="text" id="chat-message" placeholder="Votre question..." autocomplete="off" />
      <button type="submit" id="chatbtn">Envoyer</button>
    </div>
  </form>
</div>

    <script>
function toggleChat() {
  const chatWindow = document.getElementById('chat-window');
  chatWindow.style.display = (chatWindow.style.display === 'flex') ? 'none' : 'flex';
}

function sendChatMessage() {
  const input = document.getElementById('chat-message');
  const message = input.value.trim();
  if (!message) return false;

  const messagesDiv = document.getElementById('chat-messages');
  messagesDiv.innerHTML += `<div><strong>Vous :</strong> ${message}</div>`;
  input.value = "";

  fetch("", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "chat_message=" + encodeURIComponent(message)
  })
  .then(res => res.json())
  .then(data => {
    messagesDiv.innerHTML += `<div><strong>Bot :</strong> ${data.response}</div>`;
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  })
  .catch(err => {
    messagesDiv.innerHTML += `<div><strong>Bot :</strong> Erreur serveur</div>`;
  });

  return false;
}
</script>

</body>

</html>
