<!doctype html>
<?php
include "head.php";
include "header.php";
include "footer.php";
include "Kortingscode.php";

//database verbinding
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

//variabelen aanmaken voor deze pagina
$kortingscode = ' ';
$winkelmandid = '1'; //tijdelijke id voor testen

if (isset($_GET["Kortingtoepassen"])) { //kortingscode ophalen uit formulier
    $kortingscode = $_GET["kortingscode"];
    $prijs = prijsVanBestelling($winkelmandid,$kortingscode,$conn);
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
    <p class="lead"> De verzendkosten bedragen: €<?php $kostenverzending = verzendkostenBerkenen($winkelmandid, $conn); //bij gratis verzendkosten wordt hier informatie over getoond
        if($kostenverzending == '0'){
            echo $kostenverzending ."<br><small id = 'verzendkostenbericht' class='font-weight-light'>" . "  Verzendkosten voor bestellingen boven de €30 zijn gratis" . "</small>";
        }
        else{ echo $kostenverzending;}
        ?></p>
    <p class="lead" > Het totaal bedrag van de bestelling is: €<?php echo prijsVanBestelling($winkelmandid,$kortingscode,$conn); //totaalprijsTonen($winkelmandid, $conn);
         ?></p>
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
           class="form-text text-muted"><?php if(isset($_GET["Kortingtoepassen"])){
            echo kortingsCodeFeedback($kortingscode, $winkelmandid, $conn); }
               else{ echo 'Voer eventueel een geldige kortingscode in';} ?></small>
    <br>
    <form method="get">
        <div class="form-group">
            <label for="kortingscodeinput">Wil je de bestelling plaatsen?</label><br>
            <a class="btn btn-outline-success" href="checkout.php" role="button">Plaats bestelling</a>
        </div>
    </form>
</div>
<br>

<div class="container">
    <button onclick="history.go(-1);" class="btn btn-primary">Terug</button>
</div>

</body>

</html>
