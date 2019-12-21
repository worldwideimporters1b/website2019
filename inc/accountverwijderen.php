<?php
// Door Lennard S1080997 WIP

@include "head.php";
@include "header.php";

//verbinding met de database maken
$conn = new mysqli('localhost','root','','world_wide_importers');

function controle($emailadres, $wachtwoord, $conn){

    $query = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = '$emailadres' AND `wachtwoord` = '$wachtwoord';"; //controleren of er een emailadres is met het ingevoerde wachtwoord

    $result = $conn->query($query);     //Wanneer de query word uitgevoerd, komt er 0 of 1 uit als resultaat.
    $row = $result->fetch_row();        // Het resultaat komt in de vorm van een array. Deze array slaan we op in $row

    if ($row[0] == 1) {                 //Op plek 0 van de array $row staat een 0 of 1. 0 betekend dat het emailadres of wachtwoord onjuist is.
                                        //Als plek 0 van $row een 1 heeft als waarde, is het emailadres en wachtwoord een match. Het account mag verwijderd worden.
        accountVerwijderen($emailadres, $conn);

    }else{
       echo "E-mailadres of wachtwoord is onjuist."; //feedback geven dat $row[0] == 0, oftewel emailadres en wachtwoord matchen niet.

    }

    return $result;
}

function accountVerwijderen($emailadres, $conn){
    // $sql = "DELETE FROM gebruiker WHERE `gebruiker_id` = ".$gebruikersid.";";
    $sql = "DELETE FROM gebruiker WHERE `emailadres` = '$emailadres';"; //account verwijderen op basis van het ingevoerde emailadres.

    $result = $conn->query($sql);

    if($result === TRUE) { //feedback geven
        echo "Uw account is verwijderd.";
    }
    return $result;
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



