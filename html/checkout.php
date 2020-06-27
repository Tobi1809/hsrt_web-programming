<?php
    
    //Session starten
    session_start();

    //Öffnen der Datenbank-Verbindung
    include ("../backendPhp/dbConnection.php");

    //Die Klasse verfügbar machen
    include_once ("../backendPhp/cart.php");

    //Eine Neue Instanz der Klasse cart erstellen
    $cart = new Cart();

    //Falls Produkte in der Session bereits im Warenkorb - dann gib diese zurück
    $productCount = $cart->get_cart_count();

    //Sicherheitskontrolle - ist User eingeloggt der gerade bestellen will?
    $userLogin = false;

    if(isset($_SESSION["login"]) && $productCount > 0) {
 	    if($_SESSION["login"] == 111) {
               $userLogin = true;
               $uid = $_SESSION['uid'];
         }
    }
    if($userLogin == false || $productCount == 0) {
        header("Location: login.php");
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

        $(document).ready(function () { // wichtig!

            setInterval(function () {
                $.get("../backendPhp/getNumActiveUsers.php",
                    {},
                    function (numActiveUsers) {
                        var activeUserElement = document.getElementById("numUserOnline");
                        activeUserElement.innerText = numActiveUsers;
                        console.log("updated active users");
                    });
            }, 1000);

        });

    </script>

    <!--Versandkosten-Anzeige für die User-->
    <script type="text/javascript">

    $(function ()
    {
        $('#shipping').change(function()
        {
            if($(this).val()!= "")
            {
                $.get("../backendPhp/getShippingCostsForUser.php",
                    { selection: $(this).val()},
                    function(data)
                    {
                        $('#getShippingCosts').html(data);
                    });
            }
        });

    });

    </script>

    <!--Gesamtbetrag-Anzeige für die User-->
    <script type="text/javascript">

    $(function ()
    {
        $('#shipping').change(function()
        {
            if($(this).val()!= "")
            {
                $.get("../backendPhp/getTotalAmountForUsers.php",
                    { selection: $(this).val()},
                    function(data)
                    {
                        $('#getTotalAmount').html(data);
                    });
            }
        });

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
            <h3>Checkout <i class="fas fa-cash-register"></i></h3>
        </div>
    </div>

    <div class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" style="width: 50%; float:left">
        <form method="post" action="home.php" name="payment" class="form-horizontal">

            <fieldset>

                <!-- Form Name -->
                <div class="w3-container w3-center">
                    <div class="w3-panel w3-border-bottom">
                        <h3>Versandadresse und Bestelldetails</h3>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="firstname">Name</label>
                    <div class="col-md-6">
                        <input id="firstname" name="firstname" type="text" placeholder="Vorname"
                            class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="lastname"></label>
                    <div class="col-md-6">
                        <input id="lastname" name="lastname" type="text" placeholder="Nachname"
                            class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="street">Straße</label>
                    <div class="col-md-6">
                        <input id="street" name="street" type="text" placeholder="Straße" class="form-control input-md"
                            required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="city">Stadt</label>
                    <div class="col-md-6">
                        <input id="city" name="city" type="text" placeholder="Stadt" class="form-control input-md"
                            required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="zip">Postleitzahl</label>
                    <div class="col-md-6">
                        <input id="zip" name="zip" type="text" placeholder="Postleitzahl" class="form-control input-md"
                            required="">

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="shipping">Versandart</label>
                    <div class="col-md-6">
                        <select id="shipping" name="shipping" class="form-control">
                            <option value="0" disabled selected>Wähle bitte eine der folgenden Optionen aus</option>
                            <option value="5">Normale Lieferung (5€)</option>
                            <option value="15">Express Lieferung (15€)</option>
                        </select>
                    </div>
                </div>

                <!-- Multiple Radios -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="radios">Zahlungsart</label>
                    <div class="col-md-4">
                        <div class="radio">
                            <label for="radios-0">
                                <input type="radio" name="radios" id="radios-0" value="1" checked="checked">
                                Kreditkarte
                            </label>
                        </div>
                        <div class="radio">
                            <label for="radios-1">
                                <input type="radio" name="radios" id="radios-1" value="2">
                                PayPal
                            </label>
                        </div>
                        <div class="radio">
                            <label for="radios-2">
                                <input type="radio" name="radios" id="radios-2" value="3">
                                Bankeinzug
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="goback"></label>
                    <div class="col-md-8">
                        <button onclick="history.go(-1);return false;" class="btn btn-danger">Zurück zum Warenkorb</button>
                        <button type="submit" id="order" name="order" class="btn btn-success">Kostenpflichtig bestellen</button>
                    </div>
                </div>

            </fieldset>

        </form>
    </div>

    <table class="w3-container w3-table w3-card-4 w3-light-grey w3-text-black w3-margin" style="width:45%; float: right">

        <thead>
            <tr class="w3-light-gray">
                <th>Produktname</th>
                <th>Produktbeschreibung</th>
                <th>Anzahl</th>
                <th>Preis</th>
            </tr>
        </thead>

        <tbody>

        <?php
            $Array = $_SESSION['cartArray'];

            for($i = 0 ; $i < count($Array); $i++) {
                $innerArray = $Array[$i];
                
                echo "<tr>
                <td>$innerArray[1]</td>
                <td>$innerArray[2]</td>
                <td>$innerArray[3]</td>
                <td>$innerArray[4]€</td>
                </tr>";
            }
        ?>

        </tbody>
                
    </table>

    <table class="w3-container w3-table w3-card-4 w3-light-grey w3-text-black w3-margin" style="width:45%; float: right">

        <thead>
            <tr class="w3-light-gray">
                <tr><th>Zwischensumme (<?php echo $productCount?> Artikel):
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
                </th></tr>
                <tr><th>Versandkosten: <span id="getShippingCosts"></span> €</th></tr>
                <tr><th>Gesamtbetrag: <span id="getTotalAmount"></span> €</th></tr>
            </tr>
        </thead>
    
    </table>

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

<?php
    mysqli_close($dbConnection);
?>