<?php 
    session_start();

    $pageTitle = "Kontakt"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
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

<?php require 'assets/footer.php';  ?> <!-- přidáme patičku stránky -->