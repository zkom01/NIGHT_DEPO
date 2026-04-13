<?php
session_start(); // spustíme session pro správu uživatelských relací
require '../classes/Auth.php';
require '../classes/Database.php';
require '../classes/UserDB.php';
require '../classes/Url.php';

    Auth::requireLogin();

    $id = $_SESSION['log_in_user_id'];

    if(isset($_POST["submit"]) && isset($_FILES["image"])){

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

        $image_name = $_FILES["image"]["name"];
        $image_size = $_FILES["image"]["size"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $image_error = $_FILES["image"]["error"];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // vytáhne koncovku souboru
        $allowed_extension = ["jpg", "jpeg", "gif", "webp", "png"];

        if ($image_error === 0){
            if ($image_size > 9000000){
                Url::flashMessage('Soubor je příliš veliký, max. 9Mb.','error');
                Url::redirectUrl("../admin/photos.php");
                exit();

            } else {
                if (in_array($image_extension, $allowed_extension)){
                    
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

<?php 
    $pageTitle = "After Photos"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section>
        <h1>stranka pro odeslání photo</h1>
    </section>
    <section  class='align_left'>
        <p>Název souboru: <?= $image_name?></p>
        <p>Velikost souboru: <?= $image_size?></p>
        <p>Umístění souboru: <?= $image_tmp_name?></p>
        <p>Error: <?= $image_error?></p>
        <p>Koncovka souboru: <?= $image_extension?></p>
    </section>

</main>

<?php require '../assets/footer.php'; ?>