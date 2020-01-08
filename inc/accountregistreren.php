<?php
// Door Lennard S1080997 WIP

include "head.php";
include "header.php";


//database verbinding
function databaseConnectie()
{
    $conn = new mysqli('localhost', 'root', '', 'world_wide_importers');
    return $conn;
}

//deze functie zal de de registratie functie aanroepen, en controleren of het account is geregistreerd in de database.
function registreren($gegevens)
{
    $conn = databaseConnectie();

    if (accountregistreren($gegevens['emailadres'], $gegevens["voornaam"], $gegevens["achternaam"], $gegevens["geslacht"], $gegevens["wachtwoord"],
            $gegevens["adres"], $gegevens["woonplaats"], $gegevens["postcode"], $gegevens["geboortedatum"], $conn) == 1) {

        /*controle of het account succesvol is geregistreerd. Wanneer de webshop 1 terug geeft, is het gelukt.
           $result geeft een 1 terug in de functie accountRegistreren, als de database succesvol een insert heeft uitgevoerd.*/

        echo "<blockquote class=\"blockquote text-center\">";
        echo "<p class=\"mb-0\"><strong>Uw account is geregistreerd. <br> </p></strong>";
        echo "</blockquote>";
    } else {
        echo "<blockquote class=\"blockquote text-center\">";
        echo "<p class=\"mb-0\"><strong>Het registreren is mislukt. Probeer het nog eens.</strong></p>"; //anders word er onderstaande foutmelding gegeven.
        echo "</blockquote>";
    }

    return $gegevens;
}

//de functie accountregistreren zal de gegevens van de klant opslaan in de database
function accountregistreren($emailadres, $voornaam, $achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode, $geboortedatum, $conn)
{
    //met een INSERT voegen we de nieuwe klantgegevens toe aan de database
    $sql = "INSERT INTO gebruiker (emailadres, voornaam, achternaam, geslacht, wachtwoord, adres, woonplaats, postcode, geboortedatum) 
            VALUES('$emailadres','$voornaam', '$achternaam', '$geslacht', '$wachtwoord','$adres','$woonplaats','$postcode','$geboortedatum')";

    $result = $conn->query($sql);

    return $result;
}

//variabelen definieren
$voornaam = "voornaam";
$achternaam = "achternaam";
$geslacht = "geslacht";
$wachtwoord = "wachtwoord";
$adres = "adres";
$woonplaats = "woonplaats";
$postcode = "postcode";
$geboortedatum = "geboortedatum";
$message = "melding";


