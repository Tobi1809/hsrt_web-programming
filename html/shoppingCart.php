<?php
    
    //Session starten
    session_start();

    //Öffnen der Datenbank-Verbindung
    include ("../backendPhp/dbConnection.php");

    //Die Klasse verfügbar machen
    include_once ("../backendPhp/cart.php");

    //Eine Neue Instanz der Klasse cart erstellen
    $cart = new cart();

    //Prüfen, ob der Warenkorb bereits besteht
    $cart->initial_cart();

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
    <link rel="stylesheet" href="../css/headerArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">

    <script>

        $(document).ready(function() { // wichtig!
            
            setInterval(function () {
                $.get("../backendPhp/getNumActiveUsers.php",
                    {},
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
        $Array = $_SESSION['cart'];

        if ($productCount == 0) {
        echo "<tr><td> Ihr Warenkorb ist leer.</td></tr>";
        }
        else {
        for($i = 0 ; $i < count($Array); $i++){
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
            <h4>Summe: 
                
            <?php

            $total = 0;

            for($i = 0 ; $i < count($Array); $i++)
            {
                $innerArray = $Array[$i];
                $total+= $innerArray[4];
            }

            if($total!=0)
            {
                echo "$total €"; 
            }
            else
            {
                echo "0 €";
            }

            ?>
            </h4>
        </div>
    </div>

    <form method="post">
        <div class="w3-container">
            <button type="submit" name="emptyCart" class="btn btn-danger" >Warenkorb löschen</button>
            <?php
            
                if(isset($_POST['emptyCart']))
                {
                    $cart->undo_cart();
                    echo "<script>location.href=location.href;</script>";
                }

            ?>

            <button type="submit" name="checkOut" class="btn btn-success">Weiter zum Checkout</button>
            <?php

                if(isset($_POST['checkOut']))
                {
                    if($productCount == 0)
                    {
                        ?><span class="text-danger align-middle" id="invalidCredentialsErrorMessage">
                        <!-- Error message here -->
                        <i class="fa fa-close animate__animated animate__shakeX"></i>Füllen Sie bitte zuerst Ihren Warenkorb um fortzufahren!
                        </span>
                        <?php
                    }
                } else {
                    //header ("location: checkOut.php");
                }
            ?>
        </div>
    </form>

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
