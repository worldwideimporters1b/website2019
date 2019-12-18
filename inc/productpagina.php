<?php
error_reporting(E_ALL);
$conn = new mysqli('localhost','root','','world_wide_importers');

function toonProductPagina($conn)
{

    $sql = "SELECT bestandslocatie , naam FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` LIMIT 4";

    $result = $conn->query($sql);

    $html = '<table width="100%">';
    foreach ($result as $regel) {
        $html .= "<tr>";
        foreach ($regel as $veldnaam => $veld) {
            if ($veldnaam == 'bestandslocatie') {
                $html .= "<td><img src='../" . $veld . "' height='150' width='150'/></td>";
            }
            else {
                $html .= "<td>" . $veld . "</td>";
            }
        }
        $html .= "</tr>";

    }
    $html .= "</table>";
    return $html;
}

echo toonProductPagina($conn);