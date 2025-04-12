<?php
$token = getenv('TELEGRAM_TOKEN') ?: '7849122552:AAEofxNhxl8h7Qo8LWsAYttuRZ2bdBLYcG0';
$update = json_decode(file_get_contents('php://input'), true);

// Respuesta a Telegram
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pasillos = [
        1 => ["carne", "queso", "jamón"],
        2 => ["leche", "yogurth", "cereal"],
        // ... (agrega el resto de tus pasillos)
    ];
    
    $text = strtolower(trim($update['message']['text']));
    $response = "❌ Producto no encontrado";
    
    foreach ($pasillos as $num => $productos) {
        if (in_array($text, $productos)) {
            $response = "📍 $text → Pasillo $num";
            break;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(['method' => 'sendMessage', 'text' => $response]);
    exit;
}

// Respuesta para pings del servidor
echo "Bot activo! " . date('Y-m-d H:i:s');
?>
