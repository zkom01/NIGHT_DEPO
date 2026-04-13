<?php 
/**
 * Třída pro správu autentizace a autorizace uživatelů.
 */
class Auth {

    /**
     * Ověří, zda je uživatel přihlášen (pouze vrací true/false).
     */
    public static function isLoggedIn() {
        return isset($_SESSION['is_log_in']) && $_SESSION['is_log_in'];
    }

    /**
     * Vynutí přihlášení uživatele. Pokud není přihlášen, provede redirect.
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {

            Url::flashMessage('NEPOVOLENÝ PŘÍSTUP!!','error');
            Url::redirectUrl("../index.php");
            exit();
        }
    }
}