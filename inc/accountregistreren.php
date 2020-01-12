<?php
// Door Lennard S1080997

include "head.php";
include "header.php";

echo "<div class='container'>";

//deze functie zal de de registratie functie aanroepen, en controleren of het account is geregistreerd in de database.
function registreren($gegevens,$conn)
{


    if (accountregistreren($gegevens['emailadres'], $gegevens["voornaam"], $gegevens["achternaam"], $gegevens["geslacht"], $gegevens["wachtwoord"],
            $gegevens["adres"], $gegevens["woonplaats"], $gegevens["postcode"], $gegevens["geboortedatum"], $conn) == 1) {

        /*controle of het account succesvol is geregistreerd. Wanneer de webshop 1 terug geeft, is het gelukt.
           $result geeft een 1 terug in de functie accountRegistreren, als de database succesvol een insert heeft uitgevoerd.*/

        echo "<div class=\"alert alert-success\" role=\"alert\">Uw account is succesvol geregistreerd</div>";
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Het registreren van uw account is mislukt, controleer de ingevulde gegevens en probeer het nogmaals.</div>";
    }

    return $gegevens;
}

//de functie accountregistreren zal de gegevens van de klant opslaan in de database
function accountregistreren($emailadres, $voornaam, $achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode, $geboortedatum, $conn)
{
    //met een INSERT voegen we de nieuwe klantgegevens toe aan de database
    $sql = "INSERT INTO gebruiker (emailadres, voornaam, achternaam, geslacht, wachtwoord, adres, woonplaats, postcode, geboortedatum)VALUES('$emailadres','$voornaam', '$achternaam', '$geslacht', '$wachtwoord','$adres','$woonplaats','$postcode','$geboortedatum')";
    $result = $conn->query($sql);
    $usersql = "SELECT LAST_INSERT_ID(gebruiker_id) AS `gebruiker_id` FROM `gebruiker` ORDER BY `gebruiker_id` DESC LIMIT 1";
    $userid = $conn->query($usersql);
    foreach($userid as $uid){
        $uid = $uid['gebruiker_id'];
        $paysql = "INSERT INTO `betaling` (`betaling_id`, `betaalmethode`, `afrekenlink`, `betaalstatus`) VALUES (NULL, 'ideal', 'http://ideal.nl/user/".$uid."', '0');";
        $conn->query($paysql);
        $paysql = "SELECT LAST_INSERT_ID(betaling_id) AS `betaling_id` FROM `betaling` ORDER BY `betaling_id` DESC LIMIT 1 ";
        $payid = $conn->query($paysql);
        foreach($payid as $payment){
            $payid = $payment['betaling_id'];
        }
        $basketsql = "INSERT INTO `winkelmand` (`winkelmand_id`, `betaling_id`, `order_id`, `totaalprijs`, `kortingscode`, `waardebon`, `verwachte_leverdatum`, `gebruiker_id`) VALUES (NULL, '".$payid."', '', '', NULL, NULL, NULL, '".$uid."');";
        $conn->query($basketsql);
    }

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
    if (!preg_match('/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/', ($_POST[$postcode]))) { //controle op een geldig postcode
        echo "<blockquote class=\"blockquote text-center\">";
        echo "<div class=\"alert alert-danger\" role=\"alert\">De ingevulde postcode is ongeldig, vul uw postcode als volgt in: \"1111AA\"</div>";
        echo "</blockquote>";
    } else {
        if (strlen(($_POST[$wachtwoord])) < 6 || strlen(($_POST[$wachtwoord])) > 20 || !preg_match('@[A-Z]@', ($_POST[$wachtwoord])) || !preg_match('@[a-z]@', ($_POST[$wachtwoord]))
            || !preg_match('@[^\w]@', ($_POST[$wachtwoord]))) { //eisen stellen aan het ingevoerde wachtwoord
            echo "<blockquote class=\"blockquote text-center\">";
            echo "<div class=\"alert alert-danger\" role=\"alert\">Het wachtwoord moet minimaal 6  en maximaal 20 tekens bevatten. Het wachtwoord moet bestaan uit een normale en hoofdletter.<br> Het wachtwoord moet minstens 1 speciaal karakter bevatten.</div>";
            echo "</blockquote>";
        } else {
            $emailadres = $_POST['emailadres'];

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
                $gegevens = registreren($gegevens,$conn);

            } else {

                echo "<div class=\"alert alert-danger\" role=\"alert\">Dit emailadres is al in gebruik.</div>";

            }

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
</div>
