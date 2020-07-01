<?php

//Session starten
session_start();

//Öffnen der Datenbank-Verbindung
//include("../backendPhp/dbConnection.php");

//Die Klasse verfügbar machen
include_once("../backendPhp/cart.php");

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

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

//Sicherheitskontrolle - ist User eingeloggt der gerade bestellen will?
$userLogin = false;

if (isset($_SESSION["login"]) && $productCount > 0) {
    if ($_SESSION["login"] == 111) {
        $userLogin = true;
        $uid = $_SESSION['uid'];
    }
}
if ($userLogin == false || $productCount == 0) {
    header("Location: login.php");
}

?>

<?php
//auslesen der Nutzerdaten
if (isset($_SESSION["uid"])) {
    $uid = $_SESSION['uid'];
    try {
        //Öffnen der Datenbank-Verbindung
        $dbConnection = mysqli_connect("127.0.0.1", "root", "", "webshop");

        if (!$dbConnection) {
            echo "Fehler: Konnte nicht mit MySQL verbinden." . PHP_EOL;
            echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debug-Fehlermledung: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        //liest Daten des Users aus
        $sql = "SELECT * FROM ws_users where UserID ='$uid' ";
        $result = $dbConnection->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                //Speichert Werte aus der Tabelle ws_users in der Session
                $firstName = $row["firstName"];
                $lastName = $row["lastName"];
                $street = $row["street"];
                $zip = $row["zip"];
                $city = $row["city"];
            }
        }
        mysqli_close($dbConnection);
    } catch (Exception $e) {
        echo "Error Connecting to database";
        exit;
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

    <!--Versandkosten-Anzeige für die User-->
    <script type="text/javascript">
        $(function () {
            $('#shipping').change(function () {
                if ($(this).val() != "") {
                    $.get("../backendPhp/getShippingCostsForUser.php", {
                        selection: $(this).val()
                    },
                        function (data) {
                            $('#getShippingCosts').html(data);
                        });
                }
            });

        });
    </script>

    <!--Gesamtbetrag-Anzeige für die User-->
    <script type="text/javascript">
        $(function () {
            $('#shipping').change(function () {
                if ($(this).val() != "") {
                    $.get("../backendPhp/getTotalAmountForUsers.php", {
                        selection: $(this).val()
                    },
                        function (data) {
                            $('#getTotalAmount').html(data);
                            $('#TotalAmountHiddenInput').val(data);
                        });
                }
            });

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
            <h3>Checkout <i class="fas fa-cash-register"></i></h3>
        </div>
    </div>

    <div class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin" style="width: 50%; float:left">
        <form method="post" action="../backendPhp/processOrder.php" name="payment" class="form-horizontal">

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
                            value="<?php echo  $firstName; ?>" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="lastname"></label>
                    <div class="col-md-6">
                        <input id="lastname" name="lastname" type="text" placeholder="Nachname"
                            value="<?php echo $lastName; ?>" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="street">Straße</label>
                    <div class="col-md-6">
                        <input id="street" name="street" type="text" placeholder="Straße" value="<?php echo $street; ?>"
                            class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="city">Stadt</label>
                    <div class="col-md-6">
                        <input id="city" name="city" type="text" placeholder="Stadt" value="<?php echo $city; ?>"
                            class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="zip">Postleitzahl</label>
                    <div class="col-md-6">
                        <input id="zip" name="zip" type="text" placeholder="Postleitzahl" value="<?php echo $zip; ?>"
                            class="form-control input-md" required="">

                    </div>
                </div>


                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="shipping">Versandart</label>
                    <div class="col-md-6">
                        <select id="shipping" name="shipping" class="form-control" required>
                            <option value="" disabled selected>Wähle bitte eine der folgenden Optionen aus</option>
                            <option value="5">Normale Lieferung (5€)</option>
                            <option value="15">Express Lieferung (15€)</option>
                        </select>
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
                </div>
                <!-- save total amount in hidden input -->
                <input type="text" name="TotalAmountHiddenInput" id="TotalAmountHiddenInput" value="" hidden>
                <?php
                //save ItemIDs in hidden Input
                $Array = $_SESSION['cartArray'];
                $itemIDs = "";
                for ($i = 0; $i < count($Array); $i++) {
                    $innerArray = $Array[$i];
                    $itemIDs .= ",";
                    $itemIDs .= $innerArray[0];
                }
                $itemIDs .= ",";

                echo '<input type="text" name="ItemIDs" id="ItemIDs" value="' . $itemIDs . '" hidden >'
                ?>

                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="goback"></label>
                    <div class="col-md-8">
                        <button onclick="history.go(-1);return false;" class="btn btn-danger">Zurück zum
                            Warenkorb</button>
                        <button type="submit" id="order" name="order" class="btn btn-success">Kostenpflichtig
                            bestellen</button>
                    </div>

            </fieldset>

        </form>
    </div>

    <table class="w3-container w3-table w3-card-4 w3-light-grey w3-text-black w3-margin"
        style="width:45%; float: right">

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

            for ($i = 0; $i < count($Array); $i++) {
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

    <table class="w3-container w3-table w3-card-4 w3-light-grey w3-text-black w3-margin"
        style="width:45%; float: right">

        <thead>
            <tr class="w3-light-gray">
            <tr>
                <th>Zwischensumme (<?php echo $productCount ?> Artikel):
                    <?php

                    $Array = $_SESSION['cartArray'];
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
                </th>
            </tr>
            <tr>
                <th>Versandkosten: <span id="getShippingCosts"></span> €</th>
            </tr>
            <tr>
                <th>Gesamtbetrag: <span id="getTotalAmount"></span> €</th>
            </tr>
            </tr>
        </thead>

    </table>

    <!-- center Margin ende-->
    </div>

    <!-- Fußleiste schneidet Formular ab? - vorrübergehend entfernt -->

    <!-- Fußleiste -->
    <!-- footer class="footer w3-padding-32">

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

    </footer -->


</body>

</html>
