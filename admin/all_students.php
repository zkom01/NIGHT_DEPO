<?php
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';
    
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení

   Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $students = StudentsDB::allStudents($conn, "id, first_name, second_name"); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
   
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
