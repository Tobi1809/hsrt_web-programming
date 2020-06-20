<?php
session_start();


$welcomeString = "";
//create welcome string if logge in 
if ($_SESSION["login"] == 111) {
    //we are logged in
    $welcomeString .= "Hallo, ";
    $welcomeString .=  $_SESSION["firstname"];
    $welcomeString .= " ";
    $welcomeString .=  $_SESSION["lastname"];
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
        
        <div class="centerMargin"><a href="login.php" class=" w3-button w3-light-gray"><i class="fas fa-user"></i> Login</a></div>


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

        <div class="myProductsGrid">

            <!-- Produkte -->
            <div class="myProductBox">
                <!-- Produkt 1 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 2 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 3 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 4 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 5 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 6 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 7 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

            <div class="myProductBox">
                <!-- Produkt 8 -->
                <img src="../images/wristwatch.webp" class="img-rounded img-responsive" alt="">
                <p>hübsche uhr mit Zeigern</p>
                <p><b>€4.99</b></p>
                <p> <s>€14.69 </s> | 33% Rabatt</p>
                <div class="progress" style="margin: 5px;">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

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