
<?php
require '../config/database.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

$targetDir = "../images/users/";
$response = [];

// Verificar si se ha enviado una imagen
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Tipos de archivos permitidos
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Insertar la referencia en la base de datos
            
            $userId = 1; // Cambiar esto según tu lógica para obtener el ID del usuario
            $sql = "UPDATE users SET image_url = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$targetFilePath, $userId]);

            $response = [
                'status' => 'success',
                'message' => 'Imagen subida y guardada correctamente.',
                'image_url' => $targetFilePath
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al subir la imagen.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Formato de imagen no permitido.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'No se ha enviado ninguna imagen.'];
}

echo json_encode($response);
?>

