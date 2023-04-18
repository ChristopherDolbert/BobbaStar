<?php
ob_start();
session_start();

if(!isset($_SESSION['id'])){
	echo'Eerst inloggen!<br>';
}else{
	unset($_SESSION['id']);
	header("Location: index.php");
}
?>