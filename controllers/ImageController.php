<?php


class ImageController
{
    public function __construct()
    {
    }

    public function upload($image)
    {
        $response = array();
        $target_dir = "./img/";
        $target_file = $target_dir . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $response['status'] = 'success';
            $response['message'] = 'La imagen ' . basename($image["name"]) . ' se guardó correctamente.';
            $response['imageUrl'] = 'http://localhost/Proyecto2_APIImages_PHP/' . substr($target_file, 2);
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Lo sentimos, hubo un error al subir la imagen.';
        }

        return $response;
    }



}


