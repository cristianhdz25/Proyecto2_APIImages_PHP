<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
$endpoint = $_GET['endpoint'] ?? '';

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
        $response['message'] = 'Lo sentimos, hubo un error al subir su imagen.';

    }
    echo json_encode($response);
    header("HTTP/1.1 200 OK");
    exit();
}



header("HTTP/1.1 400 Bad Request");

