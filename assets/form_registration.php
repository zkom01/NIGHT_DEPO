<form action="admin/after_registration.php" method="POST">
    <input 
        type="text" 
        name="first_name" 
        placeholder="Křestní jméno" 
        value="<?= htmlspecialchars($first_name) ?>" 
        required
    >

    <input 
        type="text" 
        name="second_name" 
        placeholder="Příjmení" 
        value="<?= htmlspecialchars($second_name) ?>" 
        required
    >

    <input 
        type="email" 
        name="email" 
        placeholder="Email" 
        autocomplete="email"
        required
    >

    <input
        class="password_first" 
        type="password" 
        name="heslo" 
        placeholder="heslo" 
        autocomplete="new-password"
        required
    >

    <input 
        class="password_second"
        type="password" 
        name="heslo_confirm" 
        placeholder="heslo znovu" 
        autocomplete="new-password"
        required
    >
    <p class="result_text">&nbsp</p>
    
    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Registrovat</button>
        <a href="index.php" class="btn btn-secondary">Zpět</a>
    </section>

    <section>
        <p>Již máte účet? <a href="#" onclick="switchForms()">Přihlásit se</a></p>
    </section>
</form>