<?php    
    /**
     * Navazuje spojení s databází
     * @return mysqli
     * 
     * Tato funkce obsahuje údaje pro připojení k databázi, vytvoří spojení pomocí mysqli_connect a zkontroluje, zda došlo k chybě při připojení. Pokud ano, vypíše chybovou zprávu a ukončí skript. Pokud je připojení úspěšné, vrátí objekt připojení k databázi.
     */
    function connectionDB() {
        $db_host = "db.r3.active24.cz";
        $db_user = "DB_nightdepo_user";
        $db_password = "Pondeli4381+";
        $db_name = "DB_night_depo";

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
        }

        return $conn;
    } 

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
     * Tato funkce přijímá připojení k databázi a údaje o žákovi, připraví SQL dotaz pro vložení dat do tabulky student, naváže parametry a vykoná dotaz. Pokud je dotaz úspěšný, vrátí zprávu o úspěchu včetně ID nově přidaného žáka. Pokud dojde k chybě, vrátí zprávu s chybou.
     */
    function addStudent($conn, $first_name, $second_name, $age, $life, $college) {
        $sql = "INSERT INTO student (first_name, second_name, age, life, college) 
                VALUES (?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "ssiss", $first_name, $second_name, $age, $life, $college); // navážeme parametry

        $result = mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        if ($result) {
            header('Location: students.php'); // přesměrujeme na hlavní stránku s žáky
            // $id = mysqli_insert_id($conn); // získáme ID nově přidaného žáka    
            // return "Žák úspěšně přidán! Jeho ID je: " . $id; // vrátíme zprávu o úspěchu
        } else {
            return "Chyba při přidávání žáka: " . mysqli_error($conn);
        }
    }

    /**
     * Získává informace o jednom studentovi z databáze
     * @param mysqli $conn
     * @param int $id
     * @return array|false
     * 
     * Tato funkce přijímá připojení k databázi a ID studenta, připraví SQL dotaz pro získání informací o daném studentovi, naváže parametr a vykoná dotaz. Pokud je dotaz úspěšný, vrátí informace o studentovi jako asociativní pole. Pokud dojde k chybě, vrátí false.
     */
    function getOneStudent($conn, $id) {
        $sql = "SELECT *
                FROM student
                WHERE id = ?";

        $statement = mysqli_prepare($conn, $sql); // připravíme SQL dotaz

        mysqli_stmt_bind_param($statement, "i", $id); // navážeme parametry

        mysqli_stmt_execute($statement); // vykonáme SQL dotaz

        $result = mysqli_stmt_get_result($statement); // získáme výsledek dotazu

        return mysqli_fetch_assoc($result); // vrátíme informace o studentovi jako asociativní pole
    }

    /**
     * Získává informace o všech studentech z databáze
     * @param mysqli $conn
     * @return array
     * 
     * Tato funkce přijímá připojení k databázi a vrací informace o všech studentech jako pole asociativních polí.
     */
    function allStudents($conn) {
        $sql = "SELECT id, first_name, second_name
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