<?php
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

switch ($method) {

    // ---------- GET: listar todos o uno por id ----------
    case 'GET':
        if ($id) {
            $stmt = $pdo->prepare("SELECT id, nombre, apePaterno, apeMaterno, user, estado FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                echo json_encode($usuario);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuario no encontrado"]);
            }
        } else {
            $stmt = $pdo->query("SELECT id, nombre, apePaterno, apeMaterno, user, estado FROM usuarios ORDER BY id DESC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    // ---------- POST: registrar ----------
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nombre']) || empty($data['apePaterno']) || empty($data['apeMaterno']) ||
            empty($data['user']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan campos obligatorios"]);
            break;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (nombre, apePaterno, apeMaterno, user, password, estado)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['nombre'],
            $data['apePaterno'],
            $data['apeMaterno'],
            $data['user'],
            hash('sha256', $data['password']),
            $data['estado'] ?? 1
        ]);

        http_response_code(201);
        echo json_encode(["mensaje" => "Usuario creado correctamente", "id" => $pdo->lastInsertId()]);
        break;

    // ---------- PUT: actualizar ----------
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Debe indicar el id del usuario (?id=)"]);
            break;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $campos = [];
        $valores = [];

        foreach (['nombre', 'apePaterno', 'apeMaterno', 'user', 'estado'] as $campo) {
            if (isset($data[$campo])) {
                $campos[] = "$campo = ?";
                $valores[] = $data[$campo];
            }
        }

        if (!empty($data['password'])) {
            $campos[] = "password = ?";
            $valores[] = hash('sha256', $data['password']);
        }

        if (empty($campos)) {
            http_response_code(400);
            echo json_encode(["error" => "No hay campos para actualizar"]);
            break;
        }

        $valores[] = $id;
        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($valores);

        echo json_encode(["mensaje" => "Usuario actualizado correctamente"]);
        break;

    // ---------- DELETE: eliminar ----------
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Debe indicar el id del usuario (?id=)"]);
            break;
        }

        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(["mensaje" => "Usuario eliminado correctamente"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
