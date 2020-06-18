<?php
    $firstname  = $_GET["firstname"];
    $lastname  = $_GET["lastname"];
    $street  = $_GET["street"];
    $zip = $_GET["zip"];
    $city  = $_GET["city"];
    $email  = $_GET["email"];
    $password  = $_GET["password"];

    $returnString = $firstname + $lastname;

    echo $returnString;

    if($_GET["auswahl"]=="wi"){
        $Module = array("wi1","wi2","wi3","wi4");

        echo ausgabe($Module);
    }
    elseif ($_GET["auswahl"]=="mki") {
        $Module = array("mki1","mki2","mki3","mki4","mki5");
        echo ausgabe($Module);
    }
    elseif ($_GET["auswahl"]=="meti") {
        $Module = array("meti1","meti2","meti3","meti4","meti5");
        echo ausgabe($Module);
    }else {
        echo ("Keine Module gefunden!");
    }
    

    function ausgabe($moduleZumAusgeben){
        $Ausgabeliste ="<ul>";
        foreach($moduleZumAusgeben as $modul){
            $Ausgabeliste .="<li>$modul</li>";
        }

        $Ausgabeliste .="</ul>";

        return $Ausgabeliste;
    }
    
?>