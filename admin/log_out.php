<?php
    session_start(); // pro přístup k $_SESSION 
    require '../classes/Url.php';

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();

    session_start(); // pro přístup k $_SESSION 
    session_regenerate_id(true); // zabranuje provedení fixation attack
    Url::flashMessage('Odhlášení proběhlo úspěšně','');
    Url::redirectUrl("../index.php");
    exit(); // Zastaví vykonávání skriptu

?>