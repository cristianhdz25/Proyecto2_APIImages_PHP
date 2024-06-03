<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
$endpoint = $_GET['endpoint'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($endpoint === 'images' && isset($_GET['targetDir'])) {
        require_once 'controllers/ImageController.php';
        $imageController = new ImageController();
        $targetDir = $_GET['targetDir'];
        $imagePath = $imageController->getImageByFilePath($targetDir);

        echo json_encode(['imageUrl' => $imagePath]);

        if ($imagePath !== null && file_exists($imagePath)) {
            // Detectar el tipo de imagen y establecer la cabecera correcta
            $imageInfo = getimagesize($imagePath);
            if ($imageInfo === false) {
                header("HTTP/1.1 500 Internal Server Error");
                echo json_encode(['error' => 'Error al obtener información de la imagen']);
                exit();
            }

            header("Content-Type: " . $imageInfo['mime']);
            header("Content-Length: " . filesize($imagePath));
            header("HTTP/1.1 200 OK");

            // Leer y enviar el contenido del archivo de imagen
            readfile($imagePath);
            exit();
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['error' => 'Image not found']);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

if ($_POST['METHOD'] === 'POST') {
    $response['status'] = 'onloading';
    if (isset($_FILES["image"])) {
        require_once 'controllers/ImageController.php';
        $imageController = new ImageController();
        $image = $_FILES["image"];
        $response = $imageController->upload($image);
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Sorry, there was an error uploading your file.';

    }
    echo json_encode($response);
    header("HTTP/1.1 200 OK");
    exit();
}



header("HTTP/1.1 400 Bad Request");

