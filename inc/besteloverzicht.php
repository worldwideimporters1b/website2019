<?php
include "head.php";
include "footer.php";
include "menu.php";
include "Kortingscode.php";

//database verbinding
$conn = new mysqli('localhost','root','','world_wide_importers');

//variabelen aanmaken voor deze pagina
$kortingscode = 'placeholder';

if (isset($_GET["Toepassen"])){ //kortingscode ophalen uit formulier
    $kortingscode = isset($_GET["kortingscode"]);
    $prijs = kortingsCodeToepassen($kortingscode,'1',$conn); //$winkelmandid is hier nog ff 1
}

if (isset($_GET["Verwijder+code"])){ //kortingscode verwijderen
    $kortingscode = isset($_GET["kortingscode"]);
    kortingsCodeVerwijderen('1', $conn); //$winkelmandid is hier nog ff 1
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Besteloverzicht</title>
</head>
<body>
<div class="container">
    <h1>Besteloverzicht</h1><br>
</div>

<div class="container">
    <h3>hier komt het overzicht van de artikelen</h3><br>
</div>

<div class="container">
    <h3>hier komt de totaalprijs van de winkelwagen</h3><br>
    <?php
    if(isset($prijs)){echo $prijs;} //als een prijs is dan deze tonen
    ?>
</div>

<div class="container">
    <label for="kortingscodeinput">Een kortingscode toepassen?</label>
    <form action ="besteloverzicht.php" method="get" class="form-inline">
        <div class="form-group">
        <input type="text" name="kortingscode" class="form-control" placeholder="typ hier de kortingscode">&nbsp
        <input type="submit" name="Kortingtoepassen" value="Toepassen" class="btn btn-primary">&nbsp
            <input type="submit" name="Kortingverwijderen" value="Verwijder code" class="btn btn-primary">
        </div>
    </form>
    <small id="kortingantwoord" class="form-text text-muted">Hier komt feedback over de kortingscode</small>
    <br>
    <?php

    ?>
    <form method="get">
        <div class="form-group">
            <label for="kortingscodeinput">Wil je de bestelling plaatsen?</label><br>
            <input type="submit" name="bestellen" value="Plaats bestelling" class="btn btn-primary"><br>
        </div>
    </form>
</div>
<br>

<div class="container">
    <button onclick="history.go(-1);" class="btn btn-primary">Terug </button>
</div>

</body>

</html>
