<?php

session_start();
include '../backendPhp/dbConnection.php';
include '../backendPhp/getProductInfo.php';


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
    <link rel="stylesheet" href="../css/headerArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">

    <style>
        .carousel-inner>.item>img,
        .carousel-inner>.item>a>img {
            width: 42%;
            margin: auto;
        }
    </style>

    <script>

        $(document).ready(function() { // wichtig!
            setInterval(function () {
                $.get("daten_auf_dem_server.php",
                    {},
                    function(numActiveUsers) {
                        var activeUserElement = document.getElementById("numUserOnline");
                        activeUserElement.innerText = numActiveUsers;
                        console.log("updated active users");
                    });
            }, 1000);
            $.post("../backendPhp/getActiveUsers.php", {},
            function(returnedData) {

                
            }
            );
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
            <a href="#"> <i class="fa fa-shopping-cart fa-4x"></i></a>
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
                    <img src="../images/uhr1.jpeg" alt="Chania" width="460" height="345">
                    <div class="carousel-caption">
                        <h3>Produkt 1</h3>
                        <p>Hier könnte eine Beschreibung stehen!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="../images/uhr2.jpg" alt="Chania" width="460" height="345">
                    <div class="carousel-caption">
                        <h3>Produkt 2</h3>
                        <p>Hier könnte eine Beschreibung stehen!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="../images/uhr3.jpg" alt="Chania" width="460" height="345">
                    <div class="carousel-caption">
                        <h3>Produkt 3</h3>
                        <p>Hier könnte eine Beschreibung stehen!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="../images/uhr4.jpg" alt="Chania" width="460" height="345">
                    <div class="carousel-caption">
                        <h3>Produkt 4</h3>
                        <p>Hier könnte eine Beschreibung stehen!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="../images/uhr6.jpg" alt="Chania" width="460" height="345">
                    <div class="carousel-caption">
                        <h3>Produkt 5</h3>
                        <p>Hier könnte eine Beschreibung stehen!</p>
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
                            <img src="products/productImages/product(<?php echo $row["itemID"]; ?>).jpg" class="img-rounded img-responsive" alt="">
                        </div>
                        <hr>
                        <p><?php echo $row["itemName"]; ?></p>
                        <p><?php echo $row["description"]; ?></p>
                        <p><b><?php echo $row["price"]; ?> €</b> <s><?php echo round($row["price"] / 0.67, 2) ?> €</s> | 33% Rabatt</p>
                        <hr>
                        <div>
                            <a href="" class="btn btn-success">Zum Warenkorb hinzufügen</a>
                        </div>
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
    <footer class="w3-container w3-padding-16 w3-margin-top">
        <div class="w3-bar w3-light-gray">
            <span class="myBarItem w3-light-gray w3-left"> User online: <ins id="numUserOnline">0</ins></span>
            <a href="#kontakt.html" class="myBarItem w3-button w3-right"><i class="fas fa-envelope"></i>
                Kontakt</a>
            <a href="#impressum.html" class="myBarItem w3-button w3-right"> Impressum</a>
        </div>
    </footer>

</body>

</html>