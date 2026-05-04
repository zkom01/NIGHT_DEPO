<?php
require_once __DIR__ . '/LogError.php';

/**
 * Třída pro správu obrázků uživatelů v databázi a na disku.
 */
class PhotoDB {

    /**
     * Uloží záznam o novém obrázku do databáze.
     *
     * @param PDO    $conn       Objekt připojení k databázi.
     * @param int    $user_id    ID uživatele, kterému obrázek patří.
     * @param string $image_name Vygenerovaný název souboru (bez cesty).
     * @return array{success: bool, message: string}
     */
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

    /**
     * Vrátí seznam všech obrázků daného uživatele.
     *
     * @param PDO $conn    Objekt připojení k databázi.
     * @param int $user_id ID uživatele.
     * @return array{success: bool, data?: array, message?: string}
     */
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

    /**
     * Smaže záznam obrázku z databáze a soubor z disku.
     * Pokud je po smazání adresář prázdný, odstraní jej také.
     *
     * @param PDO    $conn       Objekt připojení k databázi.
     * @param int    $image_id   ID obrázku ke smazání.
     * @param string $image_path Absolutní nebo relativní cesta k souboru na disku.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function deleteImg($conn, $image_id, $image_path){
        $sql = "DELETE FROM image
                WHERE image_id = :image_id";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":image_id", $image_id, PDO::PARAM_INT);

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    // Smazání fyzického souboru
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }

                    // Smazání prázdné složky uživatele
                    $directory = dirname($image_path); // Získá cestu ke složce z cesty k souboru
                    if (is_dir($directory)) {
                        $files = array_diff(scandir($directory), array('.', '..'));
                        if (empty($files)) {
                            rmdir($directory);
                        }
                    }

                    return "Obrázek s ID $image_id byl úspěšně smazán.";
                } else {
                    return "Obrázek s ID $image_id nebyl nalezen.";
                }
            } else {
                return "Smazání obrázku se nezdařilo.";
            }

        } catch (PDOException $e) {
            return "Chyba při mazání obrázku: " . $e->getMessage();
        }
    }

    /**
     * Načte data jednoho obrázku podle jeho ID.
     *
     * @param PDO $conn     Objekt připojení k databázi.
     * @param int $image_id ID obrázku.
     * @return array|string Asociativní pole s daty obrázku, nebo textová chybová zpráva.
     */
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
                LogError::logError("(class PhotoDB - getOneImage) Image s ID $image_id nebyl nalezen v databázi.", 'getOneImage_errors');
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