<?php

//hier gaan we iets doen met de code, isset is een Boolean, dit betekent dat het een true of false terug geeft.
//indien true, voer het daadwerkelijke uit, indien false ga dan naar de else.
function ($zoekstring)
{
    if (isset($zoekstring)) {
        //hier gaan we checken of wat we terug krijgen ook het woord go is.
        // De controle tegen de SQL injectie gaat via een preg_match, hierdoor verzekeren we dat het nmoet beginnen met letter.
        if (preg_match("/[A-Za-z]+/", $_POST['name'])) {
            $name = $_POST['name'];
            //HIER DE DB Connectie
            $conn = new mysqli('localhost', 'root', '', 'wideworldimporters');
            //hier het daadwerkelijke zoeken, we zoeken op het zoekwoord tabel met like, als er dus een overneekomst is dan een result.
            $sql = "select artikel.artikel_id artid from artikel join zoekwoorden_artikel on artikel.artikel_id=zoekwoorden_artikel.artikel_id where zoekwoorden_artikel.zoekwoord Like '%" . $name . "%'";
            //het resultaat wat we terug krijgen van de sql query slaan wij op in de string result. hierdoor is deze aan te roepen.
            $result = $conn->query($sql);

            while ($artikelresultaat = $result->fetch_assoc()) {
                return $artikelresultaat;
            }
            //if ($artikelresultaat => 1){
            //You need to redirect
            //  header("productpagina.php"); /* Redirect browser */
            //exit();
            //}
            //else{
            // do some
            //}

        } else {
            echo "<p>Er is helaas geen geldige zoekterm ingevuld.</p>";
        }

    }
}

?>