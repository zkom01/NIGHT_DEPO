<?php
    session_start(); // pro přístup k $_SESSION
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php'; 
    require '../classes/Url.php';

    Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // získáme a validujeme id z URL
    if (!$id || $id <= 0) {
        Url::flashMessage('Neplatné ID studenta.', 'error');
        Url::redirectUrl('../admin/all_students.php');
        exit;
    }
    $oneStudent = StudentsDB::getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent
    
    if (!is_array($oneStudent)) {
        Url::flashMessage($oneStudent,'error');// Uložíme do session zprávu o nenalezení studenta, aby se zobrazila na stránce s detaily studenta
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

    <section class="one_student_card">
        <div class="text_container">
            <?php if (is_array($oneStudent)): ?>
                <h2><?= htmlspecialchars($oneStudent['first_name']) . " " . htmlspecialchars($oneStudent['second_name']) ?></h2>
                <p>Věk: <?= htmlspecialchars($oneStudent['age']) ?></p>
                <p>Život: <?= htmlspecialchars($oneStudent['life']) ?></p>
                <p>Škola: <?= htmlspecialchars($oneStudent['college_name']) ?></p>
            <?php endif ?>
        </div>
        <?php if (is_array($oneStudent)): ?>
            <section class="buttons-container">
                <?php if ($_SESSION['role_user_log_in']==="admin"):?>
                    <a href="edit_student.php?id=<?= $id ?>" class="btn btn-primary">Upravit žáka</a>
                    <a href="delete_student.php?id=<?= $id ?>" class="btn btn-secondary">Smazat žáka</a>
                <?php endif ?>
                <a href="all_students.php" class="btn btn-primary">Seznam žáků</a>
            </section>
        <?php else: ?>
            <section class="buttons-container">
                <a href="all_students.php" class="btn btn-primary">Zpět na seznam studentů</a>
            </section>
        <?php endif ?>
    </section>

</main>

<?php require '../assets/footer.php'; ?> <!-- přidáme patičku stránky -->