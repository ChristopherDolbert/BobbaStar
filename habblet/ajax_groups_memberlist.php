<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         Copyright © 2014-2023 - MyHabbo Tout droits réservés.          #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


include("../config.php");

$refer = $_SERVER['HTTP_REFERER'];
$pos = strrpos($refer, "group_profile.php");
if ($pos === false) {
	exit;
}

$groupid = $_POST['groupId'];
$page = $_POST['pageNumber'];
$searchString = $_POST['searchString'];
$pending = $_POST['pending'];

if ($pending == "true") {
	$pending = true;
} else {
	$pending = false;
}
if (!is_numeric($groupid)) {
	exit;
}

$stmt = $bdd->prepare("SELECT member_rank FROM guilds_members WHERE user_id = ? AND guild_id = ? AND member_rank > 1 AND is_pending = '0' LIMIT 1");
$stmt->execute([$user['id'], $groupid]);
$is_member = $stmt->rowCount();


if ($is_member > 0) {
	$my_membership = $check->fetch(PDO::FETCH_ASSOC);
	$member_rank = $my_membership['member_rank'];
	if ($member_rank < 2) {
		exit;
	}
} else {
	exit;
}

$stmt = $bdd->prepare("SELECT * FROM guilds WHERE id = :groupid LIMIT 1");
$stmt->bindParam(':groupid', $groupid);
$stmt->execute();
$valid = $stmt->rowCount();


if ($valid > 0) {
	$groupdata = $check->fetch(PDO::FETCH_ASSOC);
} else {
	exit;
}

// Vérification si des demandes de membres sont en attente
$stmt = $bdd->prepare("SELECT COUNT(*) FROM guilds_members WHERE guild_id = :groupid AND is_pending = '0'");
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();
$members = $stmt->fetchColumn();
if ($members < 1) {
	exit("There have to be members");
}

// Récupération du nombre de membres en attente
$stmt = $bdd->prepare("SELECT COUNT(*) FROM guilds_members WHERE guild_id = :groupid AND is_pending = '1'");
$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
$stmt->execute();
$members_pending = $stmt->fetchColumn();

$pages = ceil($members / 12);
$pages_pending = ceil($members_pending / 12);

$page = $_POST['pageNumber'];

if ($pending == true) {
	$totalPagesMemberList = $pages_pending;
	$totalMembers = $members_pending;
	if ($page < 1 || empty($page) || $page > $pages_pending) {
		$page = 1;
	}
} else {
	$totalPagesMemberList = $pages;
	$totalMembers = $members;
	if ($page < 1 || empty($page) || $page > $pages) {
		$page = 1;
	}
}

$queryLimitMin = ($page * 12) - 12;
$queryLimit = $queryLimitMin . ",12";

header("X-JSON: {\"pending\":\"Pending Members (" . $members_pending . ")\",\"members\":\"Members (" . $members . ")\"}");

echo "<div id=\"group-memberlist-members-list\">

<form method=\"post\" action=\"#\" onsubmit=\"return false;\">
<ul class=\"habblet-list two-cols clearfix\">\n";

$counter = 0;

