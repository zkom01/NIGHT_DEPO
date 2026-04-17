<form method="POST">
    <input 
        type="email" 
        name="email" 
        placeholder="Email" 
        autocomplete="email"
        required
    >

    <textarea 
        name="message" 
        placeholder="Text zprávy" 
        required
    ><?= htmlspecialchars($life) ?></textarea>


    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Odeslat</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Zrušit</a>
    </section>
</form>
