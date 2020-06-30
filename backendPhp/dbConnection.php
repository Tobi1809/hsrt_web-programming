<?php

//Öffnen der Datenbank-Verbindung
$dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

		if (!$dbConnection) {
			echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
			echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
        
