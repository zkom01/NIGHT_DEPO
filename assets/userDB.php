<?php

/**
     * Přidává nového uživatele do databáze
     * @param mysqli $conn
     * @param string $first_name
     * @param string $email
     * @param string $password
     * @return string
     * 
     * Tato funkce přijímá připojení k databázi a informace o uživateli, připraví SQL dotaz pro vložení nového uživatele do tabulky, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěšném přidání uživatele. Pokud dojde k chybě, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function addUser($conn, $first_name, $second_name, $email, $heslo) {
        $sql = "INSERT INTO user (first_name, second_name, email, heslo) 
                VALUES (?, ?, ?, ?)";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "ssss", htmlspecialchars($first_name), htmlspecialchars($second_name), htmlspecialchars($email), htmlspecialchars($heslo)); // navážeme parametry

        $result = mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        if ($result) {
            // Vrátíme pole s ID i zprávou
            return [
                "success" => true,
                "message" => "Uživatel úspěšně přidán."
            ];
        } else {
            // Vrátíme pole s informací o chybě
            return [
                "success" => false,
                "message" => "Chyba při přidávání uživatele: " . mysqli_error($conn)
            ];
        }
    }

    /**
     * Kontrola zda je uživatel v databázi
     * @param mysqli $conn
     * @param string $first_name
     * @param string $email
     * @param string $password
     * @return string
     * 
     * Tato funkce přijímá připojení k databázi a informace o uživateli, připraví SQL dotaz pro kontrolu jestli je uživatel v databázi, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěšném nalezení uživatele. Pokud dojde k chybě, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function checkUser($conn, $email, $heslo) {
        $sql = "SELECT id, heslo FROM user 
                WHERE email = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "s", ($email)); // navážeme parametry
        mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        $result = mysqli_stmt_get_result($statement);
        $data = mysqli_fetch_assoc($result);

        if(password_verify($heslo, $data['heslo'])) {
            return [
                "success" => true,
                "id" => $data['id'],
                "message" => "Úspěšné přihlášení."
            ];
        } else {
            return [
                "success" => false,
                "id" => null,
                "message" => "Uživatel nenalezen nebo špatné heslo."
            ];
        }
    }

    /**
     * Informace o uživateli
     * @param mysqli $conn
     * @param string $first_name
     * @param string $email
     * @param string $password
     * @return string
     * 
     * Tato funkce přijímá připojení k databázi a id uživatele, připraví SQL dotaz pro kontrolu jestli je uživatel v databázi, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí informace o uživateli. Pokud dojde k chybě, vrátí chybovou zprávu.
     */
    function infoUser($conn, $id) {
        $sql = "SELECT id,first_name,second_name FROM user 
                WHERE id = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "i", ($id)); // navážeme parametry
        mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        $result = mysqli_stmt_get_result($statement);

        if ($result) {
        $data = mysqli_fetch_assoc($result);
        return [
            "success" => true,
            "data" => $data
        ];
        } else {
            // Vrátíme pole s informací o chybě
            return [
                "success" => false,
                "message" => "Uživatel nenalezen."
            ];
        }
    }

    ?>