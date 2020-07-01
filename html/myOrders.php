<?php

//Session starten
session_start();

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
    <link rel="stylesheet" href="../css/myStyle.css">

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
        $(document).ready(function() { // wichtig!

            setInterval(function() {
                $.get("../backendPhp/getNumActiveUsers.php", {},
                    function(numActiveUsers) {
                        var activeUserElement = document.getElementById("numUserOnline");
                        activeUserElement.innerText = numActiveUsers;
                        console.log("updated active users");
                    });
            }, 1000);

        });
    </script>

</head>

<body class="mainColor">

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
        <!-- ----------------------------------------------- Here in this div all Orders are displayed -->
        <div class="myOrdersGrid">

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
                $ordersArr = array();
                while ($row = $result1->fetch_assoc()) {
                    array_push($ordersArr, $row);
                }

                //////////////////////////////////////////////////////////// for every Order 
                foreach ($ordersArr as $order) {
                    ////////////////////////////////////////////////////////// html for every Order at beginning
                    ?>
                    <div class="myOrderBox w3-container">
                        <div class="w3-light-gray w3-container" style="margin-top: 3px;">
                            <span style="float: left;">Bestellung Nr. <?php echo $order["orderID"]; ?></span>
                            <span style="float: right;"> Bestellzeitpunkt: <?php echo date("H:i:s M j Y", $order["orderDate"]); ?></span>
                        </div>
                        <table class="w3-table w3-margin-top">

                            <thead>
                                <tr class="w3-light-gray">
                                    <th></th>
                                    <th>Produktname</th>
                                    <th>Preis</th>
                                </tr>
                            </thead>
                    <?php
                    //////////////////////////////////////////////////////////

                    $orderID = $order["orderID"];
                    $orderPrice = $order["orderPrice"];
                    $shippingCosts = $order["shippingCosts"];
                    $shippingType = $order["shippingType"];
                    $shippingAdress = $order["shippingAdress"];
                    $shippingStatus = $order["shippingStatus"];
                    $itemIDs = $order["itemIDs"];

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

                    //get individual Product data from db
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
                    foreach ($itemsArr as $item){
                        ?>
                        <tr>
                            <td><img src="products/productImages/product(<?php echo $item["itemID"]; ?>).jpg" class="smallImage"></td>
                            <td><?php echo $item["itemName"]; ?></td>
                            <td><?php echo $item["price"]; ?> €</td>
                        </tr>
                        <?php
                    } 
                    ////////////////////////////////////////////////////////// html for every Order at the end
                    ?>   
                    </table>
                    <div class="w3-container">
                        <div class="w3-panel w3-border-top">
                            <h4>Versandkosten:  <?php echo $shippingCosts; ?> € </h4>
                            <h4>Gesamtbetrag: <?php echo $orderPrice; ?> € </h4>
                            <div class="w3-border-top">
                                <h4>Status: <?php echo $shippingStatus; ?> </h4>
                            </div>
                        </div>
                    </div>
                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="goback"></label>
                        <div class="col-md-8">
                            <form method="post" action="../backendPhp/processOrder.php" name="payment" class="form-horizontal">

                                <input type="text" name="firstname" id="firstname" value="<?php echo $_SESSION["firstname"]; ?>" hidden >
                                <input type="text" name="lastname" id="lastname" value="fake" hidden >
                                <input type="text" name="city" id="city" value="fake" hidden >
                                <input type="text" name="zip" id="zip" value="fake" hidden >
                                <input type="text" name="street" id="street" value="fake" hidden >
                                <input type="text" name="ItemIDs" id="ItemIDs" value="<?php echo $itemIDs; ?>" hidden >
                                <input type="text" name="TotalAmountHiddenInput" id="TotalAmountHiddenInput" value="<?php echo $orderPrice; ?>" hidden >
                                <input type="text" name="shipping" id="shipping" value="<?php echo $shippingCosts; ?>" hidden >

                                <button type="submit" id="order" name="order" class="btn btn-success" style="width:200px; height:50px;">noch einmal bestellen</button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                ////////////////////////////////////////////////////////// html for every Order at the end
                }

                mysqli_close($dbConnection);
            } catch (Exception $e) {
                echo "Error Connecting to database";
            }

            ?>

        <!-- div for the Orders -->
        </div>
    <!-- main content div      -->
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
