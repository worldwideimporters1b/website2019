<?php
// by sander brandriet
include_once('head.php');
include_once('header.php');

$ua = $_SERVER['HTTP_USER_AGENT']??null;
$ip = $_SERVER['REMOTE_ADDR'];
$algo = 'sha256';

echo "<div class='container'>";
$conn = new mysqli('localhost', 'root', '', 'world_wide_importers');

function checkLoginPerms($conn,$userid,$sessieid){

   $sql = "SELECT * FROM `gebruiker` JOIN `gebruikersessie` AS `sessie` ON `sessie`.`gebruiker_id` = `gebruiker`.`gebruiker_id` WHERE `sessie`.`sessie_id` = '".$sessieid."' AND `gebruiker`.`gebruiker_id` = '".$userid."'";

    $result = $conn->query($sql);
       if ($result) {

           if ($result->num_rows !== 1) {
               return 0;
           }

           if ($result->num_rows == 1) {
               return 1;
           }
       }

}

function anonymousChat($conn,$token){



}

function createToken($ua,$ip,$algo){

return hash($algo, ($ua . $ip . date('Y-m-d')));

}

function validateToken($ua,$ip,$token,$algo){

    $crypt = hash($algo, ($ua . $ip . date('Y-m-d')));
    if ($crypt !== $token){
        return 0;
    }
    if ($crypt == $token){
        return 1;
    }

}

echo createToken($ua,$ip,$algo);

echo validateToken($ua,$ip,createToken($ua,$ip,$algo),$algo);

#echo checkLoginPerms($conn,1,1234);