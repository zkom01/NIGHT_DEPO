<?php
    require 'assets/dbconnect.php'; // provede připojení k databázi a uloží připojení do proměnné $conn

    $sql = "SELECT id, first_name, second_name
            FROM student
            WHERE id > 0
            ";

    try {
        $result = mysqli_query($conn, $sql);
    } 
    catch (Exception $e) {
        echo "Chyba při provádění dotazu: " . $e->getMessage();
        exit; // ukončí skript, pokud dojde k chybě
    }

    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaci</title>
</head>
<body>

    <h1>Žáci</h1>
    <?php require 'assets/header.php'; ?>

    <main>
        <section>
            <ul>

            <?php foreach ($students as $one_student): ?>
                <li>
                    <?= $one_student['first_name'] . " " . $one_student['second_name'] ?>
                </li>
                <a href="one_student.php?id=<?= $one_student['id'] ?>">Detail</a>
            <?php endforeach; ?>

            </ul>
            
            
        </section>
    </main>

    <?php require 'assets/footer.php'; ?>
</body>
</html>