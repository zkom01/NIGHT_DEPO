<?php
class CollegeDB {
    public static function allCollege($conn) {
            $sql = "SELECT id, name 
                    FROM college 
                    ORDER BY name ASC";

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