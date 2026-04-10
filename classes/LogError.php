<?php 
/**
 * Třída pro systémové logování chyb do souboru.
 * * Zajišťuje zápis chybových hlášení včetně časové značky, IP adresy odesílatele
 * a aktuální URL adresy pro snadnější diagnostiku problémů.
 */
class LogError {

    /**
     * Zapíše detailní chybu do logovacího souboru.
     * * Metoda automaticky spravuje logovací složku, ošetřuje kódování UTF-8 (BOM)
     * a umožňuje kategorizaci logů do různých souborů. V případě fatálního selhání
     * zápisu využívá systémový error_log PHP.
     *
     * @param string $message Text chybové zprávy k uložení.
     * @param string $logName Název souboru (bez přípony), do kterého se má zapisovat. Výchozí je 'error'.
     * @return void
     */
    public static function logError($message, $logName = 'error') {
        // 1. Definice absolutní cesty k úložišti logů
        $logDir = __DIR__ . '/../errors/';
        $logFile = $logDir . $logName . '.log'; 

        // 2. Kontrola a vytvoření složky s rekurzivním přístupem
        if (!is_dir($logDir)) {
            if (!mkdir($logDir, 0777, true)) {
                // Pokud selže i systémový mkdir, zapíšeme do systémového logu serveru
                error_log("Nelze vytvořit složku pro logy: $logDir");
                return;
            }
        }

        // 3. Inicializace nového souboru s podporou UTF-8 (BOM)
        if (!file_exists($logFile)) {
            file_put_contents($logFile, "\xEF\xBB\xBF");
            chmod($logFile, 0666); // Nastavení práv pro čtení i zápis pro webserver
        }
        
        // Sběr metadat o požadavku
        $timestamp = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'neznámá IP';
        $uri = $_SERVER['REQUEST_URI'] ?? 'neznámé URI';
        
        // Sestavení finálního řádku logu
        $formattedMessage = "[$timestamp] [IP: $ip] [URL: $uri] CHYBA: $message" . PHP_EOL;

        // 4. Bezpečný zápis na konec souboru
        if (file_put_contents($logFile, $formattedMessage, FILE_APPEND) === false) {
            error_log("Kritická chyba: Do souboru $logFile nelze zapisovat.");
        }
    }
}
?>