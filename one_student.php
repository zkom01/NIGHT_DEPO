<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>one_student</title>
</head>
<body>

    <h1>Detail studenta</h1>
    <?php require 'assets/header.php'; ?>

    <main>
        <section>
            <?php
                require 'assets/dbconnect.php';

                $id = $_GET['id']; // získáme id z URL

                $sql = "SELECT *
                        FROM student
                        WHERE id = $id
                        "; // dotaz pro získání informací o konkrétním studentovi

                try {
                    $result = mysqli_query($conn, $sql);
                } 
                catch (Exception $e) {
            ?>
                <p>Chyba při provádění dotazu: <?= $e->getMessage() ?></p>
            <?php
                exit; // ukončí skript, pokud dojde k chybě
            }?>

            <?php 
                $student = mysqli_fetch_assoc($result); // získáme informace o studentovi jako asociativní pole // 
            ?>

            <?php if ($student) { ?>
                <h1><?= $student['first_name'] . " " . $student['second_name'] ?></h1>
                <p>Věk: <?= $student['age'] ?></p>
                <p>Život: <?= $student['life'] ?></p>
                <p>Škola: <?= $student['college'] ?></p>
            <?php } else { ?>
                    <p>Student nenalezen.</p>
            <?php } ?>

        </section>

    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>

