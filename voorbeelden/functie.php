<?php
function voorbeeld($parameter1, $parameter2, $parameter3 = 'standaardwaarde (die kan worden overschreven in het aanroepen van de functie.)')
{

    //code die iets doet
    $data = $parameter1 . $parameter2 . $parameter3;


    // stuur resultaat terug naar de WWI appplicatie
    return $data;
}


function toonWinkelmand($winkelmandid,$databaseverbinding){

    $sql = "Query die controleert welke producten er in deze winkelmand zitten";

    $resultaat = $databaseverbinding->query($sql);

    // 1 van de condities voor deze functie is dat aangenomen wordt voor er is gecontroleerd dat de mand leeg is. Er zijn mooiere manieren om dit te doen maar dit is simpel te begrijpen.
    $mandinhoud = '';

    foreach($resultaat as $productinmandje) {


        // we bouwen hier met html een stukje weergave van het mandje op de site
        $mandinhoud .= "<tr><td>$productinmandje</td></tr>";
    }


        return $mandinhoud;

    }
}

?>