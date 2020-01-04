<?php
// Door Lennard S1080997 WIP

include "header.php";
include "head.php";


//met $conn roepen we de verbinding met de database aan.
$conn = new mysqli('localhost','root','','world_wide_importers');

//met functie  halen we de juiste gegevens aan de hand van gebruikersID naar boven.
function gegevensOphalen($gebruikersid, $conn){

    $sql = "SELECT * FROM `gebruiker` WHERE `gebruiker_id` = ".$gebruikersid.";";  //Met deze sql query geven we aan dat we alle gegevens van de tabel gebruiker willen hebben.

    $result = $conn->query($sql); // Hiermee voeren we de bovenstaande query uitvoeren

    foreach ($result as $gegevens) {
        print("<th>");
        print("<tr><strong>E-mail adres:</strong><br>" . $gegevens["emailadres"] . "</tr><br>");
        print("<tr><strong>Voornaam:</strong><br>" . $gegevens["voornaam"] . "</tr><br>");
        print("<tr><strong>Achternaam:</strong><br>" . $gegevens["achternaam"] . "</tr><br>");
        print("<tr><strong>Geslacht:</strong><br>" . $gegevens["geslacht"] . "</tr><br>");
        print("<tr><strong>Adres:</strong><br>" . $gegevens["adres"] . "</tr><br>");
        print("<tr><strong>Postcode:</strong><br>" . $gegevens["postcode"] . "</tr><br>");
        print("<tr><strong>Woonplaats:</strong><br>" . $gegevens["woonplaats"] . "</tr><br>");
        print("<tr><strong>Geboorte datum:</strong><br>" . $gegevens["geboortedatum"] . "</tr><br>");
        print("</th>");

        return $gegevens;
    }

}


?>
<!-- Stukje HTML om de bovenstaande gegevens in een overzicht neer te zetten. -->

<div class="container">
    <h3>Uw gegevens</h3>
    <br>
</div>
<div class="container">
    <table class="table">
        <?php
        // Hier geven we aan dat we van gebruiker met ID 1 de gegevens willen weergeven. Later veranderen naar Sessie ID o.i.d.
        //print_r($_SESSION);

        $gebruikersid = $_SESSION["gebruiker_id"];
        gegevensOphalen($gebruikersid,$conn);



        ?>

    </table>
</div>
<div class="container">
    <a class="btn btn-outline-warning" href="accountwijzigen.php" role="button">Wijzig gegevens</a><br>
    <a class="btn btn-outline-warning" href="wachtwoordwijzigen.php" role="button">Wachtwoord wijzigen</a><br>
    <a class="btn btn-outline-danger" href="logout.php" role="button">Uitloggen</a>

</div>
