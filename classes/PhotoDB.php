<?php
require_once __DIR__ . '/LogError.php';

class PhotoDB {

    public static function addImg($conn, $user_id, $image_name) {
        $sql = "INSERT INTO image (user_id, image_name) 
                VALUES (:user_id, :image_name)";

        try {
            $statement = $conn->prepare($sql);

            $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $statement->bindValue(":image_name", $image_name, PDO::PARAM_STR);
            $result = $statement->execute();

            return [
                "success" => true,
                "message" => "Obrázek úspěšně přidán."
            ];

        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Chyba při nahrávání obrázku: " . $e->getMessage()
            ];
        }
    }

    public static function allImgByUser($conn,$user_id) {
        $sql = "SELECT image_id, user_id, image_name 
                FROM image 
                WHERE user_id = :user_id
                ";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $statement->execute();

            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {
                return [
                    "success" => true,
                    "data" => $data
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Uživatel nenalezen."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Chyba při získávání informací: " . $e->getMessage()
            ];
        }
    }

    public static function deleteImg($conn, $image_id, $image_path){
        $sql = "DELETE FROM image
                WHERE image_id = :image_id";

        try {
            $statement = $conn->prepare($sql);

            // Navážeme ID studenta
            $statement->bindValue(":image_id", $image_id, PDO::PARAM_INT);

            // Vykonáme dotaz
            if ($statement->execute()) {
                // Kontrola, zda bylo něco skutečně smazáno
                if ($statement->rowCount() > 0) {
                    unlink($image_path); // odstraní obrázek ze složky
                    return "Obrázek s ID $image_id byl úspěšně smazán.";
                } else {
                    return "Obrázek s ID $image_id nebyl nalezen.";
                }
            } else {
                return "Smazání obrázku se nezdařilo.";
            }

        } catch (PDOException $e) {
            // Ošetření chyby databáze
            return "Chyba při mazání obrázku: " . $e->getMessage();
        }
    }

    public static function getOneImage($conn, $image_id) {
        $sql = "SELECT *
                FROM image
                WHERE image_id = :image_id";

        try {
            $statement = $conn->prepare($sql);
            
            // Navážeme parametry a provedeme dotaz
            $statement->bindValue(":image_id", $image_id, PDO::PARAM_INT);
            $statement->execute();

            // fetch() vrátí asociativní pole, pokud záznam existuje, jinak vrátí false
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result; // Vrátíme pole s daty obrázku
            } else {
                // Logujeme nenalezení záznamu jako varování
                LogError::logError("(class PhotoDB - getOneImage) Image s ID $id nebyl nalezen v databázi.", 'getOneImage_errors');
                return "Image s ID $image_id nebyl nalezen v databázi.";
            }

        } catch (PDOException $e) {
            // Zalogujeme skutečný technický problém (např. chyba v názvu sloupce)
            LogError::logError("(class PhotoDB - getOneImage) SQL chyba: " . $e->getMessage(), 'getOneImage_errors');
            
            // Uživateli vrátíme jen neutrální zprávu pro zachování bezpečnosti
            return "Omlouváme se, došlo k technické chybě při čtení dat.";
        }
    }
}
?>