<?php  
require __DIR__ . '/../assets/configDB.php';

/**
 * Třída pro správu databázového připojení.
 */
class Database {

    /**
     * Vytvoří a vrátí instanci PDO připojení k databázi.
     *
     * Tato metoda inicializuje spojení s MySQL serverem pomocí ovladače PDO.
     * V případě selhání dojde k výpisu chyby a ukončení skriptu.
     * * @return PDO Objekt reprezentující aktivní připojení k databázi.
     * @throws PDOException Pokud se připojení nezdaří a není zachyceno v try-catch bloku.
     */
    public function connectionDB() {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_user = DB_USER;
        $db_password = DB_PASS;
        
        $conn = "mysql:host=" . $db_host . "; dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($conn, $db_user, $db_password);
            // Nastavení režimu vyhazování výjimek pro lepší ladění
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e){
            // Zavoláme pomocnou metodu pro logování
            $this->logError($e->getMessage());
            
            // Uživateli ukážeme upozornění
            die("Došlo k chybě při spojení s databází. Správce byl informován.");
        }
    } 

    /**
     * Zapíše detailní chybu do souboru včetně kontextu (IP, URL).
     */
    private function logError($message) {
        $logFile = __DIR__ . '/db_errors.log'; 
        
        $timestamp = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'neznámá IP';
        $uri = $_SERVER['REQUEST_URI'] ?? 'neznámé URI';
        
        $formattedMessage = "[$timestamp] [IP: $ip] [URL: $uri] CHYBA: $message" . PHP_EOL;

            // test: pokud zápis selže, vyhodí to chybu na obrazovku
            if (file_put_contents($logFile, $formattedMessage, FILE_APPEND) === false) {
                echo "Kritická chyba: Do souboru $logFile nelze zapisovat. Prověřte práva.";
            }
    }
}
    
?>