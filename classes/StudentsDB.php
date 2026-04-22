<?php
require_once __DIR__ . '/LogError.php';
/**
 * Třída pro komplexní správu databáze studentů pomocí PDO.
 */
class StudentsDB {  

    /**
     * Získá data jednoho konkrétního studenta podle jeho ID s logováním chyb.
     * * * Metoda se pokusí vyhledat studenta. Pokud není nalezen nebo dojde k SQL chybě,
     * zapíše podrobnosti do specifického logu 'oneStudent_errors' a vrátí textové hlášení.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id Unikátní identifikátor studenta.
     * @param string $columns Seznam sloupců k výběru (výchozí vše "*").
     * @return array|string Pole s daty studenta při úspěchu, nebo textová zpráva pro uživatele.
     */
    public static function getOneStudent($conn, $id) {
        $sql = "SELECT student.*, college.name AS college_name
                FROM student
                LEFT JOIN college ON student.college_id = college.id
                WHERE student.id = :id";

        try {
            $statement = $conn->prepare($sql);
            
            // Navážeme parametry a provedeme dotaz
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            // fetch() vrátí asociativní pole, pokud záznam existuje, jinak vrátí false
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
     * Upraví existující záznam studenta v databázi.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id ID studenta, kterého chceme upravit.
     * @param string $first_name Nové křestní jméno.
     * @param string $second_name Nové příjmení.
     * @param int $age Nový věk.
     * @param string $life Textový popis nebo životopis.
     * @param string $college_id Id vysoké školy/koleje.
     * @return string Potvrzení o úspěchu nebo chybové hlášení.
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
            $statement->bindValue(":college_id", $college_id, PDO::PARAM_STR);
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
     * @param PDO $conn Objekt připojení k databázi.
     * @param string $first_name Křestní jméno.
     * @param string $second_name Příjmení.
     * @param int $age Věk.
     * @param string $life Popis/život.
     * @param string $college_id Id vysoké školy.
     * @return string Potvrzení o úspěchu nebo chybové hlášení.
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
     * Odstraní studenta z databáze podle ID.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id ID studenta ke smazání.
     * @return string Potvrzení o smazání nebo informace, že záznam neexistuje.
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
     * Vrátí seznam všech studentů v databázi.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param string $columns Seznam sloupců k výběru (výchozí "*").
     * @return array Pole asociativních polí se všemi studenty.
     */
    public static function allStudents($conn) {
        $sql = "SELECT *
                FROM student
                WHERE id > 0";

        try {
            $statement = $conn->prepare($sql);
            $statement->execute();

            // fetchAll(PDO::FETCH_ASSOC) nahrazuje mysqli_fetch_all($result, MYSQLI_ASSOC)
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Místo exit je lepší chybu zalogovat nebo vypsat kontrolovaně
            echo "Chyba při provádění dotazu: " . $e->getMessage();
            return []; // Vrátíme prázdné pole, aby zbytek aplikace nespadl na chybě iterace (např. ve foreach)
        }
    }

}

?>