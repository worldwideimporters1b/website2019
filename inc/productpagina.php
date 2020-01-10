<?php
#error_reporting(E_ALL);

include_once('head.php');
include_once('header.php');
echo "<div class='container'>";

function toonProductPagina($conn, $artikel_id = 'NULL', $categorie_id = 'NULL')
{
    if ($categorie_id == 'NULL' && $artikel_id == 'NULL' && !isset($_GET['btnSearch'])) {
        $sql = "SELECT `categorienaam`, `categorie_id` 
                        FROM `categorie` ";
        $result = $conn->query($sql);

        $html = '<table class="table rounded">';
        $html .= '<tr><th><h3>Categorieën Overzicht</h3></th></tr>';

        foreach ($result as $regel) {
            $html .= "<tr>";
            $categorie_id = $regel['categorie_id'];
            $categorienaam = $regel['categorienaam'];
            foreach ($regel as $veldnaam => $veld) {

                if ($veldnaam == 'categorie_id') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $artikel_id . "&amp;cat_id=" . $categorie_id . "'>Bekijk $categorienaam</a></td>";
                }

            }
            $html .= "</tr>";
        }

        $html .= "</table>";

    } elseif ($artikel_id == 'NULL') {
        // && $categorie_id != 'NULL'

        $sql = "SELECT `bestandslocatie` , `naam` , `unitprice` prijs, `art`.`artikel_id` 
                        FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` 
                        JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` 
                        JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID
                        JOIN `artikel_categorie` as `cat` ON `cat` . `artikel_id` =  `art` . `artikel_id`
                        WHERE `cat` . `categorie_id` = '" . $categorie_id . "' LIMIT 20";
        // Hier wordt de zoek functie aan geroepen indien de zoek functie is gebruikt.



        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['btnSearch'])) {
                $zoekstring = $_GET['zoekstring'];
//                var_dump($zoekstring);
//                die();
                $sql = "SELECT `bestandslocatie` , `naam` , `unitprice` prijs, `art`.`artikel_id` 
                        FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` 
                        JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` 
                        JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID
                        JOIN `zoekwoorden_artikel` on `art`.`artikel_id`=`zoekwoorden_artikel`.`artikel_id` 
                        WHERE `zoekwoorden_artikel`.`zoekwoord` LIKE '%" . $zoekstring . "%' LIMIT 4";
            }
        }


        $result = $conn->query($sql);


        $html = '<table class="table rounded">';
        $html .= '<tr><th><h3>Product Overzicht</h3></th></tr>';
        foreach ($result as $regel) {
            $html .= "<tr>";
            $artikel_id = $regel['artikel_id'];
            foreach ($regel as $veldnaam => $veld) {
                if ($veldnaam == 'bestandslocatie') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $artikel_id . "'><img style='height: 100px; width: auto;' src='../" . $veld . "' class=\"rounded img-responsive thumbnail border border-white\"/></a></td>";
                }

                if ($veldnaam == 'artikel_id') {
                    $html .= "<td><a class='btn btn-secondary' href='productpagina.php?id=" . $veld . "'>Bekijk Product</a></td>";
                }
                if ($veldnaam == 'prijs') {
                    $html .= "<td><h4>€" . $veld . "</h4></td>";
                }

                if ($veldnaam !== 'bestandslocatie' AND $veldnaam !== 'artikel_id' AND $veldnaam !== 'prijs') {
                    $html .= "<td><h4>" . $veld . "</h4></td>";
                }
            }
            $html .= "</tr>";

        }
        $html .= "</table>";
    } else {

        $imagesquery = "SELECT `bestandslocatie` FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` WHERE `art`.`artikel_id` = '" . $artikel_id . "' LIMIT 50 OFFSET 1";
        $images = $conn->query($imagesquery);
        $sql = "SELECT bestandslocatie, unitprice prijs, naam, herkomst, productieproces, ingredienten, afmetingen, gewicht, art.omschrijving FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID WHERE `art`.`artikel_id` = '" . $artikel_id . "' LIMIT 1";
        $result = $conn->query($sql);

        $html = '<table class="table table-hover">';
        foreach ($result as $regel) {
            $html .= "<tr><td></td><td><a class='btn btn-secondary'href='productpagina.php?add&aid=" . $artikel_id . "&amt=1&id=" . $artikel_id . "'>Toevoegen</a></td></tr>";
            foreach ($regel as $veldnaam => $veld) {
                if ($veldnaam == 'bestandslocatie') {
                    $html .= "<tr><td>

                        <div style='position: relative; width: 80%;' id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
                          <div class='carousel-inner'>
                          
                          <div class='carousel-item active' >
                             <img style='margin-left: auto; margin-right: auto; max-width: 200px;' src = '../" . $veld . "' class='d-block w-100 rounded img-responsive thumbnail border border-white' >
                          </div >";

                    foreach ($images as $image) {
                        $html .= "
                                <div class='carousel-item' >
                                    <img style='margin-left: auto; margin-right: auto; max-width: 200px;' src = '../" . $image['bestandslocatie'] . "' class='d-block w-100 rounded img-responsive thumbnail border border-white' >
                                </div >";
                    };

                    $html .= "
                            </div>
                            <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'><span>
                            <span class='sr-only'>Previous</span>
                            </a>
                            <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                            </a>
                            </div>
                      </td></tr>";
                } else {
                    if ($veldnaam == 'prijs') {
                        $html .= "<td></td><td>€ " . $veld . "</td>";
                    }
                    if ($veldnaam !== 'prijs') {
                        $html .= "<tr></td><td>" . $veldnaam . "</td><td>" . $veld . "</td></tr>";

                    }
                }
            }
        }
        $html .= "</table><a class='btn btn-secondary' href='productpagina.php'>Terug naar overrzicht</a>";


/// GERELATEERDE PRODUCT VIDEOS BEGIN
        $artikelvideos = "
        SELECT `vid` . `bestandslocatie` ,  `art` .`artikel_id` , `art`.`artikel_id` 
                        FROM `video` as `video` 
                        JOIN `artikel_video` AS `art_vid` on `art_vid`.`video_id` = `art_vid`.`video_id` 
                        JOIN `video` AS `vid` on `vid`.`video_id` = `vid`.`video_id` 
                        
                        JOIN `artikel` as `art` ON `art` . `artikel_id` =  `art` . `artikel_id`
                        WHERE `art` . `artikel_id` = '" . $artikel_id . "' 
        ";

        $artikelvids = $conn->query($artikelvideos);

        $html .= "<br><br><h3>Product video links:</h3><br>";

        foreach ($artikelvids as $video) {
            $vid = $video;
            $html .= "
            <td><a target='_blank' href='" . $vid['bestandslocatie'] . "'> " . $vid['bestandslocatie'] . "</a></td>
            ";
        }

/// GERELATEERDE PRODUCT VIDEOS EIND


///GERELATEERDE ARTIKELEN BEGIN


        $findcategorie_id = "
        SELECT `categorie_id` 
        FROM `artikel_categorie` 
        WHERE `artikel_categorie`.`artikel_id` = '" . $artikel_id . "' LIMIT 1;
    ";


        $categorie_id = $conn->query($findcategorie_id);

        foreach ($categorie_id as $cat_id) {
            $id = $cat_id;
        }

        if ($id['categorie_id']){
            $findartikel_ids = "SELECT `artikel_id` FROM `artikel_categorie` WHERE `artikel_categorie`.`categorie_id` = '" . $id['categorie_id'] . "' LIMIT 4;";
    }
        $artikel_ids = $conn->query($findartikel_ids);

        $artikelen = array();

        $html .= "<br><br><br>";

        $html .= "<div class='row'>";

        foreach ($artikel_ids as $artikel_id) {
            $artikelen = $artikel_id;

            $relatedarticle = "SELECT `bestandslocatie` , `naam`,  `art`.`artikel_id` FROM `artikel` as `art` JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id` JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id` JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID WHERE `art`.`artikel_id` = '" . $artikel_id['artikel_id'] . "' LIMIT 1;";

            $artikel = $conn->query($relatedarticle);

            foreach ($artikelen as $artikels) {

                $relatedartikel = $artikels;

            }

            $sqlbestandslocatie = "
        SELECT `bestandslocatie` , `art`.`artikel_id` FROM `artikel` as `art`
        JOIN `artikel_afbeelding` AS `afb` on `afb`.`artikel_id` = `art`.`artikel_id`
        JOIN `afbeeldingen` AS `img` on `img`.`afbeelding_id` = `afb`.`afbeelding_id`
        JOIN `wideworldimporters`.`stockitems` ON `art`.`artikel_id` =  `wideworldimporters`.`stockitems`.StockItemID
        WHERE `art`.`artikel_id` = '" . $relatedartikel . "' LIMIT 1;";


            $bestandslocatie = $conn->query($sqlbestandslocatie);

            foreach ($bestandslocatie as $bestand) {
                $file = $bestand;
            }

            $html .= "
        
        <div class='col-md-4 col-sm-4 col-8'>
        <img style='height: 150px; width: auto;' src='../" . $file['bestandslocatie'] . "' class=\"rounded img-responsive thumbnail border border-white\"/>
        <a class='btn btn-secondary' href='productpagina.php?id=" . $relatedartikel . "'>Bekijk Product</a>
        </div>
        
        
        
        ";

        }

        $html .= "</div>";

        ///EIND GERELATEERDE ARTIKELEN


}


    return $html;
}


    if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
        $id = 'NULL';
        $categorie_id = $_GET['cat_id'];
        echo toonProductPagina($conn, $id, $categorie_id);
    }


if (isset($_GET['id'])) {

    if (is_numeric($_GET['id'])) {

        $id = $_GET['id'];

        echo toonProductPagina($conn, $id);

    }
} else {

    echo toonProductPagina($conn);

}
echo "</div>";

include_once('footer.php');