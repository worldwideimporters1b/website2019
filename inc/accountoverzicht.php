<?php
// Door Lennard S1080997 WIP
include "head.php";
include "header.php";

//met $conn roepen we de verbinding met de database aan.
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

//met functie  halen we de juiste gegevens aan de hand van gebruikersID naar boven.
function gegevensOphalen($gebruikersid, $conn)
{

    $sql = "SELECT * FROM `gebruiker` WHERE `gebruiker_id` = " . $gebruikersid . ";";  //Met deze sql query geven we aan dat we alle gegevens van de tabel gebruiker willen hebben.

    $result = $conn->query($sql); // Hiermee voeren we de bovenstaande query uitvoeren

    foreach ($result as $gegevens) {
        echo "<th>";
        echo "<tr><strong>E-mail adres:</strong><br>" . $gegevens["emailadres"] . "</tr><br>";
        echo "<tr><strong>Voornaam:</strong><br>" . $gegevens["voornaam"] . "</tr><br>";
        echo "<tr><strong>Achternaam:</strong><br>" . $gegevens["achternaam"] . "</tr><br>";
        echo "<tr><strong>Geslacht:</strong><br>" . $gegevens["geslacht"] . "</tr><br>";
        echo "<tr><strong>Adres:</strong><br>" . $gegevens["adres"] . "</tr><br>";
        echo "<tr><strong>Postcode:</strong><br>" . $gegevens["postcode"] . "</tr><br>";
        echo "<tr><strong>Woonplaats:</strong><br>" . $gegevens["woonplaats"] . "</tr><br>";
        echo "<tr><strong>Geboorte datum:</strong><br>" . $gegevens["geboortedatum"] . "</tr><br>";
        echo "</th>";

        return $gegevens;
    }
}
if (!isset($_SESSION['ingelogd'])) {
    //wanneer de gebruiker niet is ingelogd, maar verder wil bestellen, sturen we de gebruiker naar de inlogpagina.
    header('Location: inloggen.php');
    die();
}
?>
<div class="container">
    <h3>Uw gegevens</h3>
    <br>
</div>
<div class="container">
    <table class="table">
        <?php
        if(isset($_SESSION['ingelogd'])){
            //anders is de gebruiker wel ingelogd, en halen we de gegevens op op basis van gebruiker_id
            $gebruikersid = $_SESSION["gebruiker_id"];
            gegevensOphalen($gebruikersid, $conn);
        }
        ?>
    </table>
</div>
<div class="container">
    <a class="btn btn-outline-warning" href="accountwijzigen.php" role="button">Wijzig gegevens</a>
    <a class="btn btn-outline-success" href="besteloverzicht.php" role="button">Plaats bestelling</a>
</div>