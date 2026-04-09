<?php 
/**
 * Třída pro systémové logování chyb do souboru.
 * * Zajišťuje zápis chybových hlášení včetně časové značky, IP adresy odesílatele
 * a aktuální URL adresy pro snadnější diagnostiku problémů.
 */
class LogError {

    /**
     * Zapíše detailní chybu do logovacího souboru.
     * * Metoda automaticky sbírá systémová metadata a připojuje zprávu na konec souboru.
     * Pokud soubor neexistuje, pokusí se jej vytvořit. V případě selhání zápisu
     * (např. kvůli právům k zápisu) vypíše upozornění na obrazovku.
     *
     * @param string $message Text chybové zprávy k uložení.
     * @return void
     */
    public static function logError($message) {
        // Definice cesty k souboru (ve stejném adresáři jako tato třída)
        $logFile = __DIR__ . '/db_errors.log'; 
        
        $timestamp = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'neznámá IP';
        $uri = $_SERVER['REQUEST_URI'] ?? 'neznámé URI';
        
        // Formátování řádku logu
        $formattedMessage = "[$timestamp] [IP: $ip] [URL: $uri] CHYBA: $message" . PHP_EOL;

        // Pokus o zápis do souboru (FILE_APPEND zajistí nepřemazání obsahu)
        if (file_put_contents($logFile, $formattedMessage, FILE_APPEND) === false) {
            // Záložní řešení při selhání přístupových práv
            echo "Kritická chyba: Do souboru $logFile nelze zapisovat. Prověřte práva.";
        }
    }
}
?>