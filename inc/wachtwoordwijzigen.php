<?php //door Lennard van Boven 1080997 WIP
include 'header.php';
include 'head.php';

function databaseConnectie(){
    $conn = new mysqli('localhost','root','','world_wide_importers');
    return $conn;
}

function wachtwoordControle($oldpass, $newpass, $emailadres){
    $conn = databaseConnectie();
    $query = "SELECT COUNT(*) FROM gebruiker WHERE `emailadres` = '$emailadres' AND `wachtwoord` = '$oldpass';"; //controleren of er een emailadres is met het ingevoerde wachtwoord

    $result = $conn->query($query);     //Wanneer de query word uitgevoerd, komt er 0 of 1 uit als resultaat.
    $row = $result->fetch_row();        // Het resultaat komt in de vorm van een array. Deze array slaan we op in $row

    if ($row[0] == 1) {                 //Op plek 0 van de array $row staat een 0 of 1. 0 betekend dat het emailadres of wachtwoord onjuist is.
                                        //Als plek 0 van $row een 1 heeft als waarde, is het emailadres en wachtwoord een match. Het account mag verwijderd worden.
        wachtwoordWijzigen($newpass, $emailadres, $conn);

    }else{
        echo "<blockquote class=\"blockquote text-center\">
         <p class=\"mb-0\"><strong>Het wachtwoord is onjuist.</strong></p> 
         </blockquote>";
    }

    return $result;

}

function wachtwoordWijzigen($newpass, $emailadres, $conn){

    $sql = "UPDATE `gebruiker` SET `wachtwoord` = '$newpass' WHERE `emailadres` = '$emailadres';";

    $result = $conn->query($sql);

    echo "<blockquote class=\"blockquote text-center\">
         <p class=\"mb-0\"><strong>Het wachtwoord is bijgewerkt.</strong></p> 
         </blockquote>";

    return $result;
}




if (isset($_POST["bijwerken"])){
if (strlen(($_POST['wachtwoordnieuw'])) < 6 || strlen(($_POST['wachtwoordnieuw'])) > 20 || !preg_match('@[A-Z]@', ($_POST['wachtwoordnieuw'])) || !preg_match('@[a-z]@', ($_POST['wachtwoordnieuw']))
    || !preg_match('@[^\w]@', ($_POST['wachtwoordnieuw']))) { //eisen stellen aan het ingevoerde wachtwoord
    echo "<blockquote class=\"blockquote text-center\">";
    echo "<p class=\"mb-0\"><strong>Het wachtwoord moet minimaal 6  en maximaal 20 tekens bevatten. Het wachtwoord moet bestaan uit een normale en hoofdletter. Het wachtwoord moet minstens 1 speciaal karakter bevatten.</strong></p>";
    echo "</blockquote>";
}else{
    $emailadres = $_SESSION["gebruikersnaam"];
    $oldpass = md5("a@sdiu#(*$1_41" . $_POST['wachtwoordoud']);
    $newpass = md5("a@sdiu#(*$1_41" . $_POST['wachtwoordnieuw']);
    wachtwoordControle($oldpass, $newpass, $emailadres);
}


}


?>

<html>
<div class="container">
    <h3>Wijzig uw wachtwoord</h3><br>
    <p><strong>Aangemeld als: <?php echo $_SESSION['gebruikersnaam']; ?></strong></p>
    <form method="post" action="wachtwoordwijzigen.php">


            <label for="oudwachtwoord">Voer hier het huidge wachtwoord in:</label>
            <input type="password" class="form-control" name="wachtwoordoud" value="" required/>
            <br>

            <label for="nieuwwachtwoord">Voer hier het nieuwe wachtwoord in:</label>
            <input type="password" class="form-control" name="wachtwoordnieuw" value="" required/>
            <br>

        <input type="submit" class="btn btn-outline-danger" name="bijwerken" value="Bijwerken"/><br><br>

        <button onclick="history.go(-1);" class="btn btn-primary">Terug</button>


</html>