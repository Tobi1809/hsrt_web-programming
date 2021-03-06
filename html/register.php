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
  <title>Webshop - Registrierung</title>
  <meta charset="utf-8">

  <!-- our Styles -->
  <link rel="stylesheet" href="../css/headerAndFooterArea.css">
  <link rel="stylesheet" href="../css/productsGrid.css">
  <link rel="stylesheet" href="../css/formRegister.css">
  <link rel="stylesheet" href="../css/myStyle.css">

  <!-- for animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

  <!-- Webseite responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
      $("#registerform").submit(function(event) {
        event.preventDefault(); // prevent submission

        var data = $("#registerform :input").serializeArray();
        //alert( "Handler for .submit() called." );
        //alert("Input array: " +data.toString());
        var planePassword = data[6].value;
        var out = sjcl.hash.sha256.hash(planePassword);
        var hash = sjcl.codec.hex.fromBits(out); //tested hash against https://hashgenerator.de/  -->it works
        data[6].value = hash; // override plane password 

        $.post("../backendPhp/registerUser.php", {
            firstname: data[0].value,
            lastname: data[1].value,
            street: data[2].value,
            zip: data[3].value,
            city: data[4].value,
            email: data[5].value,
            password: data[6].value,
          },
          function(returnedData) {
            //alert("login happend; data = " + returnedData)

            switch (returnedData) {
              case "failed":
                //alert("e-mail is already taken");
                var emailErrorMessage = document.getElementById("emailErrorMessage");
                emailErrorMessage.innerHTML = '<i class="fa fa-close animate__animated animate__shakeX"></i> E-Mail-Adresse ist schon vergeben';
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
      <h3>Registrierung</h3>
    </div>
  </div>

  <div class="formRegister">
    <form method="POST" action="../backendPhp/b_registerUser.php" id="registerform">
      <fieldset>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="firstname"><strong>Name</strong></label>
          <div class="col-md-4">
            <input id="firstname" name="firstname" type="text" placeholder="Vorname" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="lastname"></label>
          <div class="col-md-4">
            <input id="lastname" name="lastname" type="text" placeholder="Nachname" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="street"><strong>Adresse</strong></label>
          <div class="col-md-4">
            <input id="street" name="street" type="text" placeholder="Straße und Hausnummer" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="zip"></label>
          <div class="col-md-4">
            <input id="zip" name="zip" type="text" placeholder="PLZ" class="form-control input-md" required="">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="city"></label>
          <div class="col-md-4">
            <input id="city" name="city" type="text" placeholder="Stadt" class="form-control input-md" required="">

          </div>
        </div>

        <!-- e-mail input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="email"><strong>Email</strong></label>
          <div class="col-md-4">
            <input id="email" name="email" type="email" placeholder="E-Mail-Adresse" class="form-control input-md" required="">
          </div>
          <div class="col-md-3">
            <div class="form-control-feedback">
              <span class="text-danger align-middle " id="emailErrorMessage">
                <!-- Hier wird per JAVASCRIPT Dom manipiulation eine Fahlermeldung eingefügt -->
                <!-- <i class="fa fa-close animate__animated animate__shakeX"></i> E-Mail-Adresse ist schon vergeben -->
              </span>
            </div>
          </div>

        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-8 control-label" for="password"><strong>Passwort</strong></label>
          <div class="col-md-4">
            <input id="password" name="password" type="password" placeholder="Passwort" class="form-control input-md" required="">

          </div>
        </div>

        <!-- Hidden input for encrypted Password -->
        <!-- <input id="encryptedPassword" value="" name="encryptedPassword" hidden type="text">  -->

        <!-- Password input-->
        <!-- <div class="form-group">
        <label class="col-md-8 control-label" for="passwordrepeat"></label>
        <div class="col-md-4">
          <input id="passwordrepeat" name="passwordrepeat" type="password" placeholder="Passwort wiederholen"
            class="form-control input-md" required="">

        </div>
      </div> -->

        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-8 control-label" for="register"></label>
          <div class="col-md-4">
            <button type="submit" name="register" class="btn btn-success" style="width:253.25px;padding:10px;">Registrieren</button>
            <a href="login.php" class="btn btn-danger" style="width:253.25px;padding:10px;">Zurück zum Login</a>
          </div>
        </div>

      </fieldset>
    </form>
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