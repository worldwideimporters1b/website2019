<?php
include_once('head.php');
error_reporting(E_ALL);

echo '<head><meta http-equiv="refresh" content="10"></head> ';

$ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
$ip = $_SERVER['REMOTE_ADDR'];
$algo = 'sha256';

function createToken($ua, $ip, $algo)
{

    return hash($algo, ($ua . $ip . date('Y-m-d')));

}

$chat_id = createToken($ua, $ip, $algo);

$sql = "SELECT * FROM `chat` JOIN `chatregel` ON `chat`.`chat_id` = `chatregel`.`chat_id` JOIN `gebruiker` ON `chatregel`.`gebruiker_id` = `gebruiker`.`gebruiker_id` WHERE `chat`.`chat_id` = '" . $chat_id . "' ORDER by `tijd` ASC";

$result = $conn->query($sql);

$chat = '';

foreach ($result as $msg) {


    if ($msg['gebruiker_id'] !== 0) {
        $gebruiker = $msg['voornaam'];
        $chat .= '<span class="badge badge-info">' . $gebruiker . "</span> " . $msg['berichtinhoud'] . '<br>';
    }


}

echo "<div class=\"alert alert-primary\" role=\"alert\">Begin van de chat</div>";

echo $chat;

?>