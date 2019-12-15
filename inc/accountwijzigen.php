<?php

include "head.php";
include "footer.php";
include "menu.php";


function accountWijzigen($accountgegevens){
    $conn = databaseConnectie();


}

function updateAccount($emailadres, $voornaam, $achternaam, $geslacht, $adres, $woonplaats, $postcode, $geboortedatum, $conn){
    $sql = "UPDATE `gebruiker` SET `emailadres` = '$emailadres', `voornaam` = '$voornaam',`achternaam` = '$achternaam',`geslacht` = '$geslacht',`adres` = '$adres'
            , `woonplaats` = '$woonplaats',`postcode` = '$postcode',`geboortedatum` = '$geboortedatum' WHERE `gebruiker_id` = '$gebruikersid';";

    $result = $conn->query($sql);

    return $result;

}

//variabelen definieren
$emailadres = "emailadres";
$voornaam = "voornaam";
$achternaam = "achternaam";
$geslacht = "geslacht";
$adres = "adres";
$woonplaats = "woonplaats";
$postcode = "postcode";
$geboortedatum = "geboortedatum";
$message = "melding";


// Als de knop "Bijwerken" is geklikt, haal met $_GET de gegevens op.
if (isset($_GET["bijwerken"])){
    $accountgegevens[$emailadres] = isset($_GET[$emailadres]) ? $_GET[$emailadres] : "";
    $accountgegevens[$voornaam] = isset($_GET[$voornaam]) ? $_GET[$voornaam] : "";
    $accountgegevens[$achternaam] = isset($_GET[$achternaam]) ? $_GET[$achternaam] : "";
    $accountgegevens[$geslacht] = isset($_GET[$geslacht]) ? $_GET[$geslacht] : "";
    $accountgegevens[$adres] = isset($_GET[$adres]) ? $_GET[$adres] : "";
    $accountgegevens[$woonplaats] = isset($_GET[$woonplaats]) ? $_GET[$woonplaats] : "";
    $accountgegevens[$postcode] = isset($_GET[$postcode]) ? $_GET[$postcode] : "";
    $accountgegevens[$geboortedatum] = isset($_GET[$geboortedatum]) ? $_GET[$geboortedatum] : "";
    $accountgegevens = accountWijzigen($accountgegevens);
}else{
    //als een veld niet is ingevult:
    $accountgegevens[$emailadres] = "";
    $accountgegevens[$voornaam] = "";
    $accountgegevens[$achternaam] = "";
    $accountgegevens[$geslacht] = "";
    $accountgegevens[$adres] = "";
    $accountgegevens[$woonplaats] = "";
    $accountgegevens[$postcode] = "";
    $accountgegevens[$geboortedatum] = "";
    $accountgegevens[$message] = "";
}
?>



<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<div class="container">
<form method="get" action="accountwijzigen.php">
    <label>E-mail adres</label>
    <input type="text" name="emailadres" value="<?php print($accountgegevens[$emailadres]); ?>"/>
    <br>
    <label>Voornaam</label>
    <input type="text" name="voornaam" value="<?php print($accountgegevens[$voornaam]); ?>"/>
    <br>
    <label>Achternaam</label>
    <input type="text" name="achternaam" value="<?php print($accountgegevens[$achternaam]); ?>"/>
    <br>
    <label>Geslacht</label>
    <input type="text" name="emailadres" value="<?php print($accountgegevens[$geslacht]); ?>"/>
    <br>
    <label>Adres</label>
    <input type="text" name="adres" value="<?php print($accountgegevens[$adres]); ?>"/>
    <br>
    <label>Postcode</label>
    <input type="text" name="postcode" value="<?php print($accountgegevens[$postcode]); ?>"/>
    <br>
    <label>Woonplaats</label>
    <input type="text" name="woonplaats" value="<?php print($accountgegevens[$woonplaats]); ?>"/>
    <br>
    <label>Geboortedatum</label>
    <input type="text" name="geboortedatum" value="<?php print($accountgegevens[$geboortedatum]); ?>"/>
    <br>
    <input type="submit" name="bijwerken" value="Bijwerken"/>
</form>
</div>

</html>
