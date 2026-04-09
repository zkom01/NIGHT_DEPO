<?php
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';

    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě

    Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $id = $_GET['id']; // získáme ID studenta z URL
    $oneStudent = StudentsDB::getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $result = StudentsDB::deleteStudent($conn, $id); // zavoláme funkci pro smazání studenta z databáze a uložíme výsledek do proměnné $result
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = [
                    'text' => $result,
                    'type' => 'error'
                ]; // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na další stránce
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
 
    <section class="align_left">
        <?php if (is_array($oneStudent)): ?>
            <section class="buttons-container">
                <form method="post" style="display: flex; gap: 20px;">
                        <a href="../admin/one_student.php?id=<?= $id ?>" class="btn btn-primary">Ne, zpět</a>
                        <button type="submit" class="btn btn-secondary">Ano, smazat</button>
                </form>
            </section>

            <h2><?= htmlspecialchars($oneStudent['first_name']) . " " . htmlspecialchars($oneStudent['second_name']) ?></h2>
            <p>Věk: <?= htmlspecialchars($oneStudent['age']) ?></p>
            <p>Život: <?= htmlspecialchars($oneStudent['life']) ?></p>
            <p>Škola: <?= htmlspecialchars($oneStudent['college']) ?></p>
        <?php else: ?>
            <p>"Student s ID <?= htmlspecialchars($id) ?> nebyl nalezen v databázi."</p>
            <a href="../admin/all_students.php" class="btn btn-primary">Zpět na seznam studentů</a>
        <?php endif ?>
    </section>

</main>

<?php require '../assets/footer.php'; ?>
