<?php

function updateProductAantal($winkelmandid,$artikelid,$aantal,$conn){ // de 3 dingen die hier opgesomd staan met een $ ervoor, zijn ####parameters####, deze stuur je mee als je de functie aanroept

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

function toonWinkelmand($winkelmandid,$conn){

    $sql = "SELECT * FROM `mandje` WHERE `winkelmandid` = ".$winkelmandid;

    $result = $conn->query($sql);

    $html .= '<table width="100%">';
    foreach ($result as $regel) {

        $html .= "<tr>"; // tr is table row
        foreach ($regel as $veld) {

            $html .= "<td>" . $veld . "</td>"; // td is table data

        }
        $html .= "<td><a href='index.php?page=toon&nummer=" . $regel['nummer'] . "' class='btn btn-primary'>Bewerken</a> 
                          <a href='index.php?page=verwijder&nummer=" . $regel['nummer'] . "' class='btn btn-danger'>Verwijder</a></td>";
        $html .= "</tr>";

}

    ?>