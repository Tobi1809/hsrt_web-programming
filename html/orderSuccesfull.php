<?php

    //Session starten
    session_start();

    //Sicherheitsprüfung!
    if ($_SESSION['login'] != 111)
    {
        //Sofort Weiterleitung zum Login - falls User nicht eingeloggt ist und auf diese Seite zugreifen will
        header("Location: login.php");
    }

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

<?php
    //This part is to Process the Order!

    //Get all the $_POST data from checkout.php
    if (isset($_POST['button']))
    {
        $itemID = $_POST["itemID"];
        $itemName = $_POST["itemName"];
        $description = $_POST["description"];
        $quantity = "1";
        $price = $_POST["price"];

        $cart->insertProduct($itemID, $itemName, $description, $quantity, $price);

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
    <link rel="stylesheet" href="../css/myStyle">
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

        <div class="3-bar w3-center">
            <h1 class="myTitle">shop<strong class="myTitle">33</strong></h1>
            <p class="myTitle">Only the greatest discounts!</p>
        </div>

        <div class="centerMargin"><a href="home.php"></i> Home</a></div>

        <div class="centerMargin"><a href="aboutUs.php"> Über uns</a></div>

        <div></div>

        <div class="centerMargin">
            <h3 class="myTitle"><?php echo $welcomeString ?></h3>
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

        <?php

            // Login, wenn User noch nicht angemeldet ist und Logout, wenn er angemeldet ist
            $loginHTML = '<div class="centerMargin"><a href="login.php"><i class="fas fa-user"></i> Login</a></div>';
            $logoutHTML = '<div class="centerMargin"><a href="logout.php"><i class="fas fa-user"></i> Logout</a></div>';
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
                <h3>Vielen Dank für ihre Bestellung <i class="far fa-laugh-beam"></i></h3>
            </div>
        </div>

        <div class="w3-container">
            <div></div>
            <div class="centerMargin">
                <img src="https://media.giphy.com/media/3oz8xIsloV7zOmt81G/giphy.gif" alt="Thank you cat"
                    class="centerImage">
            </div>
            <div></div>
            <div class="centerMargin align-middle" style="padding-top:2.5rem;padding-bottom:5rem;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <a href="home.php" class="centerMargin"><i class="fas fa-arrow-right"></i> weiter shoppen</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Fußleiste -->
    <footer class="titleBand w3-padding-24">

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
