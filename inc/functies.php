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

function getbasketid($conn)

{
    $sql = "SELECT `winkelmand_id` FROM `winkelmand`";

    if (!isset($_SESSION['ingelogd'])) {
        $winkelmandid = 0;
    }

    if (isset($_SESSION['ingelogd'])) {
        if ($_SESSION['ingelogd'] == 1) {

            $winkelmandid = 1;

            $sql = "SELECT `winkelmand_id` FROM `winkelmand` WHERE `winkelmand`.`gebruiker_id` = '" . $_SESSION["gebruiker_id"] . "' LIMIT 1";

            $result = $conn->query($sql);


            if ($result->num_rows == 0) {
                echo "Er is geen winkelmand";
            } else {
                foreach ($result as $user) {

                    $winkelmandid = $user['winkelmand_id'];

                }
            }

        }
    }

    return $winkelmandid;


}

function basketinfo($conn)
{
    if (!isset($_SESSION['ingelogd'])) {


        $winkelmandid = 0;


    }


    if (isset($_SESSION['ingelogd'])) {
        if ($_SESSION['ingelogd'] == 1) {

            # INSERT INTO `betaling` (`betaling_id`, `betaalmethode`, `afrekenlink`, `betaalstatus`) VALUES (NULL, 'ideal', 'http://demolink/bladiebla', '0');
            # INSERT INTO `winkelmand` (`winkelmand_id`, `betaling_id`, `order_id`, `totaalprijs`, `kortingscode`, `waardebon`, `verwachte_leverdatum`, `gebruiker_id`) VALUES (NULL, '1', '', '', NULL, NULL, NULL, '68');

            $winkelmandid = 1;

            $sql = "SELECT `winkelmand_id` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` LEFT JOIN `gebruiker` on `gebruiker`.`gebruiker_id` = `gebruiker_id` WHERE `gebruiker`.`gebruiker_id` = '" . $_SESSION["gebruiker_id"] . "' LIMIT 1";

            $result = $conn->query($sql);


            if ($result->num_rows == 0) {
                # echo "Er zijn nog geen producten toegevoegd aan het winkelmandje";
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

    $sql = "SELECT order_id FROM `orderregel` WHERE winkelmand_id = " . $winkelmandid . " LIMIT 1";
    #echo $sql;
    $result = $conn->query($sql);


    if ($result->num_rows == 0) {
        // winkelmand is leeg

        $sql = "INSERT INTO `orderregel` (`order_id`, `artikel_id`, `aantal`, `winkelmand_id`) VALUES (NULL, $artikelid, $aantal, $winkelmandid)";
        $result = $conn->query($sql);

    } else {
        foreach ($result as $order) {
            $orderid = $order['order_id'];

            $sql = "SELECT `artikel_id` FROM `orderregel` WHERE `winkelmand_id` = " . $winkelmandid . "";
            $result = $conn->query($sql);

            $artikelen = array();

            if ($result->num_rows !== 0) {

                // er zit iets in de mand YAY!


                //controleren of te wijzigen product in huidige mand zit
                foreach ($result as $artikel) {

                    array_push($artikelen, $artikel['artikel_id']);

                }

                if (in_array($artikelid, $artikelen)) {
                    // update
                    if ($aantal == 0) {
                        $sql = "DELETE FROM `orderregel` WHERE `winkelmand_id` = " . $winkelmandid . " AND `artikel_id` = " . $artikelid . "";
                        $result = $conn->query($sql);
                    }
                    if ($aantal !== 0) {
                        $sql = "UPDATE `orderregel` SET `aantal` = " . $aantal . " WHERE `winkelmand_id` = " . $winkelmandid . " AND `artikel_id` = " . $artikelid . "";
                        $result = $conn->query($sql);
                    }


                } else {
                    if ($aantal !== 0) {
                        $sql = "INSERT INTO `orderregel` (`order_id`, `artikel_id`, `aantal`, `winkelmand_id`) VALUES (NULL, $artikelid, $aantal, $winkelmandid)";
                        $result = $conn->query($sql);
                    }
                }


            }

        }
    }


    refreshpage();

}

function toonWinkelmand($winkelmandid, $conn)
{

    $sql = "SELECT `winkelmand_id`,`naam`, `unitprice`, `aantal`, `orderregel`.`artikel_id` FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = " . $winkelmandid . ";";

    $result = $conn->query($sql);


    $html = '<table class="table">';
    $html .= "<tr><th>Bestelnummer</th><th>Product</th><th>Prijs</th><th>Aantal</th></tr>";
    foreach ($result as $regel) {
        $aid = $regel['artikel_id'];
        $html .= "<tr>"; // tr is table row
        foreach ($regel as $veldnaam => $veld) {
            if ($veldnaam == 'unitprice') {
                $html .= "<td>€ " . $veld . "</td>";
            }
            if ($veldnaam == 'artikel_id') {
                $pid = $veld;
            }
            if ($veldnaam == 'aantal') {
                $html .= "<td>" . toonPullDown($veld, $aid) . "</td>";
            }
            if ($veldnaam !== 'artikel_id' AND $veldnaam !== 'unitprice' AND $veldnaam !== 'aantal') {
                $html .= "<td>" . $veld . "</td>"; // td is table data
            }
        }

        $html .= "<td><form class='form-inline' action='" . $_SERVER['PHP_SELF'] . "'>
                <input type='hidden' name='aid' id='aid' value='" . $aid . "'>
                <input type='hidden' name='add'>
                <input type='hidden' name='amt' id='amt' value='0'>
                <input type=\"submit\" class=\"btn btn-primary\" value='Verwijder'>
                 </form>


</td></tr>";
    }
    $html .= '</table>';
    return $html;
}

function toonPullDown($aantal, $aid)
{

    $html = "<form method='GET' action='basket.php' class='form-inline'><select class=\"form-control\" name='amt' id='amt'>\n";

    for ($i = 1; $i <= 10; $i++) {
        if ($aantal == $i) {
            $html .= "      <option value='" . $i . "' selected>" . $i . "</option>";
        } else {
            $html .= "      <option value='" . $i . "'>" . $i . "</option>";
        }
    }

    $html .= "</select><input type='hidden' name='aid' id='aid' value='" . $aid . "'><input type='hidden' name='add'> <input type=\"submit\" class=\"btn btn-primary\" value='Wijzig'></form>\n";

    return $html;
}

function refreshpage()
{
    header("Location: " . $_SERVER['PHP_SELF']);
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