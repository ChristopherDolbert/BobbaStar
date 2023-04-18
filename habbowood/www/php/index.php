<?php
ob_start();
session_start();
include('config.php');

if(!isset($_SESSION['id'])){
	echo'Niet ingelogd...<br>';
	echo'Klik <a href="login.php">hier</a> om je ingeloggen<br>';
	echo'Klik <a href="register.php">hier</a> om je te registreren<br>';
}else{
	echo'Welkom ID: '.$_SESSION['id'].'<br>';
	echo'Email: '.htmlspecialchars($userdata['email']).'<br>';
	echo'<a href="loguit.php">Loguit</a><br>';
}
?>
