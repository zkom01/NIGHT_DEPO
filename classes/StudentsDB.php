<?php
require_once __DIR__ . '/LogError.php';

/**
 * Třída pro komplexní správu databáze studentů pomocí PDO.
 */
class StudentsDB {  

    /**
     * Získá data jednoho konkrétního studenta včetně názvu jeho školy.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id Unikátní identifikátor studenta.
     * @return array|string Pole s daty studenta při úspěchu, nebo textová zpráva.
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
                return $result;
            } else {
                LogError::logError("(StudentsDB - getOneStudent) Student ID $id nenalezen.", 'student_queries');
                return "Student s ID $id nebyl nalezen.";
            }
        } catch (PDOException $e) {
            LogError::logError("(StudentsDB - getOneStudent) SQL chyba: " . $e->getMessage(), 'student_queries');
            return "Došlo k technické chybě při načítání studenta.";
        }
    }

    /**
     * Upraví existující záznam studenta.
     *
     * @param PDO $conn Objekt připojení.
     * @param int $id ID studenta.
     * @param int $college_id ID školy z tabulky college.
     * @return string Potvrzení nebo chybová zpráva.
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
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college_id", $college_id, PDO::PARAM_INT);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            if ($statement->execute()) {
                return "Žák úspěšně upraven.";
            }
            return "Úprava žáka se nezdařila.";
        } catch (PDOException $e) {
            LogError::logError("(StudentsDB - editStudent) SQL chyba: " . $e->getMessage(), 'student_errors');
            return "Chyba při úpravě žáka.";
        }
    }

    /**
     * Přidá nového studenta do databáze.
     */
    public static function addStudent($conn, $first_name, $second_name, $age, $life, $college_id) {
        $sql = "INSERT INTO student (first_name, second_name, age, life, college_id) 
                VALUES (:first_name, :second_name, :age, :life, :college_id)";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":age", $age, PDO::PARAM_INT);
            $statement->bindValue(":life", $life, PDO::PARAM_STR);
            $statement->bindValue(":college_id", $college_id, PDO::PARAM_INT);

            if ($statement->execute()) {
                return "Žák úspěšně přidán.";
            }
            return "Nepodařilo se přidat žáka.";
        } catch (PDOException $e) {
            LogError::logError("(StudentsDB - addStudent) SQL chyba: " . $e->getMessage(), 'student_errors');
            return "Chyba při přidávání žáka.";
        }
    }

    /**
     * Odstraní studenta z databáze.
     */
    public static function deleteStudent($conn, $id) {
        $sql = "DELETE FROM student WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Žák s ID $id byl úspěšně smazán.";
                }
                LogError::logError("(StudentsDB - deleteStudent) Pokus o smazání neexistujícího ID $id.", 'student_errors');
                return "Žák nebyl nalezen.";
            }
            return "Smazání se nezdařilo.";
        } catch (PDOException $e) {
            LogError::logError("(StudentsDB - deleteStudent) SQL chyba: " . $e->getMessage(), 'student_errors');
            return "Chyba při mazání žáka.";
        }
    }

    /**
     * Vrátí seznam všech studentů.
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
            LogError::logError("(StudentsDB - allStudents) SQL chyba: " . $e->getMessage(), 'student_queries');
            return [];
        }
    }
}
?>