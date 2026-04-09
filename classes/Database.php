<?php  
require_once __DIR__ . '/../assets/configDB.php';
require_once __DIR__ . '/LogError.php';


/**
 * Třída zajišťující konektivitu k databázovému serveru.
 * * Zapouzdřuje konfiguraci a inicializaci PDO objektu. V případě selhání
 * automaticky deleguje záznam chyby logovacímu systému a zajišťuje
 * bezpečný návrat uživatele na úvodní stránku aplikace.
 */
class Database {

    /**
     * Vytvoří a nakonfiguruje připojení k databázi pomocí PDO.
     * * Metoda využívá globální konstanty pro přístup k DB. Pokud spojení selže,
     * dojde k zachycení výjimky PDOException, jejímu zalogování a přesměrování
     * s informativní zprávou v session.
     *
     * @return PDO Objekt aktivního připojení k databázi připravený k dotazování.
     * @throws PDOException Pouze v případě, že by selhal mechanismus přesměrování (standardně neprobublá).
     */
    public function connectionDB() {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_user = DB_USER;
        $db_password = DB_PASS;
        
        $conn = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($conn, $db_user, $db_password);
            // Nastavení režimu vyhazování výjimek pro efektivní try-catch bloky
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e){
            // Zápis technického detailu do skrytého logu
            LogError::logError($e->getMessage());

            // Příprava session pro zobrazení chyby uživateli
            if (session_status() === PHP_SESSION_NONE) session_start();

            session_regenerate_id(true);
            $_SESSION['success_message'] = [
                'text' => "Došlo k chybě při spojení s databází.",
                'type' => 'error'
            ];

            // Bezpečné ukončení a návrat na index
            Url::redirectUrl("./index.php");
            exit;
        }
    } 

}
    
?>