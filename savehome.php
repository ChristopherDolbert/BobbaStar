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

// Split and count the data we've just recieved
if (isset($_POST['stickienotes'])) {
	$note = explode("/", $_POST['stickienotes']);
} else {
	$note = "golden";
}

if (isset($_POST['widgets'])) {
	$widget = explode("/", $_POST['widgets']);
} else {
	$widget = "golden";
}

if (isset($_POST['stickers'])) {
	$stickers = explode("/", $_POST['stickers']);
} else {
	$stickers = "golden";
}

if (isset($_POST['background'])) {
	$background = explode("/", $_POST['background']);
} else {
	$background = "golden";
}

$stmt = $bdd->prepare("SELECT groupid, active FROM cms_homes_group_linker WHERE userid = :my_id AND active = '1' LIMIT 1");
$stmt->bindParam(':my_id', $user['id']);
$stmt->execute();
$linked = $stmt->rowCount();


if ($linked > 0) {
	$linkdata = $stmt->fetch(PDO::FETCH_ASSOC);
	$groupid = $linkdata['groupid'];
}

if (!empty($background[1])) {
	$bg = str_replace("b_", "", $background[1]);
	echo $bg;
	$stmt = $bdd->prepare("SELECT id FROM cms_homes_inventory WHERE userid = :my_id AND type = '4' AND data = :bg LIMIT 1");
	$stmt->bindParam(':my_id',  $user['id']);
	$stmt->bindParam(':bg', $bg);
	$stmt->execute();
	$valid = $stmt->rowCount();

	if ($valid > 0) {
		if (!isset($groupid)) {
			$stmt = $bdd->query("SELECT data FROM cms_homes_stickers WHERE userid = :my_id AND groupid = '-1' AND type = '4' LIMIT 1");
			$stmt->bindParam(':my_id',  $user['id']);
		} else {
			$stmt = $bdd->query("SELECT data FROM cms_homes_stickers WHERE groupid = :groupid AND type = '4' LIMIT 1");
			$stmt->bindParam(':groupid', $groupid);
		}
		$exists = $stmt->rowCount();

		if ($exists > 0) {
			if (!isset($groupid)) {
				$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET data = :bg WHERE type = '4' AND userid = :my_id AND groupid = '-1' LIMIT 1");
				$stmt->bindParam(':bg', $bg);
				$stmt->bindParam(':my_id',  $user['id']);
			} else {
				$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET data = :bg WHERE type = '4' AND groupid = :groupid LIMIT 1");
				$stmt->bindParam(':bg', $bg);
				$stmt->bindParam(':groupid', $groupid);
			}
			$stmt->execute();
		} else {
			if (!isset($groupid)) {
				$stmt = $bdd->prepare("INSERT INTO cms_homes_stickers (userid, groupid, x, y, z, data, type, subtype, skin) VALUES (:my_id, '-1', '-1', '-1', '-1', :bg, '4', '0', '-1')");
				$stmt->bindParam(':my_id',  $user['id']);
				$stmt->bindParam(':bg', $bg);
			} else {
				$stmt = $bdd->prepare("INSERT INTO cms_homes_stickers (userid, groupid, x, y, z, data, type, subtype, skin) VALUES (:my_id, :groupid, '-1', '-1', '-1', :bg, '4', '0', '-1')");
				$stmt->bindParam(':my_id',  $user['id']);
				$stmt->bindParam(':groupid', $groupid);
				$stmt->bindParam(':bg', $bg);
			}
			$stmt->execute();
		}
	}
}


// Loop through each array of data we encountered and save the stuff that was passed onto us
if (is_array($widget) || is_iterable($widget)) {
	foreach ($widget as $raw) {
		$bits = explode(":", $raw);
		if (count($bits) >= 2) {
			$id = $bits[0];
			$data = FilterText($bits[1]);
		} else {
		}

		if (!empty($data) && !empty($id) && is_numeric($id)) {
			$coordinates = explode(",", $data);
			$x = $coordinates[0];
			$y = $coordinates[1];
			$z = $coordinates[2];

			if (is_numeric($x) && is_numeric($y) && is_numeric($z)) {
				if (isset($groupid)) {
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '2' AND groupid = :groupid LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':groupid', $groupid);
				} else {
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '2' AND userid = :my_id AND groupid = '-1' LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':my_id',  $user['id']);
				}

				$stmt->execute();
			}
		}
	}
}

if (is_array($stickers) || is_iterable($stickers)) {
	foreach ($stickers as $raw) {
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
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '1' AND groupid = :groupid LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':groupid', $groupid);
				} else {
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '1' AND userid = :my_id AND groupid = '-1' LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':my_id',  $user['id']);
				}

				$stmt->execute();
			}
		}
	}
}

if (is_array($note) || is_iterable($note)) {
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
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '3' AND groupid = :groupid LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':groupid', $groupid);
				} else {
					$stmt = $bdd->prepare("UPDATE cms_homes_stickers SET x = :x, y = :y, z = :z WHERE id = :id AND type = '3' AND userid = :my_id AND groupid = '-1' LIMIT 1");
					$stmt->bindParam(':x', $x);
					$stmt->bindParam(':y', $y);
					$stmt->bindParam(':z', $z);
					$stmt->bindParam(':id', $id);
					$stmt->bindParam(':my_id',  $user['id']);
				}

				$stmt->execute();
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
