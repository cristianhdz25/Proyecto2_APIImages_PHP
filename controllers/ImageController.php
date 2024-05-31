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
            $response['message'] = 'The file ' . basename($image["name"]) . ' has been uploaded.';
            $response['imageUrl'] = $target_file;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sorry, there was an error uploading your file.';
        }

       return $response;
    }

    function get_images($target_dir) {
        $images = array();
        if (is_dir($target_dir)) {
            if ($dh = opendir($target_dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        $images[] = $target_dir . $file;
                    }
                }
                closedir($dh);
            }
        }
        return $images;
    }



}


