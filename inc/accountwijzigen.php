<?php
// Door Lennard S1080997 WIP

include "head.php";
include "header.php";


function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}

$conn = databaseConnectie();
$gebruikersid = $_SESSION["gebruiker_id"];
gegevensOphalen($gebruikersid,$conn); //gegevens van in dit geval gebruiker met ID 1 ophalen

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

        $accountgegevens["melding"] = "<blockquote class='blockquote text-center'><p><strong>Uw accountgegevens zijn bijgewerkt.</strong></p></blockquote>";
    else $accountgegevens["melding"] = "<blockquote class='blockquote text-center'><p><strong>Het bijwerken is mislukt. Probeer het nog eens.</strong></p></blockquote>";

    return $accountgegevens;
}

//De SQL query die word aangeroepen door de functie accountWijzigen.
function updateAccount($emailadres, $voornaam, $achternaam, $geslacht, $adres, $woonplaats, $postcode, $geboortedatum, $conn){
    $gebruikersid = $_SESSION["gebruiker_id"];
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

    $_SESSION["gebruikersnaam"] = $_POST[$emailadres];  // Gezien met $_POST de nieuwe gegevens in het formulier zijn ingevult,
    $_SESSION["voornaam"] = $_POST[$voornaam];          // voeren we de gegevens opnieuw in de sessie, zodat de gebruiker de wijzigingen direct ziet.
    $_SESSION["achternaam"] = $_POST[$achternaam];
    $_SESSION["geslacht"] = $_POST[$geslacht];
    $_SESSION["adres"] = $_POST[$adres];
    $_SESSION["woonplaats"] = $_POST[$woonplaats];
    $_SESSION["postcode"] = $_POST[$postcode];
    $_SESSION["geboortedatum"] = $_POST[$geboortedatum];
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
    <?php
    print("$accountgegevens[$message]");
    ?>
<form method="post" action="accountwijzigen.php">

        <div class="col-sm-10">
    <label for="emailadres">E-mail adres</label>
    <input type="email" class="form-control" name="emailadres" value="<?php echo $_SESSION['gebruikersnaam'];?>"/>
    <br>
        </div>

        <div class="col-sm-10">
    <label for="voornaam">Voornaam</label>
    <input type="text" class="form-control" name="voornaam" value="<?php echo $_SESSION['voornaam'];?>"/>
    <br>
        </div>

        <div class="col-sm-10">
    <label for="achternaam">Achternaam</label>
    <input type="text" class="form-control" name="achternaam" value="<?php echo $_SESSION['achternaam'];?>"/>
    <br>
        </div>

            <div class="col-sm-10">
    <label for="geslacht">Geslacht</label>
    <input type="text" class="form-control" name="geslacht" value="<?php echo $_SESSION['geslacht'];?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="adres">Adres</label>
    <input type="text" class="form-control" name="adres" value="<?php echo $_SESSION['adres'];?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="postcode">Postcode</label>
    <input type="text" class="form-control" name="postcode" value="<?php echo $_SESSION['postcode'];?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="woonplaats">Woonplaats</label>
    <input type="text" class="form-control" name="woonplaats" value="<?php echo $_SESSION['woonplaats'];?>"/>
    <br>
            </div>

            <div class="col-sm-10">
    <label for="geboortedatum">Geboortedatum</label>
    <input type="text" class="form-control" name="geboortedatum" value="<?php echo $_SESSION['geboortedatum'];?>"/>
    <br>
            </div>

    <input type="submit" class="btn btn-outline-primary" name="bijwerken" value="Bijwerken"/>
    <a class="btn btn-outline-danger" href="accountverwijderen.php" role="button">Account verwijderen</a><br><br>
    <a class="btn btn-outline-success" href="accountoverzicht.php" role="button">Terug naar accountoverzicht</a>

</form>
</div>
<div class="container">
<br>



</div>

