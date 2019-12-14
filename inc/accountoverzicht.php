<?php
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
        print("<th scope='col'>");
        print("<tr>" . $gegevens["emailadres"] . "</tr><br>");
        print("<tr>" . $gegevens["voornaam"] . "</tr><br>");
        print("<tr>" . $gegevens["achternaam"] . "</tr><br>");
        print("<tr>" . $gegevens["geslacht"] . "</tr><br>");
        print("<tr>" . $gegevens["adres"] . "</tr><br>");
        print("<tr>" . $gegevens["postcode"] . "</tr><br>");
        print("<tr>" . $gegevens["woonplaats"] . "</tr><br>");
        print("<tr>" . $gegevens["geboortedatum"] . "</tr><br>");
        print("</th>");
    }

}

/*
    foreach($result as $gegevens){ //hier zetten we de gegevens in een formulier

        print("<input type='tekst' value='.$gegevens["voornaam"].'>");
        print("<td>".$gegevens["tussenvoegsel"]."</td>");
        print("<td>".$gegevens["achternaam"]."</td>");
        print("<td>".$gegevens["adres"]."</td>");
        print("<td>".$gegevens["postcode"]."</td>");
        print("<td>".$gegevens["woonplaats"]."</td>");
        print("<td>".$gegevens["geboortedatum"]."</td>");
}
*/
?>
<!-- Stukje HTML om de bovenstaande gegevens in een overzicht neer te zetten. -->
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<h3>Uw gegevens</h3>
<br>
<table class="table">

    <?php
    gegevensOphalen(1,$conn);


    ?>

</table>

</html>
