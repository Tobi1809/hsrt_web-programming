<?php

//Session starten
session_start();

//Öffnen der Datenbank-Verbindung
include("../backendPhp/dbConnection.php");

//Die Klasse verfügbar machen
include_once("../backendPhp/cart.php");

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

//Prüfen, ob der Warenkorb bereits besteht
$cart->__construct();

//Falls Produkte in der Session bereits im Warenkorb - dann gib diese zurück
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

    <!-- Webseite responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheet & FontAwesome für Icons -->
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../libraries/FontAwesome/CSS/all.css">

    <!-- Für das Karussell-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- our Styles -->
    <link rel="stylesheet" href="../css/headerAndFooterArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">
    <link rel="stylesheet" href="../css/myStyle.css">

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

    <div class="w3-container w3-center">
        <div class="w3-panel w3-border-top w3-border-bottom">
            <h3>Warenkorb <i class="fas fa-shopping-cart"></i></h3>
        </div>
    </div>

    <div class="w3-container">
        <table class="w3-table">

            <thead>
                <tr class="w3-light-gray">
                    <th>Produktname</th>
                    <th>Produktbeschreibung</th>
                    <th>Anzahl</th>
                    <th>Preis</th>
                </tr>
            </thead>

            <?php
            $Array = $_SESSION['cartArray'];

            if ($productCount == 0) {
                echo "<tr><td> Ihr Warenkorb ist leer.</td></tr>";
            } else {
                for ($i = 0; $i < count($Array); $i++) {
                    $innerArray = $Array[$i];

                    echo "<tr>
            <td>$innerArray[1]</td>
            <td>$innerArray[2]</td>
            <td>$innerArray[3]</td>
            <td>$innerArray[4]€</td>
            </tr>";
                }
            }
            ?>
        </table>
    </div>

    <div class="w3-container">
        <div class="w3-panel w3-border-top">
            <h4>Summe (<?php echo $productCount ?> Artikel):

                <?php

                $total = 0;

                for ($i = 0; $i < count($Array); $i++) {
                    $innerArray = $Array[$i];
                    $total += $innerArray[4];
                }

                if ($total != 0) {
                    echo "$total €";
                } else {
                    echo "0 €";
                }

                ?>
            </h4>
        </div>
    </div>

    <form method="post">
        <div class="w3-container">
            <button type="submit" name="emptyCart" class="btn btn-danger">Warenkorb löschen</button>
            <?php

            if (isset($_POST['emptyCart'])) {
                $cart->reset_cart();
                echo "<script>location.href = location.href;</script>";
            }

            ?>

            <button type="submit" name="checkOut" class="btn btn-success">Weiter zum Checkout</button>
            <?php

            if (isset($_POST['checkOut'])) {
                $userLogin = false;

                if ($productCount == 0) {
            ?><span class="text-danger align-middle" id="invalidCredentialsErrorMessage">
                <!-- Error message here -->
                <i class="fa fa-close animate__animated animate__shakeX"></i> Füllen Sie bitte zuerst Ihren Warenkorb um
                fortzufahren!
            </span>

            <!-- Sicherheitsprüfung - nur eingeloggte User mit Produktanzahl > 0 kommen zum Checkout-->
            <?php
                }
                if (isset($_SESSION["login"]) && $productCount > 0) {
                    if ($_SESSION["login"] == 111) {
                        $userLogin = true;
                        $uid = $_SESSION['uid'];
                        $Array = $_SESSION['cartArray'];

                        header("Location: checkout.php");
                    }
                }
                if ($userLogin == false && $productCount > 0) {
                    header("Location: login.php");
                }
            }

            ?>
        </div>
    </form>

    <!-- Fußleiste -->
    <footer class="footer w3-padding-32">

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