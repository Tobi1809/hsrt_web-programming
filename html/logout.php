<?php
session_start();


try {
    //Öffnen der Datenbank-Verbindung
    $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

    if (!$dbConnection) {
        echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
        echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    //update active status
    $uid = $_SESSION['uid'];
    $thisTime = time();
    $sql = "UPDATE webshop.ws_users SET active = 0, lastLoginTime = $thisTime WHERE userID = $uid";
    $result = $dbConnection->query($sql);


    mysqli_close($dbConnection);
} catch (Exception $e) {
    echo "Error Connecting to database";
}


session_destroy();

header("Location: home.php");

?>