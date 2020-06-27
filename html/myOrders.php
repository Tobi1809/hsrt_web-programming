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
    <link rel="stylesheet" href="../css/headerArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">

    <!-- Webseite responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheet & FontAwesome für Icons -->
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../libraries/FontAwesome/CSS/all.css">

    <!-- Für das Karussell-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



    <style>
        .carousel-inner>.item>img,
        .carousel-inner>.item>a>img {
            width: 42%;
            margin: auto;
        }
    </style>

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

<body>

    <!-- Kopfbereich -->
    <header class="titleBand w3-padding-16">

        <div class="3-bar w3-center">
            <h1 class="myTitle">shop<strong class="myTitle">33</strong></h1>
            <p class="myTitle">Only the greatest discounts!</p>
        </div>

        <div class="centerMargin"><a href="home.php" class=" w3-button "></i> Home</a></div>

        <div class="centerMargin"><a href="#überuns.html" class=" w3-button"> Über uns</a></div>

        <div></div>

        <div class="centerMargin">
            <h3 class="myTitle"><?php echo $welcomeString ?></h3>
        </div>

        <div></div>

        <div class="centerMargin">
            <!-- shopping cart -->
            <a href="shoppingCart.php"><i class="fa fa-shopping-cart fa-4x"></i>(<?php echo $productCount ?>)</a>
        </div>

        <?php
        // Login, wenn User noch nicht angemeldet ist und Logout, wenn er angemeldet ist
        $loginHTML = '<div class="centerMargin"><a href="login.php" class=" w3-button w3-light-gray"><i class="fas fa-user"></i> Login</a></div>';
        $logoutHTML = '<div class="centerMargin"><a href="logout.php" class=" w3-button w3-light-gray"><i class="fas fa-user"></i> Logout</a></div>';
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


    </header>
    <!-- Main Content -->
    <div class="mainContent">

        <div class="w3-container w3-center">
            <div class="w3-panel w3-border-top w3-border-bottom">
                <h3>Meine Bestellungen <i class="far fa-thumbs-up"></i></h3>
            </div>
        </div>

        <div class="w3-container">
            <table class="w3-table">

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
            <div class="w3-container">
        <div class="w3-panel w3-border-top">
            <h4>Zwischensumme :  14.98 € </h4>
            <h4>Versandkosten:  5 € </h4>
            <h4>Gesamtbetrag:  19.98 € </h4>
            <div class="w3-border-top">
            <h4>Status:  19.98 € </h4>
            </div>
        </div>
    </div>
            
            </table>
        </div>
    </div>

    </div>

    <!-- Fußleiste -->
    <footer class="w3-container w3-padding-16 w3-margin-top">
        <div class="w3-bar w3-light-gray">
            <span class="myBarItem w3-light-gray w3-left"> User online: <ins id="numUserOnline">0</ins></span>

            <a href="#impressum.html" class="myBarItem w3-button w3-right"> Impressum</a>
            <a href="#kontakt.html" class="myBarItem w3-button w3-right"><i class="fas fa-envelope"></i>
                Kontakt</a>
            <!-- <span class="myBarItem w3-light-gray w3-right">Sie waren zuletzt online am <ins></ins></span> -->
            <?php
            if (isset($_SESSION["login"])) {
                if ($_SESSION["login"] == 111) {
                    $dateString = date("d.m.Y", $_SESSION['lastLoginTime']);
                    echo '<span class="myBarItem w3-light-gray w3-right">Sie waren zuletzt online am: <ins>' . $dateString . '</ins></span>';
                }
            }
            ?>
        </div>
    </footer>

</body>

</html>