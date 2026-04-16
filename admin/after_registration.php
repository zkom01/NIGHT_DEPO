<?php
    session_start(); // spustíme session pro správu uživatelských relací
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/Url.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        $dbClass = new Database();
        $conn = $dbClass->connectionDB();

         // získáme data z formuláře
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $email = $_POST['email'];
        $heslo= password_hash($_POST['heslo'],PASSWORD_DEFAULT); // HASH HESLA
        $role = "user";

        $emailDB = UserDB::checkUserbyEmail($conn,$email);
        
        if (!$emailDB['success']){
            $result = UserDB::addUser($conn, $first_name, $second_name, $email, $heslo, $role); // zavoláme funkci pro přidání uživatele a uložíme vrácenou zprávu do proměnné $result
        } else {
            Url::flashMessage('Zadaný e-mail ' . $emailDB['data']['email'] .' již v databázi existuje.' , 'error');

            // Uložíme odeslaná data, abychom je mohli vrátit do formuláře
            $_SESSION['form_data'] = [
                'first_name' => $first_name,
                'second_name' => $second_name,
                'email' => $email
            ];
            // Přesměrujeme zpět s parametrem pro zobrazení registrace
            Url::redirectUrl("../login.php?show=registration");
            exit;
        }

        

        if ($result['success']) {
            session_regenerate_id(true); // zabranuje provedení fixation attack (https://owasp.org/www-community/attacks/Session_fixation)

            $id = $conn->lastInsertId(); // získáme ID přidaného uživatele 

            $_SESSION['is_log_in'] = true; // informace že je uživatel přihlášený
            $_SESSION['log_in_user_id'] = $id; // id přihlášeného uživatele
            $_SESSION['role_user_log_in'] = $role; 

            Url::flashMessage($result['message'],'success');// Uložíme do session zprávu o úspěšném přidání uživatele, aby se zobrazila na další stránce

            Url::redirectUrl("../admin/index_admin.php"); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
        else {
            Url::flashMessage($result['message'],'error');// Uložíme do session zprávu o úspěšném přihlášení uživatele, aby se zobrazila na další stránce
            Url::redirectUrl("../login.php"); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        }
    }
    else {
        session_regenerate_id(true); // zabranuje provedení fixation attack

        Url::flashMessage('NEPOVOLENÝ PŘÍSTUP!!','error');
        Url::redirectUrl("../index.php");
        exit(); // Zastaví vykonávání skriptu
    }
?>