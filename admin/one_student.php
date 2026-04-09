<?php
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php'; 
    require '../classes/Url.php';

    session_start(); // pro přístup k $_SESSION

    if ( !Auth::isLoggedIn($_SESSION['is_log_in']) ){
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $id = $_GET['id']; // získáme id z URL
    $oneStudent = StudentsDB::getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent
    
    if (!is_array($oneStudent)) {
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = [
                'text' => $oneStudent,
                'type' => 'error'
            ]; // Uložíme do session zprávu o nenalezení studenta, aby se zobrazila na stránce s detaily studenta
    }
    
?>

<?php 
    $pageTitle = "Detail studenta"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section  class='main_heading'>
        <h1>Informace o&nbsp;studentovi</h1>
    </section>

    <section class="align_left">
        <?php if (is_array($oneStudent)): ?>
            <h2><?= htmlspecialchars($oneStudent['first_name']) . " " . htmlspecialchars($oneStudent['second_name']) ?></h2>
            <p>Věk: <?= htmlspecialchars($oneStudent['age']) ?></p>
            <p>Život: <?= htmlspecialchars($oneStudent['life']) ?></p>
            <p>Škola: <?= htmlspecialchars($oneStudent['college']) ?></p>

            <section class="buttons-container">
                <a href="edit_student.php?id=<?= $id ?>" class="btn btn-primary">Upravit žáka</a>
                <a href="delete_student.php?id=<?= $id ?>" class="btn btn-secondary">Smazat žáka</a>
                <a href="all_students.php" class="btn btn-primary">Seznam žáků</a>
            </section>

        <?php else: ?>
            <p>"Student s ID <?= htmlspecialchars($id) ?> nebyl nalezen v databázi."</p>
            <a href="all_students.php" class="btn btn-primary">Zpět na seznam studentů</a>
        <?php endif ?>
    </section>

</main>

<?php require '../assets/footer.php'; ?>
