<?php

// Sander

function getgebruikerid()
{
    if (!isset($_SESSION['ingelogd'])) {


        $gebruikerid = 0;


    }


    if (isset($_SESSION['ingelogd'])) {
        if ($_SESSION['ingelogd'] == 1) {

            $gebruikerid = $_SESSION['gebruiker_id'];

        }
    }


    return $gebruikerid;

}


function basketinfo($conn)
{
    if (!isset($_SESSION['ingelogd'])) {

        echo "Niet ingelogd";


        $winkelmandid = 0;


    }


    if (isset($_SESSION['ingelogd'])) {
        if ($_SESSION['ingelogd'] == 1) {

            echo "Wel ingelogd";

            # INSERT INTO `betaling` (`betaling_id`, `betaalmethode`, `afrekenlink`, `betaalstatus`) VALUES (NULL, 'ideal', 'http://demolink/bladiebla', '0');
            # INSERT INTO `winkelmand` (`winkelmand_id`, `betaling_id`, `order_id`, `totaalprijs`, `kortingscode`, `waardebon`, `verwachte_leverdatum`, `gebruiker_id`) VALUES (NULL, '1', '', '', NULL, NULL, NULL, '68');

            $winkelmandid = 1;

            $sql = "SELECT `winkelmand_id` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` LEFT JOIN `gebruiker` on `gebruiker`.`gebruiker_id` = `gebruiker_id` WHERE `gebruiker`.`gebruiker_id` = '" . $_SESSION["gebruiker_id"] . "' LIMIT 1";

            $result = $conn->query($sql);


            if ($result->num_rows == 0) {
                echo "Er zijn nog geen producten toegevoegd aan het winkelmandje";
            } else {
                foreach ($result as $user) {


                    $winkelmandid = $user['winkelmand_id'];

                }
            }

        }
    }

    return $winkelmandid;

}

function updateProductAantal($winkelmandid, $artikelid, $aantal, $conn)
{

    $sql = "SELECT order_id FROM `winkelmand` WHERE winkelmand_id = " . $winkelmandid . " LIMIT 1";

    $result = $conn->query($sql);


    if ($result->num_rows == 0) {
        echo "Er is een technische fout opgetreden.";
        exit;
    } else {
        foreach ($result as $order) {
            $orderid = $order['order_id'];
            var_dump($orderid);
            $sql = "SELECT `artikel_id` FROM `orderregel` WHERE `winkelmand_id` = " . $winkelmandid . "";
            $result = $conn->query($sql);

            $artikelen = array();

            if ($result->num_rows !== 0) {

                // er zit iets in de mand YAY!


                //controleren of te wijzigen product in huidige mand zit
                foreach($result as $artikel){

                    array_push($artikelen, $artikel['artikel_id']);

                }

                if (in_array($artikelid, $artikelen)) {
                    // update
                    if($aantal == 0){
                        $sql = "DELETE FROM `orderregel` WHERE `winkelmand_id` = " . $winkelmandid . " AND `artikel_id` = " . $artikelid . "";
                        $result = $conn->query($sql);
                    }
                    if($aantal !== 0) {
                        $sql = "UPDATE `orderregel` SET `aantal` = " . $aantal . " WHERE `winkelmand_id` = " . $winkelmandid . " AND `artikel_id` = " . $artikelid . "";
                        $result = $conn->query($sql);
                    }


                }
                else
                {
                    $sql = "INSERT INTO `orderregel` (`order_id`, `artikel_id`, `aantal`, `winkelmand_id`) VALUES (NULL, $artikelid, $aantal, $winkelmandid)";
                    $result = $conn->query($sql);
                }


            }


            //hieronder bouwen we de query naar de database op, met daarin de parameters op de juiste plekken.
            $sql = "UPDATE `" . $aantal . " WHERE `artikelid` = " . $artikelid . " AND `winkelmandid` = " . $winkelmandid . ";";

            #INSERT INTO `orderregel` (`order_id`, `artikel_id`, `aantal`, `korting_id`, `voorraadstatu`, `winkelmand_id`) VALUES ('1', '1', '1', '1', '1', '2');

            // hieronder voeren we de query uit


            // het stuk hieronder is een voorbeeld van het uitlezen van de query (of het gelukt is of niet)

            if ($result) // controleer of er een resultaat is
            {
                $status = 1; // toevoegen is gelukt
            } else {
                $status = 0; // toevoegen is niet gelukt
            }
        }
    }


    return $artikelid;
    #return $status; // we melden aan onze applicatie (webshop) 0 of 1 de webshop weet dan voldoende.
}

function toonWinkelmand($winkelmandid, $conn)
{

    $sql = "SELECT `winkelmand_id`,`naam`, `unitprice`, `aantal` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = " . $winkelmandid . ";";

    $result = $conn->query($sql);


    $html = '<table class="table">';
    $html .= "<tr><th>Bestelnummer</th><th>Product</th><th>Prijs</th><th>Aantal</th></tr>";
    foreach ($result as $regel) {

        $html .= "<tr>"; // tr is table row
        foreach ($regel as $veld) {

            $html .= "<td>" . $veld . "</td>"; // td is table data

        }

        $html .= "<td>Prullenbakje Placeholder</td></tr>";
    }
    $html .= '</table>';
    return $html;
}

function toonWinkelstats($winkelmandid, $conn)
{

    $sql = "SELECT `unitprice`,`aantal` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = " . $winkelmandid . ";";

    $result = $conn->query($sql);
    $aantalartikelen = 0;
    $totaalartikelen = array();
    $prijs = array();
    foreach ($result as $regel) {
        $aantalartikelen++;

        array_push($prijs, $regel['unitprice'] * $regel['aantal']);
        array_push($totaalartikelen, $regel['aantal']);


    }
    $totaalprijs = array_sum($prijs);
    $totaalartikelen = array_sum($totaalartikelen);

    $basketinfo = array("Prijs" => $totaalprijs, "Aantal" => $totaalartikelen);

    return $basketinfo;
}

function secureInt($int)
{
    if (!filter_var($int, FILTER_VALIDATE_INT) === false) {
        return $int;
        } else {
        return 0;
    }
}
// Sander