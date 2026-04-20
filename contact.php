<?php
session_start();
require './vendor/PHPMailer/src/Exception.php';
require './vendor/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/src/SMTP.php';
require './classes/Url.php';
require_once './assets/configDB.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Zpracování formuláře POUZE pokud byla odeslána POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = $_POST['message'] ?? '';

    $_SESSION['form_data'] = [
        'name' => $name,
        'email' => $email,
        'message' => $message
    ];

    // Načtení obsahu souboru
    $template = file_get_contents('./assets/email_template.php');

    // Nahrazení placeholderů reálnými daty
    $emailBody = str_replace(
        ['{{name}}', '{{email}}', '{{message}}', '{{year}}'],
        [htmlspecialchars($name), htmlspecialchars($email), nl2br(htmlspecialchars($message)), date("Y")],
        $template
    );

    if (empty($name) || empty($email) || empty($message)) {
        Url::flashMessage ("Všechna pole jsou povinná.", "error");

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Url::flashMessage ("Neplatný formát emailu.", "error");

    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->Host = 'smtp.websupport.cz';
            $mail->SMTPAuth = true;
            $mail->Username = 'zkom@zkom.cz';
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('zkom@zkom.cz', 'Web nightdepo.zkom.cz Kontakt');
            $mail->addAddress($email); // Kam se má e-mail doručit
            $mail->addBCC('edzk@seznam.cz');         // kopie tobě

            $mail->isHTML(true);
            $mail->Subject = 'Nová zpráva z webu';
            $mail->Body = $emailBody;
            $mail->addReplyTo($email);

            $mail->send();
            unset($_SESSION['form_data']);
            Url::flashMessage ("Zpráva byla úspěšně odeslána.", "success");
        } catch (Exception $e) {
            Url::flashMessage ("Chyba při odesílání: {$mail->ErrorInfo}", "error");
        }
    }
    // Přesměrování po zpracování (prevence odeslání při refresh)
    Url::redirectUrl("./contact.php");
    exit();
}?>

<?php
$pageTitle = "Kontakt";
require './assets/header.php'; 
?>

<?php require 'assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section class='main_heading'>
            <h1>Kontaktní formulář</h1>
        </section>

        <section class="add_form">
            <?php require './assets/form_contact.php'; ?>
        </section>
    </main>

<?php require 'assets/footer.php';  ?>