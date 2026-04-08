<?php
    // require '../assets/auth.php'; // ověření přihlášení uživatele
    require '../classes/Auth.php';
    // require '../assets/database.php'; 
    require '../classes/Database.php';
    // require '../assets/studentsDB.php';
    require '../classes/StudentsDB.php';
    // require '../assets/url.php';
    require '../classes/Url.php';

    
    session_start(); // spustíme session pro správu uživatelských relací

    if ( !Auth::isLoggedIn($_SESSION['is_log_in']) ){
        session_regenerate_id(true); // zabranuje provedení fixation attack
        
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        // $conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college = $_POST['college'];

        $result = StudentsDB::addStudent($conn, $first_name, $second_name, $age, $life, $college); // zavoláme funkci pro přidání žáka a uložíme vrácenou zprávu do proměnné $result

        if ($result) {
            session_regenerate_id(true); // zabranuje provedení fixation attack
            
            $_SESSION['success_message'] = [
                'text' => $result,
                'type' => ''
            ]; // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na stránce s detaily studenta
            $id = $conn->lastInsertId(); // získáme ID editovaného žáka 
            Url::redirectUrl("../admin/one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    }
?>

<?php 
    $pageTitle = "Přidat žáka"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

    <main>
        <section class='main_heading'>
            <h1>Přidat žáka</h1>
        </section>

        <section class="add_form">
            <?php require '../assets/form_student.php'; ?>
        </section>
    </main>

<?php require '../assets/footer.php'; ?>
