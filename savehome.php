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

include('config.php');
// Split and count the data we've just received
$note = explode("/", $_POST['stickienotes']);
$widget = explode("/", $_POST['widgets']);
$sticker = explode("/", $_POST['stickers']);
$background = explode(":", $_POST['background']);

$check_stmt = $bdd->query("SELECT groupid,active FROM cms_homes_group_linker WHERE userid = '" . $user['id'] . "' AND active = '1' LIMIT 1");
$linked = $check_stmt->rowCount();

if ($linked > 0) {
	$linkdata = $check_stmt->fetch(PDO::FETCH_ASSOC);
	$groupid = $linkdata['groupid'];
}


if (!empty($background[1])) {
	$bg = str_replace("b_", "", $background[1]);
	echo $bg;
	if (!isset($groupid)) {
		$check_stmt = $bdd->prepare("SELECT id FROM cms_homes_inventory WHERE userid = :userid AND type = '4' AND data = :bg LIMIT 1");
		$check_stmt->execute(array(':userid' => $user['id'], ':bg' => FilterText($bg)));
	} else {
		$check_stmt = $bdd->prepare("SELECT id FROM cms_homes_inventory WHERE userid = :userid AND type = '4' AND data = :bg AND groupid = :groupid LIMIT 1");
		$check_stmt->execute(array(':userid' => $user['id'], ':bg' => FilterText($bg), ':groupid' => $groupid));
	}
	$valid = $check_stmt->rowCount();
	if ($valid > 0) {
		if (!isset($groupid)) {
			$check_stmt = $bdd->query("SELECT data FROM cms_homes_stickers WHERE userid = '" . $user['id'] . "' AND groupid = '-1' AND type = '4' LIMIT 1");
		} else {
			$check_stmt = $bdd->query("SELECT data FROM cms_homes_stickers WHERE groupid = '" . $groupid . "' AND type = '4' LIMIT 1");
		}
		$exists = $check_stmt->rowCount();
		if ($exists > 0) {
			echo("<script>console.log('Ligne 47');</script>");
			if (!isset($groupid)) {
				echo("<script>console.log('Ligne 48');</script>");
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET data = :bg WHERE type = '4' AND userid = :userid AND groupid = '-1' LIMIT 1");
				$update_stmt->execute(array(':bg' => $bg, ':userid' => $user['id']));
			} else {
				echo("<script>console.log('Ligne 53');</script>");
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET data = :bg WHERE type = '4' AND groupid = :groupid LIMIT 1");
				$update_stmt->execute(array(':bg' => $bg, ':groupid' => $groupid));
			}
		} else {
			if (!isset($groupid)) {
				$insert_stmt = $bdd->prepare("INSERT INTO cms_homes_stickers (userid, groupid, x, y, z, data, type, subtype, skin) VALUES (:userid, '-1', '-1', '-1', '-1', :bg, '4', '0', '-1')");
				$insert_stmt->execute(array(':userid' => $user['id'], ':bg' => $bg));
			} else {
				$insert_stmt = $bdd->prepare("INSERT INTO cms_homes_stickers (userid, groupid, x, y, z, data, type, subtype, skin) VALUES (:userid, :groupid, '-1', '-1', '-1', :bg, '4', '0', '-1')");
				$insert_stmt->execute(array(':userid' => $user['id'], ':groupid' => $groupid, ':bg' => $bg));
			}
		}
	}
}


// Loop through each array of data we encountered and save the stuff that was passed onto us
foreach ($widget as $raw) {
	$bits = explode(":", $raw);
	$id = $bits[0];
	$data = FilterText($bits[1]);
	if (!empty($data) && !empty($id) && is_numeric($id)) {
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if (is_numeric($x) && is_numeric($y) && is_numeric($z)) {
			if (isset($groupid)) {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '2' AND groupid = :groupid LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':groupid' => $groupid));
			} else {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '2' AND userid = :userid AND groupid = '-1' LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':userid' => $user['id']));
			}
		}
	}
}


foreach ($sticker as $raw) {
	$bits = explode(":", $raw);
	$id = $bits[0];
	$data = FilterText($bits[1]);
	if (!empty($data) && !empty($id) && is_numeric($id)) {
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if (is_numeric($x) && is_numeric($y) && is_numeric($z)) {
			if (isset($groupid)) {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '1' AND groupid = :groupid LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':groupid' => $groupid));
			} else {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '1' AND userid = :userid AND groupid = '-1' LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':userid' => $user['id']));
			}
		}
	}
}


foreach ($note as $raw) {
	$bits = explode(":", $raw);
	$id = $bits[0];
	$data = FilterText($bits[1]);
	if (!empty($data) && !empty($id) && is_numeric($id)) {
		$coordinates = explode(",", $data);
		$x = $coordinates[0];
		$y = $coordinates[1];
		$z = $coordinates[2];
		if (is_numeric($x) && is_numeric($y) && is_numeric($z)) {
			if (isset($groupid)) {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '3' AND groupid = :groupid LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':groupid' => $groupid));
			} else {
				$update_stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '3' AND userid = :userid AND groupid = '-1' LIMIT 1");
				$update_stmt->execute(array(':x' => $x, ':y' => $y, ':z' => $z, ':id' => $id, ':userid' => $user['id']));
			}
		}
	}
}


if (isset($groupid)) {
	echo "\n<script language=\"JavaScript\" type=\"text/javascript\">\nwaitAndGo('group_profile.php?id=" . $groupid . "');\n</script>";
	exit;
} else {
	echo "\n<script language=\"JavaScript\" type=\"text/javascript\">\nwaitAndGo('user_profile.php?name=" . HoloText($user['username']) . "');\n</script>";
	exit;
}
