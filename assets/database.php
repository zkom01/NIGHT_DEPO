<?php   
require_once '../assets/configDB.php'; 
    /**
     * Navazuje spojení s databází
     * @return mysqli
     * 
     * Tato funkce obsahuje údaje pro připojení k databázi, vytvoří spojení pomocí mysqli_connect a zkontroluje, zda došlo k chybě při připojení. Pokud ano, vypíše chybovou zprávu a ukončí skript. Pokud je připojení úspěšné, vrátí objekt připojení k databázi.
     */
    function connectionDB() {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_user = DB_USER;
        $db_password = DB_PASS;

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name, 3306);

        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
        }

        return $conn;
    } 
    
?>