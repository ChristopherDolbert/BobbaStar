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

include('../config.php');

$check = $bdd->prepare("SELECT groupid, active FROM cms_homes_group_linker WHERE userid = :my_id AND active = '1' LIMIT 1");
$check->bindParam(':my_id',  $user['id']);
$check->execute();
$linked = $check->rowCount();

if ($linked > 0) {
	$linkdata = $check->fetch(PDO::FETCH_ASSOC);
	$groupid = $linkdata['groupid'];
}

// Collect variables
$stickie = $_POST['stickieId'];

if (is_numeric($stickie)) {
	if ($linked > 0) {
		$sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE groupid = :groupid AND type = '3' AND id = :stickie LIMIT 1");
		$sql->bindParam(':groupid', $groupid);
		$sql->bindParam(':stickie', $stickie);
		$sql->execute();
	} else {
		$sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '3' AND id = :stickie LIMIT 1");
		$sql->bindParam(':my_id',  $user['id']);
		$sql->bindParam(':stickie', $stickie);
		$sql->execute();
	}
} else {
	exit;
}

$num = $sql->rowCount();

if ($num > 0) {
	if ($linked > 0) {
		$deleteStmt = $bdd->prepare("DELETE FROM cms_homes_stickers WHERE groupid = :groupid AND type = '3' AND id = :stickie LIMIT 1");
		$deleteStmt->bindParam(':groupid', $groupid);
		$deleteStmt->bindParam(':stickie', $stickie);
		$deleteStmt->execute();
	} else {
		$deleteStmt = $bdd->prepare("DELETE FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '3' AND id = :stickie LIMIT 1");
		$deleteStmt->bindParam(':my_id',  $user['id']);
		$deleteStmt->bindParam(':stickie', $stickie);
		$deleteStmt->execute();
	}
	echo "SUCCESS";
} else {
	echo "ERROR";
}
