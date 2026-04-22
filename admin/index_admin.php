<?php 
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/Url.php';
    
    Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $id = $_SESSION['log_in_user_id'];
    $loginUser = UserDB::infoUser($conn,$id);
?>

<?php 
    $pageTitle = "Úvodní strana"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

    <?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main class="index">
        <section>
            <img src="../img/ela_kruh.png" alt="">
            <h1>NIGHT_DEPO</h1>
            <h2>Přihlášen: <?= htmlspecialchars($loginUser['data']['first_name']) ?> <?= htmlspecialchars($loginUser['data']['second_name']) ?> id: <?= htmlspecialchars($loginUser['data']['id']) ?></h2><br>
            
        </section>
    </main>

<?php require '../assets/footer.php';  ?> <!-- přidáme patičku stránky -->