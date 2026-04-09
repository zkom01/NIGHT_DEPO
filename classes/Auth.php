<?php 
/**
 * Třída pro správu autentizace a autorizace uživatelů.
 */
class Auth {

    /**
     * Ověří, zda je uživatel aktuálně přihlášen.
     * * Metoda kontroluje, zda je předaná proměnná (typicky prvek $_SESSION) 
     * nastavena a zda má pravdivou hodnotu.
     *
     * @param mixed $session Konkrétní prvek session (např. $_SESSION['is_logged_in']).
     * @return bool Vrací true, pokud je uživatel přihlášen, jinak false.
     */
    public static function isLoggedIn($session) {
        return isset($session) && $session;
    }
}
?>