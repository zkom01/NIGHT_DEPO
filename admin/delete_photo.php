<?php
    session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě
    require '../classes/Auth.php';
    require '../classes/Database.php';
    require '../classes/PhotoDB.php';
    require '../classes/Url.php';

    Auth::requireLogin();
    
    $user_id = $_SESSION['log_in_user_id'];

    $dbClass = new Database();
    $conn = $dbClass->connectionDB();
    
    $image_id = $_GET['id']; // získáme ID obrázku z URL
    $one_image = PhotoDB::getOneImage($conn, $image_id);
    $image_path = "../uploads/" . $user_id . "/" . $one_image['image_name'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $result = PhotoDB::deleteImg($conn, $image_id, $image_path);
        Url::flashMessage($result,'error'); // Uložíme do session zprávu o úspěšném smazání obrázku
        Url::redirectUrl("../admin/photos.php");
        exit; // ukončí skript, aby se zabránilo dalšímu vykonávání po přesměrování
    }
?>

<?php 
    $pageTitle = "Smazání obrázku"; // Tady definujete název stránky, který se zobrazí v záložce prohlížeče
    require '../assets/header_admin.php'; ?>

<main>
    <section class='main_heading'>
        <h1>Smazání obrázku</h1>
    </section>
 
    <section class="one_photo_card">
        <?php if (is_array($one_image)): ?>

            <section class="text_photo_container">
                <img src="../uploads/<?= htmlspecialchars($user_id) ?>/<?= htmlspecialchars($one_image['image_name']) ?>" alt="<?= $one_image['image_name'] ?>">
            </section>

            <form method="post">
                <section class="buttons-container">
                    <a href="../admin/photos.php" class="btn btn-primary">Ne, zpět</a>
                    <button type="submit" class="btn btn-secondary">Ano, smazat</button>
                </section>
            </form>

        <?php else: ?>
            <p><?= htmlspecialchars($one_image) ?></p>
            <section class="buttons-container">
                <a href="../admin/photos.php" class="btn btn-primary">Zpět na seznam obrázků</a>
            <section>
        <?php endif ?>
    </section>

</main>

<?php require '../assets/footer.php'; ?>