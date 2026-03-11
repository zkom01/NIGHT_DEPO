<?php
    require 'assets/database.php'; // načteme soubor s funkcemi pro práci s databází
    session_start(); // spustíme session pro správu uživatelských relací

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college = $_POST['college'];

        $result = addStudent($conn, $first_name, $second_name, $age, $life, $college); // zavoláme funkci pro přidání žáka a uložíme vrácenou zprávu do proměnné $result

        if ($result) {
            // echo "<div class='error_message'>" . htmlspecialchars($result) . "</div>"; // pokud funkce vrátí zprávu, zobrazíme ji
            $_SESSION['success_message'] = $result; // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na stránce s detaily studenta
            $id = mysqli_insert_id($conn); // získáme ID editovaného žáka 
            header("Location: one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
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
            <?php require 'assets/form.php'; ?>
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>