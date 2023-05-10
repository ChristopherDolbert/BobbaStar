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

$allow_guests = false;

require_once '../config.php';

if (isset($_POST['motto'])) {

	if (strlen($_POST['motto']) > 38) {
		echo $myrow['mission'];
	} else {
		$motto = filter_var($_POST['motto'], FILTER_SANITIZE_STRING);
		$stmt = $bdd->prepare("UPDATE users SET mission = :motto WHERE id = :my_id LIMIT 1");
		$stmt->execute(['motto' => $motto, 'my_id' => $user['id']]);
		echo $_POST['motto'];
		@SendMUSData('UPRA' . $user['id']);
	}
} else {
	echo $myrow['mission'];
}
