<?php
    require 'assets/database.php'; // připojíme se k databázi

    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    
    $students = allStudents($conn); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaci</title>
</head>
<body>

    <?php require 'assets/header.php'; ?>

    <main>
        <section class="main_heading">
            <h1>Žáci</h1>
        </section>

        <section>
            <a href="add_student.php">Přidat žáka</a>
        </section>

        <section>
            <ul>

            <?php foreach ($students as $one_student): ?>
                <li>
                    <?= $one_student['first_name'] . " " . $one_student['second_name'] ?>
                </li>
                <a href="one_student.php?id=<?= $one_student['id'] ?>">Detail</a>
            <?php endforeach; ?>

            </ul>           
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>
</body>
</html>