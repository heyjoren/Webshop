<?php
session_start();

if (isset($_POST["log_out"])){
		echo"log out";
		session_unset();
		session_destroy();
		header('location:login.php');
	}

?>