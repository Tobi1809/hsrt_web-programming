<?php

    //Session starten
    session_start();

    //Öffnen der Datenbank-Verbindung
    include ("../backendPhp/dbConnection.php");

    //Die Klasse verfügbar machen
    include_once ("../backendPhp/cart.php");

    //Eine Neue Instanz der Klasse cart erstellen
    $cart = new Cart();


    $subTotal = 0;
    $Array = $_SESSION['cartArray'];
    
    for($i = 0 ; $i < count($Array); $i++)
    {
        $innerArray = $Array[$i];
        $subTotal+= $innerArray[4];
    }

    if ($_GET["selection"] == "5")
	{
        $shippingCosts = 5;
        $totalAmount = $subTotal + $shippingCosts;

		echo insertTotalAmount($totalAmount);
	}
	elseif ($_GET["selection"] == "15") 
	{
		$shippingCosts = 15;
        $totalAmount = $subTotal + $shippingCosts;

		echo insertTotalAmount($totalAmount);
    }
    elseif ($_GET["selection"] == "")
    {
        $shippingCosts = 0;

        echo "$subTotal €";
    }

    function insertTotalAmount($totalAmount) //What is this??
    {
        return $totalAmount;
    }
