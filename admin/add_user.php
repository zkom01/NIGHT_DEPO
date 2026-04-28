<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/Url.php';
    require '../classes/Auth.php';

    Auth::requireSuperAdmin();

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
            $id = $conn->lastInsertId(); // získáme ID přidaného uživatele 
            Url::flashMessage($result['message'],'success');// Uložíme do session zprávu o úspěšném přidání uživatele, aby se zobrazila na další stránce

            Url::redirectUrl("../admin/one_user.php?id=" . $id); // přesměrujeme na stránku s detaily studenta
            exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
        } else {
            Url::flashMessage('Zadaný e-mail ' . $emailDB['data']['email'] .' již v databázi existuje.' , 'error');

            // Uložíme odeslaná data, abychom je mohli vrátit do formuláře
            $_SESSION['form_data'] = [
                'first_name' => $first_name,
                'second_name' => $second_name,
                'email' => $email
            ];
            // Přesměrujeme zpět s parametrem pro zobrazení registrace
            Url::redirectUrl("./admin/add_user.php");
            exit;
        }
    }
    // Načtení dat ze session (pokud existují) a jejich následné smazání
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']);

    $pageTitle = "Přidat uživatele"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php';  ?> <!-- přidáme hlavičku stránky -->

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section id="on_click" class='main_heading'>
            <h1>Přidat uživatele</h1>
        </section>

        <section class="add_form" id="form2">
            <?php require '../assets/form_add_user.php'; ?>
        </section>
    </main>

<?php require '../assets/footer.php';  ?> <!-- přidáme patičku stránky -->
