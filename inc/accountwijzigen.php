<?php
// Door Lennard S1080997 WIP

include "head.php";
include "header.php";


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
    $gebruikersid = 1; //Gebruikers ID nog verandere in een variabele, $SESSIE o.i.d.
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


// Als de knop "Bijwerken" is geklikt, haal met POST de gegevens op.
if (isset($_POST["bijwerken"])){
    $accountgegevens[$emailadres] = isset($_POST[$emailadres]) ? $_POST[$emailadres] : "";
    $accountgegevens[$voornaam] = isset($_POST[$voornaam]) ? $_POST[$voornaam] : "";
    $accountgegevens[$achternaam] = isset($_POST[$achternaam]) ? $_POST[$achternaam] : "";
    $accountgegevens[$geslacht] = isset($_POST[$geslacht]) ? $_POST[$geslacht] : "";
    $accountgegevens[$adres] = isset($_POST[$adres]) ? $_POST[$adres] : "";
    $accountgegevens[$woonplaats] = isset($_POST[$woonplaats]) ? $_POST[$woonplaats] : "";
    $accountgegevens[$postcode] = isset($_POST[$postcode]) ? $_POST[$postcode] : "";
    $accountgegevens[$geboortedatum] = isset($_POST[$geboortedatum]) ? $_POST[$geboortedatum] : "";
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



<div class="container">
    <h3>Uw gegevens</h3><br>

<form method="post" action="accountwijzigen.php">

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
    <a class="btn btn-outline-danger" href="accountverwijderen.php" role="button">Account verwijderen</a><br><br>
    <a class="btn btn-outline-success" href="accountoverzicht.php" role="button">Terug naar accountoverzicht</a>

</form>
</div>
<div class="container">
<br>
<?php
print("$accountgegevens[$message]");
?>


</div>

