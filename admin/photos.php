<?php
    session_start(); // spustíme session pro správu uživatelských relací
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/UserDB.php';
    require '../classes/PhotoDB.php';
    require '../classes/Url.php';


    Auth::requireLogin();

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();

    $user_id = $_SESSION['log_in_user_id'];

    $loginUser = UserDB::infoUser($conn,$user_id);

    $all_images = PhotoDB::allImgByUser($conn, $user_id);
?>

<?php 
    $pageTitle = "Photos"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?> <!-- přidáme hlavičku stránky -->

<?php require '../assets/flash_message.php'; ?> <!-- přidáme soubor pro zobrazení hlášek -->

<main>
    <section  class='main_heading'>
        <h1>Photos</h1>
    </section>

    <section class="align_left">
        <h4>Přihlášen: <?= htmlspecialchars($loginUser['data']['first_name']) ?> <?= htmlspecialchars($loginUser['data']['second_name']) ?><br>id: <?= htmlspecialchars($loginUser['data']['id']) ?><br>email: <?= htmlspecialchars($loginUser['data']['email']) ?></h4>
    </section>

    <section class="add_form">
        <?php require '../assets/form_photo.php'; ?>
    </section>

    <section class="images">
        <article class="align_left">
            <?php foreach ($all_images['data'] as $one_img): ?>
                <div>
                    <div>
                        <img src="../uploads/<?= htmlspecialchars($user_id) ?>/<?= htmlspecialchars($one_img['image_name']) ?>" alt="<?= $one_img['image_name'] ?>">
                    </div>
                    <div>
                        <a href="../uploads/<?= htmlspecialchars($user_id) ?>/<?= htmlspecialchars($one_img['image_name']) ?>" download>Stáhnout</a>
                        <a href="../admin/delete_photo.php?id=<?= htmlspecialchars($one_img['image_id']) ?>">smazat</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </article>
    </section>

</main>

<?php require '../assets/footer.php'; ?>