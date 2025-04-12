<?php
// Registro de logs para diagnóstico
file_put_contents('requests.log', date('Y-m-d H:i:s')." - ".file_get_contents('php://input')."\n", FILE_APPEND);

$token = '7470738316:AAGP8HJmV1KUbRdqw1SFB9L0lGhab-JTpMs';
$update = json_decode(file_get_contents('php://input'), true);

// Base de datos de pasillos
$pasillos = [
    1 => ["carne", "queso", "jamón"],
    2 => ["leche", "yogurth", "cereal"],
    3 => ["bebidas", "jugos"],
    4 => ["pan", "pasteles", "tortas"],
    5 => ["detergente", "lavaloza"]
];

if ($update && isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = strtolower(trim($update["message"]["text"]));
    
    $response = "❌ Producto no encontrado. Prueba con: leche, pan, carne...";
    
    foreach ($pasillos as $num => $productos) {
        if (in_array($text, $productos)) {
            $response = "📍 *$text* está en el *Pasillo $num*";
            break;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(['method' => 'sendMessage', 'text' => $response]);
    exit;
}

// Respuesta para pings de Render/Telegram
echo "🤖 @bottelaiep_bot activo | ".date('Y-m-d H:i:s');
?>