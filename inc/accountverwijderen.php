<?php
// Door Lennard S1080997 WIP

include "head.php";
include "footer.php";
include "menu.php";
require_once "accountwijzigen.php";

function controle(){

}

function accountVerwijderen($gebruikersid, $conn){
    $sql = "DELETE FROM gebruiker WHERE `gebruiker_id` = ".$gebruikersid.";";

    $resultaat = $conn->query($sql);

    print("Uw account is verwijderd.");

    return $resultaat;

}

if(isset($_GET["verwijderen"])){
    if(isset($_GET['emailadres'])  && isset($_GET['wachtwoord'])){
        $emailadres = $_GET['emailadres'];
        $wachtwoord = md5("a@sdiu#(*$1_41" . $_GET["wachtwoord"]);

        $conn = new mysqli('localhost','root','','world_wide_importers');

        $query = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = ".$emailadres."; AND `wachtwoord` = ".$wachtwoord.";"; //controleren of er een gebruiker is met hetzelfde wachtwoord

        $check = $conn->query($query); //SQL QUERY verplaatsen in een functie?...

        if($check == 1) {
            //Wanneer het resultaat 1 is, heeft de gebruiker een correct email adres en bijbehorend wachtwoord ingevoert.
            accountVerwijderen(63, $conn);
        }
    }
    else{
        print("Uw wachtwoord is onjuist.");
    }

}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<div class="container">
    <label>Bevestig uw e-mail adres en wachtwoord.</label>
    <input type="email" name="emailadres" class="form-control" placeholder="e-mail adres" required>
    <input type="password" name="wachtwoord" class="form-control" placeholder="Wachtwoord" required><br>
    <input type="submit" class="btn btn-outline-danger" name="verwijderen" value="account verwijderen"/>
</div>


</html>
