<?php
// Door Lennard S1080997 WIP

include "head.php";
include "header.php";


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

/*if(isset($_POST["registreren"])) { //wachtwoordcontrole (?)
    if (strlen(($_POST[$wachtwoord])) < 6 OR strlen(($_POST[$wachtwoord])) > 20 OR !preg_match("#[0-9]+#", ($_POST[$wachtwoord])) OR !preg_match("#[a-z]+#", ($_POST[$wachtwoord]))) {
        print("tea");
    }
}*/

// Als de knop "registreren" is geklikt, haal met $_POST de gegevens op.
if (isset($_POST["registreren"])){
    $gegevens[$emailadres] = isset($_POST[$emailadres]) ? $_POST[$emailadres] : "";
    $gegevens[$voornaam] = isset($_POST[$voornaam]) ? $_POST[$voornaam] : "";
    $gegevens[$achternaam] = isset($_POST[$achternaam]) ? $_POST[$achternaam] : "";
    $gegevens[$geslacht] = isset($_POST[$geslacht]) ? $_POST[$geslacht] : "";
    $gegevens[$wachtwoord] = isset($_POST[$wachtwoord]) ?  md5("a@sdiu#(*$1_41" . $_POST[$wachtwoord]) : ""; //md5 encryptie om het wachtwoord versleutelt op te slaan.
    //$gegevens[$wachtwoord2] = isset($_POST[$wachtwoord2]) ? $_POST[$wachtwoord2] : "";
    $gegevens[$adres] = isset($_POST[$adres]) ? $_POST[$adres] : "";
    $gegevens[$woonplaats] = isset($_POST[$woonplaats]) ? $_POST[$woonplaats] : "";
    $gegevens[$postcode] = isset($_POST[$postcode]) ? $_POST[$postcode] : "";
    $gegevens[$geboortedatum] = isset($_POST[$geboortedatum]) ? $_POST[$geboortedatum] : "";
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

<div class="container">
<h1>WWI</h1><br>
<h2>Account registreren</h2><br>
<form method="post" action="accountregistreren.php">

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

<?php
/*Nog te ontwikkelen; het veld wachtwoord bevestigen. Deze word niet opgenomen in de database (wat mij goed lijkt), maar ik heb
nog geen functie gemaakt die controleerd of wachtwoord1 === wachtwoord2. */
?>