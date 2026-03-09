<?php
    require 'assets/database.php'; // načteme soubor s funkcemi pro práci s databází

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college = $_POST['college'];

        $message = addStudent($conn, $first_name, $second_name, $age, $life, $college); // zavoláme funkci pro přidání žáka a uložíme vrácenou zprávu do proměnné $message
        echo $message; // vypíšeme zprávu o úspěchu nebo chybě
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat žáka</title>
</head>

<body>
    <?php require 'assets/header.php'; ?>

    <main>
        <section class='main_heading'>
            <h1>Přidat žáka</h1>
        </section>

        <section class="add_form">
            <form action="add_student.php" method="POST">

                <input type="text" name="first_name" placeholder="Křestní jméno" required><br>
                <input type="text" name="second_name" placeholder="Příjmení" required><br>
                <input type="number" name="age" placeholder="Věk" required><br>
                <textarea name="life" placeholder="Podrobnosti o žákovi"></textarea><br>
                <input type="text" name="college" placeholder="Škola"><br>

                <button type="submit">Přidat žáka</button>

            </form>
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>