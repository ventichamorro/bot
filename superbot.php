<?php
// Debug: Registrar todas las solicitudes
file_put_contents('debug.log', "=== NEW REQUEST ===\n".date('Y-m-d H:i:s')."\nHeaders:\n".print_r(getallheaders(), true)."\nBody:\n".file_get_contents('php://input')."\n\n", FILE_APPEND);

$token = '7733844661:AAHk33WFeLAy5zT4NayupGXx3yecXIcSGZY';

// Respuesta inmediata para health checks
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "🤖 @botnuevotelegramaiep3_bot operativo | ".date('Y-m-d H:i:s');
    exit;
}

$update = json_decode(file_get_contents('php://input'), true);

if (!$update) {
    file_put_contents('error.log', "Datos no recibidos de Telegram\n", FILE_APPEND);
    header('HTTP/1.1 400 Bad Request');
    exit;
}

// Base de datos de pasillos
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
    
    $response = "❌ Producto no encontrado. Prueba con: leche, pan, carne...";
    
    foreach ($pasillos as $num => $productos) {
        if (in_array($text, $productos)) {
            $response = "📍 *$text* está en el *Pasillo $num*";
            break;
        }
    }
    
    // Enviar respuesta
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = ['chat_id' => $chat_id, 'text' => $response, 'parse_mode' => 'Markdown'];
    
    file_put_contents('response.log', "Enviando a Telegram: ".print_r($data, true)."\n", FILE_APPEND);
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    echo "Mensaje enviado a Telegram";
    exit;
}

echo "Esperando comandos válidos de Telegram";
?>