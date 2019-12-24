<?php
// by sander brandriet
include_once('head.php');
include_once('header.php');

if(isset($_POST['msg'])){
	
	$msg = filter_var(htmlspecialchars(strip_tags($_POST['msg'])),FILTER_SANITIZE_STRING);
	
}

$ua = $_SERVER['HTTP_USER_AGENT']??null;
$ip = $_SERVER['REMOTE_ADDR'];
$algo = 'sha256';
$medewerker = 1;




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

 // check if user is logged in.

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

$token = createToken($ua,$ip,$algo);

if (isset($msg)){
	
$sql = "SELECT * FROM `chat` WHERE `chat_id` = '".$token."'";
	
	
	   $result = $conn->query($sql);
       if ($result) {
		
           if ($result->num_rows !== 1) {
               $sql = "INSERT INTO `chat` (`chat_id`, `starttijd`) VALUES ('".$token."', CURRENT_TIME());";
			   $conn->query($sql);
			   header("Location: chat.php");
           }
           if ($result->num_rows == 1) {
               $sql = "INSERT INTO `chatregel` (`chatregel_id`, `chat_id`, `gebruiker_id`, `berichtinhoud`, `tijd`) VALUES (NULL, '".$token."', '0', '".$msg."', CURRENT_TIME()); ";
			   $conn->query($sql);
		   }
	   }
	
	
	



}

echo '<div class=\'container\'><h3>WWI Chat</h3>
<div class="form-group">
<iframe class="form-control" src="viewchat.php" style="height: 350px"></iframe>
</div>
<form method="post">
  <div class="form-group">
    <label for="bericht">Bericht</label>
    <textarea class="form-control" name="msg" placeholder="Typ hier uw bericht" rows="2" cols="50"></textarea>
    <small id="chatHelp" class="form-text text-muted">U hoeft niet in te loggen om de chat te kunnen gebruiken. Berichten in deze chat zijn mogelijk leesbaar voor anderen. Gebruik geen persoonlijke gegevens in de chat.</small>
  </div>
  <button type="Verzenden" class="btn btn-primary">Submit</button>
</form>

';
echo '<br><br><small id="chatId" class="form-text text-muted">ChatId: ' . $token . '</small>';