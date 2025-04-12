<?php
// Registra todas las solicitudes entrantes
file_put_contents('telegram.log', print_r($_SERVER, true)."\n\n".file_get_contents('php://input'), FILE_APPEND);

$token = '7470738316:AAGP8HJmV1KUbRdqw1SFB9L0lGhab-JTpMs';
$update = json_decode(file_get_contents('php://input'), true);

if (!$update) {
    // Respuesta para pings de Render
    echo "Bot activo. Esperando datos de Telegram...";
    exit;
}

$token = '7470738316:AAGP8HJmV1KUbRdqw1SFB9L0lGhab-JTpMs';
$update = json_decode(file_get_contents('php://input'), true);

$pasillos = [
    1 => ["carne", "queso", "jamón"],
    2 => ["leche", "yogurth", "cereal"],
    3 => ["bebidas", "jugos"],
    4 => ["pan", "pasteles", "tortas"],
    5 => ["detergente", "lavaloza"]
];

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = strtolower(trim($update["message"]["text"]));
    
    $response = "❌ Producto no reconocido. Prueba con: leche, pan, carne...";
    
    foreach ($pasillos as $num => $productos) {
        if (in_array($text, $productos)) {
            $response = "📍 *$text* está en el *Pasillo $num*";
            break;
        }
    }
    
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($response)."&parse_mode=Markdown");
    exit;
}

echo "🤖 @bottelaiep_bot activo | ".date('Y-m-d H:i:s');
?>
