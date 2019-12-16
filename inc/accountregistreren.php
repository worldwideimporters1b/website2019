<?php
// Door Lennard S1080997

include "head.php";
include "footer.php";
include "menu.php";

//database verbinding
function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}

//deze functie zal de de registratie functie aanroepen, en controleren of het account is geregistreerd in de database.
function registreren($gegevens) {
    $conn = databaseConnectie();
    if($gegevens["wachtwoord"])
    if (accountregistreren($gegevens["emailadres"], $gegevens["voornaam"],$gegevens["achternaam"], $gegevens["geslacht"],$gegevens["wachtwoord"],
            $gegevens["adres"],$gegevens["woonplaats"], $gegevens["postcode"], $gegevens["geboortedatum"], $conn) == 1)

        /*controle of het account succesvol is geregistreerd. Wanneer de webshop 1 terug geeft, is het gelukt.
           $result geeft een 1 terug in de functie accountRegistreren, als de database succesvol een insert heeft uitgevoerd.*/

        $gegevens["melding"] = "Uw account is geregistreerd. <br> Klik op onderstaande knop om in te loggen.<br>";

    else $gegevens["melding"] = "Het registreren is mislukt. Probeer het nog eens."; //anders word er onderstaande foutmelding gegeven.

    return $gegevens;
}

//de functie accountregistreren zal de gegevens van de klant opslaan in de database
function accountregistreren($emailadres, $voornaam, $achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode, $geboortedatum, $conn) {
    //met een INSERT voegen we de nieuwe klantgegevens toe aan de database
    $sql = "INSERT INTO gebruiker (emailadres, voornaam, achternaam, geslacht, wachtwoord, adres, woonplaats, postcode, geboortedatum) 
            VALUES('$emailadres','$voornaam', '$achternaam', '$geslacht', '$wachtwoord','$adres','$woonplaats','$postcode','$geboortedatum')";

    $result = $conn->query($sql);

    return $result;
}

//variabelen definieren
$emailadres = "emailadres";
$voornaam = "voornaam";
$achternaam = "achternaam";
$geslacht = "geslacht";
$wachtwoord = "wachtwoord";
//$wachtwoord2 = "wachtwoord2";
$adres = "adres";
$woonplaats = "woonplaats";
$postcode = "postcode";
$geboortedatum = "geboortedatum";
$message = "melding";

/*if(isset($_GET["registreren"])) {
    if (strlen(($_GET[$wachtwoord])) < 6 OR strlen(($_GET[$wachtwoord])) > 20 OR !preg_match("#[0-9]+#", ($_GET[$wachtwoord])) OR !preg_match("#[a-z]+#", ($_GET[$wachtwoord]))) {
        print("tea");
    }
}*/

// Als de knop "registreren" is geklikt, haal met $_GET de gegevens op.
if (isset($_GET["registreren"])){
    $gegevens[$emailadres] = isset($_GET[$emailadres]) ? $_GET[$emailadres] : "";
    $gegevens[$voornaam] = isset($_GET[$voornaam]) ? $_GET[$voornaam] : "";
    $gegevens[$achternaam] = isset($_GET[$achternaam]) ? $_GET[$achternaam] : "";
    $gegevens[$geslacht] = isset($_GET[$geslacht]) ? $_GET[$geslacht] : "";
    $gegevens[$wachtwoord] = isset($_GET[$wachtwoord]) ?  md5("@uY1#ae6R4J0B4%1" . $_GET[$wachtwoord]) : ""; //md5 encryptie om het wachtwoord versleutelt op te slaan.
    //$gegevens[$wachtwoord2] = isset($_GET[$wachtwoord2]) ? $_GET[$wachtwoord2] : "";
    $gegevens[$adres] = isset($_GET[$adres]) ? $_GET[$adres] : "";
    $gegevens[$woonplaats] = isset($_GET[$woonplaats]) ? $_GET[$woonplaats] : "";
    $gegevens[$postcode] = isset($_GET[$postcode]) ? $_GET[$postcode] : "";
    $gegevens[$geboortedatum] = isset($_GET[$geboortedatum]) ? $_GET[$geboortedatum] : "";
    $gegevens = registreren($gegevens);
}else{
    //als een veld niet is ingevult:
    $gegevens[$emailadres] = "";
    $gegevens[$voornaam] = "";
    $gegevens[$achternaam] = "";
    $gegevens[$geslacht] = "";
    $gegevens[$wachtwoord] = "";
    //$gegevens[$wachtwoord2] = "";
    $gegevens[$adres] = "";
    $gegevens[$woonplaats] = "";
    $gegevens[$postcode] = "";
    $gegevens[$geboortedatum] = "";
    $gegevens[$message] = "";
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<div class="container">
<h1>WWI</h1><br>
<h2>Account registreren</h2><br>
<form method="get" action="accountregistreren.php">

<!-- Selfhandling formulier weergeven op het scherm, zodat de klant zijn of haar gegevens kan registreren. Alle velden zijn verplicht, op geslacht en geb. datum na. -->

    <input type="email" name="emailadres" class="form-control "value="<?php print($gegevens[$emailadres]); ?>" placeholder="E-mail adres" required/>
    <br>
    <input type="text" name="voornaam" class="form-control "value="<?php print($gegevens[$voornaam]); ?>" placeholder="Voornaam" required/>
    <br>
    <input type="text" name="achternaam" class="form-control "value="<?php print($gegevens[$achternaam]); ?>" placeholder="Achternaam"required/>
    <br>
    <input type="text" name="geslacht" class="form-control "value="<?php print($gegevens[$geslacht]); ?>" placeholder="Geslacht (optioneel)"/>
    <br>
    <input type="password" name="wachtwoord" class="form-control" value="<?php print($gegevens[$wachtwoord]); ?>" placeholder="Wachtwoord" required>

   <!-- <input type="password" name="wachtwoord2" class="form-control" value="<?php//print($gegevens[$wachtwoord2]); ?>" placeholder="Herhaal uw wachtwoord"> -->
    <br>
    <input type="text" name="adres" class="form-control" value="<?php print($gegevens[$adres]); ?>" placeholder="Adres" required/>
    <br>
    <input type="text" name="woonplaats" class="form-control" value="<?php print($gegevens[$woonplaats]); ?>" placeholder="Woonplaats" required/>
    <br>
    <input type="text" name="postcode" class="form-control" value="<?php print($gegevens[$postcode]); ?>" placeholder="Postcode" required/>
    <br>
    <input type="text" name="geboortedatum" class="form-control "value="<?php print($gegevens[$geboortedatum]); ?>" placeholder="Geboortedatum yyyy-mm-dd (optioneel)"/>
    <br>
    <input type="submit" class="btn btn-outline-success" name="registreren" value="registreren"/>
</form>
</div>
<div class="container">
<?php
print($gegevens[$message]);

?><br>
<a class="btn btn-outline-primary" href="" role="button">Terug naar de inlogpagina</a>
</div>
</html>
<?php
/*Nog te ontwikkelen; het veld wachtwoord bevestigen. Deze word niet opgenomen in de database (wat mij goed lijkt), maar ik heb
nog geen functie gemaakt die controleerd of wachtwoord1 === wachtwoord2. */
?>