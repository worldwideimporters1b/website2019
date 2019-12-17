<?php
include "head.php";
include "header.php";
include "footer.php";
include "menu.php";
include "Kortingscode.php";

//database verbinding
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

//variabelen aanmaken voor deze pagina
$kortingscode = ' ';
$winkelmandid = '1';

if (isset($_GET["Kortingtoepassen"])) { //kortingscode ophalen uit formulier
    $kortingscode = $_GET["kortingscode"];
    $prijs = kortingsCodeToepassen($kortingscode, $winkelmandid, $conn);
    //$kortingnaam = kortingsNaamTonen($kortingscode, $conn); //naam van de korting ophalen
}

if (isset($_GET["Kortingverwijderen"])) { //kortingscode verwijderen
    kortingsCodeVerwijderen($winkelmandid, $conn);
}
?>

<body>
<br>
<div class="container">
    <h3>Besteloverzicht</h3><br>

    <p><?php echo toonBestelOverzicht($winkelmandid, $conn); ?></p>

    <p class="lead"> Het totaal bedrag van de bestelling is: €<?php if (isset($prijs)) {
            echo $prijs;
        } //de getoonde totaalprijs bepalen
        else {
            echo totaalprijsTonen($winkelmandid, $conn);
        } ?></p>
</div>
<br>

<div class="container">
    <label for="kortingscodeinput">Een kortingscode toepassen?</label>
    <form action="besteloverzicht.php" method="get" class="form-inline">
        <div class="form-group">
            <input type="text" name="kortingscode" class="form-control" placeholder="typ hier de kortingscode">&nbsp
            <input type="submit" name="Kortingtoepassen" value="Toepassen" class="btn btn-primary">&nbsp
            <input type="submit" name="Kortingverwijderen" value="Verwijder code" class="btn btn-primary">
        </div>
    </form>
    <small id="kortingantwoord"
           class="form-text text-muted"><?php echo kortingsCodeFeedback($kortingscode, $winkelmandid, $conn); ?></small>
    <br>
    <form method="get">
        <div class="form-group">
            <label for="kortingscodeinput">Wil je de bestelling plaatsen?</label><br>
            <input type="submit" name="bestellen" value="Plaats bestelling" class="btn btn-primary"><br>
        </div>
    </form>
</div>
<br>

<div class="container">
    <button onclick="history.go(-1);" class="btn btn-primary">Terug</button>
</div>

</body>

</html>
