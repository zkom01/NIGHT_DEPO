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

    public static function requireAdmin() {
        // Nejprve zkontrolujeme, zda je vůbec přihlášen
        self::requireLogin();

        // Poté zkontrolujeme roli
        if (!isset($_SESSION['role_user_log_in']) || $_SESSION['role_user_log_in'] !== 'admin') {
            Url::flashMessage('Nemáte oprávnění k této akci!', 'error');
            Url::redirectUrl("../index.php");
            exit();
        }
    }
}