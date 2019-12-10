<?php
//functie work in progress
function kortingsCodeToepassen($kortingscode,$winkelmandid,$kortingbestaat){ //deze functie past een kortingscode toe en berekend een nieuwe totaalprijs

    //hieronder bouwen we de query naar de database op, met daarin de parameters op de juiste plekken.
    $sql1 = "SELECT percentage FROM korting WHERE kortingscode = ".$kortingscode.";"; //het kortingspercentage ophalen
    $sql2 = "SELECT totaalprijs FROM winkelmand WHERE winkelmand_id = ".$winkelmandid.";"; //de totaalprijs van de winkelmand ophalen

    // hieronder voeren we de query uit
    $oudeprijs = $conn->query($sql2); //de totaalprijs van de winkelmand
    $kortingspercentage = $conn->query($sql1); //het kortingspercentage

    $nieuweprijs = 0; //de nieuweprijs voor het totaal
    if(is_null($kortingscode )){ //geen kortingscode, dan blijft de oude prijs gelden
        $nieuweprijs = $oudeprijs;
    }
    Elseif($kortingbestaat == False){ //de korting wordt berkeend
        $nieuweprijs = (1-($kortingspercentage / 100)) * $oudeprijs; //kortingspercentage in procenten naar nieuwe prijs
    }
    else{$nieuweprijs = $oudeprijs;
    }

    $sql4 = "UPDATE winkelmand SET totaalprijs = ".$nieuweprijs."WHERE winkelmand_id = ".$winkelmandid.";"; //schrijft de nieuwe prijs naar de database
    return $nieuweprijs;
}

function alKortingsCodeGebruikt($winkelmandid){//deze functie controleert of een kortingscode al reeds is toegepast true/false
    $sql = "SELECT kortingscode FROM winkelmand WHERE winkelmand_id = ".$winkelmandid.";"; //het kortingspercentage ophalen
    if(is_null($sql)){ //Er is nog geen kortingscode ingevoerd
        $kortingbestaat = false;
    }
    else{
        $kortingbestaat = true; // je mag maar 1 code toepassen
    }
    return $kortingbestaat;
}

function kortingsCodeVerwijderen($winkelmandid){ //deze functie verwijderd de (alle) kortingscode
    $sql = "UPDATE winkelmand SET kortingscode IS NULL WHERE winkelmand_id = ".$winkelmandid.";"; //het kortingspercentage ophalen
    return mysqli_stmt_affected_rows($sql) == 1;
}

function kortingsNaamTonen($kortingscode){ //functie geeft de naam terug van een kortingscode
    $sql = "SELECT kortingnaam FROM korting WHERE kortingscode = ".$kortingscode.";"; //het kortingspercentage ophalen
    $kortingsnaam = $conn->query($sql); //de naam van de korting
    return $kortingsnaam;
}

?>


//wat nog ontbreekt: wat als code al eens gebruikt is dit moet opgeslagen worden.