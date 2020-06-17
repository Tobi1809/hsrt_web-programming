<?php

    //Sicherheitskontrolle, um nicht unbewusst Login zu überspringen!
    session_start();

    //Daten in Variablen speichern
    $email ="";
    $password ="";

    //Variablen für Datenprüfung und Loginprüfung
    $emailAndPassword = false;
    $loginSuccess = false;

    //Sind die $_POST Werte vorhanden beim Button-click "Login"
    if (isset($_POST['email']))
	{
		$email = $_POST['email'];
	}

	if (isset($_POST['password']))
	{
        //Verschlüsselung des Passworts mit SHA 256 für die Datenbank
		$password = hash('sha256', $_POST['password']);
	}

    //Falls nichts in den Feldern angegeben wurde
	if ($email=="" || $password=="")
	{
		echo "Bitte füllen Sie die Felder vollständig aus!";
    }
	else
	{
        $emailAndPassword = true;
        //Nur zu Debugzwecken - kann auskommentiert werden!
		//echo "<br> $sEmail <br>";
		//echo "$sPassword <br>";
    }
    
    //Mit der Datenbank verbinden auf lokalem Server - nur wenn Variable true zurückgibt! 
	if ($emailAndPassword)
	{
		try
		{
			//Öffnen der Datenbank-Verbindung
			$dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

			if (!$dbConnection)
			{
				echo "Fehler: Konnte nicht mit MySQL verbinden." .PHP_EOL;
				echo "Debug-Fehlernummer: " .mysqli_connect_errno() .PHP_EOL;
				echo "Debug-Fehlermledung: " .mysqli_connect_error() .PHP_EOL;
				exit;
			}

			//SQL Syntax - wählt alle Zeilen aus, wo Email und Passwort den eingegebenen Daten entspricht
			$sql = "SELECT * FROM ws_users where email ='$email' and password ='$password'";

            $result = $dbConnection->query($sql);

            //Nur zu Debugzwecken - kann auskommentiert werden!
            //var_dump($sql);

            //Falls die Tabelle genau eine Reihe (Datensatz) besitzt, wo die Sql-Abfrage true ergibt
			if ($result->num_rows == 1)
			{
                while ($row = $result->fetch_assoc())
                {
                    //Speichert Werte aus der Tabelle ws_users in der Session
                    $_SESSION['userid'] = $row["userID"];
                    $_SESSION['email'] = $row["email"];
                    $_SESSION['login'] = 111;
                    $_SESSION['zeit'] = time();
                }
				//Login erfolgreich
				$loginSuccess = true;
			}
			else
			{
				echo "Fehler beim Verbinden mit der Datenbank: Line 78";
			}

			//Datenbank-Verbindung wieder schließen!
			mysqli_close($dbConnection);
		}
		catch (Exception $e)
		{
			echo "Fehler beim Verbinden mit der Datenbank: Line 86";
		}

	}

	//Login erfolgreich?
	if ($loginSuccess)
	{
		//Weiterleitung auf Home-Seite
		header("location: homeUser.php");
	}
	else
	{
        //Weiterleitung, falls ungültige E-Mail-Adresse und/oder Passwort eingegeben worden ist
		header("location: ../html/loginError.html");
	}

?>