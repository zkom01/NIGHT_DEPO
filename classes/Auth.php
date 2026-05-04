<?php 
/**
 * Třída pro správu autentizace a autorizace uživatelů.
 *
 * Poskytuje statické metody pro ověření přihlášení a kontrolu role.
 * Vyžaduje aktivní session (session_start() musí být zavoláno před použitím).
 */
class Auth {

    /**
     * Ověří, zda je uživatel přihlášen.
     */
    public static function isLoggedIn() {
        return isset($_SESSION['is_log_in']) && $_SESSION['is_log_in'];
    }

    /**
     * Vynutí přihlášení uživatele.
     * Pokud není přihlášen, zobrazí chybovou zprávu a přesměruje na úvodní stránku.
     *
     * @return void
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            Url::flashMessage('NEPOVOLENÝ PŘÍSTUP!!', 'error');
            Url::redirectUrl("../index.php");
            exit();
        }
    }

    /**
     * Vynutí oprávnění administrátora nebo super-administrátora.
     * Nejprve ověří přihlášení, poté zkontroluje roli.
     *
     * @return void
     */
    public static function requireAdmin() {
        self::requireLogin();

        $role = $_SESSION['role_user_log_in'] ?? '';
        if ($role !== 'admin' && $role !== 'super_admin') {
            Url::flashMessage('Nemáte oprávnění k této akci!', 'error');
            Url::redirectUrl("../index.php");
            exit();
        }
    }

     /**
     * Vynutí oprávnění super-administrátora.
     * Nejprve ověří přihlášení, poté zkontroluje roli.
     *
     * @return void
     */
    public static function requireSuperAdmin() {
        self::requireLogin();

        if (($_SESSION['role_user_log_in'] ?? '') !== 'super_admin') {
            Url::flashMessage('Nemáte oprávnění k této akci!', 'error');
            Url::redirectUrl("../index.php");
            exit();
        }
    }
}