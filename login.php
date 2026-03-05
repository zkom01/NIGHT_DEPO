<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Název webu</title>
</head>
<body>

    <h1>Přihlášení</h1>
    <?php require 'assets/header.php'; ?>

    <main>
        
        <section>
            <label for="username">Uživatelské jméno:</label>
            <input type="text" id="username" placeholder="Zadejte uživatelské jméno">
            <br>
            <label for="password">Heslo:</label>
            <input type="password" id="password" placeholder="Zadejte heslo">
        </section>

    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>
