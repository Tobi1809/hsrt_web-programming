<?php

class Cart
{
    //Initialisiert das Objekt - wird aufgerufen wenn ein neues Objekt der Klasse Cart erstellt wird
    function __construct()
    {
        $cartArray = array();
        if(!isset($_SESSION['cartArray']))
        {
            $_SESSION['cartArray']=$cartArray;
        } 
    }
    
    //Fügt ein Produkt in das Warenkorb-Array ein
    public function insertProduct($itemID, $itemName, $description, $quantity, $price)
    {
        $quantity = "1";
        $product = array($itemID, $itemName, $description, $quantity, $price);
        $cartArray = $_SESSION['cartArray'];
        array_push($cartArray, $product);
        $_SESSION['cartArray'] = $cartArray;
    }
    
    //Gibt Alle Artikel des Warenkorb-Array in einer Tabelle aus
    public function getCartTable()
    {
        $cartArray = $_SESSION['cartArray'];
        echo "<table width='100%'>";
        echo "<tr><th>Produktname</th><th>Produktbeschreibung</th><th>Anzahl</th><th>Preis</th></tr>";

        foreach ($cartArray as $cartRow) {
            echo "<tr>
            <td>$cartRow[1]</td>
            <td>$cartRow[2]</td>
            <td>$cartRow[3]</td>
            <td>$cartRow[4]</td>
            </tr>";
        }
        echo "</table>";
    }
    
    //Löscht den Warenkorb
    public function reset_cart()
    {
        $_SESSION['cartArray'] = array();
    }
    
    //Gibt einen Datensatz zurück am Point n
    public function get_cartValue_at_Point($n)
    {
        $Array = $_SESSION['cartArray'];            
        return $Array[$n];
    }
    
    //Entfernt ein Produkt am Point n
    public function delete_cartValue_at_Point($point)
    {
        $Array = $_SESSION['cartArray'];
        unset($Array[$point]);
    }
    
    //Gibt die Anzahl der Produkte im Warenkorb zurück
    public function get_cart_count()
    {
        return count($_SESSION['cartArray']);
    }

}

?>