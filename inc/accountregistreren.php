<?php
include "head.php";
include "footer.php";

function registreren($gegevens) {
    if (accountregistreren($conn, $gegevens["emailadres"], $gegevens["voornaam"],$gegevens["achternaam"], $gegevens["geslacht"],
            $gegevens["wachtwoord"],$gegevens["adres"],$gegevens["woonplaats"], $gegevens["postcode"]) == 1)
        $gegevens["melding"] = "Uw account is geregistreerd. Klik op de onderstaande link in te loggen.";
    else $gegevens["melding"] = "Het registreren is mislukt. Probeer het nog eens.";
    return $gegevens;
}
function accountregistreren($conn, $emailadres, $voornaam, $achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode) {
    $sql = "INSERT INTO gebruiker (emailadres, voornaam, achternaam, geslacht, wachtwoord, adres, woonplaats, postcode) VALUES(?,?,?,?,?,?,?,?)";
    //mysqli_stmt_bind_param($statement, 'ss', $emailadres, $voornaam,$achternaam, $geslacht, $wachtwoord, $adres, $woonplaats, $postcode);
    $conn->query($sql);
    //return mysqli_stmt_affected_rows($statement) == 1;
    return $sql;
}


$emailadres = "emailadres";
$voornaam = "voornaam";
$achternaam = "achternaam";
$geslacht = "geslacht";
$geboortedatum = "geboortedatum";
$wachtwoord = "wachtwoord";
$wachtwoord2 = "wachtwoord2";
$adres = "adres";
$woonplaats = "woonplaats";
$postcode = "postcode";
$message = "melding";

if (isset($_GET["registreren"])){
    $gegevens[$emailadres] = isset($_GET[$emailadres]) ? $_GET[$emailadres] : "";
    $gegevens[$voornaam] = isset($_GET[$voornaam]) ? $_GET[$voornaam] : "";
    $gegevens[$achternaam] = isset($_GET[$achternaam]) ? $_GET[$achternaam] : "";
    $gegevens[$geslacht] = isset($_GET[$geslacht]) ? $_GET[$geslacht] : "";
    $gegevens[$geboortedatum] = isset($_GET[$geboortedatum]) ? $_GET[$geboortedatum] : "";
    $gegevens[$wachtwoord] = isset($_GET[$wachtwoord]) ? $_GET[$wachtwoord] : "";
    $gegevens[$wachtwoord2] = isset($_GET[$wachtwoord2]) ? $_GET[$wachtwoord2] : "";
    $gegevens[$adres] = isset($_GET[$adres]) ? $_GET[$adres] : "";
    $gegevens[$woonplaats] = isset($_GET[$woonplaats]) ? $_GET[$woonplaats] : "";
    $gegevens[$postcode] = isset($_GET[$postcode]) ? $_GET[$postcode] : "";
    $gegevens = registreren($gegevens);
}else{
    $gegevens[$emailadres] = "";
    $gegevens[$voornaam] = "";
    $gegevens[$achternaam] = "";
    $gegevens[$geslacht] = "";
    $gegevens[$geboortedatum] = "";
    $gegevens[$wachtwoord] = "";
    $gegevens[$wachtwoord2] = "";
    $gegevens[$adres] = "";
    $gegevens[$woonplaats] = "";
    $gegevens[$postcode] = "";
    $gegevens[$message] = "";
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<h1>WWI</h1><br>
<h2>Account registreren</h2><br>
<form method="get" action="accountregistreren.php">

    <input type="text" name="voornaam" class="form-control "value="<?php print($gegevens[$voornaam]); ?>" placeholder="Voornaam"/>
    <br>
    <input type="text" name="achternaam" class="form-control "value="<?php print($gegevens[$achternaam]); ?>" placeholder="Achternaam"/>
    <br>
    <input type="text" name="geslacht" class="form-control "value="<?php print($gegevens[$geslacht]); ?>" placeholder="Geslacht"/>
    <br>
    <input type="password" name="wachtwoord" class="form-control" value="<?php print($gegevens[$wachtwoord]); ?>" placeholder="Wachtwoord">
    <br>
    <input type="password" name="wachtwoord2" class="form-control" value="<?php print($gegevens[$wachtwoord2]); ?>" placeholder="Herhaal uw wachtwoord">
    <br>
    <input type="text" name="adres" class="form-control" value="<?php print($gegevens[$adres]); ?>" placeholder="Adres"/>
    <br>
    <input type="text" name="woonplaats" class="form-control" value="<?php print($gegevens[$woonplaats]); ?>" placeholder="Woonplaats"/>
    <br>
    <input type="text" name="postcode" class="form-control" value="<?php print($gegevens[$postcode]); ?>" placeholder="Postcode"/>
    <br>
    <input type="submit" class="btn btn-primary" name="registreren" value="registreren"/>
</form>
<br><?php print($gegevens[$message]); ?><br>
<a href="inloggen.php">Terug naar de inlogpagina</a>
</body>
</html>
