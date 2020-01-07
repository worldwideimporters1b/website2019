<?php //door Lennard van Boven 1080997
include_once 'head.php';
include_once 'header.php';
session_destroy();
header("refresh:1;url=home.php");
?>
<html>

<div class="container">

    <blockquote class=\blockquote text-center\>
        <p class=\"mb-0\"><strong>U bent uitgelogd.</strong></p></blockquote>

</div>
</html>
