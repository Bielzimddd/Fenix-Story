<?php
    unset($_COOKIE['hash']);
    setcookie("hash", "", time() - 3600);
    header("location: login.php");
?>