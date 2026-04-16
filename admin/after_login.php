<?php
    session_start(); // spustíme session pro správu uživatelských relací
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/Url.php';
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

         // získáme data z formuláře
        $email = $_POST['email'];
        $heslo= $_POST['heslo'];

        $result = UserDB::checkUser($conn, $email, $heslo); // funkce pro kontrolu uživatele a uložíme vrácenou zprávu do proměnné $result

        if ($result['success']) {
            session_regenerate_id(true); // zabranuje provedení fixation attack (https://owasp.org/www-community/attacks/Session_fixation)

            $id = $result['id'];

            $_SESSION['is_log_in'] = true; // informace že je uživatel přihlášený
            $_SESSION['log_in_user_id'] = $id; // id přihlášeného uživatele
            $_SESSION['role_user_log_in'] = $result['role'];

            Url::flashMessage($result['message'],'success');
            Url::redirectUrl("../admin/index_admin.php"); 
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
        else {
            session_regenerate_id(true); // zabranuje provedení fixation attack
            Url::flashMessage($result['message'],'error');
            Url::redirectUrl("../login.php");
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    } else {
        session_regenerate_id(true); // zabranuje provedení fixation attack

        Url::flashMessage('NEPOVOLENÝ PŘÍSTUP','error');
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }
?>