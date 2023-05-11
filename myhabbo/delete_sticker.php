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
$sticker = $_POST['stickerId'];

if (is_numeric($sticker)) {
	if ($linked > 0) {
		$sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE groupid = :groupid AND type = '1' AND id = :sticker LIMIT 1");
		$sql->bindParam(':groupid', $groupid);
		$sql->bindParam(':sticker', $sticker);
		$sql->execute();
	} else {
		$sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '1' AND id = :sticker LIMIT 1");
		$sql->bindParam(':my_id',  $user['id']);
		$sql->bindParam(':sticker', $sticker);
		$sql->execute();
	}
} else {
	exit;
}

$num = $sql->rowCount();

if ($num > 0) {
	if ($linked > 0) {
		$deleteStmt = $bdd->prepare("DELETE FROM cms_homes_stickers WHERE groupid = :groupid AND type = '1' AND id = :sticker LIMIT 1");
		$deleteStmt->bindParam(':groupid', $groupid);
		$deleteStmt->bindParam(':sticker', $sticker);
		$deleteStmt->execute();
	} else {
		$deleteStmt = $bdd->prepare("DELETE FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '1' AND id = :sticker LIMIT 1");
		$deleteStmt->bindParam(':my_id',  $user['id']);
		$deleteStmt->bindParam(':sticker', $sticker);
		$deleteStmt->execute();
	}
	$dat = $sql->fetch(PDO::FETCH_ASSOC);
	$check = $bdd->prepare("SELECT id FROM cms_homes_inventory WHERE type = '1' AND data = :data AND userid = :my_id LIMIT 1");
	$check->bindParam(':data', $dat['data']);
	$check->bindParam(':my_id',  $user['id']);
	$check->execute();
	$exists = $check->rowCount();
	if ($exists > 0) {
		$updateStmt = $bdd->prepare("UPDATE cms_homes_inventory SET amount = amount + 1 WHERE userid = :my_id AND data = :data AND type = '1' LIMIT 1");
		$updateStmt->bindParam(':my_id',  $user['id']);
		$updateStmt->bindParam(':data', $dat['data']);
		$updateStmt->execute();
	} else {
		$insertStmt = $bdd->prepare("INSERT INTO cms_homes_inventory (userid, type, subtype, data, amount) VALUES (:my_id, '1', '1', :data, '1')");
		$insertStmt->bindParam(':my_id',  $user['id']);
		$insertStmt->bindParam(':data', $dat['data']);
		$insertStmt->execute();
	}
	echo "SUCCESS";
} else {
	echo "ERROR";
}
