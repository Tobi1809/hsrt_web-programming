<?php

//Session starten
session_start();

//Wird nicht mehr benötigt?
//include ("../backendPhp/getProductInfo.php");

//Die Klasse verfügbar machen
include_once("../backendPhp/cart.php");

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

//Falls Produkte in der Session bereits im Warenkorb - dann zeige diese an
$productCount = $cart->get_cart_count();


$welcomeString = "";
//create welcome string if logged in 
if (isset($_SESSION["login"])) {
    if ($_SESSION["login"] == 111) {
        //we are logged in
        $welcomeString .= "Hallo, ";
        $welcomeString .=  $_SESSION["firstname"];
        $welcomeString .= " ";
        $welcomeString .=  $_SESSION["lastname"];
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>

    <title>Webshop - Home</title>
    <meta charset="utf-8">

    <!-- our Styles -->
    <link rel="stylesheet" href="../css/headerAndFooterArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">
    <link rel="stylesheet" href="../css/myOrders.css">

    <!-- Webseite responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheet & FontAwesome für Icons -->
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../libraries/FontAwesome/CSS/all.css">

    <!-- Für das Karussell-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () { // wichtig!

            setInterval(function () {
                $.get("../backendPhp/getNumActiveUsers.php", {},
                    function (numActiveUsers) {
                        var activeUserElement = document.getElementById("numUserOnline");
                        activeUserElement.innerText = numActiveUsers;
                        console.log("updated active users");
                    });
            }, 1000);

        });
    </script>

</head>

<body>

    <!-- Kopfbereich -->
    <header class="titleBand w3-padding-8">

        <div class="w3-bar w3-center">
            <h1 class="myTitle">shop<strong class="myTitle">33</strong></h1>
            <p class="myTitle">Only the greatest discounts!</p>
        </div>

        <div class="centerMargin"><a href="home.php">Home</a></div>

        <div class="centerMargin"><a href="aboutUs.php"> Über uns</a></div>

        <div></div>

        <div class="centerMargin">
            <div>
                <h3 class="myTitle"><?php echo $welcomeString ?></h3>
            </div>
        </div>

        <div></div>

        <div class="centerMargin">
            <!-- shopping cart -->
            <a href="shoppingCart.php"><i class="fa fa-shopping-cart fa-2x"></i>(<?php echo $productCount ?>)</a>
        </div>

        <div class="centerMargin">
            <?php
            //show My Orders Button if logged in
            $MyOrdersHtml = '<a href="myOrders.php" class="centerMargin"><i class="fas fa-box-open"></i> Meine Bestellungen</a>';
            if (isset($_SESSION["login"])) {
                if ($_SESSION["login"] == 111) {
                    echo $MyOrdersHtml;
                }
            }

            ?>
        </div>

        <div class="centerMargin">
            <?php
            // Login, wenn User noch nicht angemeldet ist und Logout, wenn er angemeldet ist
            $loginHTML = '<a href="login.php" class="centerMargin"><i class="fas fa-user"></i> Login</a>';
            $logoutHTML = '<a href="logout.php" class="centerMargin"><i class="fas fa-user"></i> Logout</a>';
            if (isset($_SESSION["login"])) {
                if ($_SESSION["login"] == 111) {
                    echo $logoutHTML;
                } else {
                    echo $loginHTML;
                }
            } else {
                echo $loginHTML;
            }
            ?>
        </div>

    </header>

    </header>

    <!-- Main Content ------------------------------------------------------------------------------------>
    <div class="mainContent">

        <div class="w3-container w3-center">
            <div class="w3-panel w3-border-top w3-border-bottom">
                <h3>Meine Bestellungen <i class="far fa-thumbs-up"></i></h3>
            </div>
        </div>

        <?php
        // get all Orders
        try {
            //Öffnen der Datenbank-Verbindung
            $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");
    
            if (!$dbConnection) {
                echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
                echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            // get Orders
            $uid = $_SESSION["uid"];
            $sql1 = "SELECT * FROM ws_orders WHERE userID = $uid";
            $result1 = $dbConnection->query($sql1);

            while ($row = $result->fetch_assoc()) {
                
            }
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
                    "itemID" => $itemID,
                    "itemName" => $itemName,
                    "price" => $price,
                );
                array_push($itemsArr, $item);
            }


            mysqli_close($dbConnection);
        } catch (Exception $e) {
            echo "Error Connecting to database";
        }

        ?>

        <div class="myOrdersGrid">

            <div class="myOrderBox w3-container">
                <div class="w3-light-gray w3-container" style="margin-top: 3px;">
                    <span style="float: left;">Order Nr. 687654</span>
                    <span style="float: right;"> Order Datum: 13:09:27 Dec 10 2018</span>
                </div>
                <table class="w3-table w3-margin-top">

                    <thead>
                        <tr class="w3-light-gray">
                            <th></th>
                            <th>Produktname</th>
                            <th>Preis</th>
                        </tr>
                    </thead>

                    <tr>
                        <td><img src="products/productImages/product(1).jpg" class="smallImage"></td>
                        <td>Titan Uhr - Modell 1</td>
                        <td>4.99€</td>
                    </tr>
                    <tr>
                        <td><img src="products/productImages/product(1).jpg" class="smallImage"></td>
                        <td>Titan Uhr - Modell 1</td>
                        <td>9.99€</td>
                    </tr>
                </table>
                <div class="w3-container">
                    <div class="w3-panel w3-border-top">
                        <h4>Zwischensumme : 14.98 € </h4>
                        <h4>Versandkosten: 5 € </h4>
                        <h4>Gesamtbetrag: 19.98 € </h4>
                        <div class="w3-border-top">
                            <h4>Status: angekommen </h4>
                        </div>
                    </div>
                </div>
                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="goback"></label>
                    <div class="col-md-8">
                        <div class=" "><a href="#" class=" w3-button  w3-light-gray"><i class="fas fa-redo-alt"></i>
                                nocheinmal bestellen</a></div>
                        <div class=""><a href="processOrder.php" class=" w3-button w3-light-gray"><i
                                    class="fas fa-receipt"></i> Rechnung anfordern</a></div>
                    </div>
                </div>
            </div>

            <div class="myOrderBox w3-container">
                <table class="w3-table w3-margin-top">

                    <thead>
                        <tr class="w3-light-gray">
                            <th>Produktname</th>
                            <th>Preis</th>
                        </tr>
                    </thead>

                    <tr>
                        <td>Titan Uhr - Modell 1</td>
                        <td>4.99€</td>
                    </tr>
                    <tr>
                        <td>Titan Uhr - Modell 1</td>
                        <td>9.99€</td>
                    </tr>
                </table>
                <div class="w3-container">
                    <div class="w3-panel w3-border-top">
                        <h4>Zwischensumme : 14.98 € </h4>
                        <h4>Versandkosten: 5 € </h4>
                        <h4>Gesamtbetrag: 19.98 € </h4>
                        <div class="w3-border-top">
                            <h4>Status: 19.98 € </h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Fußleiste -->
    <footer class="titleBand w3-padding-32">

        <div class="centerMargin"><a href="impressum.php">Impressum</a></div>
        <div class="centerMargin"><a href="contactForm.php"><i class="fas fa-envelope"></i> Kontakt</a></div>

        <div></div>
        <div></div>
        <div></div>

        <div class="centerMargin">
            <?php
            if (isset($_SESSION["login"])) {
                if ($_SESSION["login"] == 111) {
                    $dateString = date("d.m.Y", $_SESSION['lastLoginTime']);
                    echo '<span>Sie waren zuletzt am <ins>' . $dateString . '</ins> online</span>';
                }
            }
        ?>
        </div>

        <div></div>

        <div class="centerMargin">
            <span><ins id="numUserOnline"></ins> User online</span>
        </div>

    </footer>

</body>

</html>