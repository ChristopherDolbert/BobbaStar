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
$newskin = $_POST['skinId'];
$widget = $_POST['widgetId'];

if ($newskin == 1) {
    $skin = "defaultskin";
} else if ($newskin == 2) {
    $skin = "speechbubbleskin";
} else if ($newskin == 3) {
    $skin = "metalskin";
} else if ($newskin == 4) {
    $skin = "noteitskin";
} else if ($newskin == 5) {
    $skin = "notepadskin";
} else if ($newskin == 6) {
    $skin = "goldenskin";
} else if ($newskin == 7) {
    $skin = "hc_machineskin";
} else if ($newskin == 8) {
    $skin = "hc_pillowskin";
} else if ($newskin == 9 && $user_rank > 5) {
    $skin = "nakedskin";
} else {
    $skin = "defaultskin";
}

if (is_numeric($widget)) {
    if ($linked > 0) {
        $sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE groupid = :groupid AND type = '2' AND id = :widget LIMIT 1");
        $sql->bindParam(':groupid', $groupid);
        $sql->bindParam(':widget', $widget);
        $sql->execute();
    } else {
        $sql = $bdd->prepare("SELECT * FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '2' AND id = :widget LIMIT 1");
        $sql->bindParam(':my_id',  $user['id']);
        $sql->bindParam(':widget', $widget);
        $sql->execute();
    }
} else {
    exit;
}

$num = $sql->rowCount();

if ($num > 0) {
    $dat = $sql->fetch(PDO::FETCH_ASSOC);
    if ($linked > 0) {
        $updateStmt = $bdd->prepare("UPDATE cms_homes_stickers SET skin = :skin WHERE groupid = :groupid AND type = '2' AND id = :widget LIMIT 1");
        $updateStmt->bindParam(':skin', $skin);
        $updateStmt->bindParam(':groupid', $groupid);
        $updateStmt->bindParam(':widget', $widget);
        $updateStmt->execute();
    } else {
        $updateStmt = $bdd->prepare("UPDATE cms_homes_stickers SET skin = :skin WHERE userid = :my_id AND groupid = '-1' AND type = '2' AND id = :widget LIMIT 1");
        $updateStmt->bindParam(':skin', $skin);
        $updateStmt->bindParam(':my_id',  $user['id']);
        $updateStmt->bindParam(':widget', $widget);
        $updateStmt->execute();
    }
		header("X-JSON: {\"cssClass\":\"w_skin_" . $skin . "\",\"type\":\"widget\",\"id\":\"" . $widget . "\"}");
		echo "SUCCESS";
	} else {
		echo "ERROR";
	}
