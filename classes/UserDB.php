<?php
require_once __DIR__ . '/LogError.php';
/**
 * Třída pro správu uživatelských dat v databázi přes rozhraní PDO.
 * Zajišťuje registraci, autentizaci a získávání informací o uživatelích.
 */
class UserDB {

    /**
     * Zaregistruje (přidá) nového uživatele do systému.
     *
     * @param PDO    $conn        Objekt připojení k databázi.
     * @param string $first_name  Křestní jméno.
     * @param string $second_name Příjmení.
     * @param string $email       Unikátní e-mailová adresa.
     * @param string $heslo       Již zahashované heslo (password_hash).
     * @param string $role        Role uživatele ('user', 'admin', 'super_admin').
     * @return array{success: bool, message: string}
     */
    public static function addUser($conn, $first_name, $second_name, $email, $heslo, $role) {
        $sql = "INSERT INTO user (first_name, second_name, email, heslo, role) 
                VALUES (:first_name, :second_name, :email, :heslo, :role)";

        try {
            $statement = $conn->prepare($sql);

            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->bindValue(":heslo", $heslo, PDO::PARAM_STR);
            $statement->bindValue(":role", $role, PDO::PARAM_STR);

            $result = $statement->execute();

            return [
                "success" => true,
                "message" => "Uživatel úspěšně přidán.",
            ];

        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Chyba při přidávání uživatele: " . $e->getMessage()
            ];
        }
    }

    /**
     * Ověří existenci uživatele a správnost jeho hesla (přihlášení).
     *
     * @param PDO    $conn  Objekt připojení k databázi.
     * @param string $email E-mailová adresa.
     * @param string $heslo Heslo v čistém textu (ověřuje se přes password_verify).
     * @return array{success: bool, id: int|null, message: string, role: string|null}
     */
    public static function checkUser($conn, $email, $heslo) {
        $sql = "SELECT id, heslo, role FROM user 
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
                    "message" => "Úspěšné přihlášení.",
                    "role" => $data['role']
                ];
            } else {
                return [
                    "success" => false,
                    "id" => null,
                    "message" => "Uživatel nenalezen nebo špatné heslo.",
                    "role" => null
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
     * Načte základní údaje o uživateli podle ID.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id   ID uživatele.
     * @return array{success: bool, data?: array, message?: string}
     */
    public static function infoUser($conn, $id) {
        $sql = "SELECT id, first_name, second_name, email, role 
                FROM user 
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

    /**
     * Ověří, zda v databázi existuje uživatel s daným e-mailem.
     *
     * @param PDO    $conn  Objekt připojení k databázi.
     * @param string $email E-mailová adresa ke kontrole.
     * @return array{success: bool, data?: array, message?: string}
     */
    public static function checkUserbyEmail($conn, $email) {
        $sql = "SELECT email 
                FROM user 
                WHERE email = :email";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
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

    /**
     * Vrátí seznam všech uživatelů.
     *
     * Poznámka: nevybíráme sloupec 'heslo' – hesla se nikdy nepotřebují
     * vypisovat v seznamu uživatelů.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @return array Pole asociativních polí se všemi uživateli.
     */
    public static function allUser($conn) {
        $sql = "SELECT id, first_name, second_name, email, role
                FROM user
                ORDER BY second_name ASC";

        try {
            $statement = $conn->prepare($sql);
            $statement->execute();

            // fetchAll(PDO::FETCH_ASSOC) nahrazuje mysqli_fetch_all($result, MYSQLI_ASSOC)
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            LogError::logError("Chyba při provádění dotazu: " . $e->getMessage(),'UserDB_errors');
            return []; // Vrátíme prázdné pole, aby zbytek aplikace nespadl na chybě iterace (např. ve foreach)
        }
    }

    /**
     * Upraví údaje existujícího uživatele.
     *
     * @param PDO    $conn        Objekt připojení k databázi.
     * @param int    $id          ID uživatele ke změně.
     * @param string $first_name  Nové křestní jméno.
     * @param string $second_name Nové příjmení.
     * @param string $email       Nový e-mail.
     * @param string $role        Nová role.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function editUser($conn, $id, $first_name, $second_name, $email, $role) {
        $sql = "UPDATE user
                SET first_name = :first_name, 
                    second_name = :second_name, 
                    email = :email, 
                    role = :role
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);

            // Navázání všech parametrů
            $statement->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $statement->bindValue(":second_name", $second_name, PDO::PARAM_STR);
            $statement->bindValue(":email", $email, PDO::PARAM_STR);
            $statement->bindValue(":role", $role, PDO::PARAM_STR);
             $statement->bindValue(":id", $id, PDO::PARAM_INT);

            // Provedení dotazu
            if ($statement->execute()) {
                return "Uživatel úspěšně upraven.";
            } else {
                return "Úprava uživatele se nezdařila.";
            }

        } catch (PDOException $e) {
            // Ošetření chyby přes PDO
            return "Chyba při úpravě uživatele: " . $e->getMessage();
        }
    }

    /**
     * Odstraní uživatele z databáze podle ID.
     *
     * @param PDO $conn Objekt připojení k databázi.
     * @param int $id   ID uživatele ke smazání.
     * @return string Potvrzovací nebo chybová zpráva.
     */
    public static function deleteUser($conn, $id) {
        $sql = "DELETE FROM user
                WHERE id = :id";

        try {
            $statement = $conn->prepare($sql);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            // Vykonáme dotaz
            if ($statement->execute()) {
                // Kontrola, zda byl někdo skutečně smazán
                if ($statement->rowCount() > 0) {
                    return "Uživatel s ID $id byl úspěšně smazán.";
                } else {
                    return "Uživatel s ID $id nebyl nalezen, takže nebyl smazán.";
                }
            } else {
                return "Smazání uživatele se nezdařilo.";
            }

        } catch (PDOException $e) {
            // Ošetření chyby databáze
            return "Chyba při mazání uživatele: " . $e->getMessage();
        }
    }

}
?>