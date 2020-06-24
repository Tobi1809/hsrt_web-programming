<?php

class cart
{
    //Initialisiert die Klasse - muss in jeder Seite wo der Warenkorb benötigt wird ausgeführt werden
    public function initial_cart()
    {
        $cart = array();
        if(!isset($_SESSION['cart']))
        {
            $_SESSION['cart']=$cart;
        } 
    }
    
    //Fügt ein Produkt in das Warenkorb-Array ein
    public function insertProduct($itemID, $itemName, $description, $quantity, $price)
    {
        $quantity = "1";
        $product = array($itemID, $itemName, $description, $quantity, $price);
        $cart = $_SESSION['cart'];
        array_push($cart, $product);
        $_SESSION['cart'] = $cart;
    }
    
    //Gibt Alle Artikel des Warenkorb-Array in einer Tabelle aus
    public function getCart()
    {
        $Array = $_SESSION['cart'];
        echo "<table width='100%'>";
        echo "<tr><th>Produktname</th><th>Produktbeschreibung</th><th>Anzahl</th><th>Preis</th></tr>";
        for($i = 0 ; $i < count($Array); $i++)
        {
            $innerArray = $Array[$i];
            
            echo "<tr>
            <td>$innerArray[1]</td>
            <td>$innerArray[2]</td>
            <td>$innerArray[3]</td>
            <td>$innerArray[4]</td>
            </tr>";
        }
        echo "</table>";
    }
    
    //Löscht den Warenkorb
    public function undo_cart()
    {
        $_SESSION['cart'] = array();
    }
    
    //Gibt einen Datensatz zurück am Point n
    public function get_cartValue_at_Point($n)
    {
        $Array = $_SESSION['cart'];            
        return $Array[$n];
    }
    
    //Entfernt ein Produkt am Point n
    public function delete_cartValue_at_Point($point)
    {
        $Array = $_SESSION['cart'];
        unset($Array[$point]);
    }
    
    //Gibt die Anzahl der Produkte im Warenkorb zurück
    public function get_cart_count()
    {
        return count($_SESSION['cart']);
    }

}

?>