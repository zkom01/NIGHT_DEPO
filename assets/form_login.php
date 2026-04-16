<form action="admin/after_login.php" method="POST">
    <input 
        type="email" 
        name="email" 
        placeholder="Email" 
        autocomplete="email"
        required
    >

    <input 
        type="password" 
        name="heslo" 
        placeholder="heslo"
        autocomplete="current-password" 
        required
    >

    <p>&nbsp;</p>
    
    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Přihlsit</button>
        <a href="index.php" class="btn btn-secondary">Zpět</a>
    </section>

     <section id="on_click">
        <p>Nemáte účet? <a href="#" onclick="switchForms()">Registrovat se</a></p>
    </section>
</form>