<?php    
    $db_host = "db.r3.active24.cz";
    $db_user = "DB_nightdepo_user";
    $db_password = "Pondeli4381+";
    $db_name = "DB_night_depo";

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }
?>