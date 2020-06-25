<?php

//Session starten
session_start();

//Öffnen der Datenbank-Verbindung
include ("../backendPhp/dbConnection.php");

//Die Klasse verfügbar machen
include_once ("../backendPhp/cart.php");

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

//Prüfen, ob der Warenkorb bereits besteht
$cart->__construct();

if (isset($_POST['button']))
{
    $itemID = $_POST["itemID"];
    $itemName = $_POST["itemName"];
    $description = $_POST["description"];
    $quantity = "1";
    $price = $_POST["price"];

    $cart->insertProduct($itemID, $itemName, $description, $quantity, $price);

}

header("Location: ../html/home.php");