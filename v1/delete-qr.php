<?php
require '../config/cors.php';
require '../vendor/autoload.php';
require '../config/database.php';

$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];

$sql = "DELETE FROM qr_codes WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$id])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['message' => 'Código QR eliminado exitosamente']);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['message' => 'Error al eliminar código QR']);
}
?>