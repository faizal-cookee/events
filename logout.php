<?php
session_start();

unset($_SESSION['email']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);

header("Location:user_login.php");
?>