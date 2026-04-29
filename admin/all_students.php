<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě a kontrola přihlášení
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/StudentsDB.php';
    require '../classes/Url.php';

   Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $students = StudentsDB::allStudents($conn); // zavoláme funkci pro získání všech žáků a uložíme výsledek do proměnné $students
   
?>

<?php 
    $pageTitle = "Seznam žáků"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section class="main_heading">
        <h1>Žáci</h1>
    </section>

    <section class="add_form">
        <input type="text"
               class = "search_text" 
               placeholder="Začněte psát"
               autofocus
        >
    </section>

    <?php if ($_SESSION['role_user_log_in']==="admin" OR $_SESSION['role_user_log_in']==="super_admin"):?>
        <section class="buttons-container">
            <a href="../admin/add_student.php" class="btn btn-primary">Přidat žáka</a>
        </section>
    <?php endif ?>

    <section>
        <?php if(empty($students)):?>
            <h2>Žádní žáci nebyli nalezeni.</h2>
        <?php else:?>
            <div class="all_students">
                <?php foreach ($students as $one_student): ?>
                    <div class="one_student">
                        <h2><?= htmlspecialchars($one_student['second_name']) . " " . htmlspecialchars($one_student['first_name']) ?></h2>
                        <p><?= htmlspecialchars($one_student['college_name']) ?></p>
                        <section class="buttons-container">
                            <a href="one_student.php?id=<?= $one_student['id'] ?>" class="btn btn-primary">Detail</a>
                        </section>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;?>           
    </section>
</main>

<?php require '../assets/footer.php'; ?>
