<?php
    require 'assets/database.php'; // připojíme se k databázi
    session_start(); // Opět nutné pro přístup k $_SESSION
    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $id = $_GET['id']; // získáme id z URL
    $oneStudent = getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent
    
    $error = ""; // proměnná pro třídu hlášky, která se použije v případě nenalezení studenta
    if (!is_array($oneStudent)) {
        $_SESSION['success_message'] = $oneStudent; // Uložíme do session zprávu o nenalezení studenta, aby se zobrazila na stránce s detaily studenta
        $error = "error"; // nastavíme proměnnou pro třídu hlášky na "error", aby se hláška zobrazila jako chybová
    }
    
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/message.css?v=2.7"> <!-- přidáme styl pro hlášky -->
    <title>one_student</title>
</head>
<body>

    <?php require 'assets/header.php'; ?> <!-- přidáme hlavičku stránky -->

    <?php require 'assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section class="main_heading">
            <h1>Informace o studentovi</h1>
        </section>

        <section>
            <?php if (is_array($oneStudent)): ?>
                <h2><?= htmlspecialchars($oneStudent['first_name']) . " " . htmlspecialchars($oneStudent['second_name']) ?></h2>
                <p>Věk: <?= htmlspecialchars($oneStudent['age']) ?></p>
                <p>Život: <?= htmlspecialchars($oneStudent['life']) ?></p>
                <p>Škola: <?= htmlspecialchars($oneStudent['college']) ?></p>
            <?php else: ?>
                <p>"Student s ID <?= htmlspecialchars($id) ?> nebyl nalezen v databázi."</p>
                <a href="all_students.php">Zpět na seznam studentů</a>
            <?php endif ?>
        </section>

        <?php if (is_array($oneStudent)): ?>
            <section class="buttons">
                <a href="edit_student.php?id=<?= $id ?>">Upravit žáka</a>
                <a href="delete_student.php?id=<?= $id ?>">Smazat žáka</a>
            </section>
        <?php endif ?>

    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>