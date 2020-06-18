<?php

    //Öffnen der Datenbank-Verbindung
    $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

    if (!$dbConnection)
    {
        echo "Fehler: Konnte nicht mit MySQL verbinden." .PHP_EOL;
        echo "Debug-Fehlernummer: " .mysqli_connect_errno() .PHP_EOL;
        echo "Debug-Fehlermledung: " .mysqli_connect_error() .PHP_EOL;
         exit;
    }

    //Sind die $_POST Werte vorhanden beim Button-click "Registrieren"
    if (isset($_POST['firstname']))
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $street = $_POST['street'];
        $zip = $_POST['zip'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        //$passwordrepeat = $_POST['passwordrepeat'];

        //SQL Syntax - Überprüfung, ob die E-Mail-Adresse registriert ist oder nicht
        $sql = "SELECT * FROM ws_users where email ='$email'";
        $result1 = $dbConnection->query($sql);

        if ($result1->num_rows == 1) //Wenn E-Mail-Adresse bereits registriert ist...
        {
            header("Location: ../html/alreadyRegisteredUser.html");
        }
        else //Wenn E-Mail-Adresse noch nicht vorhanden in der Datenbank...
        {
            //$password = hash('sha256', $password);

            $sql = "INSERT INTO ws_users (firstName, lastName, street, zip, city, email, password) VALUES
            ('$firstname','$lastname','$street','$zip','$city','$email','$password')";

            $result2 = $dbConnection->query($sql);
        }

        //Registrierungsbestätigung per E-Mail hier noch einfügen!


        //Start Session and initialize Variables
        session_start();
        $_SESSION['login'] = 111;
        $_SESSION['uid'] = $row["id"];
        $_SESSION['firstname'] = $row["firstname"];
        $_SESSION['lastname'] = $row["lastname"];
        
        $_SESSION['lastActiveTime'] = time();
        //Weiterleitung zu Startseite!
        header("Location: ../html/home.php");

    }

?>