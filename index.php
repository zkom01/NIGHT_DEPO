<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- přidáme styl pro hlavičku s verzováním pro zajištění načítání aktualizovaného souboru -->
    <link rel="stylesheet" href="./css/header.css?v=<?php echo filemtime('./css/header.css'); ?>"> 
    <title>index</title>
</head>
<body>

    <?php require 'assets/header.php';  ?> <!-- přidáme hlavičku stránky -->

        <main>
        <section class="main_heading">
            <h1>Index</h1>
        </section>

        <section>
            <li><a href="all_students.php">Seznam žáků</a></li>
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>

