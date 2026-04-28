<?php
// Načteme data ze session, pokud tam jsou (z login.php)
// Použijeme null coalescing operator ?? pro případ, že data neexistují
$f_name = $formData['first_name'] ?? ''; // pokud data existují použij jinak ''
$s_name = $formData['second_name'] ?? '';
$e_mail = $formData['email'] ?? '';
?>

<form method="POST">
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
    
    <section class="buttons-container">
        <button type="submit" id="hiden" class="btn btn-primary">Vytvořit</button>
        <a href="all_users.php" class="btn btn-secondary">Zpět</a>
    </section>

</form>