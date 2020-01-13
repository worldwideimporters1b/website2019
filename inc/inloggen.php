<?php

include_once "head.php";
include_once "header.php";


function databaseConnectie()
{
    $conn = new mysqli('localhost', 'root', '', 'world_wide_importers');
    return $conn;
}


//hier checken we of de database wel goed is, is het niet leeg en wat zijn gebruikersnaam en wachtwoord?
function inloggen($gebruikersnaam, $wachtwoord)
{
    if (!empty($gebruikersnaam) && !empty($wachtwoord)) {

        $conn = databaseConnectie();
        $sql = "SELECT `gebruiker_id` FROM `gebruiker` WHERE `emailadres` = '$gebruikersnaam' and `wachtwoord` = '$wachtwoord'";
        //hier binden we de query vast aan het woord result.
        $result = $conn->query($sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            #$actief = $row['actief'];
        }
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Het inloggen is mislukt. Probeer het opnieuw.</div>";
    }
    return $count = mysqli_num_rows($result);
}

//hier doen we een simpel ding, indien result een geldige waarde heeft, dan komt deze terug met minimaal 1 regel. waardoor count dus 1 is.

function inlogcheck($count)
{
    //hier gebruiken we het resultaat van de count, om te checken of deze 1 is.
    if ($count == 1) {
        $_SESSION["ingelogd"] = TRUE;
        $_SESSION["gebruikersnaam"] = $_POST["gebruikersnaam"];

        $gebruikersnaam = $_POST["gebruikersnaam"]; //gezien de gebruiker is ingelogd, halen we de overige gegevens uit de database op basis van emailadres.

        $conn = databaseConnectie();
        $sql = "SELECT * FROM `gebruiker` WHERE `emailadres` = '$gebruikersnaam'";
        $result = $conn->query($sql);
        $gegevens = $result->fetch_assoc();                     //de gegevens uit de database slaan we op in de sessie, zodat we deze kunnen hergebruiken.

        $_SESSION["gebruiker_id"] = $gegevens['gebruiker_id'];
        $_SESSION["voornaam"] = $gegevens['voornaam'];
        $_SESSION["achternaam"] = $gegevens['achternaam'];
        $_SESSION["geslacht"] = $gegevens['geslacht'];
        $_SESSION["adres"] = $gegevens['adres'];
        $_SESSION["postcode"] = $gegevens['postcode'];
        $_SESSION["woonplaats"] = $gegevens['woonplaats'];
        $_SESSION["geboortedatum"] = $gegevens['geboortedatum'];

        header("refresh:0;url=home.php");                   // Nadat alle gegevens van de ingelogde gebruiker in de sessie zijn opgeslagen, sturen we de gebruiker naar de homepage.
    } else {
        echo "<blockquote class=\"blockquote text-center\">";
        echo "<div class=\"alert alert-danger\" role=\"alert\">Uw gebruikersnaam of wachtwoord is onjuist.</div>";
        echo "</blockquote>";
        //$inlogpoging;
    }
}

//start van de functies; hier word gecontroleerd of er op inloggen word geklikt. Dan begint de functie
if (isset($_POST["inloggen"])) {

    if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = md5("a@sdiu#(*$1_41" . $_POST["wachtwoord"]);
        //   $wachtwoord = hash('sha512',"a@sdiu#(*$1_41" . $_POST["wachtwoord"]);

        inlogcheck(inloggen($gebruikersnaam, $wachtwoord));

    }
}
?>

<html>
<div class="container">
    <h1>WWI</h1><br>
    <h2>Mijn account</h2><br>
    <form method="post" action="inloggen.php">
        <input type="email" name="gebruikersnaam" class="form-control " value="" placeholder="E-mailadres" required/>
        <br>
        <input type="password" name="wachtwoord" class="form-control" value="" placeholder="Wachtwoord" required>
        <br>
        <input type="submit" class="btn btn-primary" name="inloggen" value="inloggen"/>
        <br><br><br>
        <h2> Ik ben nieuw hier</h2>
        <br>
        <a class="btn btn-primary" href="accountregistreren.php" role="button">Account registreren</a>

</html>