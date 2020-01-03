<?php
include_once 'head.php';
include_once 'header.php';
session_destroy();
?>
<html>

<div class="container">

    <p>U bent uitgelogd.</p>
    <?php header("refresh:2;url = home.php"); ?>
</div>
</html>
