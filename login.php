<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    // Zjistíme, který formulář má být aktivní
    $showRegistration = (isset($_GET['show']) && $_GET['show'] === 'registration');
    
    // Načtení dat ze session (pokud existují) a jejich následné smazání
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']);

    $pageTitle = "Přihlášení"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require 'assets/header.php';  ?> <!-- přidáme hlavičku stránky -->

<?php require 'assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

    <main>
        <section id="on_click" class='main_heading'>
            <h1><?php echo $showRegistration ? "Registrace" : "Přihlášení"; ?></h1>
        </section>

        <section id="form1" class="add_form <?php echo $showRegistration ? '' : 'hiden_active'; ?>">
            <?php require 'assets/form_registration.php'; ?>
        </section>

        <section id="form2" class="add_form <?php echo !$showRegistration ? '' : 'hiden_active'; ?>">
            <?php require 'assets/form_login.php'; ?>
        </section>
    </main>

<?php require 'assets/footer.php';  ?> <!-- přidáme patičku stránky -->