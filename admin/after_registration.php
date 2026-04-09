<?php
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/Url.php';

    session_start(); // spustíme session pro správu uživatelských relací

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $email = $_POST['email'];
        $heslo= password_hash($_POST['heslo'],PASSWORD_DEFAULT); // HASH HESLA

        $result = UserDB::addUser($conn, $first_name, $second_name, $email, $heslo); // zavoláme funkci pro přidání uživatele a uložíme vrácenou zprávu do proměnné $result

        if ($result['success']) {
            session_regenerate_id(true); // zabranuje provedení fixation attack (https://owasp.org/www-community/attacks/Session_fixation)

            $id = $conn->lastInsertId(); // získáme ID přidaného uživatele 

            $_SESSION['is_log_in'] = true; // informace že je uživatel přihlášený
            $_SESSION['log_in_user_id'] = $id; // id přihlášeného uživatele

            $_SESSION['success_message'] = [
                'text' => $result['message'],
                'type' => ''
            ]; // Uložíme do session zprávu o úspěšném přidání uživatele, aby se zobrazila na další stránce

            Url::redirectUrl("../admin/index_admin.php"); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
        else {
            $_SESSION['success_message'] = [
                'text' => $result['message'],
                'type' => 'error'
            ]; // Uložíme do session zprávu o úspěšném přihlášení uživatele, aby se zobrazila na další stránce
            Url::redirectUrl("../login.php"); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    }
    else {
        session_regenerate_id(true); // zabranuje provedení fixation attack
        
        $_SESSION['success_message'] = ['text' => "NEPOVOLENÝ PŘÍSTUP", 'type' => 'error'];
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }
?>