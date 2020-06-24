<?php
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
    $sql = "SELECT UserID FROM webshop.ws_users where active=1";
    $result = $dbConnection->query($sql);
    $numActiveUsers;-


    mysqli_close($dbConnection);
} catch (Exception $e) {
    echo "Error Connecting to database";
}
