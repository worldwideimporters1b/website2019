function toonProductPagina($conn){

$sql = "SELECT * FROM `orderregel` LEFT JOIN `artikel` on `orderregel`.`artikel_id` = `artikel`.`artikel_id` LEFT JOIN `wideworldimporters`.`stockitems` ON orderregel.artikel_id = `wideworldimporters`.`stockitems`.`StockItemID` WHERE `winkelmand_id` = ".$winkelmandid.";";
// query moet nog even werkend worden gemaakt
$result = $conn->query($sql);


$html = '<table width="100%">';
    foreach ($result as $regel) {

    $html .= "<tr>"; // tr is table row
        foreach ($regel as $veldnaam => $veld) {
        if($veldnaam == 'artikel_afbeelding' ){
        $html .= "<td><img src='" . $veld . "' height="100" width="200"/></td>"; // td is table data
        }
        $html .= "<td>" . $veld . "</td>"; // td is table data

        }
        $html .= "</tr>";
    return $html;
    }}