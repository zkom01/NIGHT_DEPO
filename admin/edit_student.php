<?php
    session_start(); // spustíme session pro správu uživatelských relací
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';

    // Auth::requireLogin();
    Auth::requireAdmin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $id = $_GET['id']; // získáme ID studenta z URL pro načtení jeho informací do formuláře
    $one_student = StudentsDB::getOneStudent($conn, $id); // získáme informace o studentovi pro předvyplnění formuláře

    if (is_array($one_student)) { // pokud se nám podařilo získat informace o studentovi, uložíme je do proměnných pro předvyplnění formuláře
        $first_name = $one_student['first_name'];
        $second_name = $one_student['second_name'];
        $age = $one_student['age'];
        $life = $one_student['life'];
        $college = $one_student['college'];
    } else {
        Url::redirectUrl("../admin/one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
        exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college = $_POST['college'];

        $result = StudentsDB::editStudent($conn, $id, $first_name, $second_name, $age, $life, $college); // zavoláme funkci pro úpravu informací o studentovi a uložíme výsledek do proměnné $result

        if ($result) {
            Url::flashMessage($result,'success'); // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na další stránce
            Url::redirectUrl("../admin/one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    }
    
?>

<?php 
    $pageTitle = "Upravit žáka"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

    <main>
        <section class='main_heading'>
            <h1>Upravit žáka</h1>
        </section>

        <section class="add_form">
            <?php require '../assets/form_student.php'; ?>
        </section>
    </main>

<?php require '../assets/footer.php'; ?>
