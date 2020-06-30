<?php

    if ($_GET["selection"] == "5")
	{
		$shippingCosts = 5;

		echo insertShippingCosts($shippingCosts);
	}
	elseif ($_GET["selection"] == "15") 
	{
		$shippingCosts = 15;

		echo insertShippingCosts($shippingCosts);
    }
    elseif ($_GET["selection"] == "")
    {
        $shippingCosts = 0;

        echo insertShippingCosts($shippingCosts);
    }

    function insertShippingCosts($shippingCosts)
    {
        return $shippingCosts;
    }
    
?>