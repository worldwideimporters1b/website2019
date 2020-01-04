<!doctype html>
<?php
include "head.php";
include "header.php";

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

    <table width="100%" class="table">
        <tr>
            <th scope="row">Totaal artikelen:</th>
            <td>€<?php echo totaalprijsZonderVerzendkostenTonen($winkelmandid, $conn);?></td>
        </tr>
        <?php $kortingbedrag1 = kortingsBedragTonen($winkelmandid,$conn); if ($kortingbedrag1 > 0){
            echo "<th scope=\"row\">Korting:</th><td> € -$kortingbedrag1 </td>";} ?>
        <tr>
            <th scope="row">BTW (21%):</th>
            <td>€<?php echo BtwTonen($kortingscode,$winkelmandid, $conn);?></td>
        </tr>
        <tr>
            <th scope="row">Verzendkosten:</th>
            <td>€<?php $kostenverzending = verzendkostenBerkenen($winkelmandid, $conn); //bij gratis verzendkosten wordt hier informatie over getoond
                if($kostenverzending == '0'){
                    echo $kostenverzending ."<br><small id = 'verzendkostenbericht' class='font-weight-light'>" . "  Verzendkosten voor bestellingen boven de €30 zijn gratis" . "</small>";
                }
                else{ echo $kostenverzending;}
                ?></td>
        </tr>
        <tr>
            <th scope="row">Te betalen bedrag:</th>
            <td>€<?php echo prijsVanBestelling($winkelmandid,$kortingscode,$conn);?></td>
        </tr>
    </table>
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
    <?php echo "U bestelling wordt naar dit adres verstuurt: ". klantNAWgegevens($winkelmandid, $conn);?>
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
