<?php
session_start();
// session_unset();
unset($_SESSION['adminEmail']);
echo "<script>location.assign('login.php')</script>";
?>