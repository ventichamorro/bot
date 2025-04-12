<?php
$token = "7849122552:AAEofxNhxl8h7Qo8LWsAYttuRZ2bdBLYcG0";
$update = json_decode(file_get_contents("php://input"), true);

$chat_id = $update["message"]["chat"]["id"];
$text = strtolower(trim($update["message"]["text"]));

// Base de datos de productos
$pasillos = [
    1 => ["carne", "queso", "jamón"],
    2 => ["leche", "yogurth", "cereal"],
    3 => ["bebidas", "jugos"],
    4 => ["pan", "pasteles", "tortas"],
    5 => ["detergente", "lavaloza"]
];

$response = "❌ Producto no encontrado. Prueba con: carne, leche, pan...";

foreach ($pasillos as $num => $productos) {
    if (in_array($text, $productos)) {
        $response = "📍 *$text* está en el *Pasillo $num*";
        break;
    }
}

// Enviar respuesta con formato Markdown
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($response)."&parse_mode=Markdown");
?>