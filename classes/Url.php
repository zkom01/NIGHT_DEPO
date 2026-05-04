<?php
/**
 * Pomocná třída pro práci s URL adresami a flash zprávami.
 */
class Url {

    /**
     * Přesměruje uživatele na zadanou relativní cestu.
     *
     * Automaticky detekuje protokol (HTTP/HTTPS) a sestaví absolutní URL.
     *
     * @param string $path Relativní cesta v rámci domény (např. 'login.php' nebo 'admin/index_admin.php').
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

    /**
     * Uloží flash zprávu do session pro zobrazení na další stránce.
     *
     * @param string $text_message Text zprávy zobrazené uživateli.
     * @param string $type         Typ zprávy – 'success' nebo 'error' (ovlivňuje CSS třídu).
     * @return void
     */
    public static function flashMessage ($text_message, $type){
        $_SESSION['success_message'] = [
            'text' => $text_message,
            'type' => $type
        ];
    }
}

?>