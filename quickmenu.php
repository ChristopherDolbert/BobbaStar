<?php

require_once('../config.php');

$key = $_GET['key'];

switch ($key) {
	case "friends_all":
		$mode = 1;
		break;
	case "groups":
		$mode = 2;
		break;
	case "rooms":
		$mode = 3;
		break;
}

if (!isset($mode) || !isset($key)) {
	$mode = 1;
}

if (isset($user['id'])) {
	
} else {
	exit;
}

switch ($mode) {
	case 1:
		$str = "friends";
		$stmt = $bdd->prepare("SELECT friendid FROM messenger_friendships WHERE userid = ? OR friendid = ? ORDER BY friendid LIMIT 500");
		$stmt->bind_param('ii', $user['id'], $user['id']);
		$stmt->execute();
		$get_em = $stmt->get_result();
		break;
	case 2:
		$str = "groups";
		$stmt = $bdd->prepare("SELECT * FROM guilds_members WHERE user_id = ? AND is_pending = '0' ORDER BY member_rank LIMIT 10");
		$stmt->bind_param('i', $user['id']);
		$stmt->execute();
		$get_em = $stmt->get_result();
		break;
	case 3:
		$str = "rooms";
		$stmt = $bdd->prepare("SELECT * FROM rooms WHERE owner = ? ORDER BY name ASC LIMIT 100");
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$get_em = $stmt->get_result();
		break;
}

$results = $get_em->rowCount();
$oddeven = 0;

if ($results > 0) {
	if ($mode == 1) {
		echo "<ul id=\"offline-friends\">\n";
		while ($row = $get_em->fetch(PDO::FETCH_ASSOC)) {
			$userdatasql = $bdd->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
			$userdatasql->bindParam(1, $row['friendid'], PDO::PARAM_INT);
			$userdatasql->execute();
			$user_exists = $userdatasql->rowCount();
			if ($user_exists > 0) {
				$userrow = $userdatasql->fetch(PDO::FETCH_ASSOC);
				$oddeven++;
				if (IsEven($oddeven)) {
					$even = "odd";
				} else {
					$even = "even";
				}
				printf(" <li class=\"%s\"><a href=\"info?tag=%s\">%s</a></li>\n", $even, $userrow['name'], $userrow['name']);
			}
		}
		echo "\n</ul>";
	} elseif ($mode == 2) {
		echo "<ul id=\"quickmenu-groups\">\n";

		$num = 0;

		while ($row = $bdd->query("SELECT * FROM groups_memberships WHERE userid = '" . $user['id'] . "' AND is_pending = '0' ORDER BY member_rank LIMIT 10'")->fetch(PDO::FETCH_ASSOC)) {

			$num++;

			$group_id = $row['groupid'];

			$stmt = $bdd->prepare("SELECT name, ownerid FROM groups_details WHERE id = ? LIMIT 1");
			$stmt->execute([$group_id]);
			$groupdata = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "<li class=\"";
			if (IsEven($num)) {
				echo "odd";
			} else {
				echo "even";
			}
			echo "\">";

			if ($row['is_current'] == 1) {
				echo "<div class=\"favourite-group\" title=\"Favourite\"></div>\n";
			}
			if ($row['member_rank'] > 1 && $groupdata['ownerid'] !== $user['id']) {
				echo "<div class=\"admin-group\" title=\"Admin\"></div>\n";
			}
			if ($groupdata['ownerid'] == $user['id'] && $row['member_rank'] > 1) {
				echo "<div class=\"owned-group\" title=\"Owner\"></div>\n";
			}

			echo "\n<a href=\"group_profile.php?id=" . $group_id . "\">" . HoloText($groupdata['name']) . "</a>\n</li>";
		}

		echo "\n</ul>";
	} elseif ($mode == 3) {
		echo "<ul id=\"quickmenu-rooms\">\n";

		$stmt = $bdd->prepare("SELECT * FROM rooms WHERE owner = ? ORDER BY name ASC LIMIT 100");
		$stmt->bindValue(1, $name, PDO::PARAM_STR);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($results as $row) {
			$oddeven++;
			if (IsEven($oddeven)) {
				$even = "odd";
			} else {
				$even = "even";
			}
			printf("        <li class=\"%s\"><a href=\"client?forwardId=2&amp;roomId=%s\" onclick=\"roomForward(this, '%s', 'private'); return false;\" target=\"client\" id=\"room-navigation-link_%s\">%s</a></li>\n", $even, $row['id'], $row['id'], $row['id'], $row['name']);
		}

		echo "\n</ul>";
	} else {
		echo "Invalid mode";
	}
} else {
	echo "<ul id=\"quickmenu-" . $str . "\">\n	<li class=\"odd\">Tu n'as pas de " . $str . " </li>\n</ul>";
}

if ($mode == "3") {
	echo "<p class=\"create-room\"><a href=\"client?shortcut=roomomatic\" onclick=\"HabboClient.openShortcut(this, 'roomomatic'); return false;\" target=\"client\">Cr&eacute;er un appart</a></p>";
} elseif ($mode == "2") {
	echo "<p class=\"create-group\"><a href=\"#\" onclick=\"GroupPurchase.open(); return false;\">Cr&eacute;er un clan</a></p>";
}
