<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- přidáme styl pro hlavičku s verzováním pro zajištění načítání aktualizovaného souboru -->
    <link rel="stylesheet" href="./css/header.css?v=<?php echo filemtime('./css/header.css'); ?>"> 
    <link rel="stylesheet" href="css/warning.css"> <!-- přidáme styl pro varování -->
    <link rel="stylesheet" href="css/message.css"> <!-- přidáme styl pro hlášky -->
    <title>
        <?php 
            // Pokud existuje proměnná $pageTitle, vypiš ji, jinak vypiš "Můj Web"
            echo isset($pageTitle) ? $pageTitle : "!!!!!!! DOPLNIT_NÁZEV_STRÁNKY !!!!!!!"; 
        ?>
    </title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domů</a></li>
                <li><a href="all_students.php">Seznam žáků</a></li>
                <li><a href="add_student.php">Přidat žáka</a></li>
            </ul>
        </nav>

        <img src="./img/cross.png" alt="Cross">
        <img src="./img/menu.png" alt="menu">
        
    </header>