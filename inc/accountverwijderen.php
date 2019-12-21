<?php
// Door Lennard S1080997 WIP

@include "head.php";
@include "header.php";

// require_once "accountwijzigen.php";

$conn = new mysqli('localhost','root','','world_wide_importers');

function controle($emailadres, $wachtwoord, $conn){

    $query = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = '$emailadres' AND `wachtwoord` = '$wachtwoord';"; //controleren of er een emailadres is met het ingevoerde wachtwoord

    $result = $conn->query($query);     //Wanneer de query word uitgevoerd, komt er 0 of 1 uit als resultaat.

    if ($result !== 0) { //als het niet gelijk is aan 0, voeren we de verwijdering van het account uit.
        accountVerwijderen($emailadres, $conn);
    }
    return $result;
}

function accountVerwijderen($emailadres, $conn){
    // $sql = "DELETE FROM gebruiker WHERE `gebruiker_id` = ".$gebruikersid.";";
    $sql = "DELETE FROM gebruiker WHERE `emailadres` = '$emailadres';"; //account verwijderen op basis van het ingevoerde emailadres.

    $resultaat = $conn->query($sql);

    if($resultaat == TRUE) { //feedback geven
        echo "Uw account is verwijderd.";
    }
    return $resultaat;

}

if(isset($_POST["verwijderen"])){ //wanneer de knop "verwijderen" is geklikt;
    if(isset($_POST['emailadres'])  && isset($_POST['wachtwoord'])){ //controleer of het email adres en wachtwoord is ingevoerd.

        $emailadres = $_POST['emailadres'];
        $wachtwoord = md5("a@sdiu#(*$1_41" . $_POST['wachtwoord']);

        controle($emailadres, $wachtwoord, $conn);

    }
    else{
        echo "Voer uw e-mail adres en uw wachtwoord in.";
    }

}

?>


<div class="container">
    <form method="post" action="accountverwijderen.php">
    <label>Bevestig uw e-mail adres en wachtwoord.</label>
    <input type="email" name="emailadres" class="form-control" placeholder="e-mail adres" required>
    <input type="password" name="wachtwoord" class="form-control" placeholder="Wachtwoord" required><br>
    <input type="submit" class="btn btn-outline-danger" name="verwijderen" value="verwijderen"/>
    <a class="btn btn-secondary" href="accountoverzicht.php" role="button">Terug naar accountoverzicht</a>
    </form>
</div>



