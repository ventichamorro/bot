<?php
// Configuración con nuevo token
$token = '7470738316:AAGP8HJmV1KUbRdqw1SFB9L0lGhab-JTpMs';
$update = json_decode(file_get_contents('php://input'), true);

// Base de datos de productos (sin cambios)
$pasillos = [
    1 => ["carne", "queso", "jamón"],
    // ... (mantener misma estructura)
];

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = strtolower(trim($update["message"]["text"]));
    
    $response = "❌ Producto no encontrado. Prueba con: leche, pan...";
    
    foreach ($pasillos as $num => $productos) {
        if (in_array($text, $productos)) {
            $response = "📍 *$text* está en el *Pasillo $num*";
            break;
        }
    }
    
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($response)."&parse_mode=Markdown");
    exit;
}

echo "SuperBot (@bottelaiep_bot) activo! ".date('Y-m-d H:i:s');
?>
