<?php
    require 'assets/database.php'; // načteme soubor s funkcemi pro práci s databází
    require 'assets/url.php'; // načteme soubor s funkcí pro přesměrování
    session_start(); // spustíme session pro správu uživatelských relací

    $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
    $id = $_GET['id']; // získáme ID studenta z URL pro načtení jeho informací do formuláře
    $one_student = getOneStudent($conn, $id); // získáme informace o studentovi pro předvyplnění formuláře

    if (is_array($one_student)) { // pokud se nám podařilo získat informace o studentovi, uložíme je do proměnných pro předvyplnění formuláře
        $first_name = $one_student['first_name'];
        $second_name = $one_student['second_name'];
        $age = $one_student['age'];
        $life = $one_student['life'];
        $college = $one_student['college'];
    } else {
        redirectUrl("one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
        exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college = $_POST['college'];

        $result = editStudent($conn, $id, $first_name, $second_name, $age, $life, $college); // zavoláme funkci pro úpravu informací o studentovi a uložíme výsledek do proměnné $result

        if ($result) {
            $_SESSION['success_message'] = $result; // Uložíme do session zprávu o úspěšném upravení studenta, aby se zobrazila na stránce s detaily studenta
            redirectUrl("one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    }
    
?>

<?php 
    $pageTitle = "Upravit žáka"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require 'assets/header.php'; ?>

    <main>
        <section class='main_heading'>
            <h1>Upravit žáka</h1>
        </section>

        <section class="add_form">
            <?php require 'assets/form.php'; ?>
        </section>
    </main>

<?php require 'assets/footer.php'; ?>
