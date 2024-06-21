<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Mostrar errores (solo para desarrollo; eliminar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../config/database.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['nombre'], $input['delegacion'], $input['email'], $input['password'])) {
        echo json_encode(['message' => 'Datos incompletos']);
        exit;
    }

    $nombre = $input['nombre'];
    $delegacion = $input['delegacion'];
    $email = $input['email'];
    $password = password_hash($input['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nombre, delegacion, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nombre, $delegacion, $email, $password])) {
        echo json_encode([
            'message' => "$nombre registrado exitosamente",
            'email' => $email
        ]);
    } else {
        echo json_encode(['message' => "Error al registrar $nombre"]);
    }
} catch (\Exception $e) {
    // Manejar cualquier excepción y devolver un mensaje de error JSON
    echo json_encode(['message' => "Error del servidor: " . $e->getMessage()]);
}
?>