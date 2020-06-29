<?php
//Session starten
session_start();

//Klasse 
include 'sendEmail.php';

//Die Klasse verfügbar machen
include_once("cart.php");
//This is to Process the Order!

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

//Get all the $_POST data from checkout.php
if (isset($_POST['firstname'])) {
    $uid = $_SESSION['uid'];

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $city = $_POST["city"];
    $zip = $_POST["zip"];
    $street = $_POST["street"];
    $houseNumber = "17";
    $itemIDs = $_POST["ItemIDs"];
    $shippingAdress = $zip . "," . $city . "," . $street . "," . $houseNumber . "," . $firstname . "," . $lastname;
    $orderPrice = $_POST["TotalAmountHiddenInput"];

    switch ($_POST["shipping"]) {
        case '5':
            $shippingCosts = 5.00;
            $shippingType = "Normale Lieferung";

            break;
        case '15':
            $shippingCosts = 15.00;
            $shippingType = "Express Lieferung";
            break;
        default:
            header("Location: ../html/orderFailed.php");
            break;
    }
    $orderDate = time();

    try {
        //Öffnen der Datenbank-Verbindung
        $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

        if (!$dbConnection) {
            echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
            echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        // hier sollen die Daten in die Datenbank gespeichert werden
        //here I should test if sum of itemIDs Prices + shipping cost sum Up to orderPrice

        $sql1 = "INSERT INTO ws_orders (userID, orderPrice, shippingCosts, shippingType, orderDate, shippingAdress, itemIDs) VALUES
                ('$uid','$orderPrice','$shippingCosts','$shippingType','$orderDate','$shippingAdress','$itemIDs')";


        $result1 = $dbConnection->query($sql1);




        //email Bestellbestätigung hier einfügen

        //get email
        $sql2 = "SELECT email FROM ws_users WHERE userID = $uid";
        $result2 = $dbConnection->query($sql2);
        $empfaenger_email = $result2->fetch_assoc()["email"];

        //Produkte auseinander fledern
        $length = strlen($itemIDs);
        $itemIDsArr = array();
        $i = 1;
        while ($i < $length) {
            //if($i == ",")(++$i)
            $item = "";
            while ($itemIDs[$i] != ",") {
                $item .= $itemIDs[$i];
                ++$i;
            }
            array_push($itemIDsArr, intval($item));
            ++$i;
        }

        //individual Product names
        $itemsArr = array();
        foreach ($itemIDsArr as $itemID) {
            $sql3 = "SELECT itemName, price FROM ws_items WHERE itemID = $itemID";
            $result3 = $dbConnection->query($sql3);
            $row = $result3->fetch_assoc();
            $itemName = $row["itemName"];
            $price = $row["price"];
            $item = array(
                "itemName" => $itemName,
                "price" => $price,
            );
            array_push($itemsArr, $item);
        }

        //Inhalt der email dynamisch generieren
        $bestellTabelle = "<table>";
        foreach ($itemsArr as $item) {
            $bestellTabelle .= "<tr>";
            $bestellTabelle .= "<td>" . $item["itemName"] . "</td>";
            $bestellTabelle .= "<td>" . $item["price"] . "€</td>";
            $bestellTabelle .= "</tr>";
        }
        $bestellTabelle .= "</table>";
        $bestellTabelle .= "<br>";
        $bestellTabelle .= "Shipping Type: " . $shippingType . "<br>";
        $bestellTabelle .= "Shipping Cost: " . $shippingCosts . "€<br>";
        $bestellTabelle .= "Gesamt Kosten: " . $orderPrice . "€<br>";

        $bestellnummer = 2345132;

        sendOrderConfirmationEmail($firstname, $lastname, $empfaenger_email, $bestellnummer, $bestellTabelle);  #! auskommentiert, um nicht ausversehen emails zu verschicken

        echo "success";
        $cart->reset_cart();
        header("Location: ../html/orderSuccesfull.php");
        mysqli_close($dbConnection);
        exit;
    } catch (Exception $e) {
        echo "Error Connecting to database";
        header("Location: ../html/orderFailed.php");
        exit;
    }

    //email Bestellbestätigung hier einfügen


    header("Location: ../html/orderFailed.php");
}
header("Location: ../html/orderFailed.php");