if ($pending == true) {
	if ($members_pending < 1) {
		echo "There are no pending membership requests at this time. Please check back later.";
	} else {
		$$stmt = $con->prepare("SELECT * FROM guilds_members WHERE guild_id = ? AND is_pending = '1' ORDER BY member_rank DESC LIMIT ?");
		$stmt->bind_param("si", $groupid, $queryLimit);
		$stmt->execute();
		$get_memberships = $stmt->get_result();
		while ($membership = mysqli_fetch_assoc($get_memberships)) {
			if (!is_numeric($membership['userid'])) {
				// handle the error case here, e.g. with an error message or an exception
				exit;
			}
			$stmt = $con->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
			$stmt->bind_param("i", $membership['userid']);
			$stmt->execute();
			$get_userdata = $stmt->get_result();
			$valid_user = mysqli_num_rows($get_userdata);
			if ($valid_user > 0) {
				$counter++;
				$userdata = $get_userdata->fetch(PDO::FETCH_ASSOC);
				if (IsEven($counter)) {
					$pos = "right";
					$rights++;
				} else {
					$pos = "left";
					$lefts++;
				}
				if (IsEven($lefts)) {
					$oddeven = "odd";
				} else {
					$oddeven = "even";
				}
				echo "<li class=\"" . $oddeven . " online " . $pos . "\">
    	<div class=\"item\" style=\"padding-left: 5px; padding-bottom: 4px;\">
    		<div style=\"float: right; width: 16px; height: 16px; margin-top: 1px\">\n";
				if ($membership['userid'] == $groupdata['ownerid']) {
					echo "<img src=\"./web-gallery/images/groups/owner_icon.gif\" width=\"15\" height=\"15\" alt=\"Owner\" title=\"Owner\" />\n";
				} elseif ($membership['member_rank'] > 1) {
					echo "<img src=\"./web-gallery/images/groups/administrator_icon.gif\" width=\"15\" height=\"15\" alt=\"Administrator\" title=\"Administrator\" />";
				}
				echo "</div>
				<input id=\"group-memberlist-m-" . $userdata['id'] . "\" type=\"checkbox\"";
				if ($membership['userid'] == $groupdata['ownerid'] || $membership['userid'] == $user['id']) {
					echo " disabled=\"disabled\"";
				}
				echo " style=\"margin: 0; padding: 0; vertical-align: middle\"/>
    	    <a class=\"home-page-link\" href=\"user_profile.php?name=" . $userdata['name'] . "\"><span>" . $userdata['name'] . "</span></a>
        </div>
    </li>";
			}
		}
	}
} else {
	if ($members < 1) {
		echo "There are no pending membership requests at this time. Please check back later.";
	} else {
		// Préparation de la requête SQL pour récupérer les membres de la guilde
		$sql = "SELECT * FROM guilds_members WHERE guild_id = :groupid AND is_pending = '0' ORDER BY member_rank DESC LIMIT :queryLimit";
		$stmt = $bdd->prepare($sql);
		$stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);
		$stmt->bindParam(':queryLimit', $queryLimit, PDO::PARAM_INT);
		$stmt->execute();

		// Récupération des données des membres
		while ($membership = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$tinyrank = "m";
			if (!is_numeric($membership['userid'])) {
				// Gestion de l'erreur si l'ID utilisateur n'est pas numérique
				continue;
			}
			// Récupération des données de l'utilisateur correspondant
			$sql = "SELECT * FROM users WHERE id = :userid LIMIT 1";
			$stmt2 = $bdd->prepare($sql);
			$stmt2->bindParam(':userid', $membership['userid'], PDO::PARAM_INT);
			$stmt2->execute();
			$valid_user = $stmt2->rowCount();
			if ($valid_user > 0) {
				$counter++;
				$userdata = $stmt2->fetch(PDO::FETCH_ASSOC);
				if (IsEven($counter)) {
					$pos = "right";
					$rights++;
				} else {
					$pos = "left";
					$lefts++;
				}
				if (IsEven($lefts)) {
					$oddeven = "odd";
				} else {
					$oddeven = "even";
				}
				echo "<li class=\"" . $oddeven . " online " . $pos . "\">
        <div class=\"item\" style=\"padding-left: 5px; padding-bottom: 4px;\">
            <div style=\"float: right; width: 16px; height: 16px; margin-top: 1px\">\n";
				if ($membership['userid'] == $groupdata['ownerid']) {
					$tinyrank = "a";
					echo "<img src=\"./web-gallery/images/groups/owner_icon.gif\" width=\"15\" height=\"15\" alt=\"Owner\" title=\"Owner\" />\n";
				} elseif ($membership['member_rank'] > 1) {
					$tinyrank = "a";
					echo "<img src=\"./web-gallery/images/groups/administrator_icon.gif\" width=\"15\" height=\"15\" alt=\"Administrator\" title=\"Administrator\" />";
				}
				echo "</div>
                <input id=\"group-memberlist-" . $tinyrank . "-" . $userdata['id'] . "\" type=\"checkbox\"";
				if ($membership['userid'] == $groupdata['ownerid']) {
					echo " disabled=\"disabled\"";
				}
				echo " style=\"margin: 0; padding: 0; vertical-align: middle\"/>
                <a class=\"home-page-link\" href=\"user_profile.php?name=" . $userdata['name'] . "\"><span>" . $userdata['name'] . "</span></a>
            </div>
        </li>";
			}
		}
	}
}

$results = count($get_memberships);

echo "</ul>

</form>



</div>
<div id=\"member-list-pagenumbers\">
" . ($queryLimitMin + 1) . " - " . ($results + $queryLimitMin) . " / " . $totalMembers . "
</div>
<div id=\"member-list-paging\" >";
if ($page > 1) {
	echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-first\" >First</a>";
} else {
	echo "First";
}
echo " | ";
if ($page > 1) {
	echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-previous\" >&lt;&lt;</a>";
} else {
	echo "&lt;&lt;";
}
echo " | ";
if ($page < $totalPagesMemberList) {
	echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-next\" >&gt;&gt;</a>";
} else {
	echo "&gt;&gt;";
}
echo " | ";
if ($page < $totalPagesMemberList) {
	echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-last\" >Last</a>";
} else {
	echo "Last";
}
echo "<input type=\"hidden\" id=\"pageNumberMemberList\" value=\"" . $page . "\"/>
<input type=\"hidden\" id=\"totalPagesMemberList\" value=\"" . $totalPagesMemberList . "\"/>
</div>";
