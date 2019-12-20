<?php

error_reporting(E_ALL);

$conn = new mysqli('localhost','root','','world_wide_importers');

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

    $sql = "SELECT `winkelmand_id`,`naam`, `unitprice`, `aantal` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = ".$winkelmandid.";";

    $result = $conn->query($sql);


    $html = '<table class="table">';
    $html .= "<tr><th>Bestelnummer</th><th>Product</th><th>Prijs</th><th>Aantal</th></tr>";
    foreach ($result as $regel) {

        $html .= "<tr>"; // tr is table row
        foreach ($regel as $veld) {

            $html .= "<td>" . $veld . "</td>"; // td is table data

        }

        $html .= "</tr>";
    }
       $html .= '</table>';
        return $html;
}

include('head.php');
include('header.php');

echo toonWinkelmand('1',$conn);
echo '
<form method="get" target="accountoverzicht.php">
        <div class="form-group">
            <label for="kortingscodeinput">Doorgaan?</label><br>
            <a class="btn btn-secondary" href="productpagina.php" role="button">Verder winkelen</a> <a class="btn btn-secondary" href="accountoverzicht.php" role="button">Inloggen & verzendinformatie</a>
        </div>
    </form>';