<?php
session_start();
include_once('functies.php');
$basketinfo = toonWinkelstats(basketinfo($conn), $conn);
$winkelmandid = basketinfo($conn);
$prijs = $basketinfo['Prijs'];
$aantalproducten = $basketinfo['Aantal'];
if (isset($_GET['add'])) {
    $winkelmandid = getbasketid($conn);
    if (isset($_GET['aid']) AND isset($_GET['amt'])) {
        $artikelid = secureInt($_GET['aid']);
        $aantal = secureInt($_GET['amt']);
        updateProductAantal($winkelmandid, $artikelid, $aantal, $conn);
    }
}
?>
<div class="subheader">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <img class="wwilogo" style="width: 10%; height: 10%;" alt="worldwideimporterslogo"
             src="../img/wide-world-importers-logo-small.png">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="productpagina.php">Artikelen</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="aboutus.php" tabindex="-1" aria-disabled="false">Over Ons</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php" tabindex="-1" aria-disabled="false">Contact</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="chat.php" tabindex="-1" aria-disabled="false">Chat</a>

                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="productpagina.php">
                    <input type="text" name="zoekstring" class="form-control mr-sm-2" value="" placeholder="Zoek artikel" aria-label="Search"/>
                    <input type="submit" class="btn btn-primary" name="btnSearch" value="zoeken"/>
                </form>
                <div style="width: 20px"></div>
                <a href="basket.php"><span><b class="basket"><?php echo formatprijs($prijs); ?></b></span>
                    <svg version="1.1" id="Capa_1" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         width="24px" height="24px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;"
                         xml:space="preserve">
                    <g>
                        <g id="shopping-cart">
                            <path d="M153,408c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S181.05,408,153,408z M0,0v51h51l91.8,193.8L107.1,306 c-2.55,7.65-5.1,17.85-5.1,25.5c0,28.05,22.95,51,51,51h306v-51H163.2c-2.55,0-5.1-2.55-5.1-5.1v-2.551l22.95-43.35h188.7 c20.4,0,35.7-10.2,43.35-25.5L504.9,89.25c5.1-5.1,5.1-7.65,5.1-12.75c0-15.3-10.2-25.5-25.5-25.5H107.1L84.15,0H0z M408,408 c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S436.05,408,408,408z"/>
                        </g>
                    </g>
                </svg>
                </a>
            </div>
        </div>
        <?php
        if (!isset($_SESSION['ingelogd'])) {
            ?>
            <a href="inloggen.php">
                <svg class="bi bi-person-fill" width="32px" height="32px" viewBox="0 0 20 20" fill="#FFFFFF"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5 16s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H5zm5-6a3 3 0 100-6 3 3 0 000 6z"
                          clip-rule="evenodd"/>
                </svg>
            </a>
            <?php
        } else {
            echo "<span class='basket'>" . $_SESSION["voornaam"] . " " . $_SESSION["achternaam"] . "</span>" .
            "<a href=\"accountbekijken.php\">
            <svg class=\"bi bi-person-fill\" width=\"32px\" height=\"32px\" viewBox=\"0 0 20 20\" fill=\"#FFFFFF\"
                 xmlns=\"http://www.w3.org/2000/svg\">
            <path fill-rule=\"evenodd\" d=\"M5 16s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H5zm5-6a3 3 0 100-6 3 3 0 000 6z\"
                      clip-rule=\"evenodd\"/>
            </svg>
            </a>";
        }
        ?>
    </nav>
</div>