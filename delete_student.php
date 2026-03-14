<?php
require 'assets/database.php'; // načteme soubor s funkcemi pro práci s databází
require 'assets/url.php'; // načteme soubor s funkcí pro přesměrování
session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě

$conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
$id = $_GET['id']; // získáme ID studenta z URL
$oneStudent = getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $oneStudent

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $result = deleteStudent($conn, $id); // zavoláme funkci pro smazání studenta z databáze a uložíme výsledek do proměnné $result
    $_SESSION['success_message'] = $result; // uložíme výsledek do session, aby se zobrazil na další stránce
    redirectUrl("all_students.php"); // přesměrujeme na stránku se seznamem studentů
    exit(); // ukončíme skript, aby se zabránilo dalšímu vykonávání kódu po přesměrování
}



?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css?v=<?php echo filemtime('./css/header.css'); ?>"> <!-- přidáme styl pro hlavičku s verzováním pro zajištění načítání aktualizovaného souboru -->
    <title>Smazání studenta</title>
    <link rel="stylesheet" href="css/warning.css"> <!-- přidáme styl pro varování -->
</head>

<body>
    <?php require 'assets/header.php'; ?>

    <main>
        <section class='main_heading'>
            <h1>Smazání studenta</h1>
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

        <section>
            <p class="warning">Opravdu smazat studenta?</p>
            <form method="post">
                <button type="submit">Ano, smazat</button>
                <a href="one_student.php?id=<?= $id ?>">Ne, vrátit se zpět</a>
            </form>
        </section>
    </main>
    
    <?php require 'assets/footer.php'; ?>

</body>
</html>