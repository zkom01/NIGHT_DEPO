<?php
    require '../assets/auth.php'; // ověření přihlášení uživatele
    require '../assets/database.php'; // připojíme se k databázi
    require '../assets/studentsDB.php'; 
    require '../assets/url.php'; // načteme soubor s funkcí pro přesměrování
    session_start(); // Opět nutné pro přístup k $_SESSION

    if ( !isLoggedIn($_SESSION['is_log_in']) ){
        session_regenerate_id(true); // zabranuje provedení fixation attack
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $id = $_GET['id']; // získáme id z URL
    $oneStudent = getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent
    
    $error = ""; // proměnná pro třídu hlášky, která se použije v případě nenalezení studenta
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
