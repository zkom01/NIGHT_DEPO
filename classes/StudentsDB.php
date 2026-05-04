<?php
require_once __DIR__ . '/LogError.php';
/**
 * Třída pro správu databáze studentů pomocí PDO.
 */
class StudentsDB {  

    /**
     * Načte data jednoho studenta podle ID, včetně názvu katedry.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id   ID studenta.
     * @return array|string Asociativní pole s daty studenta, nebo textová chybová zpráva.
     */
    public static function getOneStudent($conn, $id) {
        $sql = "SELECT student.*, college.name AS college_name
                FROM student
                LEFT JOIN college ON student.college_id = college.id
                WHERE student.id = :id";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result; // Vrátíme pole s daty studenta
            } else {
                // Logujeme nenalezení záznamu jako varování
                LogError::logError("(class StudentsDB - getOneStudent) Student s ID $id nebyl nalezen v databázi.", 'oneStudent_errors');
                return "Student s ID $id nebyl nalezen v databázi.";
            }

        } catch (PDOException $e) {
            // Zalogujeme skutečný technický problém (např. chyba v názvu sloupce)
            LogError::logError("(class StudentsDB - getOneStudent) SQL chyba: " . $e->getMessage(), 'oneStudent_errors');
            
            // Uživateli vrátíme jen neutrální zprávu pro zachování bezpečnosti
            return "Omlouváme se, došlo k technické chybě při čtení dat.";
        }
    }

    /**
     * Upraví existující záznam studenta.
     *
     * @param PDO    $conn        Objekt připojení k databázi.
     * @param int    $id          ID studenta.
     * @param string $first_name  Nové křestní jméno.
     * @param string $second_name Nové příjmení.
     * @param int    $age         Nový věk.
     * @param string $life        Nový textový popis.
     * @param int    $college_id  ID katedry/fakulty.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function editStudent($conn, $id, $first_name, $second_name, $age, $life, $college_id) {
        $sql = "UPDATE student
                SET first_name = :first_name, 
                    second_name = :second_name, 
                    age = :age, 
                    life = :life, 
                    college_id = :college_id 
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);

            // Navázání všech parametrů
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college_id", $college_id, PDO::PARAM_INT);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            // Provedení dotazu
            if ($statement->execute()) {
                return "Žák úspěšně upraven.";
            } else {
                return "Úprava žáka se nezdařila.";
            }

        } catch (PDOException $e) {
            // Ošetření chyby přes PDO
            return "Chyba při úpravě žáka: " . $e->getMessage();
        }
    }

    /**
     * Přidá nového studenta do databáze.
     *
     * @param PDO    $conn        Objekt připojení k databázi.
     * @param string $first_name  Křestní jméno.
     * @param string $second_name Příjmení.
     * @param int    $age         Věk.
     * @param string $life        Textový popis.
     * @param int    $college_id  ID katedry/fakulty.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function addStudent($conn, $first_name, $second_name, $age, $life, $college_id) {
        $sql = "INSERT INTO student (first_name, second_name, age, life, college_id) 
                VALUES (:first_name, :second_name, :age, :life, :college_id)";

        try {
            $statement = $conn->prepare($sql);

            // Navázání parametrů pomocí pojmenovaných zástupců
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college_id", $college_id, PDO::PARAM_STR);

            if ($statement->execute()) {
                return "Žák úspěšně přidán.";
            } else {
                return "Nepodařilo se přidat žáka.";
            }

        } catch (PDOException $e) {
            // Výpis chyby v případě problému s databází
            return "Chyba při přidávání žáka: " . $e->getMessage();
        }
    }

    /**
     * Odstraní studenta z databáze.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id   ID studenta ke smazání.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function deleteStudent($conn, $id) {
        $sql = "DELETE FROM student
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);

            // Navážeme ID studenta
            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            // Vykonáme dotaz
            if ($statement->execute()) {
                // Kontrola, zda byl někdo skutečně smazán
                if ($statement->rowCount() > 0) {
                    return "Žák s ID $id byl úspěšně smazán.";
                } else {
                    return "Žák s ID $id nebyl nalezen, takže nebyl smazán.";
                }
            } else {
                return "Smazání žáka se nezdařilo.";
            }

        } catch (PDOException $e) {
            // Ošetření chyby databáze
            return "Chyba při mazání žáka: " . $e->getMessage();
        }
    }

    /**
     * Vrátí seznam všech studentů seřazený podle příjmení, včetně názvu katedry.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @return array Pole asociativních polí se všemi studenty, nebo prázdné pole při chybě.
     */
    public static function allStudents($conn) {
        $sql = "SELECT student.*, college.name AS college_name
                FROM student
                LEFT JOIN college ON student.college_id = college.id
                ORDER BY student.second_name ASC";

        try {
            $statement = $conn->prepare($sql);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            LogError::logError("Chyba při provádění dotazu: " . $e->getMessage(),'StudentsDB_errors');
            return []; // Vrátíme prázdné pole, aby zbytek aplikace nespadl na chybě iterace (např. ve foreach)
        }
    }

}

?>