<?php
header("Content-Type: application/json; charset=UTF-8");
echo json_encode([
    "mensaje" => "API REST de usuarios - bd_ventas",
    "endpoints" => [
        "GET"    => "/api/usuarios.php  (listar) o /api/usuarios.php?id=1 (uno)",
        "POST"   => "/api/usuarios.php  (registrar)",
        "PUT"    => "/api/usuarios.php?id=1  (actualizar)",
        "DELETE" => "/api/usuarios.php?id=1  (eliminar)"
    ]
]);
