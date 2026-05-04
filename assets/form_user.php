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
        type="email" 
        name="email" 
        placeholder="Email" 
        value="<?= htmlspecialchars($email) ?>" 
    >
    
    <select 
        name="role"
        required>
        <option value="" disabled <?php echo empty($role) ? 'selected' : ''; ?>>-- Vyberte --</option>
        <option value="user" <?php echo $role == 'user' ? 'selected' : ''; ?>>user</option>
        <option value="admin" <?php echo $role == 'admin' ? 'selected' : ''; ?>>admin</option>
        <option value="super_admin" <?php echo $role == 'super_admin' ? 'selected' : ''; ?>>super_admin</option>
    </select>

    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Uložit</button>
        <a href="../admin/all_users.php" class="btn btn-secondary">Zrušit</a>
    </section>

</form>