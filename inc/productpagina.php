<?php
#error_reporting(E_ALL);

include_once('head.php');
include_once('header.php');

$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

function toonProductPagina($conn, $artikel_id = 'NULL')
{
    if ($artikel_id == 'NULL') {
        $sql = "SELECT `bestandslocatie` , `naam` , `art`.artikel_id FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` LIMIT 4";

        $result = $conn->query($sql);

        $html = '<table class="table table-hover">';
        foreach ($result as $regel) {
            $html .= "<tr>";
            foreach ($regel as $veldnaam => $veld) {
                if ($veldnaam == 'bestandslocatie') {
                    $html .= "<td><img src='../" . $veld . "' height='150' width='150'/></td>";
                }

                if ($veldnaam == 'artikel_id') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $veld . "'>Bekijk Product</a></td>";
                }

                if ($veldnaam !== 'bestandslocatie' AND $veldnaam !== 'artikel_id') {
                    $html .= "<td>" . $veld . "</td>";
                }
            }
            $html .= "</tr>";

        }
        $html .= "</table>";
    } else {

        $sql = "SELECT bestandslocatie, naam, herkomst, productieproces, ingredienten, afmetingen, gewicht, art.omschrijving FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` WHERE `art`.`artikel_id` = '" . $artikel_id . "' LIMIT 1";

        $result = $conn->query($sql);

        $html = '<table class="table table-hover">';
        foreach ($result as $regel) {

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