<?php

function updateProductAantal($winkelmandid,$artikelid,$aantal){ // de 3 dingen die hier opgesomd staan met een $ ervoor, zijn ####parameters####, deze stuur je mee als je de functie aanroept

            //hieronder bouwen we de query naar de database op, met daarin de parameters op de juiste plekken.
            $sql = "UPDATE `".$aantal." WHERE `artikelid` = ". $artikelid ." AND `winkelmandid` = ".$winkelmandid.";";

            // hieronder voeren we de query uit
            $result = $conn->query($sql);

            // het stuk hieronder is een voorbeeld van het uitlezen van de query (of het gelukt is of niet)

            if($result) // controleer of er een resultaat is
            {
                    $status = 1; // toevoegen is gelukt
            }
            else
            {
            $status = 0; // toevoegen is niet gelukt
            }

            return $status; // we melden aan onze applicatie (webshop) 0 of 1 de webshop weet dan voldoende.
}
?>