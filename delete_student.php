<?php
require 'assets/database.php'; // načteme soubor s funkcemi pro práci s databází
require 'assets/url.php';
session_start(); // spustíme session pro ukládání hlášek o úspěchu nebo chybě

$conn = connectionDB(); // zavoláme funkci pro připojení k databázi a uložíme připojení do proměnné $conn
$id = $_GET['id']; // získáme ID studenta z URL
$result = deleteStudent($conn, $id); // zavoláme funkci pro smazání studenta z databáze a uložíme výsledek do proměnné $result

$_SESSION['success_message'] = $result; // uložíme výsledek do session, aby se zobrazil na další stránce
redirectUrl("students.php"); // přesměrujeme na stránku se seznamem studentů
exit(); // ukončíme skript, aby se zabránilo dalšímu vykonávání kódu po přesměrování

?>