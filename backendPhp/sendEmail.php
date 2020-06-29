<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';



if (!debug_backtrace()) {
    //this is like Pythons if __name__ == "__main__":
    //this will only be executed if this php script is called directly

    //this is to test if email works!

    sendRegistrationEmail("Dustin", "Walker", "du-blauwal@web.de");
}


function sendRegistrationEmail($firstname, $lastname, $empfaenger_email)
{

    $betreff = "Registrierung bei Shopp33";
    $nachricht = "<p>Hallo $firstname, Vielen Dank für die Registrierung bei <strong>Shop33</strong> <br> Viel Spaß beim shoppen! </p>";

    // $mailsuccess = mail($empfaenger_email, $betreff, $nachricht, "From: Absender <shopp33prozent@gmail.com>");

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //get Password
        include '../../info.php';
        $password = $word;    //password should be saved aoutside of the scope of the public git repository

        //Server settings
        //$mail->SMTPDebug = 1;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'shop33prozent@gmail.com';              // SMTP username
        $mail->Password   = $password;                              // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';                                   //to fix äöü € Problems
        $mail->Encoding = 'base64';

        //Recipients
        $mail->setFrom('shop33prozent@gmail.com', 'Shopp33');
        $mail->addAddress($empfaenger_email);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $betreff;
        $mail->Body    = $nachricht;
        $mail->AltBody = strip_tags($nachricht);

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function sendOrderConfirmationEmail($firstname, $lastname, $empfaenger_email, $bestellnummer, $bestellTabelle)
{

    $betreff = "Bestellbestätigung";
    $nachricht = "<p>Hallo $firstname, Vielen Dank für ihre Bestellung bei <strong>Shop33</strong> <br> <br> Sie haben bestellt:</p>";
    $nachricht .= $bestellTabelle;
    $nachricht .= "Shop33 wünscht ihnen viel Spaß mit ihren Produkten";
    // $mailsuccess = mail($empfaenger_email, $betreff, $nachricht, "From: Absender <shopp33prozent@gmail.com>");

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //get Password
        include '../../info.php';
        $password = $word;    //password should be saved aoutside of the scope of the public git repository

        //Server settings
        //$mail->SMTPDebug = 1;                                     // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'shop33prozent@gmail.com';              // SMTP username
        $mail->Password   = $password;                              // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';                                   //to fix äöü € Problems
        $mail->Encoding = 'base64';
        
        //Recipients
        $mail->setFrom('shop33prozent@gmail.com', 'Shopp33');
        $mail->addAddress($empfaenger_email);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $betreff;
        $mail->Body    = $nachricht;
        $mail->AltBody = strip_tags($nachricht);

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function receiveContactForm($firstname, $lastname, $entered_email, $empfaenger_email, $topic, $message)
{
    $betreff = "Kontaktformular-Anfrage zum Thema: $topic";
    $nachricht = "<h3>Der User: $firstname $lastname, mit der Email: $entered_email hat per Kontaktformular eine Anfrage gesendet.</h3><br>";
    $nachricht .= "<p>Inhalt der Anfrage: $message <br>";
    $nachricht .= "Bitte die Anfrage so schnell wie möglich bearbeiten und ihm eine Antwort per Email senden. <br>";
    $nachricht .= "Vielen Dank!</p>"

    try {
        //get Password
        include '../../info.php';
        $password = $word;    //password should be saved aoutside of the scope of the public git repository

        //Server settings
        //$mail->SMTPDebug = 1;                                     // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'shop33prozent@gmail.com';              // SMTP username
        $mail->Password   = $password;                              // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('shop33prozent@gmail.com', 'Shopp33');
        $mail->addAddress($empfaenger_email);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $betreff;
        $mail->Body    = $nachricht;
        $mail->AltBody = strip_tags($nachricht);

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>



