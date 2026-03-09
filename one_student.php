<?php
    require 'assets/database.php'; // připojíme se k databázi
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>one_student</title>
</head>
<body>

    <?php require 'assets/header.php'; ?> <!-- přidáme hlavičku stránky -->

    <main>
        <section class="main_heading">
            <h1>Informace o studentovi</h1>
        </section>

        <section>
            <?php

                $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn

                $id = $_GET['id']; // získáme id z URL

                $result = getOneStudent($conn, $id); // zavoláme funkci pro získání informací o studentovi a uložíme výsledek do proměnné $result
            ?>

            <?php if ($result): ?>
                <h2><?= $result['first_name'] . " " . $result['second_name'] ?></h2>
                <p>Věk: <?= $result['age'] ?></p>
                <p>Život: <?= $result['life'] ?></p>
                <p>Škola: <?= $result['college'] ?></p>
            <?php else: ?>
                    <p>Student nenalezen.</p>
            <?php endif ?>
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>

