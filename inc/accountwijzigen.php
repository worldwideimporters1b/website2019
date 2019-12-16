<?php
// Door Lennard S1080997

include "head.php";
include "footer.php";
include "menu.php";

function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}

$conn = databaseConnectie();
gegevensOphalen(1,$conn); //gegevens van in dit geval gebruiker met ID 1 ophalen

//zorgen dat bovenstaande functie uitgevoerd word.
function gegevensOphalen($gebruikersid, $conn){
    $sql = "SELECT * FROM `gebruiker` WHERE `gebruiker_id` = ".$gebruikersid.";";  //Met deze sql query geven we aan dat we alle gegevens van de tabel gebruiker willen hebben.

    $accountgegevens = $conn->query($sql); // Hiermee voeren we de bovenstaande query uitvoeren

    return $accountgegevens;
}


function accountWijzigen($accountgegevens){ //De feedback geven door middel van een melding op het scherm.
    $conn = databaseConnectie();
    if (updateAccount($accountgegevens["emailadres"], $accountgegevens["voornaam"], $accountgegevens["achternaam"], $accountgegevens["geslacht"], $accountgegevens["adres"],
    $accountgegevens["woonplaats"], $accountgegevens["postcode"], $accountgegevens["geboortedatum"], $conn) == 1)

        $accountgegevens["melding"] = "Uw accountgegevens zijn bijgewerkt.";
    else $accountgegevens["melding"] = "Het bijwerken is mislukt. Probeer het nog eens.";

    return $accountgegevens;
}

//De SQL query die word aangeroepen door de functie accountWijzigen.
function updateAccount($emailadres, $voornaam, $achternaam, $geslacht, $adres, $woonplaats, $postcode, $geboortedatum, $conn){
    $gebruikersid = 1; //Gebruikers ID nog verandere in een variabele, SESSIE o.i.d.
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
    <h3>Uw gegevens</h3><br>

<form method="get" action="accountwijzigen.php">

        <div class="col-sm-10">
    <label for="emailadres">E-mail adres</label>
    <input type="email" class="form-control" name="emailadres" placeholder='<?php print($accountgegevens["emailadres"]); ?>' value="<?php print($accountgegevens[$emailadres]); ?>"/>
    <br>
        </div>

        <div class="col-sm-10">
    <label for="voornaam">Voornaam</label>
    <input type="text" class="form-control" name="voornaam" value="<?php print($accountgegevens[$voornaam]); ?>"/>
    <br>
        </div>

        <div class="col-sm-10">
    <label for="achternaam">Achternaam</label>
    <input type="text" class="form-control" name="achternaam" value="<?php print($accountgegevens[$achternaam]); ?>"/>
    <br>
        </div>

            <div class="col-sm-10">
    <label for="geslacht">Geslacht</label>
    <input type="text" class="form-control" name="geslacht" value="<?php print($accountgegevens[$geslacht]); ?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="adres">Adres</label>
    <input type="text" class="form-control" name="adres" value="<?php print($accountgegevens[$adres]); ?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="postcode">Postcode</label>
    <input type="text" class="form-control" name="postcode" value="<?php print($accountgegevens[$postcode]); ?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="woonplaats">Woonplaats</label>
    <input type="text" class="form-control" name="woonplaats" value="<?php print($accountgegevens[$woonplaats]); ?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="geboortedatum">Geboortedatum</label>
    <input type="text" class="form-control" name="geboortedatum" value="<?php print($accountgegevens[$geboortedatum]); ?>"/>
    <br>
            </div>

    <input type="submit" class="btn btn-outline-primary" name="bijwerken" value="Bijwerken"/>
    <a class="btn btn-outline-success" href="accountoverzicht.php" role="button">Terug naar accountoverzicht</a>
</form>
</div>
<div class="container">
<br>
<?php
print("$accountgegevens[$message]");
?>


</div>
</html>
