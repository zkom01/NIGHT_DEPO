<?php
require '../classes/Auth.php';
require '../classes/Database.php';
require '../classes/UserDB.php';
require '../classes/Url.php';

session_start(); // spustíme session pro správu uživatelských relací

    Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $id = $_SESSION['log_in_user_id'];


    $loginUser = UserDB::infoUser($conn,$id);


?>

<?php 
    $pageTitle = "Photos"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section  class='main_heading'>
        <h1>Photos</h1>
    </section>

    <section class="align_left">
        <h2>Přihlášen: <?= htmlspecialchars($loginUser['data']['first_name']) ?> <?= htmlspecialchars($loginUser['data']['second_name']) ?><br>id: <?= htmlspecialchars($loginUser['data']['id']) ?><br>email: <?= htmlspecialchars($loginUser['data']['email']) ?></h2>
    </section>

</main>

<?php require '../assets/footer.php'; ?>