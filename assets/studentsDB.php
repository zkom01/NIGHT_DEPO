<?php
    
    /**
     * Přidává nového studenta do databáze
     * @param mysqli $conn
     * @param string $first_name
     * @param string $second_name
     * @param int $age
     * @param string $life
     * @param string $college
     * @return string
     * 
     * Tato funkce přijímá připojení k databázi a informace o studentovi, připraví SQL dotaz pro vložení nového studenta do tabulky, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěšném přidání studenta. Pokud dojde k chybě, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function addStudent($conn, $first_name, $second_name, $age, $life, $college) {
        $sql = "INSERT INTO student (first_name, second_name, age, life, college) 
                VALUES (?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "ssiss", htmlspecialchars($first_name), htmlspecialchars($second_name), $age, htmlspecialchars($life), htmlspecialchars($college)); // navážeme parametry

        $result = mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        if ($result) {
            return "Žák úspěšně přidán.";
        } else {
            return "Chyba při přidávání žáka: " . mysqli_error($conn);
        }
    }

    /**
     * Upravuje informace o studentovi v databázi
     * @param mysqli $conn
     * @param int $id
     * @param string $first_name
     * @param string $second_name
     * @param int $age
     * @param string $life
     * @param string $college
     * @return string
     *
     * Tato funkce upraví informace o studentovi v databázi na základě jeho ID. Připraví SQL dotaz pro aktualizaci informací o studentovi, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěšném upravení studenta. Pokud dojde k chybě, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function editStudent($conn, $id, $first_name, $second_name, $age, $life, $college) {
        $sql = "UPDATE student
                SET first_name = ?, second_name = ?, age = ?, life = ?, college = ?
                WHERE id = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "ssissi", htmlspecialchars($first_name), htmlspecialchars($second_name), $age, htmlspecialchars($life), htmlspecialchars($college), $id); // navážeme parametry

        $result = mysqli_stmt_execute($statement); // vykonáme SQL dotaz a vrátíme výsledek

        if ($result) {
            return "Žák úspěšně upraven.";
        } else {
            return "Chyba při úpravě žáka: " . mysqli_error($conn);
        }
    }

    /**
     * Maže studenta z databáze na základě jeho ID
     * @param mysqli $conn  
     * @param int $id
     * @return string
     * 
     * Tato funkce přijímá připojení k databázi a ID studenta, připraví SQL dotaz pro smazání studenta z tabulky, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěšném smazání studenta. Pokud dojde k chybě, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function deleteStudent($conn, $id) {
        $sql = "DELETE FROM student
                WHERE id = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "i", $id); // navážeme parametry

        $result = mysqli_stmt_execute($statement); // vykonáme SQL dotaz a vrátíme výsledek

        if ($result) {
            return "Žák s ID $id byl úspěšně smazán.";
        } else {
            return "Chyba při mazání žáka: " . mysqli_error($conn);
        }
    }

    /**
     * Získává informace o jednom studentovi z databáze na základě jeho ID
     * @param mysqli $conn
     * @param int $id   
     * @return array|string 
     * 
     * Tato funkce přijímá připojení k databázi a ID studenta, připraví SQL dotaz pro získání informací o studentovi, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný a student s daným ID existuje, vrátí informace o studentovi jako asociativní pole. Pokud student s daným ID není nalezen, vrátí zprávu o nenalezení studenta. Pokud dojde k chybě při získávání informací, vrátí chybovou zprávu s informací o chybě z databáze.
     */
    function getOneStudent($conn, $id, $columns = "*") {
        $sql = "SELECT $columns
                FROM student
                WHERE id = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "i", $id); // navážeme parametry

        mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        $result = mysqli_stmt_get_result($statement); // získáme výsledek dotazu

        if ($result) {
            $data = mysqli_fetch_assoc($result);
            if ($data) {
                return $data; // vrátíme informace o studentovi jako asociativní pole
            } else {
                return "Student s ID $id nebyl nalezen v databázi."; // student s daným ID nebyl nalezen
            }   
        } else {
            return "Chyba při získávání informací o žáku: " . mysqli_error($conn);
        }   
    }

    /**
     * Získává informace o všech studentech z databáze
     * @param mysqli $conn
     * @return array
     * 
     * Tato funkce přijímá připojení k databázi a vrací informace o všech studentech jako pole asociativních polí.
     */
    function allStudents($conn, $columns = "*") {
        $sql = "SELECT $columns
                FROM student
                WHERE id > 0";

        try {
            $result = mysqli_query($conn, $sql);
        } 
        catch (Exception $e) {
            echo "Chyba při provádění dotazu: " . $e->getMessage();
            exit; // ukončí skript, pokud dojde k chybě
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC); // vrátí všechny studenty jako pole asociativních polí
    }

?>