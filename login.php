<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    $pageTitle = "Přihlášení"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require 'assets/header.php';  ?> <!-- přidáme hlavičku stránky -->

<?php require 'assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section id="on_click" class='main_heading'>
            <h1>Přihlášení</h1>
        </section>

        <section id="form1" class="add_form hiden_active">
            <?php require 'assets/form_registration.php'; ?>
        </section>

        <section id="form2" class="add_form">
            <?php require 'assets/form_login.php'; ?>
        </section>
    </main>

<?php require 'assets/footer.php';  ?> <!-- přidáme patičku stránky -->