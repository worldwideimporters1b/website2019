<?php
include "header.php";
include "head.php";

session_start();

function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}
//function inlogpoging(){
  //  $inlogpoging = "Update gebruikers set foutieve_aanmeldpogingen = foutieve_aanmeldpogingen +1 where '"$session"'");
    //return $inlogpoging;
//}



//hier checken we of de database wel goed is, is het niet leeg en wat zijn gebruikersnaam en wachtwoord?
function inloggen(){
if(!empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = md5("a@sdiu#(*$1_41" . $_POST["wachtwoord"]);

    $conn = databaseConnectie();
    $sql = "SELECT `gebruiker_id` FROM `gebruiker` WHERE `emailadres` = '$gebruikersnaam' and `wachtwoord` = '$wachtwoord'";
    //hier binden we de query vast aan het woord result.
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $actief = $row['actief'];
    }
}
    else {
            echo "Helaas, het inloggen is mislukt";
    }
    return $count = mysqli_num_rows($result);
}
    //hier doen we een simpel ding, indien result een geldige waarde heeft, dan komt deze terug met minimaal 1 regel. waardoor count dus 1 is.

function inlogcheck(){
    //hier gebruiken we het resultaat van de count, om te checken of deze 1 is.
    if($count == 1) {
        $_SESSION["ingelogd"] = TRUE;
        $_SESSION["gebruikersnaam"] = $_POST["gebruikersnaam"];
//Nadat iemand is ingelogd, wil ik natuurlijk dat deze op de vorige pagina uit komt. Hoe kan ik dit realiseren? Uitzoeken
    //header("location: search_display.php");
    }
    else {
        echo "Helaas gebruikersnaam is niet goed.";
        //$inlogpoging;
    }
}
//start van de functies; hier word gecontroleerd of er op inloggen word geklikt. Dan begint de functie
if (isset($_POST["inloggen"])){
    inloggen();
}
?>

<html>
<div class="container">
    <h1>WWI</h1><br>
    <h2>Mijn account</h2><br>
    <form method="post" action="inloggen.php">
        <input type="email" name="gebruikersnaam" class="form-control "value="" placeholder="E-mailadres" required/>
        <br>
        <input type="password" name="wachtwoord" class="form-control" value="" placeholder="Wachtwoord" required>
        <br>
        <input type="submit" class="btn btn-primary" name="inloggen" value="inloggen"/>
        <br><br><br>
        <h2> Ik ben nieuw hier</h2>
        <br>
        <a class="btn btn-primary" href="accountregistreren.php" role="button">Account registreren</a>

</html>