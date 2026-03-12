<?php

function redirectUrl($path) {
    if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {
        $protocol = "https";
    } else {
        $protocol = "http";
    }

    return header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . "/$path"); // přesměrujeme na zadanou URL
}

?>