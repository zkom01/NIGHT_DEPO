<?php
    require 'assets/database.php'; // připojíme se k databázi

    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $students = allStudents($conn); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě
    $error = ""; // proměnná pro třídu hlášky, která se použije v případě nenalezení studenta
    if (isset($_SESSION['success_message'])) {
        $error = "error"; // nastavíme proměnnou pro třídu hlášky na "error", aby se hláška zobrazila jako červená protože mažeme studenta, což je akce, která může být vnímána jako negativní, a proto chceme, aby hláška byla vizuálně odlišná a upozornila uživatele na to, že došlo k odstranění záznamu.
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/message.css?v=2.8"> <!-- přidáme styl pro hlášky -->
    <title>Zaci</title>
</head>
<body>

    <?php require 'assets/header.php'; ?>

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
            <h1>Žáci</h1>
        </section>

        <section>
            <ul>

            <?php foreach ($students as $one_student): ?>
                <li>
                    <?= htmlspecialchars($one_student['first_name']) . " " . htmlspecialchars($one_student['second_name']) ?>
                </li>
                <a href="one_student.php?id=<?= $one_student['id'] ?>">Detail</a>
            <?php endforeach; ?>

            </ul>           
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>
</body>
</html>