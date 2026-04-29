<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preload" as="image" href="../img/background.webp">

    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="../css/general.css?v=<?php echo filemtime('../css/general.css');?>"> 

    <!-- styl pro hlavičku s verzováním pro zajištění načítání aktualizovaného souboru -->
    <link rel="stylesheet" href="../css/header.css?v=<?php echo filemtime('../css/header.css'); ?>"> 
    <link rel="stylesheet" href="../css/query/header_query.css?v=<?php echo filemtime('../css/query/header_query.css'); ?>">

    <!-- styl pro index -->
    <link rel="stylesheet" href="../css/index.css?v=<?php echo filemtime('../css/index.css'); ?>">

    <!-- styl pro all_students -->
    <link rel="stylesheet" href="../css/all_students.css?v=<?php echo filemtime('../css/all_students.css'); ?>">

    <!-- styl pro one_students -->
    <link rel="stylesheet" href="../css/one_student.css?v=<?php echo filemtime('../css/one_student.css'); ?>">

    <!-- styl pro photos -->
    <link rel="stylesheet" href="../css/photos.css?v=<?php echo filemtime('../css/photos.css'); ?>">

    <!-- styl pro form -->
    <link rel="stylesheet" href="../css/form.css?v=<?php echo filemtime('../css/form.css'); ?>">
    <link rel="stylesheet" href="../css/query/form_query.css?v=<?php echo filemtime('../css/query/form_query.css'); ?>">

    <!-- styl pro buttons -->
    <link rel="stylesheet" href="../css/buttons.css?v=<?php echo filemtime('../css/buttons.css'); ?>">

    <!-- styl pro varování -->
    <link rel="stylesheet" href="../css/warning_text.css?v=<?php echo filemtime('../css/warning_text.css'); ?>">

    <!-- styl pro hlášky -->
    <link rel="stylesheet" href="../css/message.css?v=<?php echo filemtime('../css/message.css'); ?>"> 

    <!-- styl pro footer -->
     <link rel="stylesheet" href="../css/footer.css?v=<?php echo filemtime('../css/footer.css'); ?>">

    <!-- script pro hamburger menu defer = načte se až se načte celá stránka -->
    <script src="../js/header.js?v=<?php echo filemtime('../js/header.js'); ?>" defer></script>

    <!-- script pro filtr all_students -->
    <script src="../js/filter_all_students.js?v=<?php echo filemtime('../js/filter_all_students.js'); ?>" defer></script>

    <!-- script pro photos název vybraného souboru -->
    <script src="../js/chose_file.js?v=<?php echo filemtime('../js/chose_file.js'); ?>" defer></script>

   

    <title>
        <?php 
            // Pokud existuje proměnná $pageTitle, vypiš ji, jinak vypiš "!!!!!!! DOPLNIT_NÁZEV_STRÁNKY !!!!!!!"
            echo isset($pageTitle) ? $pageTitle : "!!!!!!! DOPLNIT_NÁZEV_STRÁNKY !!!!!!!"; 
        ?>
    </title>
</head>

<body>
    <header class="menu">
        <div class="logo">
            <a href="../admin/index_admin.php">
                <img src="../img/logo.png" alt="logo">
            </a>
        </div>

        <nav>
            <ul>
                <li><a href="../admin/all_students.php">Seznam žáků</a></li>
                <?php if ($_SESSION['role_user_log_in']==="super_admin"):?>
                    <li><a href="../admin/all_users.php">Seznam uživatelů</a></li>
                <?php endif ?>
                <li><a href="../admin/photos.php">Fotky</a></li>
                <li><a href="../admin/log_out.php">Odhlásit</a></li>
            </ul>
        </nav>

        <div class="menu_icon">
            <img src="../img/more_white.png" alt="menu" class="img_switch">
        </div>
        
    </header>
    