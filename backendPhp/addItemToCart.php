<?php

//Die Klasse verfügbar machen
include_once ("../backendPhp/cart.php");

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();


if (isset($_POST['itemID']))
{
    $itemID = $_POST ["itemID"];
    $itemName = $_POST["itemName"];
    $description = $_POST["description"];
    $quantity = "1";
    $price = $_POST["price"];

    $cart->insertProduct($itemID, $itemName, $description, $quantity, $price);

}

header("Location: ../html/home.php");