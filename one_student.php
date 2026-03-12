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

    <?php if (isset($_SESSION['success_message'])): ?>
        <div id="flash-message" class="flash_message <?=($error) ?>"> <!-- přidáme třídu pro styl hlášky -->
            <?= htmlspecialchars($_SESSION['success_message']) ?> <!-- zobrazíme hlášku z session -->
        </div>

    <script>
        (function() {
            var msg = document.getElementById('flash-message');
            if (msg) {
                // Po načtení stránky se hláška postupně objeví
                setTimeout(function() {
                    msg.style.transition = "opacity 2s ease, transform 1s ease";
                    msg.style.opacity = "1";
                });

                // Po 2 sekundách začne mizet
                setTimeout(function() {
                    msg.style.transition = "opacity 2s ease, transform 1s ease";
                    msg.style.opacity = "0";

                    // Po dokončení animace odstraníme hlášku z DOM, aby nezůstávala jako prázdný element
                    setTimeout(function() { 
                        msg.remove(); 
                    }, 1000);
                }, 2000);
            }
        })();
    </script>
    
    <!-- Po zobrazení hlášky ji odstraníme ze session, aby se neobjevovala znovu při obnovení stránky -->
    <?php unset($_SESSION['success_message']); ?> 
<?php endif; ?>

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
                <a href="students.php">Zpět na seznam studentů</a>
            <?php endif ?>
        </section>

        <?php if (is_array($oneStudent)): ?>
            <section class="buttons">
                <a href="edit_student.php?id=<?= $id ?>">Upravit žáka</a>
            </section>
        <?php endif ?>

    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>