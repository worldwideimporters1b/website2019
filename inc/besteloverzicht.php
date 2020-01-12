<?php
include "head.phpS";
include "header.php";
error_reporting(E_ALL);
include "Kortingscode.php";

//variabelen aanmaken voor deze pagina
$kortingscode = ' ';
#$winkelmandid = '1'; //tijdelijke id voor testen

if (isset($_GET["Kortingtoepassen"])) { //kortingscode ophalen uit formulier
    $kortingscode = $_GET["kortingscode"];
    $prijs = prijsVanBestelling($winkelmandid, $kortingscode, $conn);
    //$kortingnaam = kortingsNaamTonen($kortingscode, $conn); //naam van de korting ophalen
}

if (isset($_GET["Kortingverwijderen"])) { //kortingscode verwijderen
    kortingsCodeVerwijderen($winkelmandid, $conn);
}
?>

<div class="container">
    <h3>Besteloverzicht</h3>

    <p><?php echo toonBestelOverzicht($winkelmandid, $conn); ?></p>

        <h6>Overzicht prijsinhoud:</h6>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td><b>Totaalprijs artikelen:</b></td>
            <td><b>
                <?php echo formatprijs(totaalprijsZonderVerzendkostenTonen($winkelmandid, $conn)); ?></td>
        </b></tr>
        <?php $kortingbedrag1 = kortingsBedragTonen($winkelmandid, $conn);
        if ($kortingbedrag1 < 0) {
            echo "<th scope=\"row\">Korting:</th><td></td><td></td><td></td><td> " . formatprijs($kortingbedrag1) ." </td>";
        } ?>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td>BTW</td>
            <td>

                <?php echo formatprijs(BtwTonen($kortingscode, $winkelmandid, $conn)); ?>
            </td>
            <!--            <td>€--><?php //echo BtwTonen($kortingscode, $winkelmandid, $conn); ?><!--</td>-->
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td>Verzendkosten:</td>
            <td>

                <?php $kostenverzending = verzendkostenBerkenen($winkelmandid, $conn); //bij gratis verzendkosten wordt hier informatie over getoond
                if ($kostenverzending == '0') {
                    echo formatprijs($kostenverzending);
                } else {
                    echo formatprijs($kostenverzending);
                }
                ?></td>
        </tr>
        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td><b>Totaal te betalen bedrag:</b></td>
            <td><b>
                    <?php echo formatprijs(prijsVanBestelling($winkelmandid, $kortingscode, $conn)); ?></b></td>
        </tr>
    </table>
    <br><small id='verzendkostenbericht' class='font-weight-light'>Verzendkosten voor bestellingen boven de €30,- zijn
        gratis</small>

<br>


    <label for="kortingscodeinput">Een kortingscode toepassen?</label>
    <form action="besteloverzicht.php" method="get" class="form-inline">
        <div class="form-group">
            <input type="text" name="kortingscode" class="form-control" placeholder="typ hier de kortingscode">&nbsp
            <input type="submit" name="Kortingtoepassen" value="Toepassen" class="btn btn-primary">&nbsp
            <input type="submit" name="Kortingverwijderen" value="Verwijder code" class="btn btn-primary">
        </div>
    </form>
    <small id="kortingantwoord"
           class="form-text text-muted"><?php if (isset($_GET["Kortingtoepassen"])) {
            echo kortingsCodeFeedback($kortingscode, $winkelmandid, $conn);
        } else {
            echo 'Voer eventueel een geldige kortingscode in';
        } ?></small>
    <br>
    <?php echo "Uw bestelling wordt naar dit adres verstuurd: " . klantNAWgegevens($winkelmandid, $conn); ?>
    <br>
    <form method="get">
        <div class="form-group">
            <label for="kortingscodeinput">Wil je de bestelling plaatsen?</label><br>
            <a class="btn btn-outline-success" href="checkout.php" role="button">Plaats bestelling</a>
        </div>
    </form>


    <button onclick="history.go(-1);" class="btn btn-primary">Terug</button>
</div>
