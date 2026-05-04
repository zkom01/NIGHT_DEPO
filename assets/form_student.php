<?php
    require '../classes/CollegeDB.php';


    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $colleges = CollegeDB::allColleges($conn);
?>

<form method="POST">
    <input 
        type="text" 
        name="first_name" 
        placeholder="Křestní jméno" 
        value="<?= htmlspecialchars($first_name) ?>" 
        pattern="\S+.*"
        required
    >

    <input 
        type="text" 
        name="second_name" 
        placeholder="Příjmení" 
        value="<?= htmlspecialchars($second_name) ?>" 
        pattern="\S+.*"
        required
    >

    <input 
        type="number" 
        name="age" 
        placeholder="Věk" 
        min="10" 
        value="<?= htmlspecialchars($age) ?>" 
        required
    >

    <textarea 
        name="life" 
        placeholder="Podrobnosti o žákovi" 
        required
        pattern="\S+.*"
    ><?= htmlspecialchars($life) ?></textarea>

    <select name="college_id" id="college_id" required>
        <option value="" disabled <?php echo empty($college_name) ? 'selected' : ''; ?>>-- Vyberte školu --</option>

        <?php foreach ($colleges as $c): ?>
            <option value="<?= htmlspecialchars($c['id']) ?>" <?php echo $college_name == $c['name'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Uložit</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Zrušit</a>
    </section>
</form>
