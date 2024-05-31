<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

$endpoint = $_GET['endpoint'] ?? '';

$response = array();
$target_dir = "/img";
$target_file = $target_dir . basename($_FILES["image"]["name"]);


if ($_POST['METHOD'] === 'POST') {
    $response['status'] = 'onloading';
    if (isset($_FILES["image"])) {
        require_once 'controllers/ImageController.php';
        $imageController = new ImageController();
        $image = $_FILES["image"];
        $response = $imageController->upload($image);
    }else{
        $response['status'] = 'error';
        $response['message'] = 'Sorry, there was an error uploading your file.';
    
    }
    echo json_encode($response);
    header("HTTP/1.1 200 OK");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once 'controllers/ImageController.php';
    $imageController = new ImageController();
    $images = $imageController->get_images($target_dir);
    echo json_encode($images);
}

header("HTTP/1.1 400 Bad Request");

