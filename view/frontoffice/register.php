<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/UserController.php';

$error_messages = [];
$success_message = '';

$UserController = new UserController();

if (isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_messages[] = "Tous les champs sont obligatoires.";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $nom)) {
        $error_messages[] = "Le nom ne doit contenir que des lettres, espaces ou tirets.";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $prenom)) {
        $error_messages[] = "Le prénom ne doit contenir que des lettres, espaces ou tirets.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Veuillez entrer une adresse email valide.";
    }

    if (strlen($password) < 8) {
        $error_messages[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($password !== $password_confirm) {
        $error_messages[] = "Les mots de passe ne correspondent pas.";
    }

    if ($UserController->isEmailTaken($email)) {
        $error_messages[] = "Cet email est déjà utilisé.";
    }

    if (empty($error_messages)) {
        $user = new User(null, $nom, $prenom, $email, $password);
        $UserController->register($user);
        $success_message = "Inscription réussie.";
    }
}

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


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <style>
        .error {
            background-color: #ffe0e0;
            color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .error ul {
            margin: 0;
            padding-left: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }

        /* chat zoamra */
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
</head>
<body>

    <div class="form-container">
        <h2>Inscription</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?= isset($prenom) ? htmlspecialchars($prenom) : '' ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>

            <button type="submit" name="register">S'inscrire</button>
        </form>

        <?php if (!empty($error_messages)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($error_messages as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
            <script>
                const user = {
                    nom: <?= json_encode($nom) ?>,
                    prenom: <?= json_encode($prenom) ?>,
                    email: <?= json_encode($email) ?>,
                    role: 'user'
                };
                localStorage.setItem('user', JSON.stringify(user));
                setTimeout(() => {
                    window.location.href = 'home.html';
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="link-login">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
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
