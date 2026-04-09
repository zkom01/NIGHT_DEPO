<?php
/**
 * Třída pro komplexní správu databáze studentů pomocí PDO.
 */
class StudentsDB {  

    /**
     * Získá data jednoho konkrétního studenta podle jeho ID.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id Unikátní identifikátor studenta.
     * @param string $columns Seznam sloupců k výběru (výchozí vše "*").
     * @return array|string Pole s daty studenta při úspěchu, nebo chybová zpráva.
     */
    public static function getOneStudent($conn, $id, $columns = "*") {
        $sql = "SELECT $columns
                FROM student
                WHERE id = :id";

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
                return "Student s ID $id nebyl nalezen v databázi.";
            }

        } catch (PDOException $e) {
            return "Chyba při získávání informací o žáku: " . $e->getMessage();
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
     * @param string $college Název vysoké školy/koleje.
     * @return string Potvrzení o úspěchu nebo chybové hlášení.
     */
    public static function editStudent($conn, $id, $first_name, $second_name, $age, $life, $college) {
        $sql = "UPDATE student
                SET first_name = :first_name, 
                    second_name = :second_name, 
                    age = :age, 
                    life = :life, 
                    college = :college 
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);

            // Navázání všech parametrů
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college", $college, PDO::PARAM_STR);
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
     * @param string $college Vysoká škola.
     * @return string Potvrzení o úspěchu nebo chybové hlášení.
     */
    public static function addStudent($conn, $first_name, $second_name, $age, $life, $college) {
        $sql = "INSERT INTO student (first_name, second_name, age, life, college) 
                VALUES (:first_name, :second_name, :age, :life, :college)";

        try {
            $statement = $conn->prepare($sql);

            // Navázání parametrů pomocí pojmenovaných zástupců
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college", $college, PDO::PARAM_STR);

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
    public static function allStudents($conn, $columns = "*") {
        $sql = "SELECT $columns
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