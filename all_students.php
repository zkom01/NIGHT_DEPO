<?php
    require 'assets/database.php'; // připojíme se k databázi
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě
    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $students = allStudents($conn, "id, first_name, second_name"); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
   
    $error = ""; // proměnná pro třídu hlášky, která se použije v případě nenalezení studenta
    if (isset($_SESSION['success_message'])) {
        $error = "error"; // pokud existuje hláška o úspěchu, nastavíme třídu na "error" pro zobrazení červené hlášky
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/message.css"> <!-- přidáme styl pro hlášky -->
    <link rel="stylesheet" href="./css/header.css?v=<?php echo filemtime('./css/header.css'); ?>"> <!-- přidáme styl pro hlavičku s verzováním pro zajištění načítání aktualizovaného souboru -->
    <title>Zaci</title>
</head>
<body>

    <?php require 'assets/header.php'; ?>

    <?php require 'assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

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