// Als de knop "registreren" is geklikt, haal met $_POST de gegevens op.
if (isset($_POST['registreren'])) {
    if (strlen(($_POST[$wachtwoord])) < 6 || strlen(($_POST[$wachtwoord])) > 20 || !preg_match('@[A-Z]@', ($_POST[$wachtwoord])) || !preg_match('@[a-z]@', ($_POST[$wachtwoord]))
        || !preg_match('@[^\w]@', ($_POST[$wachtwoord]))) { //eisen stellen aan het ingevoerde wachtwoord
        echo "<blockquote class=\"blockquote text-center\">";
        echo "<p class=\"mb-0\"><strong>Het wachtwoord moet minimaal 6  en maximaal 20 tekens bevatten. Het wachtwoord moet bestaan uit een normale en hoofdletter. Het wachtwoord moet minstens 1 speciaal karakter bevatten.</strong></p>";
        echo "</blockquote>";
    } else {
        $emailadres = $_POST['emailadres'];
        $conn = databaseConnectie();
        $sql = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = '$emailadres';";  //Met deze sql query controleren we of het emailadres al in gebruik is.
        $result = $conn->query($sql);           //Wanneer de query word uitgevoerd, komt er 0 of 1 uit als resultaat.
        $row = $result->fetch_row();             // Het resultaat komt in de vorm van een array. Deze array slaan we op in $row

        if ($row[0] == 0) {                 //Op plek 0 van de array $row staat een 0 of 1. 0 betekend of het emailadres nog niet in gebruik is.
            //Als plek 0 van $row een 0 staat, mag het account gemaakt worden.

            $gegevens['emailadres'] = $_POST['emailadres'];
            $gegevens[$voornaam] = isset($_POST[$voornaam]) ? $_POST[$voornaam] : "";
            $gegevens[$achternaam] = isset($_POST[$achternaam]) ? $_POST[$achternaam] : "";
            $gegevens[$geslacht] = isset($_POST[$geslacht]) ? $_POST[$geslacht] : "";
            $gegevens[$wachtwoord] = isset($_POST[$wachtwoord]) ? md5("a@sdiu#(*$1_41" . $_POST[$wachtwoord]) : ""; //md5 encryptie om het wachtwoord versleutelt op te slaan.
            //               $gegevens[$wachtwoord] = isset($_POST[$wachtwoord]) ? hash('sha512',"a@sdiu#(*$1_41" . $_POST[$wachtwoord]) : ""; //sha512 encryptie om het wachtwoord versleutelt op te slaan.
            $gegevens[$adres] = isset($_POST[$adres]) ? $_POST[$adres] : "";
            $gegevens[$woonplaats] = isset($_POST[$woonplaats]) ? $_POST[$woonplaats] : "";
            $gegevens[$postcode] = isset($_POST[$postcode]) ? $_POST[$postcode] : "";
            $gegevens[$geboortedatum] = isset($_POST[$geboortedatum]) ? $_POST[$geboortedatum] : "";
            $gegevens = registreren($gegevens);

        } else {
            echo "<blockquote class=\"blockquote text-center\">";
            echo "<p class=\"mb-0\"><strong>Dit emailadres is al in gebruik</p></strong>";
            echo "</blockquote>";
        }

    }

}


?>

<div class="container">
    <h1>WWI</h1><br>
    <h2>Account registreren</h2><br>
    <p><small>Velden met een * zijn verplicht.</small></p>
    <form method="post" action="accountregistreren.php">

        <!-- Selfhandling formulier weergeven op het scherm, zodat de klant zijn of haar gegevens kan registreren. Alle velden zijn verplicht, op geslacht en geb. datum na. -->

        <input type="email" name="emailadres" class="form-control " value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['emailadres'];
        } ?>" placeholder="* E-mail adres" required/>
        <br>
        <input type="text" name="voornaam" class="form-control " value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['voornaam'];
        } ?>" placeholder="* Voornaam" required/>
        <br>
        <input type="text" name="achternaam" class="form-control " value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['achternaam'];
        } ?>" placeholder="* Achternaam" required/>
        <br>
        <input type="text" name="geslacht" class="form-control " value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['geslacht'];
        } ?>" placeholder="Geslacht (optioneel)"/>
        <br>
        <input type="password" name="wachtwoord" class="form-control" value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['wachtwoord'];
        } ?>" placeholder="* Wachtwoord" required>
        <br>
        <input type="text" name="adres" class="form-control" value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['adres'];
        } ?>" placeholder="* Adres" required/>
        <br>
        <input type="text" name="postcode" class="form-control" value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['postcode'];
        } ?>" placeholder="* Postcode" required/>
        <br>
        <input type="text" name="woonplaats" class="form-control" value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['woonplaats'];
        } ?>" placeholder="* Woonplaats" required/>
        <br>
        <input type="text" name="geboortedatum" class="form-control " value="<?php
        if (isset($_POST['registreren'])) {
            echo $_POST['geboortedatum'];
        } ?>" placeholder="Geboortedatum yyyy-mm-dd (optioneel)"/>
        <br>
        <input type="submit" class="btn btn-outline-success" name="registreren" value="registreren"/>
    </form>
</div>
<div class="container">
    <br>
    <a class="btn btn-outline-primary" href="inloggen.php" role="button">Terug naar de inlogpagina</a>
</div>

