<?php
$formData = $_SESSION['form_data'] ?? [];
// Použijeme null coalescing operator ?? pro případ, že data neexistují
$name = $formData['name'] ?? ''; // pokud data existují použij jinak ''
$email = $formData['email'] ?? '';
$message = $formData['message'] ?? '';

?>
<form method="POST">

    <input novalidate
        type="text" 
        name="name" 
        placeholder="Jméno" 
        autocomplete="name"
        value="<?= htmlspecialchars($name) ?>" 
    >

    <input novalidate
        type="email" 
        name="email" 
        placeholder="Email" 
        autocomplete="email"
        value="<?= htmlspecialchars($email) ?>"
    >

    <textarea novalidate
        name="message" 
        placeholder="Text zprávy"
    ><?= htmlspecialchars($message) ?></textarea>


    <section class="buttons-container">
        <button type="submit" class="btn btn-primary">Odeslat</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Zrušit</a>
    </section>
</form>

