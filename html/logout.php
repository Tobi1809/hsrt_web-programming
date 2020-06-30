<?php
session_start();

//Sicherheitsprüfung!
if ($_SESSION['login'] != 111)
{
    //Sofort Weiterleitung zum Login - falls User nicht eingeloggt ist und auf diese Seite zugreifen will
    header("Location: login.php");
}

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

// Löschen aller Session-Variablen.
$_SESSION = array();

/* Falls die Session gelöscht werden soll, löschen Sie auch das Session-Cookie.
// Achtung: Damit wird die Session gelöscht, nicht nur die Session-Daten!
*/
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"],
        $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Zum Schluss - löschen der Session
session_destroy();

header("Location: home.php");

?>