<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Si c’est une requête POST => traiter et quitter avant d’envoyer du HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non autorisé']);
        exit;
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!isset($data['message'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No message provided']);
        exit;
    }

    $message = trim($data['message']);

    // Google Gemini API
    $api_key = 'AIzaSyA3t5e4a6wl3VjZatdnDLBWfDi6xzPU-yo';
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $api_key;

    $request_data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => "Tu es un assistant pour un site web de listing de topics. Tu dois répondre en français. Question: " . $message]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur de connexion']);
        exit;
    }

    $result = json_decode($response, true);

    if ($http_code !== 200 || !isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        echo json_encode(['error' => 'Erreur API', 'debug' => $result]);
        exit;
    }

    echo json_encode(['response' => trim($result['candidates'][0]['content']['parts'][0]['text'])]);
    exit; // ✅ TRÈS IMPORTANT
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Assistant Topics</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; padding: 2rem; }
    #chat-box { max-width: 600px; margin: auto; background: white; padding: 1rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    textarea { width: 100%; height: 100px; margin-bottom: 1rem; padding: 10px; font-size: 16px; }
    button { padding: 10px 20px; background: #3498db; color: white; border: none; cursor: pointer; }
    button:hover { background: #2980b9; }
    #response { margin-top: 20px; white-space: pre-wrap; }
  </style>
</head>
<body>
  <div id="chat-box">
    <h2>Assistant Topics</h2>
    <textarea id="message" placeholder="Pose ta question ici..."></textarea>
    <button onclick="sendMessage()">Envoyer</button>
    <div id="response"></div>
  </div>

  <script>
    async function sendMessage() {
      const message = document.getElementById("message").value.trim();
      if (!message) {
        alert("Veuillez entrer un message.");
        return;
      }

      const responseDiv = document.getElementById("response");
      responseDiv.textContent = "Chargement...";

      try {
        const res = await fetch("", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ message })
        });

        const data = await res.json();
        responseDiv.textContent = data.response || "Erreur : " + (data.error || "inconnue");
        console.log(data);
      } catch (err) {
        responseDiv.textContent = "Erreur de connexion au serveur.";
        console.error(err);
      }
    }
  </script>
</body>
</html>
