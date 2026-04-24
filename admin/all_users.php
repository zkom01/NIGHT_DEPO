<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/Url.php';
    require '../classes/UserDB.php';

    Auth::requireSuperAdmin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $users = UserDB::allUser($conn); // zavoláme funkci pro získání všech uživatelů a uložíme výsledek do proměnné $users
   
?>

<?php 
    $pageTitle = "Seznam uživatelů"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section class="main_heading">
        <h1>Uživatelé</h1>
    </section>

    <section class="add_form">
        <input type="text"
               class = "search_text" 
               placeholder="Začněte psát"
               autofocus
        >
    </section>

    <section>
        <?php if(empty($users)):?>
            <h2>Žádní uživatelé nebyli nalezeni.</h2>
        <?php else:?>
            <div class="all_students">
                <?php foreach ($users as $one_user): ?>
                    <div class="one_student">
                        <h2><?= htmlspecialchars($one_user['first_name']) . " " . htmlspecialchars($one_user['second_name']) ?></h2>
                        <section class="buttons-container">
                            <a href="one_user.php?id=<?= $one_user['id'] ?>" class="btn btn-primary">Detail</a>
                        </section>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;?>           
    </section>
</main>

<?php require '../assets/footer.php'; ?>
