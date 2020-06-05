<?php

session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    unset($_SESSION['admin']);
}

echo "<script>window.location.href =\"/login.php\";</script>";

?>
