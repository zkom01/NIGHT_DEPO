<?php
/**
 * Třída pro správu uživatelských dat v databázi přes rozhraní PDO.
 * Zajišťuje registraci, autentizaci a získávání informací o uživatelích.
 */
class UserDB {

    /**
     * Zaregistruje nového uživatele do systému.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param string $first_name Křestní jméno uživatele.
     * @param string $second_name Příjmení uživatele.
     * @param string $email Unikátní e-mailová adresa uživatele.
     * @param string $heslo Již zahashované heslo (např. pomocí password_hash).
     * @return array Pole s klíčem 'success' (bool) a 'message' (string).
     */
    public static function addUser($conn, $first_name, $second_name, $email, $heslo) {
        $sql = "INSERT INTO user (first_name, second_name, email, heslo) 
                VALUES (:first_name, :second_name, :email, :heslo)";

        try {
            $statement = $conn->prepare($sql);

            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->bindValue(":heslo", $heslo, PDO::PARAM_STR);

            $result = $statement->execute();

            return [
                "success" => true,
                "message" => "Uživatel úspěšně přidán."
            ];

        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Chyba při přidávání uživatele: " . $e->getMessage()
            ];
        }
    }

    /**
     * Ověří existenci uživatele a správnost jeho hesla.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param string $email E-mailová adresa zadaná při přihlášení.
     * @param string $heslo Heslo v textové podobě (bude ověřeno proti hashi).
     * @return array Výsledek přihlášení obsahující success, message a případně ID uživatele.
     */
    public static function checkUser($conn, $email, $heslo) {
        $sql = "SELECT id, heslo FROM user 
                WHERE email = :email";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->execute();

            $data = $statement->fetch(PDO::FETCH_ASSOC);

            // Pokud uživatel existuje a heslo sedí
            if ($data && password_verify($heslo, $data['heslo'])) {
                return [
                    "success" => true,
                    "id" => $data['id'],
                    "message" => "Úspěšné přihlášení."
                ];
            } else {
                return [
                    "success" => false,
                    "id" => null,
                    "message" => "Uživatel nenalezen nebo špatné heslo."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "id" => null,
                "message" => "Chyba databáze: " . $e->getMessage()
            ];
        }
    }

    /**
     * Načte základní údaje o uživateli podle jeho ID.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id Unikátní identifikátor uživatele.
     * @return array Pole s daty uživatele (success => true) nebo chybová hláška.
     */
    public static function infoUser($conn, $id) {
        $sql = "SELECT id, first_name, second_name FROM user 
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $data = $statement->fetch(PDO::FETCH_ASSOC);

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
}
?>