<?php 

function isLoggedIn($sesion) {
    return isset($sesion) and $sesion;
}

?>