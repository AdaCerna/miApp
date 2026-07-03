<?php
// Cabeceras CORS para que el frontend (React) pueda consumir la API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Responder rápido a las peticiones preflight (OPTIONS) del navegador
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Variables de entorno definidas en docker-compose.yml
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'bd_ventas';
$user = getenv('DB_USER') ?: 'ventas_user';
$pass = getenv('DB_PASS') ?: 'ventas_pass';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
    exit();
}
