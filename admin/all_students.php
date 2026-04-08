<?php
    require '../assets/auth.php'; // ověření přihlášení uživatele
    require '../assets/database.php'; // připojíme se k databázi
    require '../assets/studentsDB.php'; 
    require '../assets/url.php'; // funkce pro přesměrování
    
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení

    if ( !isLoggedIn($_SESSION['is_log_in']) ){
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $students = allStudents($conn, "id, first_name, second_name"); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
   
?>

<?php 
    $pageTitle = "Seznam žáků"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section class="main_heading">
            <h1>Žáci</h1>
        </section>

        <section class="align_left">
            <ul>

            <?php foreach ($students as $one_student): ?>
                <li>
                    <?= htmlspecialchars($one_student['first_name']) . " " . htmlspecialchars($one_student['second_name']) ?>
                </li>
                <a href="one_student.php?id=<?= $one_student['id'] ?>" class="btn btn-primary">Detail</a>
            <?php endforeach; ?>

            </ul>           
        </section>
    </main>

<?php require '../assets/footer.php'; ?>
