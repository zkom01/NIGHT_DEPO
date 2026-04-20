<?php
// Načteme data ze session, pokud tam jsou (z login.php)
// Použijeme null coalescing operator ?? pro případ, že data neexistují
$f_name = $formData['first_name'] ?? ''; // pokud data existují použij jinak ''
$s_name = $formData['second_name'] ?? '';
$e_mail = $formData['email'] ?? '';
?>

<form action="admin/after_registration.php" method="POST">
    <input 
        type="text" 
        name="first_name" 
        placeholder="Křestní jméno" 
        value="<?= htmlspecialchars($f_name) ?>" 
        pattern="\S+.*"
        required
    >

    <input 
        type="text" 
        name="second_name" 
        placeholder="Příjmení" 
        value="<?= htmlspecialchars($s_name) ?>" 
        pattern="\S+.*"
        required
    >

    <input 
        type="email" 
        name="email" 
        placeholder="Email" 
        value="<?= htmlspecialchars($e_mail) ?>" 
        autocomplete="email"
        required
    >

    <input
        class="password_first" 
        type="password" 
        name="heslo" 
        placeholder="Heslo" 
        autocomplete="new-password"
        required
    >

    <input 
        class="password_second"
        type="password" 
        name="heslo_confirm" 
        placeholder="Heslo znovu" 
        autocomplete="new-password"
        required
    >
    
    <p class="result_text">&nbsp;</p>
    
    <section class="buttons-container">
        <button type="submit" id="hiden" class="btn btn-primary">Registrovat</button>
        <a href="index.php" class="btn btn-secondary">Zpět</a>
    </section>

    <section>
        <p>Již máte účet? <a href="#" onclick="switchForms()">Přihlásit se</a></p>
    </section>
</form>