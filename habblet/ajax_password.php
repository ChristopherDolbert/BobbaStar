<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include("../config.php");

$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

if(strlen($password) < 6){
	echo "Password must be at least 6 characters long.";
} else {
	header("X-JSON: \"charOk\"");
	echo "Password is secure!";
}

?>

