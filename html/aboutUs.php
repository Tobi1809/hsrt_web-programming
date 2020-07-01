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

    <title>Webshop - About Us</title>
    <meta charset="utf-8">

    <!-- our Styles -->
    <link rel="stylesheet" href="../css/headerAndFooterArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">
    <link rel="stylesheet" href="../css/aboutUs.css">
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

        <div class="w3-bar float-left" style="margin: 2%;">
            <h1 class="myTitle"><a href="home.php">uhr<strong class="myTitle">33</strong></a></h1>
            <p class="myTitle">Luxus für dich</p>
        </div>

        <div></div>

        <div class="centerMargin float-right">
            <!-- shopping cart -->
            <a href="shoppingCart.php"><i class=" fa fa-shopping-cart fa-3x"></i>(<?php echo $productCount ?>)</a>
        </div>

        <div class="centerMargin  float-right">
            <?php
            //show My Orders Button if logged in
            $MyOrdersHtml = '<a href="myOrders.php" class="centerMargin"><i class="fas  fa-box-open fa-3x"></i></a>';
            if (isset($_SESSION["login"])) {
                if ($_SESSION["login"] == 111) {
                    echo $MyOrdersHtml;
                }
            }

            ?>
        </div>

        <div class="centerMargin  float-right">
            <?php
            // Login, wenn User noch nicht angemeldet ist und Logout, wenn er angemeldet ist
            $loginHTML = '<a href="login.php" class="centerMargin"><i class="fas fa-user fa-3x"></i> Login</a>';
            $logoutHTML = '<a href="logout.php" class="centerMargin"><i class="fas fa-user fa-3x"></i> Logout</a>';
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

    <!-- Main content -->
    <div>

        <div class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin"
            style="width: 75%; left: 10px; top: 10px;">
            <article>
                <div class="aboutUs-entry clearfix">
                    <h2 class="aboutUs">Unser Projekt</h2>
                    <p class="aboutUs">Shop33 repräsentiert das Ergebnis einer Zusammenarbeit zwischen Dustin Niklas
                        Walker
                        (Fakultät Technik) und Tobias Münch (Fakultät Informatik), unter der Aufsicht von dem Dozenten
                        Matthias
                        Gutbrod (Fakultät
                        Informatik) in dem Modul Webprogrammierung der Hochschule Reutlingen.
                        Dabei wurde der Webshop von Grund auf eigenhändig programmiert, um ...<br></p>
                    <ul class="aboutUs">
                        <li>
                            <p class="list">Kenntnis der Architekturen von Webanwendungen</p>
                        <li>
                            <p class="list">zugrundeliegende Technologien benennen, sowie ihr Zusammenspiel beschreiben
                                zu
                                können</p>
                        <li>
                            <p class="list">und grundlegendes Wissen über Programmiersprachen und Datenbanken zur
                                Realisierung
                                von Webanwendungen zu erlangen.</p>
                    </ul>
                    <p class="aboutUs">Umgesetzt wurde das Projekt mit Hilfe von GitHub, einem netzbasierter Dienst zur
                        Versionsverwaltung für Software-Entwicklungsprojekte.
                        Eine Ausführliche Dokumentation des Projekts finden Sie hierbei unter folgendem Link:</p>
                    <p class="aboutUs"><a
                            href="https://github.com/Tobi1809/hsrt_web-programming">https://github.com/Tobi1809/hsrt_web-programming</a>
                    </p>
                    <h2 class="aboutUs">Kompetenzen</h2>
                    <p class="aboutUs">Wir sind in der Lage eigene Webanwendungen auf Basistechnologien unter der
                        Verwendung
                        von gängigen Programmierplattformen, -werkzeugen und Systemen zu entwickeln.
                        Clientseitig liegt der Schwerpunkt dabei auf HTML/CSS und JavaScript.
                        Die serverseitige Programmierung wird mit aktuellen Frameworks, wie PHP, Java oder Node.js
                        (JavaScript)
                        durchgeführt.
                        Zudem sind wir in der Lage Basistechnologien von Webanwendungen und unterschiedliche Ansätze der
                        Webprogrammierung
                        unter Einbindung einer MySQL-Datenbank anzuwenden und diese dann auch dementsprechend
                        abzusichern.
                    </p>
                </div>
            </article>
        </div>
        
        <!-- linked images -->
        <div class="w3-container w3-center" style="width:50%;position: absolute; right:-26%; top: 16.25%;">
            <div class="w3-card-4 center" style="width:45%;">
                <a href="https://www.reutlingen-university.de/home/">
                    <img src="../images/logo1.png" style="width:100%;height:10%;">
                </a>
            </div>
        </div>

    <!-- Fußleiste -->
    <footer class="titleBand w3-padding-32">

        <div class="centerMargin align-content-center"><a href="impressum.php">Impressum</a></div>
        <div class="centerMargin align-content-center"><a href="contactForm.php"><i class="fas fa-envelope"></i> Kontakt</a></div>

        <div class="centerMargin align-content-center"><a href="aboutUs.php"> Über uns</a></div>

        <div style="margin-left: auto;">
            <div class="centerMargin align-content-center">
                <?php
                if (isset($_SESSION["login"])) {
                    if ($_SESSION["login"] == 111) {
                        $dateString = date("d.m.Y", $_SESSION['lastLoginTime']);
                        echo '<span>zuletzt online: <ins>' . $dateString . '</ins></span>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="centerMargin align-content-center">
            <span><ins id="numUserOnline"></ins> User online</span>
        </div>

    </footer>

</body>

</html>