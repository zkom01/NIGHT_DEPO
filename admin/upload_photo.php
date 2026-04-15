<?php
session_start(); // spustíme session pro správu uživatelských relací
require '../classes/Auth.php';
require '../classes/Database.php';
require '../classes/PhotoDB.php';
require '../classes/Url.php';

    Auth::requireLogin();

    $user_id = $_SESSION['log_in_user_id'];

    if(isset($_POST["submit"]) && isset($_FILES["image"])){

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

        $image_name = $_FILES["image"]["name"];
        $image_size = $_FILES["image"]["size"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $image_error = $_FILES["image"]["error"];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // vytáhne koncovku souboru
        $allowed_extension = ["jpg", "jpeg", "gif", "webp", "png", "svg"];

        if ($image_error === 0){
            if ($image_size > 9000000){
                Url::flashMessage('Soubor je příliš veliký, max. 9Mb.','error');
                Url::redirectUrl("../admin/photos.php");
                exit();

            } else {
                if (in_array($image_extension, $allowed_extension)){
                    $new_image_name = uniqid("IMG_", true) . "." . $image_extension;

                    if(!file_exists("../uploads/" . $user_id)){
                        mkdir("../uploads/" . $user_id, 0777, true);
                    }
                    $image_upload_path = "../uploads/" . $user_id . "/" . $new_image_name;
                    move_uploaded_file($image_tmp_name, $image_upload_path);

                    $result = PhotoDB::addImg($conn, $user_id, $new_image_name);
                    if ($result) {
                        Url::flashMessage($result['message'], "success");
                        Url::redirectUrl("../admin/photos.php");
                        exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
                    }

                } else {
                    Url::flashMessage('Nepodporovaný typ souboru.','error');
                    Url::redirectUrl("../admin/photos.php");
                    exit();
                }
            }

        } else {
            Url::flashMessage('Chyba při nahrávání obrázku.','error');
            Url::redirectUrl("../admin/photos.php");
            exit();
        }
    }

?>