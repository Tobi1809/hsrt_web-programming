<?php

session_start();

//Daten in Variablen speichern
$email = "";
$password = "";

//Variablen für Datenprüfung und Loginprüfung
$loginSuccess = false;


//Sind die $_POST Werte vorhanden beim Button-click "Registrieren"
if (isset($_POST['email'])) //#! Check clientside with js if values are set
{
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
		//SQL Syntax - wählt alle Zeilen aus, wo Email und Passwort den eingegebenen Daten entspricht
		$sql = "SELECT * FROM ws_users where email ='$email' and password ='$password'";
		$result = $dbConnection->query($sql);

		//Falls die Tabelle genau eine Reihe (Datensatz) besitzt, wo die Sql-Abfrage true ergibt
		if ($result->num_rows == 1) {
			while ($row = $result->fetch_assoc()) {
				//Speichert Werte aus der Tabelle ws_users in der Session
				$thisTime = time();
				$uid = $row["userID"];
				$_SESSION['login'] = 111;
				$_SESSION['uid'] = $uid;
				$_SESSION['firstname'] = $row["firstName"];
				$_SESSION['lastname'] = $row["lastName"];
				$_SESSION['lastLoginTime'] = $row["lastLoginTime"];

				//update active status
				$sql2 = "UPDATE webshop.ws_users SET active = 1 WHERE userID = $uid";
				$result2 = $dbConnection->query($sql2);
			}
			//Login erfolgreich			
			echo "success";
		} else {
			echo "failed";
		}

		//Datenbank-Verbindung wieder schließen!
		mysqli_close($dbConnection);
	} catch (Exception $e) {
		echo "Error Connecting to database";
		exit;
	}
	// here shouldn't be any code! #?
}
