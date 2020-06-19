<?php
//Sind die $_POST Werte vorhanden beim Button-click "Registrieren"
if (isset($_POST['firstname'])) //#! Check clientside with js if values are set
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $street = $_POST['street'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    try {
        //Öffnen der Datenbank-Verbindung
        $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

        if (!$dbConnection) {
            echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
            echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        //SQL Syntax - Überprüfung, ob die E-Mail-Adresse registriert ist oder nicht
        $sql = "SELECT * FROM ws_users where email ='$email'";
        $result1 = $dbConnection->query($sql);

        if ($result1->num_rows >= 1) //Wenn E-Mail-Adresse bereits registriert ist...
        {
            echo "failed";
        } else //Wenn E-Mail-Adresse noch nicht vorhanden in der Datenbank...
        {
            //$password = hash('sha256', $password);

            $sql = "INSERT INTO ws_users (firstName, lastName, street, zip, city, email, password) VALUES
                ('$firstname','$lastname','$street','$zip','$city','$email','$password')";
            $result2 = $dbConnection->query($sql);

            //Registrierungsbestätigung per E-Mail hier noch einfügen! #!

            // get User ID of newly registered user // could be optimized be including it in sql query above
            $sql = "SELECT UserID FROM webshop.ws_users where email='$email';";
            $result3 = $dbConnection->query($sql);
            $uid = intval($result3->fetch_assoc()["UserID"]);   //with typeconversion

            //Start Session and initialize Variables
            $sessionStarted = session_start();
            $_SESSION['login'] = 111;
            $_SESSION['uid'] = $uid;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['lastActiveTime'] = time();

            //Rückgabewert für ajax anfrage
            echo "success";
        }
        mysqli_close($dbConnection);
    } catch (Exception $e) {
        echo "Error Connecting to database";
        exit;
    }
    // here shouldn't be any code! #?
}
