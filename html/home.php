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

    <!-- Webseite responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheet & FontAwesome für Icons -->
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../libraries/FontAwesome/CSS/all.css">
    <link rel="stylesheet" href="../css/myStyle.css">


    <!-- Für das Karussell -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Karussell Style -->
    <style>
        .carousel-inner>.item>img,
        .carousel-inner>.item>a>img {
            width: auto;
            height: auto;
            margin: auto;
        }
    </style>

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

<body class ="mainColor">

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

    <!-- Main Content Start -->
    <div class="mainContent">

        <div class="w3-container w3-center">
            <div class="w3-panel w3-border-top w3-border-bottom">
                <h3>Shoppen Sie ganz einfach direkt drauflos <i class="far fa-thumbs-up"></i></h3>
            </div>
        </div>

        <!-- Karussell Slideshow-->
        <div class="container">
            <br>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                    <div class="item active">
                        <img src="../images/Uhr1.jpg" alt="Chania" width="" height="">
                        <div class="carousel-caption">
                            <h4></h4>
                        </div>
                    </div>

                    <div class="item">
                        <img src="../images/Uhr2.jpg" alt="Chania" width="" height="">
                        <div class="carousel-caption">
                            <h4></h4>
                        </div>
                    </div>

                    <div class="item">
                        <img src="../images/Uhr3.jpg" alt="Chania" width="" height="">
                        <div class="carousel-caption">
                            <h4></h4>
                        </div>
                    </div>

                    <div class="item">
                        <img src="../images/Uhr4.jpg" alt="Chania" width="" height="">
                        <div class="carousel-caption">
                            <h4></h4>
                        </div>
                    </div>

                    <div class="item">
                        <img src="../images/Uhr5.jpg" alt="Chania" width="" height="">
                        <div class="carousel-caption">
                            <h4></h4>
                        </div>
                    </div>

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="myProductsArea">
            <!-- Produkte -->
            <div class="myProductsGrid">

                <?php
                // echo "Print Products";
                try {
                    //Öffnen der Datenbank-Verbindung
                    $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

                    if (!$dbConnection) {
                        echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
                        echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
                        echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
                        exit;
                    }
                    //SQL Syntax - wählt alle Zeilen aus, wo Email und Passwort den eingegebenen Daten entspricht
                    $sql1 = "SELECT itemID, itemName, description, price FROM ws_items";
                    $result1 = mysqli_query($dbConnection, $sql1);

                    //Falls die Tabelle genau eine Reihe (Datensatz) besitzt, wo die Sql-Abfrage true ergibt

                    while ($row = $result1->fetch_assoc()) {
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////// Create Product Cards dynamically
                        $name = $row["itemName"];
                ?>
                <div class="myProductBox">
                    <!-- Produkt <?php echo $row["itemID"]; //lol, php für kommentare XD
                                            ?> -->
                    <div style="height: 50%;">
                        <img src="products/productImages/product(<?php echo $row["itemID"]; ?>).jpg"
                            class="img-rounded img-responsive" alt="">
                    </div>
                    <hr>
                    <p><?php echo $row["itemName"]; ?></p>
                    <p><?php echo $row["description"]; ?></p>
                    <p><b><?php echo $row["price"]; ?> €</b> <s><?php echo round($row["price"] / 0.67, 2) ?> €</s> | <i
                            class="red">33% Rabatt</i></p>
                    <hr>

                    <form method="post" action="../backendPhp/addItemToCart.php">
                        <div>
                            <input id="itemID" value="<?php echo $row["itemID"]; ?>" name="itemID" hidden>
                            <input id="itemName" value="<?php echo $row["itemName"]; ?>" name="itemName" hidden>
                            <input id="description" value="<?php echo $row["description"]; ?>" name="description"
                                hidden>
                            <input id="price" value="<?php echo $row["price"]; ?>" name="price" hidden>
                            <button type="submit" name="button" class="btn btn-success">Zum Warenkorb
                                hinzufügen</button>
                        </div>
                    </form>
                </div>

                <?php
                    }

                    //Datenbank-Verbindung wieder schließen!
                    mysqli_close($dbConnection);
                } catch (Exception $e) {
                    echo "Error Connecting to database";
                    exit;
                }
                ?>

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

    </div>
    <!-- Main Content Ende -->

</body>

</html>
