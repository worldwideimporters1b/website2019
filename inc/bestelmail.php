<?php //Lennard S1080997
include 'head.php';
include 'header.php';
include 'Kortingscode.php';
$kortingscode = ' ';

?>
<div class="container">
    <br>
    <h3> Beste <?php echo $_SESSION['voornaam']; echo ' '. $_SESSION['achternaam']; ?>, Bedankt voor uw bestelling</h3>
    <br>
    <h5> Je besteling wordt momenteel gesorteerd en zo spoedig mogelijk naar jouw adres verstuurd. </h5>
    <br>
    <?php
    echo toonBestelOverzicht($winkelmandid, $conn);
    ?>

    <br>
    <br>
    <h6> Het totaalbedrag inclusief verzendkosten: €<?php echo prijsVanBestelling($winkelmandid, $kortingscode, $conn); ?></h6>
    <br>
    <table style="width:50%" class="table">
        <tr>
            <th>Ordernummer:</th>
            <th>Klantnummer:</th>
            <th>Besteldatum:</th>
            <th>Betaalwijze:</th>

        </tr>
        <tr>

            <td>
                <?php
                $sql = "SELECT order_id FROM orderregel WHERE winkelmand_id = ".$winkelmandid.";";  //order ID ophalen op basis van het winkelmand_id
                $result = $conn->query($sql);
                $row = $result->fetch_row();
                echo $row[0];  ?>
            </td>
            <td><?php echo $_SESSION['gebruiker_id']; ?></td>
            <td><?php echo date("j-m-Y") ; ?></td>
            <td>IDEAL</td>
        </tr>
    </table>
    <br>
    <h5>Afleveradres:</h5>
    <h6><?php echo $_SESSION['voornaam'] ." ". $_SESSION['achternaam']; ?> </h6>
    <h6><?php echo $_SESSION['adres']; ?></h6>
    <h6><?php echo $_SESSION['postcode']." ".$_SESSION['woonplaats']; ?></h6>
    <br>
    <h5>Factuuradres:</h5>
    <h6><?php echo $_SESSION['voornaam'] ." ". $_SESSION['achternaam']; ?> </h6>
    <h6><?php echo $_SESSION['adres']; ?></h6>
    <h6><?php echo $_SESSION['postcode']." ".$_SESSION['woonplaats']; ?></h6>
    <br>
    <h4> Veel plezier met je bestelling! </h4>
    <h4> Het WWI team!</h4>
</div>
