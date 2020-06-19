<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Webshop - Registrierung</title>
  <meta charset="utf-8">

  <!-- our Styles -->
  <link rel="stylesheet" href="../css/headerArea.css">

  <!-- for animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

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
                var emailErrorMessage = document.getElementById("e-mailFehlerMeldung");
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

</head>

<body>

  <!-- Kopfbereich -->
  <header class="w3-container w3-padding-16">
    <div class="w3-bar w3-light-gray">
      <div class="w3-bar-item w3-light-gray w3-center">
        <h1 class="myTitle">shop<strong class="myTitle">33</strong></h1>
        <p class="myTitle">Only the greatest discounts!</p>
      </div>
      <a href="home.php" class="myBarItem w3-button w3-hide-small w3-left"></i> Home</a>
      <a href="#überuns.html" class="myBarItem w3-button w3-hide-small"> Über uns</a>
      <a href="login.html" class="myBarItem w3-button w3-hide-small w3-right w3-light-gray"><i class="fas fa-user"></i>
        Login</a>
    </div>
  </header>

  <form method="POST" action="../backendPhp/b_registerUser.php" id="registerform" class="form-horizontal">
    <fieldset>

      <!-- Form Name -->
      <legend>Registrierung</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-8 control-label" for="firstname">Vor- und Nachname</label>
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
        <label class="col-md-8 control-label" for="street">Adresse</label>
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
        <label class="col-md-8 control-label" for="email">Email</label>
        <div class="col-md-4">
          <input id="email" name="email" type="email" placeholder="E-Mail-Adresse" class="form-control input-md" required="">
        </div>
        <div class="col-md-3">
          <div class="form-control-feedback">
            <span class="text-danger align-middle " id="e-mailFehlerMeldung"> 
              <!-- Hier wird per JAVASCRIPT Dom manipiulation eine Fahlermeldung eingefügt -->
              <!-- <i class="fa fa-close animate__animated animate__shakeX"></i> E-Mail-Adresse ist schon vergeben -->
            </span>
          </div>
        </div>

      </div>

      <!-- Password input-->
      <div class="form-group">
        <label class="col-md-8 control-label" for="password">Passwort</label>
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
          <button type="submit" name="register" class="btn btn-success">Registrieren</button>
          <a href="login.html" class="btn btn-info">Zurück zum Login</a>
        </div>
      </div>

    </fieldset>
  </form>

  <!-- Fußleiste -->
  <footer class="w3-container w3-padding-16 w3-margin-top">
    <div class="w3-bar w3-light-gray">
      <span class="myBarItem w3-light-gray w3-left"> User online: 0</span>
      <a href="#kontakt.html" class="myBarItem w3-button w3-right"><i class="fas fa-envelope"></i>
        Kontakt</a>
      <a href="#impressum.html" class="myBarItem w3-button w3-right"> Impressum</a>
    </div>
  </footer>

</body>

</html>