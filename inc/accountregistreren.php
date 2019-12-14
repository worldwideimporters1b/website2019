<?php
include "head.php";
include "footer.php";
include "menu.php";

//database verbinding
function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}

function registreren($gegevens) {
    $conn = databaseConnectie();
    if (accountregistreren($gegevens["emailadres"], $gegevens["voornaam"],$gegevens["achternaam"], $gegevens["geslacht"],
            $gegevens["wachtwoord"],$gegevens["adres"],$gegevens["woonplaats"], $gegevens["postcode"], $conn) == 1)

        //controle of het account succesvol is geregistreerd. Wanneer de webshop 1 terug geeft, is het gelukt.

        $gegevens["melding"] = "Uw account is geregistreerd. Klik op de onderstaande link in te loggen.";

    else $gegevens["melding"] = "Het registreren is mislukt. Probeer het nog eens."; //anders word er onderstaande foutmelding gegeven.

    return $gegevens;
}
//de functie account registreren zal de gegevens van de klant opslaan in de database
function accountregistreren($emailadres, $voornaam, $achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode, $conn) {
    //met een INSERT voegen we de nieuwe klantgegevens toe aan de database
    $sql = "INSERT INTO gebruiker (emailadres, voornaam, achternaam, geslacht, wachtwoord, adres, woonplaats, postcode) 
            VALUES('$emailadres','$voornaam', '$achternaam', '$geslacht', '$wachtwoord','$adres','$woonplaats','$postcode')";

    $conn->query($sql);

    return $sql;
}

//variabelen definieren
$emailadres = "emailadres";
$voornaam = "voornaam";
$achternaam = "achternaam";
$geslacht = "geslacht";
$geboortedatum = "geboortedatum";
$wachtwoord = "wachtwoord";
//$wachtwoord2 = "wachtwoord2";
$adres = "adres";
$woonplaats = "woonplaats";
$postcode = "postcode";
$message = "melding";

// Als de knop "registreren" is geklikt, haal met $_GET de gegevens op.
if (isset($_GET["registreren"])){
    $gegevens[$emailadres] = isset($_GET[$emailadres]) ? $_GET[$emailadres] : "";
    $gegevens[$voornaam] = isset($_GET[$voornaam]) ? $_GET[$voornaam] : "";
    $gegevens[$achternaam] = isset($_GET[$achternaam]) ? $_GET[$achternaam] : "";
    $gegevens[$geslacht] = isset($_GET[$geslacht]) ? $_GET[$geslacht] : "";
    $gegevens[$geboortedatum] = isset($_GET[$geboortedatum]) ? $_GET[$geboortedatum] : "";
    $gegevens[$wachtwoord] = isset($_GET[$wachtwoord]) ? $_GET[$wachtwoord] : "";
    //$gegevens[$wachtwoord2] = isset($_GET[$wachtwoord2]) ? $_GET[$wachtwoord2] : "";
    $gegevens[$adres] = isset($_GET[$adres]) ? $_GET[$adres] : "";
    $gegevens[$woonplaats] = isset($_GET[$woonplaats]) ? $_GET[$woonplaats] : "";
    $gegevens[$postcode] = isset($_GET[$postcode]) ? $_GET[$postcode] : "";
    $gegevens = registreren($gegevens);
}else{
    //als het een veld niet is ingevult:
    $gegevens[$emailadres] = "";
    $gegevens[$voornaam] = "";
    $gegevens[$achternaam] = "";
    $gegevens[$geslacht] = "";
    $gegevens[$geboortedatum] = "";
    $gegevens[$wachtwoord] = "";
    //$gegevens[$wachtwoord2] = "";
    $gegevens[$adres] = "";
    $gegevens[$woonplaats] = "";
    $gegevens[$postcode] = "";
    $gegevens[$message] = "";
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<h1>WWI</h1><br>
<h2>Account registreren</h2><br>
<form method="get" action="accountregistreren.php">

<!-- Selfhandling formulier weergeven op het scherm, zodat de klant zijn of haar gegevens kan registreren. -->

    <input type="text" name="voornaam" class="form-control "value="<?php print($gegevens[$voornaam]); ?>" placeholder="Voornaam"/>
    <br>
    <input type="text" name="achternaam" class="form-control "value="<?php print($gegevens[$achternaam]); ?>" placeholder="Achternaam"/>
    <br>
    <input type="text" name="geslacht" class="form-control "value="<?php print($gegevens[$geslacht]); ?>" placeholder="Geslacht"/>
    <br>
    <input type="password" name="wachtwoord" class="form-control" value="<?php print($gegevens[$wachtwoord]); ?>" placeholder="Wachtwoord">
    <br>
   <!-- <input type="password" name="wachtwoord2" class="form-control" value="<?php print($gegevens[$wachtwoord2]); ?>" placeholder="Herhaal uw wachtwoord"> -->
    <br>
    <input type="text" name="adres" class="form-control" value="<?php print($gegevens[$adres]); ?>" placeholder="Adres"/>
    <br>
    <input type="text" name="woonplaats" class="form-control" value="<?php print($gegevens[$woonplaats]); ?>" placeholder="Woonplaats"/>
    <br>
    <input type="text" name="postcode" class="form-control" value="<?php print($gegevens[$postcode]); ?>" placeholder="Postcode"/>
    <br>
    <input type="submit" class="btn btn-outline-primary" name="registreren" value="registreren"/>
</form>
<br><?php print($gegevens[$message]); ?><br>
<a class="btn btn-primary" href="inloggen.php" role="button">Terug naar de inlogpagina</a>
</body>
</html>
