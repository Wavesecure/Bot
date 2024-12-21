<?php
// Récupérer les données envoyées par JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$name = $data['name'];
$message = $data['message'];

// Token du bot Telegram
$token = '7942341902:AAH-Es10Dc5KgSL6pJpyhMHFzFQvZMsL_HM';
$chatId = '6970748370';  // Remplacez par l'ID du chat ou votre propre configuration

// Créer le message à envoyer avec des émojis
$telegramMessage = "💬 **Message du Service Chat Leboncoin** :\n\n";
$telegramMessage .= "✉️ **Email** : $email\n";
$telegramMessage .= "🧑‍💼 **Nom** : $name\n";
$telegramMessage .= "💬 **Message** : $message\n";

// URL de l'API Telegram
$apiUrl = "https://api.telegram.org/bot$token/sendMessage";

// Préparer les paramètres de la requête
$params = [
    'chat_id' => $chatId,
    'text' => $telegramMessage,
    'parse_mode' => 'Markdown',  // Pour activer la mise en forme (gras, italique)
];

// Effectuer la requête POST à l'API Telegram
$response = file_get_contents($apiUrl . '?' . http_build_query($params));

// Retourner une réponse JSON pour le JavaScript
echo json_encode(['status' => 'success', 'response' => $response]);
?>