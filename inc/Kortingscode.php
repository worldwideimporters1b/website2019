<?php
//functie work in progress


//database verbinding
$conn = new mysqli('localhost','root','','world_wide_importers');

function kortingsCodeBestaat($kortingscode, $conn){ //functie die controleerd of code bestaat
    $sql = "SELECT korting_id FROM korting WHERE kortingscode =" . $kortingscode . ";";
    $result = $conn->query($sql);
    $codebestaat = 0;
    if($result->num_rows == 0) {
        $codebestaat = 0;// code bestaat niet
    } else {
        $codebestaat = 1;// code bestaat
    }
    return $codebestaat;
}

function alKortingsCodeGebruikt($winkelmandid,$codebestaat,$conn){//deze functie controleert of een kortingscode al reeds is toegepast true/false
    $sql = "SELECT kortingscode FROM winkelmand WHERE winkelmand_id = ".$winkelmandid.";";
    $result = $conn->query($sql);
    if($codebestaat == 1){
    if(is_null($result)){ //Er is nog geen kortingscode ingevoerd
        $kortingalgebruikt = 0;
    }
    else{
        $kortingalgebruikt = 1; // je mag maar 1 code toepassen
    }
    }
    else{
        $kortingalgebruikt = 2; //er is geen bestaande code ingevoerd
    }
    return $kortingalgebruikt;
}

function kortingsCodeToepassen($kortingscode,$winkelmandid,$conn){ //deze functie past een kortingscode toe en berekend een nieuwe totaalprijs

    $codebestaat1 = kortingsCodeBestaat($kortingscode,$conn);
    $kortingalgebruikt1 = alKortingsCodeGebruikt($winkelmandid,$codebestaat1,$conn);

    $sql1 = "SELECT totaalprijs FROM winkelmand WHERE winkelmand_id = " . $winkelmandid . ";"; //de totaalprijs van de winkelmand ophalen
    $result1 = $conn->query($sql1); //de totaalprijs van de winkelmand $oudeprijs

    if($codebestaat1 = 1) {//de code bestaat
        //hieronder bouwen we de query naar de database op, met daarin de parameters op de juiste plekken.
        $sql2 = "SELECT percentage FROM korting WHERE kortingscode = " . $kortingscode . ";"; //het kortingspercentage ophalen
        // hieronder voeren we de query uit
        $result2 = $conn->query($sql2); //het kortingspercentage $kortingspercentage

        if ($kortingalgebruikt1 == 0) { //als er nog geen korting is gebruikt dan wordt de korting berekend
            $nieuweprijs = (1 - ($result2 / 100)) * $result1; //kortingspercentage in procenten naar nieuwe prijs
            $sql3 = "UPDATE winkelmand SET totaalprijs = ".$nieuweprijs."WHERE winkelmand_id = ".$winkelmandid.";"; //schrijft de nieuwe prijs naar de database
            $conn->query($sql3);
        } else {
            $nieuweprijs = $result1; //geen wijziging in nieuweprijs
        }
    }
    else{ //de totaalprijs van de winkelwagen wordt opgehaald
        $nieuweprijs = $result1;
    }
    return $nieuweprijs;
}

function kortingsCodeVerwijderen($winkelmandid, $conn){ //deze functie verwijderd de (alle) kortingscode
    $sql = "UPDATE winkelmand SET kortingscode = NULL WHERE winkelmand_id = ".$winkelmandid.";"; // kortingscode veld leegmaken
    $result = $conn->query($sql);
    return mysqli_stmt_affected_rows($result) == 1;
}

function kortingsNaamTonen($kortingscode, $conn){ //functie geeft de naam terug van een kortingscode
    $sql = "SELECT kortingnaam FROM korting WHERE kortingscode = ".$kortingscode.";"; //de naam van de korting ophalen
    $result = $conn->query($sql);
    return $result;
}
?>


