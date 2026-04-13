<?php
/**
 * Třída pro práci s URL adresami.
 */
class Url {

    /**
     * Provede přesměrování uživatele na zadanou cestu v rámci aktuální domény.
     * Metoda automaticky detekuje použitý protokol (HTTP nebo HTTPS) a 
     * sestaví absolutní URL adresu pro hlavičku 'Location'.
     *
     * @param string $path Relativní cesta k souboru nebo endpointu (např. 'login.php' nebo 'admin/dashboard').
     * @return void
     */
    public static function redirectUrl($path) {
        if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {
            $protocol = "https";
        } else {
            $protocol = "http";
        }

        header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . "/$path"); // přesměrujeme na zadanou URL
        exit;
    }

    public static function flashMessage ($text_message, $type){
        $_SESSION['success_message'] = [
            'text' => $text_message,
            'type' => $type
        ];
    }
}

?>