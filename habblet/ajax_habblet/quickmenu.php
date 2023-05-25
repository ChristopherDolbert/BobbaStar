<?php

require_once('../../config.php');

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

switch ($mode) {
	case 1:
		$str = "friends";
		$query = "SELECT user_two_id FROM messenger_friendships WHERE user_one_id = :my_id OR user_two_id = :my_id ORDER BY user_two_id LIMIT 500";
		$stmt = $bdd->prepare($query);
		$stmt->bindParam(':my_id', $user['id']);
		$stmt->execute();
		break;
	case 2:
		$str = "groups";
		$query = "SELECT * FROM guilds_members WHERE user_id = :my_id AND is_pending = '0' ORDER BY member_rank LIMIT 10";
		$stmt = $bdd->prepare($query);
		$stmt->bindParam(':my_id', $user['id']);
		$stmt->execute();
		break;
	case 3:
		$str = "rooms";
		$query = "SELECT * FROM rooms WHERE owner_name  = :name ORDER BY owner_name ASC LIMIT 100";
		$stmt = $bdd->prepare($query);
		$stmt->bindParam(':name', $user['username']);
		$stmt->execute();
		break;
}

$results = $stmt->rowCount();
$oddeven = 0;

if ($results > 0) {
	if ($mode == 1) {
		echo "<ul id=\"offline-friends\">\n";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$userdatasql = $bdd->prepare("SELECT username FROM users WHERE id = :friendid LIMIT 1");
			$userdatasql->bindParam(':friendid', $row['user_two_id']);
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
				printf("        <li class=\"%s\"><a href=\"info?tag=%s\">%s</a></li>\n", $even, $userrow['username'], $userrow['username']);
			}
		}
		echo "\n</ul>";
	} elseif ($mode == 2) {
		echo "<ul id=\"quickmenu-groups\">\n";
		$num = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$num++;
			$group_id = $row['groupid'];
			$check = $bdd->prepare("SELECT name,user_id FROM guilds WHERE id = :group_id LIMIT 1");
			$check->bindParam(':group_id', $group_id);
			$check->execute();
			$groupdata = $check->fetch(PDO::FETCH_ASSOC);
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
			if ($row['member_rank'] > 1 && $groupdata['user_id'] !== $user['id']) {
				echo "<div class=\"admin-group\" title=\"Admin\"></div>\n";
			}
			if ($groupdata['user_id'] == $user['id'] && $row['member_rank'] > 1) {
				echo "<div class=\"owned-group\" title=\"Owner\"></div>\n";
			}
			echo "\n<a href=\"group_profile.php?id=" . $group_id . "\">" . HoloText($groupdata['name']) . "</a>\n</li>";
		}
		echo "\n</ul>";
	} elseif ($mode == 3) {
		echo "<ul id=\"quickmenu-rooms\">\n";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$oddeven++;
			if (IsEven($oddeven)) {
				$even = "odd";
			} else {
				$even = "even";
			}
			printf("        <li class=\"%s\"><a href=\"client.php?forwardId=2&amp;roomId=%s\" onclick=\"roomForward(this, '%s', 'private'); return false;\" target=\"client\" id=\"room-navigation-link_%s\">%s</a></li>\n", $even, $row['id'], $row['id'], $row['id'], $row['name']);
		}
		echo "\n</ul>";
	} else {
		echo "Invalid mode";
	}
} else {
	echo "<ul id=\"quickmenu-\" . $str . \"\">\n <li class=\"odd\">Tu n'as pas de " . $str . " </li>\n</ul>";
}

if ($mode == "3") {
	echo "<p class=\"create-room\"><a href=\"client.php?shortcut=roomomatic\" onclick=\"HabboClient.openShortcut(this, 'roomomatic'); return false;\" target=\"client\">Créer un appart</a></p>";
} elseif ($mode == "2") {
	echo "<p class=\"create-group\"><a href=\"#\" onclick=\"GroupPurchase.open(); return false;\">Créer un clan</a></p>";
}
