<?php
    session_start(); // spustíme session pro správu uživatelských relací
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';

    Auth::requireLogin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $age = $_POST['age'];
        $life = $_POST['life'];
        $college_id = $_POST['college_id'];

        $result = StudentsDB::addStudent($conn, $first_name, $second_name, $age, $life, $college_id);

        if ($result) {
            Url::flashMessage($result, "success"); // Uložíme do session zprávu o úspěšném přidání studenta, aby se zobrazila na stránce s detaily studenta
            $id = $conn->lastInsertId(); // získáme ID přidaného žáka
            Url::redirectUrl("../admin/one_student.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        } else {
            Url::flashMessage("Nepodařilo se přidat žáka.", "error");
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
