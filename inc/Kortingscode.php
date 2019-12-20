<?php
// gemaakt door Boaz S1147963
//kortingspercentage wordt pas toegepast bij het bestellen. de variabele $nieuwprijs kan worden gebruikt om tot die tijd de aangepaste prijs te gebruiken


//database verbinding opbouwen
$conn = new mysqli('localhost','root','','world_wide_importers');

function kortingsCodeBestaat($kortingscode, $conn){ //functie die controleerd of code bestaat
    $sql = "SELECT `korting_id` FROM `korting` WHERE `kortingscode` ='$kortingscode';";
    $result = $conn->query($sql);
    $codebestaat = 0;
    if($result->num_rows == 0) {
        $codebestaat = 0;// code bestaat niet
    } else {
        $codebestaat = 1;// code bestaat
    }
    return $codebestaat;
}

function alKortingsCodeGebruikt($winkelmandid,$conn){ //deze functie controleert of een kortingscode al reeds is toegepast true/false
    $sql = "SELECT `kortingscode` FROM `winkelmand` WHERE `winkelmand_id` = '$winkelmandid';";
    $result = $conn->query($sql);
    $kortingalgebruikt = 3;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        if(is_null($row["kortingscode"])){ //Er is nog geen kortingscode ingevoerd
            $kortingalgebruikt = 0;
        }
        else{
            $kortingalgebruikt = 1; // je mag maar 1 code toepassen
        }
    }
    return $kortingalgebruikt;
}

function kortingsCodeToepassen($kortingscode,$winkelmandid,$conn){ //deze functie past een kortingscode toe en berekend een nieuwe totaalprijs

    $codebestaat1 = kortingsCodeBestaat($kortingscode,$conn);
    $kortingalgebruikt1 = alKortingsCodeGebruikt($winkelmandid,$conn);
    $verzendkosten1 = verzendkostenBerkenen($winkelmandid, $conn);

    $opgehaaldeprijs = totaalprijsTonen($winkelmandid,$conn) - $verzendkosten1;//de totaalprijs van de winkelwagen ophalen

        $sql1 = "SELECT `percentage` FROM `korting` WHERE `kortingscode` = '$kortingscode';"; //het kortingspercentage ophalen
        $result1 = $conn->query($sql1); //het kortingspercentage uitlezen
        $percentage = 0;
        while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC))
        {$percentage = $row["percentage"];}
        // de query om het percentage van een reeds toegepaste code op te vragen
    $sql2 = "SELECT `percentage` FROM `korting` WHERE `kortingscode` IN (SELECT `kortingscode` FROM `winkelmand` WHERE `winkelmand_id` = '$winkelmandid');";

        if($kortingalgebruikt1 == 0 && $codebestaat1 == 1) { //als er nog geen korting is gebruikt dan wordt de korting berekend
            $nieuweprijs = (1 - ($percentage / 100)) * $opgehaaldeprijs; //kortingspercentage in procenten naar nieuwe prijs
            $sql3 = "UPDATE `winkelmand` SET `kortingscode` = '$kortingscode' WHERE `winkelmand_id` = '$winkelmandid';"; //schrijft de gebruikte code naar de winkelwagen
            $conn->query($sql3);
        }
        elseif($kortingalgebruikt1 == 1 && $codebestaat1 == 1) {
            $result2 = $conn->query($sql2);
            $percentage2 = 0;
            while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {$percentage2 = $row["percentage"];}
            $nieuweprijs = (1 - ($percentage2 / 100)) * $opgehaaldeprijs; //kortingspercentage toepassen van de korting in de database
        }
        elseif($kortingalgebruikt1 == 1 && $codebestaat1 == 0) {
            $result2 = $conn->query($sql2);
            $percentage2 = 0;
            while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {$percentage2 = $row["percentage"];}
            $nieuweprijs = (1 - ($percentage2 / 100)) * $opgehaaldeprijs; //kortingspercentage toepassen van de korting in de database
        }
        else {
            $nieuweprijs = $opgehaaldeprijs; //geen wijziging in nieuweprijs
        }

    return ($nieuweprijs + $verzendkosten1);
}

function kortingsCodeVerwijderen($winkelmandid, $conn){ //deze functie verwijderd de (alle) kortingscode
    $sql = "UPDATE `winkelmand` SET `kortingscode` = NULL WHERE `winkelmand_id` = '$winkelmandid';"; // kortingscode veld leegmaken
    $result = $conn->query($sql);
    return $result;
}

function kortingsNaamTonen($winkelmandid, $conn){ //functie geeft de naam terug van een kortingscode
    $sql = "SELECT `kortingnaam` FROM `korting` WHERE `kortingscode` IN (SELECT `kortingscode` FROM `winkelmand` WHERE `winkelmand_id` = '$winkelmandid');"; //de naam van de korting ophalen .$kortingscode.
    $result = $conn->query($sql);
    $naam = 'kortingscode fout';
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $naam = $row["kortingnaam"];
    }
    return $naam;
}

