<?php
// Registro de solicitudes para depuración
file_put_contents('requests.log', date('Y-m-d H:i:s')." - ".file_get_contents('php://input')."\n", FILE_APPEND);

$token = '7733844661:AAHk33WFeLAy5zT4NayupGXx3yecXIcSGZY';
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
    
    // Enviar respuesta
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($response)."&parse_mode=Markdown");
    exit;
}

// Respuesta para pings
echo "🤖 @botnuevotelegramaiep3_bot activo | ".date('Y-m-d H:i:s');
?>