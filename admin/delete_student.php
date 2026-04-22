<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';

    // Auth::requireLogin();
    Auth::requireAdmin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $id = $_GET['id']; // získáme ID studenta z URL
    $oneStudent = StudentsDB::getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $result = StudentsDB::deleteStudent($conn, $id); // zavoláme funkci pro smazání studenta z databáze a uložíme výsledek do proměnné $result
        Url::flashMessage($result,'error');
        Url::redirectUrl("../admin/all_students.php"); // přesměrujeme na stránku se seznamem studentů
        exit(); // ukončíme skript, aby se zabránilo dalšímu vykonávání kódu po přesměrování
    }
?>

<?php 
    $pageTitle = "Smazání studenta"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

<main>
    <section class='main_heading'>
        <h1>Smazání studenta</h1>
    </section>
 
    <section class="one_student_card">
        <?php if (is_array($oneStudent)): ?>
            <div class="text_container">
                <h2><?= htmlspecialchars($oneStudent['first_name']) . " " . htmlspecialchars($oneStudent['second_name']) ?></h2>
                <p>Věk: <?= htmlspecialchars($oneStudent['age']) ?></p>
                <p>Život: <?= htmlspecialchars($oneStudent['life']) ?></p>
                <p>Škola: <?= htmlspecialchars($oneStudent['college_name']) ?></p>
            </div>
            
            <form method="post">
                <section class="buttons-container">
                    <a href="../admin/one_student.php?id=<?= $id ?>" class="btn btn-primary">Ne, zpět</a>
                    <button type="submit" class="btn btn-secondary">Ano, smazat</button>
                </section>
            </form>
            
            
        <?php else: ?>
            <h2><?= htmlspecialchars($oneStudent) ?></h2>
                <section class="buttons-container">
                    <a href="../admin/all_students.php" class="btn btn-primary">Zpět na seznam studentů</a>
                <section>
        <?php endif ?>
    </section>

</main>

<?php require '../assets/footer.php'; ?>
