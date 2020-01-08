<?php
// Door Lennard S1080997 WIP

@include "head.php";
@include "header.php";

//verbinding met de database maken
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

function controle($emailadres, $wachtwoord, $conn)
{

    $query = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = '$emailadres' AND `wachtwoord` = '$wachtwoord';"; //controleren of er een emailadres is met het ingevoerde wachtwoord

    $result = $conn->query($query);     //Wanneer de query word uitgevoerd, komt er 0 of 1 uit als resultaat.
    $row = $result->fetch_row();        // Het resultaat komt in de vorm van een array. Deze array slaan we op in $row

    if ($row[0] == 1) {                 //Op plek 0 van de array $row staat een 0 of 1. 0 betekend dat het emailadres of wachtwoord onjuist is.
        //Als plek 0 van $row een 1 heeft als waarde, is het emailadres en wachtwoord een match. Het account mag verwijderd worden.
        accountVerwijderen($emailadres, $conn);

    } else {
        echo "<blockquote class=\"blockquote text-center\">";
        echo "<p class=\"mb-0\"><strong>E-mailadres of wachtwoord is onjuist.</strong></p>"; //feedback geven dat $row[0] == 0 is, oftewel emailadres en wachtwoord matchen niet.
        echo "</blockquote>";
    }

    return $result;
}

function accountVerwijderen($emailadres, $conn)
{
    //Deze functie word alleen aangeroepen nadat de controle is uitgevoerd.
    $sql = "DELETE FROM gebruiker WHERE `emailadres` = '$emailadres';"; //Account verwijderen op basis van het ingevoerde emailadres. Hiervan is altijd maar 1 record.

    $result = $conn->query($sql); //query uitvoeren

    if ($result === TRUE) {
        echo "<blockquote class=\"blockquote text-center\">";           //feedback geven aan de gebruiker.
        echo "<p class=\"mb-0\"><strong>Uw account is verwijderd.</strong></p>";
        echo "</blockquote>";
        session_destroy();                                              // sessie afsluiten en de gebruiker terug naar de homepage sturen als het account is verwijderd.
    }
    header("refresh:1;url=home.php");
    return $result;
}

if (isset($_POST["verwijderen"])) { //wanneer de knop "verwijderen" is geklikt;
    if (isset($_POST['emailadres']) && isset($_POST['wachtwoord'])) {        //controleer of het email adres en wachtwoord is ingevoerd.

        $emailadres = $_POST['emailadres'];                                 //het ingevoerde emailadres opslaan in $emailadres
        $wachtwoord = md5("a@sdiu#(*$1_41" . $_POST['wachtwoord']);     //het ingevoerde wachtwoord vergelijken met de md5 hash. Vervolgens opslaan in $wachtwoord.
//        $wachtwoord = hash('sha512',"a@sdiu#(*$1_41" . $_POST['wachtwoord']);     //het ingevoerde wachtwoord vergelijken met de sha512 hash. Vervolgens opslaan in $wachtwoord.

        controle($emailadres, $wachtwoord, $conn);                          //de controle uitvoeren of het gegeven mailadres bij het wachtwoord hoort.

    } else {
        echo "Voer uw e-mail adres en uw wachtwoord in.";
    }

}

?>

<html> <!-- stukje HTML voor het formulier -->
<div class="container">
    <form method="post" action="accountverwijderen.php">
        <label>Bevestig uw e-mail adres en wachtwoord.</label>
        <input type="email" name="emailadres" class="form-control" placeholder="e-mail adres" required>
        <input type="password" name="wachtwoord" class="form-control" placeholder="Wachtwoord" required><br>
        <input type="submit" class="btn btn-outline-danger" name="verwijderen" value="verwijderen"/>
        <a class="btn btn-secondary" href="accountoverzicht.php" role="button">Terug naar accountoverzicht</a>
    </form>
</div>
</html>


