<?php
//Session starten
session_start();

//Klasse
include 'dbConnection.php;'
include 'sendEmail.php';

//Die Klasse verfügbar machen
include_once("cart.php");
//This is to Process the Order!

//Eine Neue Instanz der Klasse cart erstellen
$cart = new Cart();

//$_POST daten von contactForm.php
if(isset($_POST['sendContactForm'])) {
    $uid = $_SESSION['uid'];

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $entered_email = $_POST['email'];
    $empfaenger_email = "shop33prozent@gmail.com";
    $message = $_POST['message'];

    switch ($_POST['betreff']) {
        case '1':
            $topic = "Supportanfrage";
            break;
        case '2':
            $topic = "Probleme bei der Bestellung";
            break;
        case '3':
            $topic = "Probleme bei der Lieferung";
            break;
        case '4':
            $topic = "Sonstiges";
            break;
        default:
            echo "<script>alert('Ihre Nachricht konnte leider nicht versendet werden!')</script>";
    }

    receiveContactForm($firstname, $lastname, $entered_email, $empfaenger_email, $topic, $message);

    echo "<script>alert('Ihre Nachricht wurde versandt! Wir werden diese so schnell wie möglich bearbeiten
            und dir dann per Email antworten.')</script>";
}

echo "<script>alert('Ihre Nachricht konnte leider nicht versendet werden. Bitte versuchen Sie es
        zu einem späteren Zeitpunkt erneut!')</script>";