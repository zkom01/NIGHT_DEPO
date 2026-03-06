<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>one_student</title>
</head>
<body>

    <h1>Detail studenta</h1>
    <?php require 'assets/header.php'; ?> <!-- přidáme hlavičku stránky -->

    <main>
        <section>
            <?php
                require 'assets/dbconnect.php'; // připojíme se k databázi

                $id = $_GET['id']; // získáme id z URL

                if (!is_numeric($id)) : // zkontrolujeme, zda je id číslo
                    echo "Neplatné ID studenta.";
                    exit; // ukončí skript, pokud id není číslo
                endif;

                $sql = "SELECT *
                        FROM student
                        WHERE id = $id
                        "; // dotaz pro získání informací o konkrétním studentovi

                try {
                    $result = mysqli_query($conn, $sql); // provedeme dotaz a získáme výsledek
                } 
                catch (Exception $e) { // pokud dojde k chybě při provádění dotazu, zachytíme výjimku a vypíšeme chybovou zprávu
            ?>
                <p>Chyba při provádění dotazu: <? echo $e->getMessage() ?></p> <!-- vypíšeme chybovou zprávu, pokud dojde k chybě -->
            <?php
                exit; // ukončí skript, pokud dojde k chybě
            }?>

            <?php 
                $student = mysqli_fetch_assoc($result); // získáme informace o studentovi jako asociativní pole // 
            ?>

            <?php if ($student): ?>
                <h2><?= $student['first_name'] . " " . $student['second_name'] ?></h2>
                <p>Věk: <?= $student['age'] ?></p>
                <p>Život: <?= $student['life'] ?></p>
                <p>Škola: <?= $student['college'] ?></p>
            <?php else: ?>
                    <p>Student nenalezen.</p>
            <?php endif ?>
        </section>

    </main>

    <?php require 'assets/footer.php'; ?>

</body>
</html>

