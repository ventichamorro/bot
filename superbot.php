<?php
// Configuración de encabezados para evitar caché
header("Content-Type: application/json");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Token de tu bot (obtenido de @BotFather)
$token = '7733844661:AAHk33WFeLAy5zT4NayupGXx3yecXIcSGZY';

// Registro de logs para depuración
$log_data = date('Y-m-d H:i:s')." | ".json_encode($_SERVER)."\nInput: ".file_get_contents('php://input')."\n\n";
file_put_contents('telegram.log', $log_data, FILE_APPEND);

// Verificar si es una solicitud POST de Telegram
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update = json_decode(file_get_contents('php://input'), true);
    
    if (!$update) {
        http_response_code(400);
        die(json_encode(['status' => 'error', 'message' => 'Datos no válidos']));
    }

    // Base de datos de productos
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
        
        // Enviar respuesta a Telegram
        $telegram_url = "https://api.telegram.org/bot$token/sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $response,
            'parse_mode' => 'Markdown'
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($telegram_url, false, $context);
        
        die(json_encode(['status' => 'success']));
    }
}

// Respuesta para health checks y pruebas
die(json_encode([
    'status' => 'ready',
    'bot' => '@botnuevotelegramaiep3_bot',
    'server_time' => date('Y-m-d H:i:s')
]));
?>