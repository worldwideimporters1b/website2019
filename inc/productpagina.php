<?php
#error_reporting(E_ALL);

include_once('head.php');
include_once('header.php');
echo "<div class='container'>";
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

function toonProductPagina($conn, $artikel_id = 'NULL')
{
    if ($artikel_id == 'NULL') {

		$sql = "SELECT `bestandslocatie` , `naam` , `unitprice` prijs, `art`.`artikel_id` 
                        FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` 
                        JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` 
                        JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID LIMIT 20";
        // Hier wordt de zoek functie aan geroepen indien de zoek functie is gebruikt.
		
		
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btnSearch'])) {
                $zoekstring = $_POST['zoekstring'];
                var_dump($zoekstring);
                die();
                $sql = "SELECT `bestandslocatie` , `naam` , `unitprice` prijs, `art`.`artikel_id` 
                        FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` 
                        JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` 
                        JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID
                        JOIN `zoekwoorden_artikel` on artikel.artikel_id=zoekwoorden_artikel.artikel_id LIMIT 4
                        WHERE `zoekwoorden_artikel.zoekwoord` LIKE '%" . $name . "%'";
            } 
        }


        $result = $conn->query($sql);

        $html = '<table class="table rounded">';
        $html .= '<tr><th><h3>Product Overzicht</h3></th></tr>';
        foreach ($result as $regel) {
            $html .= "<tr>";
            $artikel_id = $regel['artikel_id'];
            foreach ($regel as $veldnaam => $veld) {
                if ($veldnaam == 'bestandslocatie') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $artikel_id . "'><img style='height: 150px; width: auto;' src='../" . $veld . "' class=\"rounded img-responsive thumbnail border border-white\"/></a></td>";
                }

                if ($veldnaam == 'artikel_id') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $veld . "'>Bekijk Product</a></td>";
                }

                if ($veldnaam !== 'bestandslocatie' AND $veldnaam !== 'artikel_id') {
                    $html .= "<td><h4>" . $veld . "</h4></td>";
                }
            }
            $html .= "</tr>";

        }
        $html .= "</table>";
    } else {

        $sql = "SELECT bestandslocatie, unitprice prijs, naam, herkomst, productieproces, ingredienten, afmetingen, gewicht, art.omschrijving FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID WHERE `art`.`artikel_id` = '" . $artikel_id . "' LIMIT 1";

        $result = $conn->query($sql);

        $html = '<table class="table table-hover">';
        foreach ($result as $regel) {
            $html .= "<tr><td></td><td><a class='btn btn-secondary'href='basket.php?add=" . $artikel_id . "'>Toevoegen</a></td></tr>";
            foreach ($regel as $veldnaam => $veld) {
                if ($veldnaam == 'bestandslocatie') {
                    $html .= "<tr><td><img src='../" . $veld . "' height='200' width='200'/></td></tr>";
                } else {
                    $html .= "<tr><td>" . $veldnaam . "</td><td>" . $veld . "</td></tr>";
                }
            }


        }
        $html .= "</table><a class='btn btn-secondary' href='productpagina.php'>Terug naar overzicht</a>";


    }

    return $html;
}

if (isset($_GET['id'])) {

    if (is_numeric($_GET['id'])) {

        $id = $_GET['id'];

        echo toonProductPagina($conn, $id);

    }

} else {

    echo toonProductPagina($conn);

}
echo "</div>";
