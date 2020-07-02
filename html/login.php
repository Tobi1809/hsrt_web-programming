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
<html>

<head>
    <title>Webshop - Login</title>
    <meta charset="utf-8">

    <!-- our Styles -->
    <link rel="stylesheet" href="../css/headerAndFooterArea.css">
    <link rel="stylesheet" href="../css/productsGrid.css">
    <link rel="stylesheet" href="../css/formLogin.css">
    <link rel="stylesheet" href="../css/myStyle.css">

    <!-- for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />


    <!-- Webseite responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheet & FontAwesome für Icons -->
    <link rel="stylesheet" href="../css/w3.css">
    <link rel="stylesheet" href="../libraries/FontAwesome/CSS/all.css">

    <!-- Benötigt für login -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- JS for SHA256 -->
    <script src="../libraries/StanfordJavascriptCryptoLibrary.js"></script>

    <script>
        $(document).ready(function() { // wichtig!
            //bind event Handler to submission form
            $("#loginform").submit(function(event) {
                event.preventDefault(); // prevent submission

                var data = $("#loginform :input").serializeArray();
                //alert( "Handler for .submit() called." );
                //alert("Input array: " +data.toString());
                var planePassword = data[1].value;
                var out = sjcl.hash.sha256.hash(planePassword);
                var hash = sjcl.codec.hex.fromBits(out); //tested hash against https://hashgenerator.de/  -->it works
                data[1].value = hash; // override plane password 

                $.post("../backendPhp/loginUser.php", {
                        email: data[0].value,
                        password: data[1].value,
                    },
                    function(returnedData) {
                        //alert("login happend; data = " + returnedData)

                        switch (returnedData) {
                            case "failed":
                                //alert("e-mail is already taken");
                                var emailErrorMessage = document.getElementById("invalidCredentialsErrorMessage");
                                emailErrorMessage.innerHTML = '<i class="fa fa-close animate__animated animate__shakeX"></i>Bitte prüfen Sie noch einmal Ihre Eingaben.';
                                break;
                            case "success":
                                //alert("registration successfull");
                                window.location.href = 'home.php';
                                break;
                            default:
                                alert("!!!!!!!!Unecpected server replie!!!!!!!!!!!!!!");
                                break;
                        }
                    }
                );
            });

        });
    </script>

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

    <div class="w3-container w3-center">
        <div class="w3-panel w3-border-top w3-border-bottom">
            <h3>Login </h3>
        </div>
    </div>

    <div class="form">
        <form class="form-horizontal" role="form" id="loginform" method="POST" action="../backendPhp/loginUser.php">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group has-danger">
                        <label class="sr-only" for="email">E-Mail</label>
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input type="email" name="email" class="form-control" id="email" placeholder="E-Mail-Adresse" required autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Passwort" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" id="invalidCredentialsErrorMessage">
                            <!-- Put password error message here -->
                            <!-- <i class="fa fa-close animate__animated animate__shakeX"></i>Bitte prüfen Sie noch einmal Ihre Eingaben. -->
                        </span>
                    </div>
                </div>
            </div>

            <div class="row align-middle" style="padding-top: 0.5rem">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success align-center""><i class=" fa fa-sign-in"></i> einloggen</button>
                    <a class="btn btn-link" href="register.php">Sie haben noch kein Benutzerkonto? Dann hier
                        registrieren!</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Fußleiste -->
    <footer class="titleBand w3-padding-32" style="bottom: 0;position: fixed;width: 100%;">

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