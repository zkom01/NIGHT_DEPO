<?php 
require_once __DIR__ . '/LogError.php';
/**
 * Třída pro práci s databází kateder/fakult (college).
 */
class CollegeDB {

    /**
     * Vrátí seznam všech kateder/fakult seřazený abecedně.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @return array Pole asociativních polí s klíči 'id' a 'name', nebo prázdné pole při chybě.
     */
    public static function allColleges($conn) {
        $sql = "SELECT id, name 
                FROM college 
                ORDER BY name ASC";

        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            LogError::logError("Chyba při provádění dotazu: " . $e->getMessage(),'ColageDB_errors');
            return []; // Vrátíme prázdné pole, aby zbytek aplikace nespadl na chybě iterace (např. ve foreach)
        }
    }

}