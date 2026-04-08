<?php 
    // require '../assets/auth.php'; // ověření přihlášení uživatele
    require '../classes/Auth.php';
    // require '../assets/database.php'; // připojíme se k databázi
    require '../classes/Database.php'; // načteme soubor s funkcemi pro práci s databází
    // require '../assets/userDB.php';
    require '../classes/UserDB.php';
    // require '../assets/url.php';
    require '../classes/Url.php';

    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení

    if ( !Auth::isLoggedIn($_SESSION['is_log_in']) ){
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    // $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $id = $_SESSION['log_in_user_id'];
    $loginUser = UserDB::infoUser($conn,$id);
?>

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<?php 
    $pageTitle = "Úvodní strana"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

    <main class="index">
        <section>
            <img src="../img/ela_kruh.png" alt="">
            <h1>NIGHT_DEPO</h1>
            <h2>Přihlášen: <?= htmlspecialchars($loginUser['data']['first_name']) ?> <?= htmlspecialchars($loginUser['data']['second_name']) ?> id: <?= htmlspecialchars($loginUser['data']['id']) ?></h2>
        </section>
    </main>

<?php require '../assets/footer.php';  ?> <!-- přidáme patičku stránky -->