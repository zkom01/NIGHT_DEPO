<?php
require '../classes/Auth.php';
require '../classes/Url.php';

session_start(); // spustíme session pro správu uživatelských relací

    Auth::requireLogin();

?>