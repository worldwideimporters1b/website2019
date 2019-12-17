<?php
// Door Lennard S1080997 WIP

include "head.php";
include "footer.php";
include "menu.php";


//met $conn roepen we de verbinding met de database aan.
$conn = new mysqli('localhost','root','','world_wide_importers');

//met functie  halen we de juiste gegevens aan de hand van gebruikersID naar boven.
function gegevensOphalen($gebruikersid, $conn){

    $sql = "SELECT * FROM `gebruiker` WHERE `gebruiker_id` = ".$gebruikersid.";";  //Met deze sql query geven we aan dat we alle gegevens van de tabel gebruiker willen hebben.

    $result = $conn->query($sql); // Hiermee voeren we de bovenstaande query uitvoeren

    foreach ($result as $gegevens) {
        print("<th>");
        print("<tr>" . $gegevens["emailadres"] . "</tr><br>");
        print("<tr>" . $gegevens["voornaam"] . "</tr><br>");
        print("<tr>" . $gegevens["achternaam"] . "</tr><br>");
        print("<tr>" . $gegevens["geslacht"] . "</tr><br>");
        print("<tr>" . $gegevens["adres"] . "</tr><br>");
        print("<tr>" . $gegevens["postcode"] . "</tr><br>");
        print("<tr>" . $gegevens["woonplaats"] . "</tr><br>");
        print("<tr>" . $gegevens["geboortedatum"] . "</tr><br>");
        print("</th>");

        return $gegevens;
    }

}


?>
<!-- Stukje HTML om de bovenstaande gegevens in een overzicht neer te zetten. -->
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<div class="container">
<h3>Uw gegevens</h3>
<br>
</div>
<div class="container">
<table class="table">
    <?php
    // Hier geven we aan dat we van gebruiker met ID 1 de gegevens willen weergeven. Later veranderen naar Sessie ID o.i.d.

    gegevensOphalen(1,$conn);



    ?>

</table>
</div>
<div class="container">
<a class="btn btn-outline-warning" href="accountwijzigen.php" role="button">Wijzig gegevens</a>
<a class="btn btn-outline-success" href="besteloverzicht.php" role="button">Plaats bestelling</a>
</div>
</html>