function kortingsCodeFeedback($kortingscode,$winkelmandid,$conn){// functie die feedback genereerd op de kortingscode
    $kcbestaat = kortingsCodeBestaat($kortingscode, $conn);
    $kcalgebruikt = alKortingsCodeGebruikt($winkelmandid,$conn);

    if($kcbestaat == 1 && $kcalgebruikt == 0){//de kortingscode is geldig en er is nog geen code toegepast
        $kortingfeedback = 'De kortingscode '. kortingsNaamTonen($winkelmandid,$conn) . 'bestaat';
    }
    Elseif($kcbestaat == 1 && $kcalgebruikt == 1){//de code is geldig maar er is al een code toegepast
        $kortingfeedback = 'De kortingscode '. kortingsNaamTonen($winkelmandid,$conn) . ' is toegepast';
    }
    Elseif($kcbestaat == 0 && $kcalgebruikt == 1){// de code is ongeldig en er is al een andere code toegepast
        $kortingfeedback = 'Voer een geldige code in';
    }
    Elseif($kcbestaat == 0 && $kcalgebruikt == 0){ //de ingevoerde code is niet goed en er is nog geen code toegepast
        $kortingfeedback = 'Voer een geldige kortingscode in';
    }
    else{$kortingfeedback = 'Voer eventueel een kortingscode in';
    }
    return $kortingfeedback;
}
//hier volgen de functies die benodigd zijn voor het bestel overzicht
function totaalprijsUpdaten($winkelmandid,$nieuweprijs,$conn){ //deze functie schrijft de berekenede prijs weg naar de database
    $sql = "UPDATE `winkelmand` SET `totaalprijs` = '$nieuweprijs' WHERE `winkelmand_id` = '$winkelmandid';"; //schrijft de nieuwe prijs naar de database
    $result=$conn->query($sql);
    return $result;
}

function totaalprijsTonen($winkelmandid,$conn){ //deze functie haalt de totaalprijs van de winkelmand op
    $verzendkosten1 = verzendkostenBerkenen($winkelmandid, $conn);
    //$sql = "SELECT sum(`aantal` * (SELECT `UnitPrice` FROM `wideworldimporters.stockitems` WHERE `wideworldimporters.stockitems.StockItemID` = 1)) as `prijs` FROM `orderregel` WHERE `winkelmand_id` in (SELECT `orderregel.artikel_id` FROM `orderregel` WHERE `winkelmand_id` = 1);";
    $sql = "SELECT `totaalprijs` FROM `winkelmand` WHERE `winkelmand_id` = '$winkelmandid';";
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $opgehaaldeprijs = $row["totaalprijs"];
    }
    return ($opgehaaldeprijs + $verzendkosten1);
}

function toonBestelOverzicht($winkelmandid,$conn){

    $sql = "SELECT `StockItemID`, `StockItemName`, `aantal`, `UnitPrice` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = ".$winkelmandid.";";
    $result = $conn->query($sql);

    $html = '<table width="100%" class = "table-striped"><th>Nr</th><th>Artikel Nr.</th><th>Artikelnaam</th><th>Aantal</th><th>Prijs p/st</th>';
    $i = 0;
    foreach ($result as $regel) {
        $i++;
        $html .= "<tr>"; // tr is table row
        $html .= "<td>" . $i . "</td>";
        foreach ($regel as $veld) {
            $html .= "<td>" . $veld . "</td>"; // td is table data
        }
    }
        //$html .= "<td>" . $regel['aantal'] . "</td>";
        $html .= "</tr></table>";
        return $html;
    }

    function verzendkostenBerkenen($winkelmandid, $conn){ //functie berkend de verzendkosten op basis van het totaalbedrag
        $verzendkosten = 0; //0 euro verzendkosten
        $sql = "SELECT `totaalprijs` FROM `winkelmand` WHERE `winkelmand_id` = '$winkelmandid';"; //de totaalprijs uit de winkelmand halen
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $opgehaaldeprijs1 = $row["totaalprijs"];
        }
        if($opgehaaldeprijs1 < 30){// als het totaalbedrag kleiner is dan 30 euro dan kost de verzending 3 euro anders 0
            $verzendkosten = 3;
        }
        return $verzendkosten;
    }

    function totaalBedragWinkelmandBijwerken($winkelmandid, $conn){
    $sql = "SELECT sum(`UnitPrice`) FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = ".$winkelmandid.";";
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $totaalprijs = $row["totaalprijs"];
    }
}
?>


