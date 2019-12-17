<?php
// gemaakt door Boaz S1147963
//functie work in progress
//kortingspercentage wordt pas toegepast bij het bestellen. de variabele $nieuwprijs kan worden gebruikt om tot die tijd de aangepaste prijs te gebruiken


//database verbinding opbouwen
$conn = new mysqli('localhost','root','','world_wide_importers');

function kortingsCodeBestaat($kortingscode, $conn){ //functie die controleerd of code bestaat
    $sql = "SELECT korting_id FROM korting WHERE kortingscode ='$kortingscode';";
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
    $sql = "SELECT kortingscode FROM winkelmand WHERE winkelmand_id = '$winkelmandid';";
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

    $opgehaaldeprijs = totaalprijsTonen($winkelmandid,$conn);//de totaalprijs van de winkelwagen ophalen

    if($codebestaat1 = 1) {//de code bestaat
        $sql2 = "SELECT percentage FROM korting WHERE kortingscode = '$kortingscode';"; //het kortingspercentage ophalen
        $result2 = $conn->query($sql2); //het kortingspercentage uitlezen
        $percentage = 0;
        while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))
        {
            $percentage = $row["percentage"];
        }

        if ($kortingalgebruikt1 == 0) { //als er nog geen korting is gebruikt dan wordt de korting berekend
            $nieuweprijs = (1 - ($percentage / 100)) * $opgehaaldeprijs; //kortingspercentage in procenten naar nieuwe prijs
            //$sql3 = "UPDATE winkelmand SET totaalprijs = '$nieuweprijs' WHERE winkelmand_id = '$winkelmandid';"; //schrijft de nieuwe prijs naar de database
            $sql4 = "UPDATE winkelmand SET kortingscode = '$kortingscode' WHERE winkelmand_id = '$winkelmandid';"; //schrijft de gebruikte code naar de winkelwagen
            //$conn->query($sql3);
            $conn->query($sql4);
        } else {
            $nieuweprijs = $opgehaaldeprijs; //geen wijziging in nieuweprijs
        }
    }
    else{ //de totaalprijs van de winkelwagen wordt opgehaald
        $nieuweprijs = $opgehaaldeprijs;
    }
    return $nieuweprijs;
}

function kortingsCodeVerwijderen($winkelmandid, $conn){ //deze functie verwijderd de (alle) kortingscode
    $sql = "UPDATE winkelmand SET kortingscode = NULL WHERE winkelmand_id = '$winkelmandid';"; // kortingscode veld leegmaken
    $result = $conn->query($sql);
    return $result;
}

function kortingsNaamTonen($kortingscode, $conn){ //functie geeft de naam terug van een kortingscode
    $sql = "SELECT kortingnaam FROM korting WHERE kortingscode = '$kortingscode';"; //de naam van de korting ophalen .$kortingscode.
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
        $kortingfeedback = 'De volgende kortingscode is bestaat:'. kortingsNaamTonen($kortingscode,$conn);
    }
    Elseif($kcbestaat == 1 && $kcalgebruikt == 1){//de code is geldig maar er is al een code toegepast
        $kortingfeedback = 'De kortingscode '. kortingsNaamTonen($kortingscode,$conn) . ' is toegepast';
    }
    Elseif($kcbestaat == 0 && $kcalgebruikt == 1){// de code is ongeldig en er is al een andere code toegepast
        $kortingfeedback = 'De ingevoerde code is ongeldig, De volgende kortingscode is al toegespast:'. kortingsNaamTonen($kortingscode,$conn);
    }
    Elseif($kcbestaat == 0 && $kcalgebruikt == 0){ //de ingevoerde code is niet goed en er is nog geen code toegepast
        $kortingfeedback = 'voer een geldige kortingscode in';
    }
    elseif($kcbestaat == 0 && $kcalgebruikt == 1 && (kortingsNaamTonen($kortingscode,$conn) == 'kortingscode fout')){
        $kortingfeedback = 'voer een geldige kortingscode in';
    }
    else{$kortingfeedback = 'Voer eventueel een kortingscode in';
    }
    return $kortingfeedback;
}

function totaalprijsUpdaten($winkelmandid,$nieuweprijs,$conn){ //deze functie schrijft de berekenede prijs weg naar de database
    $sql = "UPDATE winkelmand SET totaalprijs = '$nieuweprijs' WHERE winkelmand_id = '$winkelmandid';"; //schrijft de nieuwe prijs naar de database
    $result=$conn->query($sql);
    return $result;
}

function totaalprijsTonen($winkelmandid,$conn){ //deze functie haalt de totaalprijs van de winkelmand op
    $sql1 = "SELECT totaalprijs FROM winkelmand WHERE winkelmand_id = '$winkelmandid';";
    $result1 = $conn->query($sql1);
    while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC))
    {
        $opgehaaldeprijs = $row["totaalprijs"];
    }
    return $opgehaaldeprijs;
}
?>


