<form method="POST">
    <input 
        type="text" 
        name="first_name" 
        placeholder="Křestní jméno" 
        value="<?= htmlspecialchars($first_name) ?>" 
        required
    ><br>

    <input 
        type="text" 
        name="second_name" 
        placeholder="Příjmení" 
        value="<?= htmlspecialchars($second_name) ?>" 
        required
    ><br>

    <input 
        type="number" 
        name="age" 
        placeholder="Věk" 
        min="10" 
        value="<?= htmlspecialchars($age) ?>" 
        required
    ><br>

    <textarea 
        required 
        name="life" 
        placeholder="Podrobnosti o žákovi" 
        required
    ><?= htmlspecialchars($life) ?></textarea><br>
    
    <input 
        type="text" 
        name="college" 
        placeholder="Škola" 
        value="<?= htmlspecialchars($college) ?>" 
        required
    ><br>

    <button type="submit">Uložit</button>
</form>