<?php
error_reporting(E_ALL);

include('head.php');
include('header.php');

echo "<div class='container'>";
echo toonWinkelmand(basketinfo($conn), $conn);

echo '
<form method="get" target="accountoverzicht.php">
        <div class="form-group">
            <label for="kortingscodeinput">Doorgaan?</label><br>
            <a class="btn btn-secondary" href="productpagina.php" role="button">Verder winkelen</a> <a class="btn btn-secondary" href="accountoverzicht.php" role="button">Inloggen & verzendinformatie</a>
        </div>
    </form>';
echo "</div>";
