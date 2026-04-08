<?php
    // require '../assets/auth.php'; // ověření přihlášení uživatele
    require '../classes/Auth.php';
    // require '../assets/database.php'; // načteme soubor s funkcemi pro práci s databází
    require '../classes/Database.php'; // načteme soubor s funkcemi pro práci s databází
    // require '../assets/studentsDB.php'; 
    require '../classes/StudentsDB.php';
    // require '../assets/url.php'; // načteme soubor s funkcí pro přesměrování
    require '../classes/Url.php';

    session_start(); // spustíme session pro správu uživatelských relací

    if ( !Auth::isLoggedIn($_SESSION['is_log_in']) ){
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    // $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
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
            session_regenerate_id(true); // zabranuje provedení fixation attack
            $_SESSION['success_message'] = [
                'text' => $result,
                'type' => ''
            ]; // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na další stránce
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
